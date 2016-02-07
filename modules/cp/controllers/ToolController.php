<?php
/**
 * Created by WebAIS Company.
 * URL: webais.company
 * Developer: alekseyyp
 * Date: 01.02.16
 * Time: 11:42
 */

namespace app\modules\cp\controllers;

use app\modules\cp\models\EmailTesterForm;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use app\components\AccessRule;
use app\models\User;

class ToolController extends DefaultController {

    public $enableCsrfValidation = false;
    public $layout = "admin";

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'ruleConfig' => [
                    'class' => AccessRule::className(),
                ],
                'rules' => [
                    [
                        'actions' => [ 'emailtester'],
                        'allow' => true,
                        'roles' => [User::ROLE_ADMIN ],
                    ]
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'emailtester'    => ['get', 'post'],
                ],
            ],
        ];
    }

    public function actionEmailtester()
    {
        $model = new EmailTesterForm();

        if ( $model->load( Yii::$app->request->post() ) && $model->validate() ) {

            $model->send();
            Yii::$app->getSession()->setFlash('success', Yii::t("app", "Your test email has been sent."));
            return $this->refresh();

        } else {

            $model->subject = 'Test Email from Skynix Server';

        }
        return $this->render("emailtester", [
            'model'         => $model
        ]);
    }

}