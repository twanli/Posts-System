<?php
return array(
    'controllers' => array(
         'invokables' => array(
             'Album\Controller\Album' => 'Album\Controller\AlbumController',
         ),

    ),
    
    'router' => array(
         'routes' => array(
             'album' => array(
                 'type'    => 'segment',
                 'options' => array(
                     'route'    => '/albums[/:action][/:id]',
                     'constraints' => array(
                         'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                         'id'     => '[0-9]+',
                     ),
                     'defaults' => array(
                         'controller' => 'Album\Controller\Album',
                         'action'     => 'index',
                     ),
                 ),
             ),
             'sort' => array(
                 'type'    => 'segment',
                 'options' => array(
                     'route'    => '/orderby/:orderby/:way',
                     'constraints' => array(
                         'action' => '[a-zA-Z][a-zA-Z0-9_-]*'
                     ),
                     'defaults' => array(
                         'controller' => 'Album\Controller\Album',
                         'action'     => 'index',
                     ),
                 ),
             ),
         ),
    ),
    
    'view_manager' => array(
         'template_path_stack' => array(
             'album' => __DIR__ . '/../view',
         ),
    ),
    'view_helpers' => array(
        'invokables'=> array(
            'errorHelper' => 'Album\View\Helper\ErrorHelper',
            'sortHelper'  => 'Album\View\Helper\SortHelper' 
        )
    ),
);
?>
