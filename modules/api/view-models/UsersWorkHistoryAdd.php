<?php
/**
 * Create By Skynix Team
 * Author: oleksii
 * Date: 6/11/18
 * Time: 9:08 PM
 */

namespace viewModel;
use app\components\DateUtil;
use app\modules\api\components\Api\Processor;
use Yii;
use app\models\WorkHistory;
use app\models\User;
use yii\helpers\ArrayHelper;


class UsersWorkHistoryAdd extends ViewModelAbstract
{
    /** @var  WorkHistory */
    protected $model;

    public function define()
    {

        if ( User::hasPermission([User::ROLE_ADMIN, User::ROLE_SALES]) &&
            ($id = Yii::$app->request->getQueryParam('id')) &&
            $id !== Yii::$app->user->id &&
            ($user = User::findOne($id)) ) {

            $this->model->date_start = DateUtil::convertData( $this->model->date_start  );
            $this->model->date_end = DateUtil::convertData( $this->model->date_end  );

            $this->model->added_by_user_id  = Yii::$app->user->id;
            $this->model->user_id           = $user->id;

            if ($this->validate()) {

                $this->model->save();
                $this->setData([
                    'id' => $this->model->id
                ]);

            }

        } else {

            return $this->addError(Processor::ERROR_PARAM, Yii::t('app', 'Sorry, no access to post a new item'));
        }

    }

}