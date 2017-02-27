<?php
/**
 * Created by PhpStorm.
 * User: dmytro
 * Date: 24.02.17
 * Time: 12:20
 */

namespace viewModel;

use app\models\User;
use Yii;
use app\modules\api\models\ApiAccessToken;

class ReportsFetch extends ViewModelAbstract
{
    public function define()
    {
        // login action (SiteController->actionLoginByAccessToken)
        $token       = Yii::$app->request->headers->get('skynix-access-token');
        if ( ($accessToken = $token) &&
            ( $apiAccessTokenModel = ApiAccessToken::findIdentityByAccessToken( $accessToken ) ) &&
            $apiAccessTokenModel->isAccessTokenValid() &&
            ( $user = User::findOne($apiAccessTokenModel->user_id) ) &&
            $user->is_active == User::ACTIVE_USERS &&
            $user->is_delete != User::DELETED_USERS ) {

            Yii::$app->user->login( $user );
            Yii::$app->getSession()->setFlash('success', Yii::t("app", "Welcome to Skynix CRM"));


        }
        // end of login action


        $user_id     = Yii::$app->request->getQueryParam('user_id');
        $date_period = Yii::$app->request->getQueryParam('date_period');
        $project_id  = Yii::$app->request->getQueryParam('project_id');
        $from_date   = Yii::$app->request->getQueryParam('from_date');
        $to_date     = Yii::$app->request->getQueryParam('to_date');
        $search_query= Yii::$app->request->getQueryParam('search_query');
        $is_invoiced = Yii::$app->request->getQueryParam('is_invoiced');
        $start       = Yii::$app->request->getQueryParam('start');
        $limit       = Yii::$app->request->getQueryParam('limit');
        $order       = Yii::$app->request->getQueryParam('order', []);

    }
}