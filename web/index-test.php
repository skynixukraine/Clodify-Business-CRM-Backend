<?php

// NOTE: Make sure this file is not accessible when deployed to production
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'test');

require(__DIR__ . '/../vendor/autoload.php');
require(__DIR__ . '/../vendor/yiisoft/yii2/Yii.php');

$config = require(__DIR__ . '/../modules/api/tests/config/functional.php');

Yii::$classMap['app\components\CrowdComponent'] = '@app/modules/api/tests/_support/Helper/CrowdComponent.php';


(new yii\web\Application($config))->run();
