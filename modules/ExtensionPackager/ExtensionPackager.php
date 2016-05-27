<?php

namespace app\modules\ExtensionPackager;
use yii\BaseYii;

/**
 * ExtensionPackager module definition class
 */
class ExtensionPackager extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    
    public $controllerNamespace = 'app\modules\ExtensionPackager\controllers';
    /*public $defaultRoute = 'extension';*/
    public $layout = '@app/modules/cp/views/layouts/admin.php';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        $pathes = \Yii::$app->assetManager->publish(\Yii::getAlias(__DIR__ . "/assets"));
        $this->setAliases([
            '@extension-assets' => $pathes[1]
        ]);
        // custom initialization code goes here
    }
}
