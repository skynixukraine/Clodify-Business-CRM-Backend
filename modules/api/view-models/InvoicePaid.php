<?php
/**
 * Created by Skynix Team
 * Date: 22.05.18
 * Time: 11:46
 */
namespace viewModel;

use app\models\Invoice;
use app\models\User;
use app\modules\api\components\Api\Processor;
use Yii;


class InvoicePaid extends ViewModelAbstract
{
    /**
     * see https://jira.skynix.co/browse/SCA-154
     */
    public function define()
    {
        if(User::hasPermission([User::ROLE_ADMIN, User::ROLE_FIN])) {
            $invoiceId   = Yii::$app->request->getQueryParam('id');
            $model    = Invoice::findOne($invoiceId);
            if ($model && $model->status != Invoice::STATUS_PAID) {
                $model->status = Invoice::STATUS_PAID;
                if( $model->validate() && $model->save()){
                    $this->setData([
                        'invoice_id' => $invoiceId
                    ]);
                } else {
                    foreach ($model->getErrors() as $param=> $errors) {
                        foreach ( $errors as $error )
                            $this->addError( $param , Yii::t('yii', $error));
                    }
                }
            } else {
                $this->addError('id', Yii::t('app','That invoice can\'t be marked as PAID.'));
            }
        } else {
            $this->addError(Processor::ERROR_PARAM, Yii::t('app','You don\'t have permissions to that action. '));
        }
    }
}