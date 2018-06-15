<?php
/**
 * Created by Skynix Team
 * Date: 19.04.17
 * Time: 18:27
 */

namespace viewModel;

use app\components\DateUtil;
use app\modules\api\components\Api\Processor;
use Yii;
use app\models\WorkHistory;
use app\models\User;
use yii\helpers\ArrayHelper;

class UsersWorkHistory extends ViewModelAbstract
{

    public function define()
    {

        $dateFrom   = Yii::$app->request->getQueryParam("from_date", date('d/m/Y'));
        $dateTo     = Yii::$app->request->getQueryParam("to_date", date('d/m/Y'));
        $workHistory = WorkHistory::find();
        $workHistory->where(['between', 'date_start', DateUtil::convertData($dateFrom), DateUtil::convertData($dateTo)]);
        if ( User::hasPermission([User::ROLE_ADMIN]) &&
            ($id = Yii::$app->request->getQueryParam('id')) &&
            ($user = User::findOne($id)) ) {


            $workHistory = $workHistory
                ->andWhere([WorkHistory::tableName() . '.user_id' => $user->id])
                ->orderBy(['id' => SORT_DESC])
                ->all();

        } else if ( ($slug = Yii::$app->request->getQueryParam('slug')) &&
            ($user = User::findOne(['slug' => $slug])) &&
            $user->is_published == true) {

            $workHistory = $workHistory
                ->andWhere(['type' => WorkHistory::TYPE_PUBLIC])
                ->andWhere([WorkHistory::tableName() . '.user_id' => $user->id])
                ->orderBy(['id' => SORT_DESC])
                ->all();

        } else {

            return $this->addError(Processor::ERROR_PARAM, Yii::t('app', 'Sorry, no access to data'));
        }


        $workHistory = ArrayHelper::toArray($workHistory, [
            WorkHistory::className() => [
              'id', 'date_start', 'date_end', 'type', 'title'
            ],
        ]);

        $data = [
            'workHistory' => $workHistory,
        ];
        $this->setData($data);
    }

}