<?php
/**
 * Application configuration shared by all test types
 */
return [
    'language' => 'en-US',
    'components' => [
        'db' => [
            'dsn' => 'mysql:host=<testdb_host>;dbname=<testdb_name>',
            'username' => '<testdb_username>',
            'password' => '<testdb_password>'
        ],
        'mailer' => [
            'useFileTransport' => true,
        ],
        'urlManager' => [
            'enablePrettyUrl'   => true,
            'showScriptName'    => true,
        ],
    ],
];
