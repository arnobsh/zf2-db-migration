<?php
namespace Employee;

return array(
    'controllers' => array(
        'invokables' => array(
            'Employee\Controller\Employee' => 'Employee\Controller\EmployeeController',   // <----- Module Controller
        ),
    ),

    // The following section is new and should be added to your file
    'router' => array(
        'routes' => array(
            'employee' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/employee[/:action][/:id]',  // <---- url format module/action/id
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Employee\Controller\Employee',  // <--- Defined as the module controller
                        'action'     => 'index',                   // <---- Default action
                    ),
                ),
            ),
            //default routing
            'default' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/employee/index',  
                    
                    'defaults' => array(
                        'controller' => 'Employee\Controller\Employee',  // <--- Defined as the module controller
                        'action'     => 'index',                   // <---- Default action
                    ),
                ),
            ),
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'employee' => __DIR__ . '/../view',
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
                    __NAMESPACE__ .  '\Mapping' =>  __NAMESPACE__ . '_YamlDriver'
                )
            ),
            'migrations_configuration' => array(
            'orm_default' => array(
                'directory' => __DIR__ . '/../src/' . __NAMESPACE__ . '/Migrations',
                'namespace' => __NAMESPACE__ . '\Migrations',
                'table' => 'migrations',
            ),  
        ),
        )
    )
);