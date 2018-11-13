<?php

$params = require(__DIR__ . '/params.php');
$route = require(__DIR__ . '/route.php');

$config = [
    'id' => 'basic',
    'basePath'  => dirname(__DIR__),
    'bootstrap' => [
        'log',
        'app\components\Bootstrap'
    ],
    'modules'   => [
        'cp' => [
            'class' => 'app\modules\cp\ControlPanel',
        ],
        'ExtensionPackager' => [
            'class' => 'app\modules\ExtensionPackager\ExtensionPackager',
        ],
        'api' => [
            'class' => 'app\modules\api\Module',
        ],
        'core-api' => [
            'class' => 'app\modules\coreApi\Module',
        ],
    ],
   // 'onBeginRequest' => ['app\components\SkynixBootstrap', 'init'],
    'timeZone'=> 'Europe/Kiev',
    'language' => 'ua-UK',
    'sourceLanguage' => 'en-US',
    'components' => [
        'Helper'    => 'app\components\Helper',
        'assetManager' => [
            'bundles' => [
                'yii\bootstrap\BootstrapAsset' => [
                    'css' => [],
                ],
            ],
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
        'request' => [
            'class'               => 'app\components\Request',
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
                'domain' => '.skynix.co',
                'path' => '/',
            ]
        ],
        'errorHandler' => [
            'errorAction' => 'api/default/error',
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
            'rules' =>array_merge($route, [
                'check-my-sso-and-login'                    => 'site/checksso',
                'check-status'                              => 'site/status',
                's/<shortcode:\w+>'                         => 'site/survey',
                '<controller>/<action>'                     => '<controller>/<action>',
                '<module>/<controller>/<action>/<id:\d+>'   => '<module>/<controller>/<action>/<id:\d+>',
                '<module>/<controller>/<action>/<id:\d+>'   => '<module>/<controller>/<action>',
                'profile/<name:\w+\-\w+>/<public_key:\w+>'  => 'profile/index',

            ]),
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'], //'info' 'profile' to debug database
                ],
            ],
        ],
        'formatter' => [
            'timeZone' => 'Europe/Kiev',
        ],
        'session' => [
            'cookieParams' => [
                'path' => '/',
                'domain' => '.skynix.co'
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
        'dbCore' => require(__DIR__ . '/db-core.php'),
        'crowdComponent' => [
            'class' => 'app\components\CrowdComponent',
        ],
        'privatbankApi' => [
            'class' => 'yii\httpclient\Client',
            'baseUrl' => 'https://api.privatbank.ua/p24api',
        ],
    ],
    'params' => $params,
];
if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        'allowedIPs'    => ['127.0.0.1', '172.20.0.1']
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class'         => 'yii\gii\Module',
        'allowedIPs'    => ['127.0.0.1']
    ];
}
if ( file_exists(__DIR__ . '/local.php') ) {

    $localConfig    = include( __DIR__ . '/local.php');
    $config         = array_replace_recursive($config, $localConfig);

}
return $config;