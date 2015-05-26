<?php
    namespace Application\Controller;

    use Zend\Mvc\Controller\AbstractActionController;
    use Zend\Mvc\MvcEvent; 
    use Zend\View\Model\ViewModel;
    use Zend\Session\Container;
    use Zend\Http\Request; 
    
    use Application\Model\User;
    use Application\Model\UserRole;
    use Application\Form\UserForm;
    
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
            $userForm = new UserForm();
            $userForm->get('submit')->setValue('Add User');
            
            $request = $this->getRequest();
            
            if ($request->isPost()) {
                $user = new User();
                $userForm->setInputFilter($user->getInputFilter());
                
                $postData = $request->getPost();
                $userForm->setData($postData);

                if ($userForm->isValid()) {
                    if (empty($postData['user_password']) && 
                        $postData['gen_password'] == 0){
                        
                        $userForm->get('gen_password')
                             ->setMessages(array('You should set a password!'));    
                    
                    } else {
                        /**
                        * If we want to generate from brand new password then 
                        * we redirect to related action and save form data there
                        */
                        try {
                            $data=$userForm->getData();

                            $user->exchangeArray($data);
                            $this->getUserTable()->saveUser($user);
                            
                            if ($postData['gen_password'] == true) {
                                $id = $this->getUserTable()->lastAddedUser();
                                $this->generatePassword($id, self::ADD);
                            }  else {
                                return $this->redirect()->toRoute('users');     
                            }
                        } catch (\Exception $e) {
                            $userForm->get('user_name')
                            ->setMessages(array('User '.$data['user_name'].
                                                ' allready exists.'));    
                        }
                    }
                }               
            }
            
            return array('form' =>  $userForm,
                         'roles' => $this->roles,
                         );
        }

        /**
        * Editing Users Form
        * 
        */        
        public function editAction()
        {
            //DebugBreak();
            $id = $this->getRouteId(self::ADD);
            $user = $this->getUser($id);

            $userForm = new UserForm();
            $userForm->bind($user);
            $userForm->get('submit')->setAttribute('value', 'Edit');

            $request = $this->getRequest();

            $postData = $request->getPost();
            if ($request->isPost()) {
                $userForm->setInputFilter($user->getInputFilter());
                $userForm->setData($postData);

                if ($userForm->isValid()) {
                    try {
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
                    } catch (\Exception $e) {
                        $userForm->get('user_name')
                        ->setMessages(array('User '.$postData['user_name'].
                                            ' allready exists.'));    
                    }

                }
            }

            return array(
                'id' => $id,
                'form' => $userForm,
                'roles' => $this->roles,
            );
        }
        
        public function manageAccAction()
        {
            $id = $this->getRouteId(self::ADD);
            return $this->redirect()->toRoute('users', 
            array('action' => 'edit', 
                  'id' => $id));   
        }
        
        /**
        * Action for generating new password
        * 
        */
        public function genPasswordAction ()
        {
            $id = $this->params('id');
            $user     = $this->getUserTable()->getUser($id);
            $userRole = $this->getUserRoleTable()->getUserRole($user->user_role);
            $action = $this->formDataSession->action;
            
            $user->user_password = User::genPassword();
            $this->getUserTable()->saveUser($user);
            
            return array('user' => $user,
                         'userRole' => $userRole,
                         'genPass' => $user->user_password,
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
        
        /**
        * redirect to gen Password action
        * 
        * @param int $id
        * @param string $action
        */
        private function generatePassword($id=null, $action=null)
        {
            $this->formDataSession->action = $action;
            
            return $this->redirect()->toRoute('users', 
                        array('action' => 'genPassword', 
                              'id' => $id));    
        }
        
        /**
        * Get Id from url route
        * 
        * @param string $action
        */
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
        
        /**
        * Get User according to his id
        * 
        * @param int $id
        */
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
        
        /**
        * Set in main admin panel new user name
        * 
        * @param mixed $user
        */
        private function updateSessionUser($user=null)
        {
            if($user->user_id == $this->userSession->id
                && $user->user_name != $this->userSession->username) {
                $this->userSession->username = $user->user_name;
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
