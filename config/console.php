<?php

Yii::setAlias('@tests', dirname(__DIR__) . '/tests');

$params = require(__DIR__ . '/params.php');
$db = require(__DIR__ . '/db.php');
$dbCore = require(__DIR__ . '/db-core.php');

$config = [
    'id' => 'basic-console',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log', 'gii'],
    'controllerNamespace' => 'app\commands',
    'language' => 'ua-UK',
    'sourceLanguage' => 'en-US',
    'modules' => [
        'gii' => 'yii\gii\Module',
    ],
    'controllerMap' => [
        'migrate' => [
            'class'                 => 'app\console\controllers\MigrateController',
        ],
    ],
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'i18n' => [
            'translations' => [
                'app*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'fileMap' => [
                        'app' => 'app.php',
                        'app/error' => 'error.php',
                    ],
                ],
            ],
        ],
        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
                [
                    'class' => 'yii\log\FileTarget',
                    'logFile' => '@runtime/logs/profile.log',
                    'categories' => ['yii\db\Command::query'],
                    'levels' => ['error', 'warning', 'profile'],
                ],
            ],
        ],
        'db' => $db,
        'dbCore' => $dbCore,
        'user' => [
            'class' => 'app\models\User',
            'identityCookie' => [
                'name' => 'skynix',
                'domain' => '.skynix.co',
                'path' => '/',
            ]
        ],
        'privatbankApi' => [
            'class' => 'yii\httpclient\Client',
            'baseUrl' => 'https://api.privatbank.ua/p24api',
        ],
    ],
    'params' => $params,
];
if ( file_exists(__DIR__ . '/local.php') ) {

    $localConfig    = include( __DIR__ . '/local.php');
    if ( isset($localConfig['components']['user']) ) {

        unset($localConfig['components']['user']);
    }
    if ( isset($localConfig['components']['session']) ) {

        unset($localConfig['components']['session']);
    }

    $config         = array_replace_recursive($config, $localConfig);

}
return $config;