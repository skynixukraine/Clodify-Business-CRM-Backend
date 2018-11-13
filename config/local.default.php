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
            'dsn' => 'mysql:host=<mysql_host_name>;dbname=<mysql_db_name>',
            'username' => '<mysql_user>',
            'password' => '<mysql_pass>'
        ],
        'dbCore' => [
            'dsn' => 'mysql:host=<mysql_host_name>;dbname=<core_db_name>',
            'username' => '<core_db_username>',
            'password' => '<core_db_password>',
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
            'siteKey' => '<recaptcha_siteKey>',
            'secret' => '<recaptcha_secret>',
        ],
        'awssdk' => [
            'class' => 'fedemotta\awssdk\AwsSdk',
            'credentials' => [
                //you can use a different method to grant access
                'key' => '<aws_key>',
                'secret' => '<aws_secret>',
            ],
            'region' => 'us-east-1', //i.e.: 'us-east-1'
            'version' => 'latest', //i.e.: 'latest'
        ],
    ],
    'params' => array(
        'url_crm'           => 'https://skynix.co',
        'url_site'          => 'https://skynix.company',
        'port'		        => '',
        'adminEmail'        => 'admin@skynix.co',
        'basketAwssdk'      => '<aws_basket>',
        'crowd_code'        => 'Basic <encoded_crowd_auth>',
        'crowd_domain'      => 'https://crowd-01.skynix.co/crowd',
        //Twillio on hold we won't use twillio for the moment
        'twillio'           => [
            'serviceSid'    => '<twillio_service_sid>', // Skynix Emergency Service ID: ISac0bb20e481cd93fe43f0dfea1ca57de
            'from'          => '<twillio_from_number>', //LT SMS: +37066802569
            'accountSid'    => '<twillio_sid>',
            'token'         => '<twillio_token>'
        ],
        'smsService'        => [
            'from'          => 'InfoCentr',
            'user'          => '<smsServiceUser>',
            'password'      => '<smsServicePassword>',
        ],
        'merchantPassword'  => '<bankMerchantPassword>'

    )
];
