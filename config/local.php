<?php
/**
 * Created by WebAIS Company.
 * URL: webais.company
 * Developer: alekseyyp
 * Date: 02.01.16
 * Time: 10:08
 */

/**
 * Create local.php file by coping this file and fill local.php with your local preferences
 */
return [
    'components' => [
        'db' => [
            'dsn' => 'mysql:host=localhost;dbname=in.skynix',
            'username' => 'root',
            'password' => 'root'
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'useFileTransport' => false,
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.gmail.com',
                'username' => '',//your google email
                'password' => '', //your google password
                'port' => '587',
                'encryption' => 'tls',
            ],
        ],
        'user' => [
            'identityCookie' => [
                'domain' => '.skynix.local',
            ]
        ],
        'session' => [
            'cookieParams' => [
                'path' => '/',
                'domain' => '.skynix.local'
            ],
        ],
    ],
    'params' => array(
        'ua_site'           => 'http://ua.skynix.local',
        'en_site'           => 'http://skynix.local',
        'in_site'           => 'http://in.skynix.local',
        'port'		        => ''
    )
];