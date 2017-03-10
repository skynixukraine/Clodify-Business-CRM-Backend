<?php
/**
 * Created by Skynix Team
 * Date: 10.03.17
 * Time: 10:18
 */
namespace viewModel;

use app\components\DataTable;
use app\models\Project;
use app\models\ProjectCustomer;
use app\models\ProjectDeveloper;
use app\models\Report;
use app\models\User;
use app\modules\api\components\Api\Processor;
use Yii;
use DateTime;
use app\modules\api\components\SortHelper;


class ActivateDeactivateUser extends ViewModelAbstract
{
    public function define()
    {
        $userId   = Yii::$app->request->getQueryParam('id');
        $model    = User::findOne($userId);
        if(User::hasPermission([User::ROLE_ADMIN])) {
            if ($model) {
                if (strpos($_SERVER["REQUEST_URI"], 'deactivate')) {
                    $model->is_active = 0;
                } else {
                    $model->is_active = 1;
                }
                $model->save(true, ['is_active']);
            } else {
                $this->addError('id', Yii::t('app','Such user is not existed'));
            }
        } else {
            $this->addError(Processor::ERROR_PARAM, Yii::t('app','You don\'t have permissions. Only admin can activate or deactivate users.'));
        }
    }
}