<?php
return array(
    'controllers' => array(
         'invokables' => array(
             'Post\Controller\Post' => 'Post\Controller\PostController',
             'Post\Controller\Like' => 'Post\Controller\LikeController',
             'Post\Controller\AttachFiles' => 'Post\Controller\AttachFilesController',
         ),
    ),
    
         // The following section is new and should be added to your file
    'router' => array(
         'routes' => array(
             'post' => array(
                 'type'    => 'segment',
                 'options' => array(
                     'route'    => '/post[/:action][/:id]',
                     'constraints' => array(
                         'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                         'id'     => '[0-9]+',
                     ),
                     'defaults' => array(
                         'controller' => 'Post\Controller\Post',
                         'action'     => 'index',
                     ),
                 ),
             ),
             'like' => array(
                 'type'    => 'literal',
                 'options' => array(
                     'route'    => '/like',
                     /*'constraints' => array(
                         'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                     ),*/
                     'defaults' => array(
                         'controller' => 'Post\Controller\Like',
                         'action'     => 'like',
                     ),
                 ),
             ),
             'attach-files' => array(
                 'type'    => 'literal',
                 'options' => array(
                     'route'    => '/upload',
                     /*'constraints' => array(
                         'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                     ),*/
                     'defaults' => array(
                         'controller' => 'Post\Controller\AttachFiles',
                         'action'     => 'upload',
                     ),
                 ),
             ),
         ),
    ),
    /*'router' => array(
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
    ),*/
    
    'view_manager' => array(
         'template_path_stack' => array(
             'post' => __DIR__ . '/../view',
         ),
         /*'strategies' => array(
            'ViewJsonStrategy',
        ),*/
    ),
    'view_helpers' => array(
        'invokables'=> array(
            'postTime' => 'Post\View\Helper\PostTimeHelper',  
            'printReplies' => 'Post\View\Helper\PrintRepliesHelper',
            'printLikedBy' => 'Post\View\Helper\PrintLikedHelper'
            
        )
    ),
);
?>
