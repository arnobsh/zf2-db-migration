<?php
namespace Checklist;

return array(
    // The following section is new and should be added to your file
    'router' => array(
     'routes' => array(
         'task' => array(
             'type'    => 'Segment',
             'options' => array(
                 'route'    => '/task[/:action[/:id]]',
                 'defaults' => array(
                     '__NAMESPACE__' => 'Checklist\Controller',
                     'controller'    => 'Task',
                     'action'        => 'index',
                 ),
                 'constraints' => array(
                     'action' => '(add|edit|delete)',
                     'id'     => '[0-9]+',
                 ),
             ),
         ),
     ),
 ),
     'controllers' => array(
        'invokables' => array(
            'Checklist\Controller\Task' => 'Checklist\Controller\TaskController',   // <----- Module Controller
        ),
    ),
/*
    // The following section is new and should be added to your file
    'router' => array(
        'routes' => array(
            'task' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/task[/:action][/:id]',  // <---- url format module/action/id
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Checklist\Controller\Task',  // <--- Defined as the module controller
                        'action'     => 'index',                   // <---- Default action
                    ),
                ),
            ),
            //default routing
            'default' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/task/index',  
                    
                    'defaults' => array(
                        'controller' => 'Checklist\Controller\Task',  // <--- Defined as the module controller
                        'action'     => 'index',                   // <---- Default action
                    ),
                ),
            ),
        ),
    ),
    */
    'view_manager' => array(
        'template_path_stack' => array(
            'checklist' => __DIR__ . '/../view',
        ),
    ),
    
     
);