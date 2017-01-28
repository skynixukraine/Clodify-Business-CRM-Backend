<?php

namespace app\modules\api;
use Yii;

/**
 * api module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'app\modules\api\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
		parent::init();	

        // custom initialization code goes here
		Yii::setAlias('viewModel', Yii::getAlias("@app") . '/modules/api/view-models');

		// http://www.yiiframework.com/doc-2.0/guide-rest-authentication.html
		Yii::$app->user->enableSession = false;
		Yii::$app->user->loginUrl = null;
	}
}
