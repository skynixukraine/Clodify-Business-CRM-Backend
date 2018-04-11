<?php
/**
 * Created by Skynix Team
 * Date: 27.04.17
 * Time: 18:30
 */

namespace viewModel;

use Yii;
use app\models\Invoice;
use app\models\User;
use app\models\Report;
use app\models\Contract;
use app\modules\api\components\Api\Processor;

class InvoiceDelete extends ViewModelAbstract
{
    public function define()
    {
        if (User::hasPermission([User::ROLE_ADMIN, User::ROLE_FIN])) {
            $invoiceId = Yii::$app->request->getQueryParam("invoice_id");
            if ($invoiceId) {
                $model = Invoice::find()
                    ->where(['id' => $invoiceId])
                    ->one();
                $model->is_delete = 1;
                if ($model->save(true, ['is_delete'])) {
                    $reports = Report::find()->where(['invoice_id' => $invoiceId])->all();
                    foreach ($reports as $report) {
                        $report->invoice_id = null;
                        $report->save(false);
                    }
                }
            }
        } else {
            return $this->addError(Processor::ERROR_PARAM, 'You have no permission for this action');
        }
    }
}