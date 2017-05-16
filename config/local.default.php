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
                'username' => '<mail_username>',//your google email
                'password' => '<mail_password', //your google password
                'port' => '587',
                'encryption' => 'tls',
            ],
        ],
        'user' => [
            'identityCookie' => [
                'domain' => '.skynix.co',
            ]
        ],
        'session' => [
            'cookieParams' => [
                'path' => '/',
                'domain' => '.skynix.co'
            ],
        ],
        'reCaptcha' => [
            'name' => 'reCaptcha',
            'class' => 'himiklab\yii2\recaptcha\ReCaptcha',
            'siteKey' => '6Lf4bhsUAAAAAGdS65wleDLXAbaUEJFNm_fw5OgP',
            'secret' => '6Lf4bhsUAAAAAGZjWZEOxuvCzIEMZB1clVh5WhAw',
        ],
    ],
    'params' => array(
        'url_crm'           => 'https://skynix.co',
        'url_site'          => 'https://skynix.company',
        'port'		        => ''
    )
];