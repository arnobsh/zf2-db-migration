<?php
/**
 * Global Configuration Override
 *
 * You can use this file for overridding configuration values from modules, etc.
 * You would place values in here that are agnostic to the environment and not
 * sensitive to security.
 *
 * @NOTE: In practice, this file will typically be INCLUDED in your source
 * control, so do not include passwords or other sensitive information in this
 * file.
 */

return array(
    'db' => array(
        'driver' => 'Pdo',
        'dsn'            => 'mysql:dbname=zftutordoctrine;hostname=localhost',
        'username'       => 'root',
        'password'       => 'dri@2016',
        'driver_options' => array(
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''
        ),
    ),
    'service_manager' => array(
        'factories' => array(
            'Zend\Db\Adapter\Adapter' => 'Zend\Db\Adapter\AdapterServiceFactory',
        ),
    ),
    // Doctrine global config for migrationjs and other set up
    'doctrine' => array(
         'migrations_configuration' => array(
            'orm_default' => array(
                'directory' => __DIR__ . '/../../Migrations',
                'namespace' => 'Migrations',
                'table' => 'migrations',
            ),  
        ),
        
        ),
    'data-fixture' => array(
                  'location' => __DIR__ . '/../../Fixture',
            ),
     "paths" => array(
            "migrations" => __DIR__ . '/../../migrations'
        ),
        "environments" => array(
            "default_migration_table" => "migrations",
            "default_database" => "development_db_1",
            "development_db_1" => array(
                "adapter" => "mysql",
                "host" => "localhost",
                "name" => "development_db_1",
                "user" => "root",
                "pass" => "dri@2016",
                "port" => "3306"
            )
        )
);