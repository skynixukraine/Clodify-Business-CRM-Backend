<?php
/**
 * Created by Skynix Team
 * Date: 19.04.17
 * Time: 18:27
 */

namespace viewModel;

use Yii;
use app\models\WorkHistory;
use app\models\User;
use yii\helpers\ArrayHelper;

class UsersWorkHistory extends ViewModelAbstract
{

    public function define()
    {
        $slug = Yii::$app->request->getQueryParam('slug');

        if (!($user = User::findOne(['slug' => $slug])) || $user->is_published != true) {
            return $this->addError('work-history', 'Sorry, no access to data');
        }

        $workHistory = WorkHistory::find()
            ->andWhere([WorkHistory::tableName() . '.user_id' => $user->id])
            ->orderBy(['date_start' => SORT_DESC])
            ->all();

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