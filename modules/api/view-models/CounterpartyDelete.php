<?php
/**
 * Created by SkynixTeam.
 * User: igor
 * Date: 07.11.17
 * Time: 14:17
 */

namespace viewModel;

use app\models\User;
use app\models\Counterparty;
use app\models\Transaction;
use app\modules\api\components\Api\Processor;
use Yii;

/**
 * Delete counterparties data. Accepts one GET param - id.
 * Class CounterpartyDelete
 * @package viewModel
 */
class CounterpartyDelete extends ViewModelAbstract
{

    public function define()
    {
        $id = Yii::$app->request->getQueryParam('id');

        // Action available only for ADMIN role.
        if (User::hasPermission([User::ROLE_ADMIN])) {

            $model = Counterparty::findOne( $id );
            $counterparty = Transaction::find()->where(['counterparty_id' => $id])->all();
            if($model){
                if(!$counterparty){
                    $model->delete();
                } else {
                    return $this->addError(Processor::ERROR_PARAM, 'Sorry, this counteragent can not be deleted');
                }
            } else {
                return $this->addError(Processor::ERROR_PARAM, 'You are trying to delete non existent counterparty');
            }

        } else {
            return $this->addError(Processor::ERROR_PARAM, 'You have no access for this action');
        }

    }
}