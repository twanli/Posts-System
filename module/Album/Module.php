<?php
namespace Album;

use Album\Model\Album;
use Album\Model\AlbumTable;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\Authentication\Adapter\DbTable as DbAuthAdapter;
use Zend\Authentication\AuthenticationService;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;

class Module implements AutoloaderProviderInterface, ConfigProviderInterface
{
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
             __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
             'namespaces' => array(
                 __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
             ),
            ),
        );
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }
    
    public function getServiceConfig()
    {
        //DebugBreak();
        return array(
         'factories' => array(
             'Album\Model\AlbumTable' =>  function($sm) {
                 $tableGateway = $sm->get('AlbumTableGateway');
                 $table = new AlbumTable($tableGateway);
                 return $table;
             },
             'AlbumTableGateway' => function ($sm) {
                 $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                 $resultSetPrototype = new ResultSet();
                 $resultSetPrototype->setArrayObjectPrototype(new Album());
                 return new TableGateway('album', $dbAdapter, null, $resultSetPrototype);
             },

             'Album\Model\AlbumFiles' => function($sm){
                $model = new \Album\Model\AlbumFiles(); 
                $model->setServiceLocator($sm);
                return $model;
             },

         ),
        );
    }
}

?>
