<?php
/**
 * Created by Skynix Team
 * Date: 21.12.16
 * Time: 16:20
 */

namespace app\modules\cp\controllers;

use yii\filters\AccessControl;
use app\models\User;
use app\components\AccessRule;
use app\models\Contract;
use Yii;

class ContractController extends DefaultController
{
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
                        'actions' => [ 'index', 'create'],
                        'allow' => true,
                        'roles' => [User::ROLE_ADMIN, User::ROLE_FIN, User::ROLE_SALES ],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionCreate()
    {
        $model = new Contract();
        if ($model->load(Yii::$app->request->post())) {

            if ($model->validate()) {
                $model->save();
                Yii::$app->getSession()->setFlash('success', Yii::t("app", "You created new Contract " . $model->id));
            }
        }
        return $this->render('create', ['model' => $model]);
    }

}