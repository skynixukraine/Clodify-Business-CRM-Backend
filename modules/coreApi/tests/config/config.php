<?php
/**
 * Application configuration shared by all test types
 */
return [
    'language' => 'en-US',
    'components' => [
        'dbCore' => [
            'dsn' => 'mysql:host=skynixcrm-db;dbname=skynixcrm_testdb_core',
            'username' => 'skynixcrm_testdb_user',
            'password' => 'N2IyNTdjNGEzOTMwYmM4M2UwMWQ1YmM4'
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
