<?php

namespace Checklist;

class Module
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
    
    public function getServiceConfig()
     {
         return array(
             'factories' => array(
                 'TaskMapper' => function ($sm) {
                     $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                     $mapper = new TaskMapper($dbAdapter);
                     return $mapper;
                 }
             ),
         );
     }
    
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }
 }