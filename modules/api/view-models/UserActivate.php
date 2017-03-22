<?php
/**
 * Created by Skynix Team
 * Date: 10.03.17
 * Time: 10:18
 */
namespace viewModel;

use app\models\User;
use app\modules\api\components\Api\Processor;
use Yii;



class UserActivate extends ViewModelAbstract
{
    public function define()
    {
        $userId   = Yii::$app->request->getQueryParam('id');
        $model    = User::findOne($userId);
        if(User::hasPermission([User::ROLE_ADMIN])) {
            if ($model) {
                if($model->is_delete == 1) {
                    return $this->addError(Processor::ERROR_PARAM, Yii::t('app','You can\'t activate deleted user.'));
                }
                $model->is_active = 1;
                $model->save(true, ['is_active']);
            } else {
                $this->addError('id', Yii::t('app','Such user is not existed'));
            }
        } else {
            $this->addError(Processor::ERROR_PARAM, Yii::t('app','You don\'t have permissions. Only admin can activate or deactivate users.'));
        }
    }
}