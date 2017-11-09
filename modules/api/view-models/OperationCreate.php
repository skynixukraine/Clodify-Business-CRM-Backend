<?php
/**
 * Created by SkynixTeam.
 * User: igor
 * Date: 09.11.17
 * Time: 12:06
 */

namespace viewModel;

use app\models\Transaction;
use app\models\User;
use app\models\Operation;
use app\modules\api\components\Api\Processor;
use Yii;

/**
 * Class OperationCreate
 *
 * @package viewModel
 * @see     https://jira.skynix.company/browse/SCA-55
 * @author  Igor (Skynix)
 */
class OperationCreate extends ViewModelAbstract
{
    private $operationId ;

    public function define()
    {
        if (User::hasPermission([User::ROLE_ADMIN, User::ROLE_FIN])) {
            
//bussiness_id                       `id` INT NOT NULL AUTO_INCREMENT,            `id` INT NOT NULL,
//name                               `business_id` INT NOT NULL,                  `type` ENUM('DEBIT', 'CREDIT') NULL,
//operation_type_id                  `name` VARCHAR(255) NULL,                    `name` VARCHAR(255) NULL,
//transaction_name                   `status` ENUM('DONE', 'CANCELED') NULL,      `date` INT NULL,
//amount                             `date_created` INT NULL,                     `amount` DECIMAL(15,2) NULL,
//currency                           `date_updated` INT NULL,                     `currency` ENUM('USD', 'UAH') NULL,
//debit_reference_id                 `operation_type_id` INT NOT NULL,            `reference_book_id` INT NOT NULL,
//credit_reference_id                                                             `counterparty_id` INT NOT NULL,
//debit_counterparty_id                                                           `operation_id` INT NOT NULL,
//credit_counterparty_id                                                          `operation_business_id` INT NOT NULL,


            $bussiness_id = $this->postData['bussiness_id'];
            $name = $this->postData['name'];
            $operation_type_id = $this->postData['operation_type_id'];
            $transaction_name = $this->postData['transaction_name'];
            $amount = $this->postData['amount'];
            $currency = $this->postData['currency'];
            $debit_reference_id = $this->postData['debit_reference_id'];
            $credit_reference_id = $this->postData['credit_reference_id'];
            $debit_counterparty_id  = $this->postData['debit_counterparty_id'];
            $credit_counterparty_id = $this->postData['credit_counterparty_id'];

//            var_dump($amount);
//            var_dump($bussiness_id);
//            exit();

            $operation = new Operation();
            $operation->business_id = $bussiness_id;
            $operation->name = $name;
            $operation->date_created = time();
            $operation->operation_type_id = $operation_type_id;
            $operation->save(false);
            $this->operationId = $operation->id;

            $transaction1 = new Transaction();
            $transaction1->type = Transaction::DEBIT;
            $transaction1->name =  $transaction_name;
            $transaction1->date = time();
            $transaction1->amount = $amount;
            $transaction1->currency = $currency;
            $transaction1->reference_book_id = $debit_reference_id;
            $transaction1->counterparty_id = $debit_counterparty_id;
            $transaction1->operation_id = $this->operationId;
            $transaction1->operation_business_id = $bussiness_id;
            $transaction1->save(false);

            $transaction2 = new Transaction();
            $transaction2->type = Transaction::CREDIT;
            $transaction2->name =  $transaction_name;
            $transaction2->date = time();
            $transaction2->amount = $amount;
            $transaction2->currency = $currency;
            $transaction2->reference_book_id = $credit_reference_id;
            $transaction2->counterparty_id = $credit_counterparty_id;
            $transaction2->operation_id = $this->operationId;
            $transaction2->operation_business_id = $bussiness_id;
            if ($transaction2->save(false)) {
                $this->setData([
                    'operation' => $this->operationId
                ]);
            }

        } else {
            return $this->addError(Processor::ERROR_PARAM, Yii::t('yii', 'You have no permission for this action'));
        }
    }
}