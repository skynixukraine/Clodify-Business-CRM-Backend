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

}