<?php
/**
 * Created by Skynix Team
 * Date: 18.04.18
 * Time: 16:23
 */

namespace viewModel;

use app\models\Operation;
use Yii;
use app\models\User;
use app\modules\api\components\Api\Processor;

class OperationDelete extends ViewModelAbstract
{
    /** @deprecated */
    public function define()
    {
        if (User::hasPermission([User::ROLE_ADMIN, User::ROLE_FIN])) {
            $id = Yii::$app->request->getQueryParam("id");
            $operation = Operation::findOne($id);
            $operation->is_deleted = 1;
            $operation->update();
        } else {
            return $this->addError(Processor::ERROR_PARAM, Yii::t('yii', 'You have no permission for this action'));
        }
    }
}