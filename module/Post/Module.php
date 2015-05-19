<?php
    namespace Post;

    use Post\Model\Post;
    use Post\Model\PostTable;
    use Post\Model\Like;
    use Post\Model\LikesTable;
    use Post\Model\PostFiles;
    use Post\Model\PostFilesTable;
    use Zend\Db\ResultSet\ResultSet;
    use Zend\Db\TableGateway\TableGateway;

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
            return array(
                'factories' => array(
                    'Post\Model\PostTable' =>  function($sm) {
                        $tableGateway = $sm->get('PostTableGateway');
                        $table = new PostTable($tableGateway);
                        return $table;
                    },
                    'PostTableGateway' => function ($sm) {
                        $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                        $resultSetPrototype = new ResultSet();
                        $resultSetPrototype->setArrayObjectPrototype(
                                                new Post());
                        return new TableGateway('posts', $dbAdapter, 
                                                null, $resultSetPrototype);
                    },
                    'Post\Model\LikesTable' =>  function($sm) {
                        $tableGateway = $sm->get('LikesTableGateway');
                        $table = new LikesTable($tableGateway);
                        return $table;
                    },
                    'LikesTableGateway' => function ($sm) {
                        $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                        $resultSetPrototype = new ResultSet();
                        $resultSetPrototype->setArrayObjectPrototype(new Like());
                        return new TableGateway('likes', $dbAdapter, 
                                                null, $resultSetPrototype);
                    },
                    'Post\Model\PostFilesTable' =>  function($sm) {
                        $tableGateway = $sm->get('PostFilesTableGateway');
                        $table = new PostFilesTable($tableGateway);
                        return $table;
                    },
                    'PostFilesTableGateway' => function ($sm) {
                        $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                        $resultSetPrototype = new ResultSet();
                        $resultSetPrototype->setArrayObjectPrototype(new PostFiles());
                        return new TableGateway('post_files', $dbAdapter, null, 
                        $resultSetPrototype);
                    },

                ),
            );
        }
    }
?>
