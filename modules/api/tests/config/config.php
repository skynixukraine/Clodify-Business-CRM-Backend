<?php
/**
 * Application configuration shared by all test types
 */
return [
    'language' => 'en-US',
    'components' => [
        'db' => [
            'dsn' => 'mysql:host=skynixcrm-db;dbname=skynixcrm_testdb',
            'username' => 'skynixcrm_testdb_user',
            'password' => 'YzhkNTk3Y2JiMzUxNWU2ZDcyNDYwOWM1'
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
