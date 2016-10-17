ZF2 - Phing Data Migration tutorial application

See [http://arnobsaha.com/](http://arnobsaha.com/)

Phinx Installation:

Phnix can be installed as compose packages as following

1. php composer.phar require robmorgan/phinx
2. initialize the phinx.yml file where I can define the production/development environment settings by using following commands
    vendor/bin/phinx init
3. To check the all Phinx available commands
    vendor/bin/phinx list

Set up the Phinx environment with your current DB:

1. To set up the Phinx current environment first edit the phinx.yml file in the root directory
2. Change the production and development environment and file locations based on Phing file

paths:
    migrations: %%PHINX_CONFIG_DIR%%/migrations
    seeds: %%PHINX_CONFIG_DIR%%/data-fixtures

environments:
    default_migration_table: data_access_migrations
    default_database: development
    production:
        adapter: mysql
        host: localhost
        name: production_db
        user: root
        pass: ''
        port: 3306
        charset: utf8

    development:
        adapter: mysql
        host: localhost
        name: migration_testing
        user: root
        pass: ''
        port: 3306
        charset: utf8

    testing:
        adapter: mysql
        host: localhost
        name: testing_db
        user: root
        pass: ''
        port: 3306
        charset: utf8

