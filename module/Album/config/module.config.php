<?php
namespace Album;

return array(
    'controllers' => array(
        'invokables' => array(
            'Album\Controller\Album' => 'Album\Controller\AlbumController',   // <----- Module Controller
        ),
    ),

    // The following section is new and should be added to your file
    'router' => array(
        'routes' => array(
            'album' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/album[/:action][/:id]',  // <---- url format module/action/id
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Album\Controller\Album',  // <--- Defined as the module controller
                        'action'     => 'index',                   // <---- Default action
                    ),
                ),
            ),
            //default routing
            'default' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/album/index',  
                    
                    'defaults' => array(
                        'controller' => 'Album\Controller\Album',  // <--- Defined as the module controller
                        'action'     => 'index',                   // <---- Default action
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
    
     // Doctrine config
    'doctrine' => array(
        'driver' => array(
            __NAMESPACE__ . '_driver' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(__DIR__ . '/../src/' . __NAMESPACE__ . '/Entity')
            ),
            __NAMESPACE__ . '_YamlDriver' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\YamlDriver',
                'cache' => 'array',
                'extension' => '.dcm.yml',
                'paths' => array(__DIR__ . '/../src/' . __NAMESPACE__ . '/Mapping')
                ),
             
            
            'orm_default' => array(
                'drivers' => array(
                    __NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver',
                    __NAMESPACE__ . '\Repository' => __NAMESPACE__ . '_driver',
                    __NAMESPACE__ .  '\Mapping' =>  __NAMESPACE__ . '_YamlDriver',
                    //  __NAMESPACE__ .  '\Mapping' =>  __NAMESPACE__ . '_driver'
                )
            )
        ),
         'configuration' => array(
            'orm_default' => array(
                'query_cache' => 'array',
                'result_cache' => 'array',
                'metadata_cache' => 'array'
            )
        ),
        
        
    ),
    
     
);