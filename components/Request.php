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
        $SKYNIX_IP = '213.160.139.198';

        if ( isset($_SERVER['HTTP_X_REAL_IP']) ) {

            //This is internal network, most probably staging server
            if ( false && strstr($_SERVER['HTTP_X_REAL_IP'], '192.168') !== false ) {

                //Never use it, better move CRM to intranet
                return $SKYNIX_IP;

            } else {

                return $_SERVER['HTTP_X_REAL_IP'];

            }

        } else if ( $_SERVER['REMOTE_ADDR'] === "172.20.0.1") {

            return $SKYNIX_IP;

        }
        return parent::getUserIP();
    }

}