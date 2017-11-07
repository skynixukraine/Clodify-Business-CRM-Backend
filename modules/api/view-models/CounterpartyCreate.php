<?php
/**
 * Created by SkynixTeam.
 * User: igor
 * Date: 07.11.17
 * Time: 9:16
 */

namespace viewModel;

use app\models\Counterparty;
use app\models\User;
use app\modules\api\components\Api\Processor;
use Yii;

/**
 * Class CounterpartyCreate
 *
 * @package viewModel
 * @see     https://jira.skynix.company/browse/SCA-43
 * @author  Igor (Skynix)
 */
class CounterpartyCreate extends ViewModelAbstract
{
    public function define()
    {
        if (User::hasPermission([User::ROLE_ADMIN, User::ROLE_FIN])) {
            $name = $this->postData['name'];

            if ($name) {
                $this->model->name = $name;
            } else {
                return $this->addError(Processor::ERROR_PARAM, Yii::t('yii', 'You have to provide name of the counterparty'));
            }

            if ($this->validate() && $this->model->save()) {
                $this->setData([
                    'counterparty_id' => $this->model->id
                ]);
            }

        } else {
            return $this->addError(Processor::ERROR_PARAM, Yii::t('yii', 'You have no permission for this action'));
        }
    }
}