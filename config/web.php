<?php

$params = require(__DIR__ . '/params.php');


$config = [
    'id' => 'basic',
    'basePath'  => dirname(__DIR__),
    'bootstrap' => ['log'],
    'modules'   => [
        'cp' => [
            'class' => 'app\modules\cp\ControlPanel',
        ],
        'ExtensionPackager' => [
            'class' => 'app\modules\ExtensionPackager\ExtensionPackager',
        ],
    ],

    'timeZone'=> 'Europe/Kiev',
    'language' => 'en-US',
    'components' => [
        'assetManager' => [
            'bundles' => [
                'yii\bootstrap\BootstrapAsset' => [
                    'css' => [],
                ],
            ],
        ],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'bCRKiFqWufwrIeZGQ7dRApKddnf6xszA',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => [
                'name' => 'skynix',
                'domain' => '.skynix.company',
                'path' => '/',
            ]
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
        'urlManager' => [
            'class' => 'yii\web\UrlManager',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '/cp' => '/cp/default/index',
                '/s/<shortcode>' => '/site/survey',
                '<module>/<controller>/<action>/<id:\d+>' => '<module>/<controller>/<action>'
            ],
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'formatter' => [
            'timeZone' => 'Europe/Kiev',
        ],
        'session' => [
            'cookieParams' => [
                'path' => '/',
                'domain' => '.skynix.company'
            ],
        ],
        'i18n' => [
            'translations' => [
                'app*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@app/messages',
                    'sourceLanguage' => 'ua-UA',
                    'fileMap' => [
                        'app' => 'app.php',
                        'app/error' => 'error.php',

                    ],
                ],
            ],
        ],
        'db' => require(__DIR__ . '/db.php'),
    ],
    'params' => $params,
];
if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class'         => 'yii\gii\Module',
        'allowedIPs'    => ['127.0.0.1', '*']
    ];
}
if ( file_exists(__DIR__ . '/local.php') ) {

    $localConfig    = include( __DIR__ . '/local.php');
    $config         = array_replace_recursive($config, $localConfig);

}
return $config;
