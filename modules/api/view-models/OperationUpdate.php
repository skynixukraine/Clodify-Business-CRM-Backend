<?php
/**
 * Created by SkynixTeam.
 * User: igor
 * Date: 10.11.17
 * Time: 11:06
 */

namespace viewModel;

use app\models\Counterparty;
use app\models\User;
use app\modules\api\components\Api\Processor;
use yii;

class OperationUpdate extends ViewModelAbstract
{

    public function define()
    {
        $id = Yii::$app->request->getQueryParam('id');

        if (User::hasPermission([User::ROLE_ADMIN, User::ROLE_FIN])) {

        } else {
            return $this->addError(Processor::ERROR_PARAM,
                Yii::t('yii', 'You have no permission for this action'));
        }
    }
}