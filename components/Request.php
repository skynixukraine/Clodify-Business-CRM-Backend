<?php
/**
 * Create By Skynix Team
 * Author: oleksii
 * Date: 7/28/18
 * Time: 9:31 AM
 */

namespace app\components;


class Request extends \yii\web\Request
{

    public $ipHeaders = [
        'HTTP_X_REAL_IP',
        'HTTP_X_FORWARDED_FOR',
        'X-Forwarded-For', // Common
    ];

    public function getUserIP()
    {
        if ( isset($_SERVER['HTTP_X_REAL_IP']) ) {

            //This is internal network, most probably staging server
            if ( strstr($_SERVER['HTTP_X_REAL_IP'], '192.168') !== false ) {

                return '213.160.139.198';

            } else {

                return $_SERVER['HTTP_X_REAL_IP'];

            }

        }
        return parent::getUserIP();
    }

}