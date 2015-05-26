<?php
    namespace Application\Controller;

    use Zend\Mvc\Controller\AbstractActionController;
    use Zend\View\Model\ViewModel;
    use Zend\Mvc\MvcEvent; 
    use Zend\Session\Container;
    
    use Application\Model\UserRole;
    use Application\Model\Login;
    use Application\Form\LoginForm;
    
    class LoginController extends AbstractActionController
    {
        protected $userTable;
        protected $authservice;
        protected $storage;
        
        public function indexAction()
        {   
            $config = $this->getServiceLocator()->get('config');
            
            if ($this->getAuthService()->hasIdentity()){
                $this->redirect()->toRoute('album');
            }

            $loginForm = new LoginForm();
            $loginForm->get('submit')->setValue('Login');
            
            $request = $this->getRequest();
            
            if ($request->isPost()) {
                $login = new Login();
                
                $loginForm->setInputFilter($login->getInputFilter());
                
                $data = $request->getPost();
                $loginForm->setData($data);
                
                try {
                    if ($loginForm->isValid()) {
                        $data = $loginForm->getData();
                        $user = $this->getUserTable()->
                                       getUserByName($data['username']);
                        
                        $this->verifyUserActive($user);
                        $this->loginUser($user, $data);
                    } 
                } catch(\Exception $e) {
                    $loginForm->get('password')
                                ->setMessages(array($e->getMessage()));    
                }
            }
            
            return array(
                'loginForm' => $loginForm,
                'config' => $config
            ); 
        }
        
        
        public function logoutAction()
        {
            $this->getAuthService()->clearIdentity();

            return $this->redirect()->toRoute('log', array(
                     'action' => 'index'
                 ));
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
        
        private function getAuthService()
        {
            if (! $this->authservice) {
            $this->authservice = $this->getServiceLocator()->get('AuthService');
            }
            return $this->authservice;
        }
        
        private function getSessionStorage()
        {
            if (! $this->storage) {
                $this->storage = $this->getServiceLocator()
                                      ->get('SanAuth\Model\MyAuthStorage');
            }
         
            return $this->storage;
        }        

        private function verifyUserActive($user = null)
        {
            if ($user['user_active'] == false) {
                throw new \Exception(
                    'This account is inactive. 
                    Please contact administrator.'
                );    
            }            
        }

        /**
        * Log User in system
        * 
        * @param array $user
        * @param array $data
        */
        private function loginUser($user = null, $data = null)
        {
            $this->getAuthService()->getAdapter()
                 ->setIdentity($data['username'])
                 ->setCredential(md5($data['password']));
            $result = $this->getAuthService()->authenticate();
            
            if ($result->isValid()) {
                $userSession = new Container('user');
                $userSession->id = $user['user_id'];
                $userSession->username = $user['user_name'];
                $userSession->role = $user['user_roles_role'];
                $userSession->img = $user['user_img'];
                
                return $this->redirect()->toRoute('album');      
            } else {
                throw new \Exception(
                    'Password or Username is incorrect.'
                ); 
            }            
        }   
    }    
?>
