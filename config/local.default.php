<?php
/**
 * Created by Skynix Company.
 * URL: skynix.company
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
            'username' => 'mysql_user',
            'password' => 'mysql_pass'
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'useFileTransport' => false,
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.gmail.com',
                'username' => 'mail_user',//your google email
                'password' => 'mail_pass', //your google password
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
        'url_crm'           => 'https://skynix.local',
        'url_site'          => 'https://skynix.local',
        'port'		        => ''
    )
];