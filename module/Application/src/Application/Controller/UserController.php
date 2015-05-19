<?php
    namespace Application\Controller;

    use Zend\Mvc\Controller\AbstractActionController;
    /*use Zend\Validator\File\Size; 
    use Zend\Validator\File\Extension;*/  
    use Zend\Mvc\MvcEvent; 
    use Zend\View\Model\ViewModel;
    use Application\Model\User;
    use Application\Model\UserRole;
    use Application\Form\UserForm;
    use Zend\Session\Container;     
    
    class UserController extends AbstractActionController
    {
        const GEN_PASS_LENGHT = 8;
        const ADD = "add";
        const UPDATE = "update";
        const EDIT = "edit";  
                
        private $userSession;
        private $formDataSession;
        private $roles;
        private $userForm;
        
        protected $userTable;
        protected $userRoleTable;
        
        /**
        * Controler Dispatch
        * 
        * @param MvcEvent $e
        * @return \Zend\Http\Response
        */
        public function onDispatch(MvcEvent $e )
        {
            $this->userSession     = new Container('user');
            $this->formDataSession = new Container('formData');
            $this->userForm = new UserForm();
            $this->roles = $this->getUserRoleTable()->fetchAll();
            
            $routeMatch = $e->getRouteMatch();
            $controller = $routeMatch->getParam('controller');
            $action     = $routeMatch->getParam('action');
         
            if ($action == self::EDIT) {
                $request    = $this->getRequest();
                
                if($request->isPost()) {
                    $routeId = $routeMatch->getParam('id');
                    $hidFieldId = $request->getPost('id'); 
                    $secure = $this->validateSecureData($routeId, $hidFieldId);
                    
                    if (!$secure) {
                        return $this->redirect()->toRoute('users', 
                        array('action' => 'edit', 
                              'id' => $this->userSession->id));        
                    }                    
                }
            }            
            
            return parent::onDispatch( $e );    
        }
        
        
        /**
        * Users Grid
        * 
        */
        public function indexAction()
        {
            $this->formDataSession->action = self::UPDATE;
            
            return new ViewModel(array(
             'users' => $this->getUserTable()->fetchAllJoinRoles(),             
            ));
        }
        
        /**
        * Adding Users Form
        * 
        */
        public function addAction()
        {
            $this->userForm->get('submit')->setValue('Add User');
            
            $request = $this->getRequest();
            
            if ($request->isPost()) {
                $user = new User();
                
                $this->userForm->setInputFilter($user->getInputFilter());
                
                $postData = $request->getPost();
                $this->userForm->setData($postData);

                if ($this->userForm->isValid()) {
                    if (empty($postData['password']) && 
                        $postData['gen_password'] == 0){
                        
                        $this->userForm->get('gen_password')
                             ->setMessages(array('You should set a password!'));    
                    
                    } else {
                        /**
                        * If we want to generate from brand new password then 
                        * we redirect to related action and save form data there
                        */
                        try {
                            $data=$this->userForm->getData();

                            $user->exchangeArray($data);
                            $this->getUserTable()->saveUser($user);
                            
                            if ($postData['gen_password'] == true) {
                                $id = $this->getUserTable()->lastAddedUser();
                                $this->generatePassword($id, self::ADD);
                            }  else {
                                return $this->redirect()->toRoute('users');     
                            }
                        } catch (\Exception $e) {
                            $this->userForm->get('username')
                            ->setMessages(array('User '.$data['username'].
                                                ' allready exists.'));    
                        }
                    }
                }               
            }
            
            return array('form' =>  $this->userForm,
                         'roles' => $this->roles,
                         );
        }

        /**
        * Editing Users Form
        * 
        */        
        public function editAction()
        {
            $id = $this->getRouteId(self::ADD);
            $user = $this->getUser($id);

            $this->userForm->bind($user);
            $this->userForm->get('submit')->setAttribute('value', 'Edit');

            $request = $this->getRequest();
            $postData = $request->getPost();
            
            if ($request->isPost()) {
                $this->userForm->setInputFilter($user->getInputFilter());
                $this->userForm->setData($postData);

                if ($this->userForm->isValid()) {
                    $this->getUserTable()->saveUser($user);
                    
                    /* Update user name in Admin panel (text 'username' is logged)
                      if the name of Actual administrator was changed */
                    $this->updateSessionUser($user);
                    
                    if ($postData['gen_password'] == true) {
                        $this->generatePassword($id, self::EDIT);  
                    }  else {
                        $role = $this->userSession->role;
                        
                        if ($this->userSession->role 
                            == UserRole::ROLE_SUPERADMIN) {
                            return $this->redirect()->toRoute('users');                              
                        } else {
                            return $this->redirect()->toRoute('album');
                        }   
                    }
                }
            }

            return array(
                'id' => $id,
                'form' => $this->userForm,
                'roles' => $this->roles,
            );
        }
        
        /**
        * Action for generating new password
        * 
        */
        public function genPasswordAction ()
        {
            //DebugBreak();
            $id = $this->params('id');
            $user     = $this->getUserTable()->getUser($id);
            $userRole = $this->getUserRoleTable()->getUserRole($user->role);
            
            $action = $this->formDataSession->action;
            $genPass = substr(md5(uniqid(mt_rand(), true)), 
                        0, self::GEN_PASS_LENGHT);
            
            $user->password = $genPass;
            $this->getUserTable()->saveUser($user);
            
            return array('user' => $user,
                         'userRole' => $userRole,
                         'genPass' => $genPass,
                         'action' => $action);
        }
        
        public function deleteAction()
        {
            $id = $this->params('id');
            
            $this->getUserTable()->deleteUser($id);
            
            return $this->redirect()->toRoute('users');
        }
        
        /**
        * Get all users
        * 
        */
        public function getUserTable()
        {
            if (!$this->userTable) {
                $sm = $this->getServiceLocator();
                $this->userTable = $sm->get('Application\Model\UserTable');
            }
            return $this->userTable;
        }

        public function getUserRoleTable()
        {
            if (!$this->userRoleTable) {
                $sm = $this->getServiceLocator();
                $this->userRoleTable = $sm->get('Application\Model\UserRolesTable');
            }
            return $this->userRoleTable;
        }
        
        private function generatePassword($id=null, $action=null)
        {
            $this->formDataSession->action = $action;
            
            return $this->redirect()->toRoute('users', 
                        array('action' => 'genPassword', 
                              'id' => $id));    
        }
        
        private function getRouteId($action = null)
        {
            $id = (int) $this->params()->fromRoute('id', 0);
            if (!$id) {
                return $this->redirect()->toRoute('users', array(
                     'action' => $action
                    ));                        
            }
            
            return $id;            
        }
        
        private function getUser($id = null)
        {
            try {
                $user = $this->getUserTable()->getUser($id);    
            } catch (\Exception $ex) {
                return $this->redirect()->toRoute('users', array(
                 'action' => 'index'
                ));
            }  
            
            return $user;
        }
        
        private function updateSessionUser($user=null)
        {
            if($user->id == $this->userSession->id
                && $user->username != $this->userSession->username) {
                $this->userSession->username = $user->username;
            }    
        }
        /**
        * Validate ids from form (could be changed from browser by a hacker) 
        * if they are the same as userSession id
        * 
        * @param int $routeId
        * @param int $hiddenFieldId
        * 
        * @return bool
        */
        private function validateSecureData($routeId, $hiddenFieldId)
        {
            if(($routeId == $this->userSession->id &&
                $hiddenFieldId == $this->userSession->id
               ) || UserRole::ROLE_SUPERADMIN == $this->userSession->role) {
               return true;    
            } else {
               return false; 
            }
                                            
        }       



    }  
?>
