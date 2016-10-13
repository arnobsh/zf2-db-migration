<?php
return array(
    'modules' => array(
        'Application',
        'DoctrineModule',
        'DoctrineORMModule',
        //'DoctrineMongoODMModule',
        'DoctrineDataFixtureModule',
        'Album',
        'Track',
        'BgportalSessionToolbar',
        'Blog',
        'Checklist',
        'Employee',
    ),
    'module_listener_options' => array(
        'config_glob_paths'    => array(
            'config/autoload/{,*.}{global,local}.php',
        ),
        'module_paths' => array(
            './module',
            './vendor',
        ),
    ),
);
