<?php

namespace app\modules\cp;
use \app\models\Language;

class ControlPanel extends \yii\base\Module
{
    public $controllerNamespace = 'app\modules\cp\controllers';

    public $defaultRoute = 'index';

    public $layout = 'admin.php';

    public function init()
    {
        parent::init();

    }
}
