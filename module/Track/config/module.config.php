<?php
namespace Track;

return array(
    'controllers' => array(
        'invokables' => array(
            'Track\Controller\Track' => 'Track\Controller\TrackController',   // <----- Module Controller
        ),
    ),

    // The following section is new and should be added to your file
    'router' => array(
        'routes' => array(
            'track' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/track[/:action][/:id]',  // <---- url format module/action/id
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Track\Controller\Track',  // <--- Defined as the module controller
                        'action'     => 'index',                   // <---- Default action
                    ),
                ),
            ),
            //default routing
            'default' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/track/index',  
                    
                    'defaults' => array(
                        'controller' => 'Track\Controller\Track',  // <--- Defined as the module controller
                        'action'     => 'index',                   // <---- Default action
                    ),
                ),
            ),
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'track' => __DIR__ . '/../view',
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
        
        
    )
);