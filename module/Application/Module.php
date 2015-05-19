<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\Session\Config\SessionConfig;
use Zend\Session\SessionManager;
use Zend\Authentication\Adapter\DbTable as DbAuthAdapter;
use Zend\Authentication\AuthenticationService;
use Zend\Session\Container;
use Zend\Permissions\Acl\Acl;

use Application\Model\User;
use Application\Model\UserRole;
use Application\Model\UserTable;
use Application\Model\UserRolesTable;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;


class Module
{
    private $acl;
    
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager        = $e->getApplication()->getEventManager();
        $eventManager->attach( \Zend\Mvc\MvcEvent::EVENT_DISPATCH, array($this, 'preDispatch'), 100 );
    
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
        
        $userRole = new UserRole();
        $this->acl = $userRole->initAcl();
        
        $view = $e->getViewModel();
        $view->acl = $this->acl;

            
        /*$this->initSession(array(
            'remember_me_seconds' => 180,
            'use_cookies' => true,
            'cookie_httponly' => true,
        ));*/
    }
    
    public function preDispatch(MvcEvent $e)
    {
        $userSession = new Container('user');
        
        $serviceManager = $e->getApplication()->getServiceManager();
        $authService = $serviceManager->get('AuthService');
        
        $routeMatch = $e->getRouteMatch();
        $controller = $routeMatch->getParam('controller');
        $action     = $routeMatch->getParam('action');
        $id     = $routeMatch->getParam('id');
        
     
        
        if (!$authService->hasIdentity()) {
            
            if ($controller == 'Application\Controller\Login' && $action == 'index')
                return;
                
            $response = $e->getResponse();
            $response->getHeaders()->addHeaderLine('Location', '/');
            $response->setStatusCode(302);
            $response->sendHeaders();
            exit;
            
        } else {
            $controller = explode('\\',$controller);
            
            if (end($controller) == "User") {
                if ($action == 'edit' || $action == 'genPassword') {
                    if (($userSession->id != $id) && 
                        ($userSession->role != UserRole::ROLE_SUPERADMIN)) {
                        
                        $url = $e->getRouter()->assemble(
                            array('action' => 'edit', 
                                  'id' => $userSession->id), 
                            array('name' => 'users'));
                                    
                        $response = $e->getResponse();
                        $response->getHeaders()->addHeaderLine('Location', $url);
                        $response->setStatusCode(302);
                        $response->sendHeaders();
                    }
                    
                    return;                     
                }
                

                if (!$this->acl->isAllowed($userSession->role, strtolower(end($controller)).":".$action)) {
                    
                    $url = $e->getRouter()->assemble(array('action' => 'edit', 'id' => $userSession->id), array('name' => 'users'));
                    
                    $response = $e->getResponse();
                    $response->getHeaders()->addHeaderLine('Location', $url);
                    $response->setStatusCode(302);
                    $response->sendHeaders();
                }
            }

            if (end($controller) == "Album") {
                if ($action == 'index') return;
                
                if (!$this->acl->isAllowed($userSession->role, strtolower(end($controller)).":".$action)) {
                    
                    $url = $e->getRouter()->assemble(array('action' => 'index'), array('name' => 'album'));
                    
                    $response = $e->getResponse();
                    $response->getHeaders()->addHeaderLine('Location', $url);
                    $response->setStatusCode(302);
                    $response->sendHeaders();
                }
            }            
        }
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
    
    public function initSession($config)
    {
        $sessionConfig = new SessionConfig();
        $sessionConfig->setOptions($config);
        $sessionManager = new SessionManager($sessionConfig);
        $sessionManager->start();
        
        $selectParamsSession = new Container('criteria');
        if (!isset($selectParamsSession->init)) {
             $sessionManager->regenerateId(true);
             $selectParamsSession->init = 1;
        }
        Container::setDefaultManager($sessionManager);
    }

    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'AuthService' => function ($serviceManager) {
                    $adapter = $serviceManager->get('Zend\Db\Adapter\Adapter');
                    $dbAuthAdapter = new DbAuthAdapter ( $adapter, 'users', 'username', 'password' );
                    
                    $auth = new AuthenticationService();
                    $auth->setAdapter ( $dbAuthAdapter );
                    return $auth;
                },
                'Application\Model\UserTable' =>  function($sm) {
                    $tableGateway = $sm->get('UserTableGateway');
                    $table = new UserTable($tableGateway);
                    return $table;
                },
                'Application\Model\UserRolesTable' =>  function($sm) {
                    $tableGateway = $sm->get('UserRolesTableGateway');
                    $table = new UserRolesTable($tableGateway);
                    return $table;
                },
                'UserTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new User());
                    return new TableGateway('users', $dbAdapter, null, $resultSetPrototype);
                },
                'UserRolesTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new UserRole());
                    return new TableGateway('user_roles', $dbAdapter, null, $resultSetPrototype);
                }, 
            ),
        );
    }
    
    private function getAuthService()
    {
        if (! $this->authservice) {
        $this->authservice = $this->getServiceLocator()->get('AuthService');
        }
        return $this->authservice;
    }    
    

}
