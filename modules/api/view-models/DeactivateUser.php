<?php
/**
 * Created by Skynix Team
 * Date: 10.03.17
 * Time: 16:46
 */
namespace viewModel;

use app\models\User;
use app\modules\api\components\Api\Processor;
use Yii;

class DeactivateUser extends ViewModelAbstract
{
    public function define()
    {
        $userId   = Yii::$app->request->getQueryParam('id');
        $model    = User::findOne($userId);
        if(User::hasPermission([User::ROLE_ADMIN])) {
            if ($model) {
                $model->is_active = 0;
                $model->save(true, ['is_active']);
            } else {
                $this->addError('id', Yii::t('app','Such user is not existed'));
            }
        } else {
            $this->addError(Processor::ERROR_PARAM, Yii::t('app','You don\'t have permissions. Only admin can activate or deactivate users.'));
        }
    }
}