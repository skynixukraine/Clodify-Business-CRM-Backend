<?php
/**
 * Created by SkynixTeam.
 * User: igor
 * Date: 07.11.17
 * Time: 12:55
 */

namespace viewModel;

use app\models\Counterparty;
use app\models\User;
use app\modules\api\components\Api\Processor;
use yii;

class CounterpartyUpdate extends ViewModelAbstract
{

    public function define()
    {
        $id = Yii::$app->request->getQueryParam('id');

        if (User::hasPermission([User::ROLE_ADMIN, User::ROLE_FIN, User::ROLE_SALES])) {

            $counterparty = Counterparty::findOne($id);

            if ($counterparty){
                if(isset($this->postData['name'])) {
                    $counterparty->setAttributes(
                        array_intersect_key($this->postData, array_flip($this->model->safeAttributes())), false
                    );

                    if ($counterparty->validate()) {
                        $counterparty->save(true);
                    } else {
                        return $this->addError(Processor::ERROR_PARAM,
                            Yii::t('yii', 'Sorry, but the entered data is not correct'));
                    }
                } else {
                    return $this->addError(Processor::ERROR_PARAM,
                        Yii::t('yii', 'You have to provide name of the counterparty'));
                }
            } else {
                return $this->addError(Processor::ERROR_PARAM,
                    Yii::t('yii', 'You are trying to update data for not existent counterparty '));
            }
        } else {
            return $this->addError(Processor::ERROR_PARAM,
                Yii::t('yii', 'You have no permission for this action'));
        }
    }
}