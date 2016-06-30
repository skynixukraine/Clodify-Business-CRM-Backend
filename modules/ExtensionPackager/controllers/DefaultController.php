<?php

namespace app\modules\ExtensionPackager\controllers;

use yii\web\Controller;
use app\components\AccessRule;


/**
 * Default controller for the `ExtensionPackager` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */

    public function beforeAction( $action )
    {
        \Yii::$app->assetManager->bundles['yii\web\JqueryAsset'] = false;
        \Yii::$app->assetManager->bundles['yii\bootstrap\BootstrapPluginAsset'] = false;
        \Yii::$app->assetManager->bundles['yii\bootstrap\BootstrapAsset'] = false;
        return parent::beforeAction( $action );
    }



    public function actionIndex()
    {
        return $this->render('index');
    }
}
