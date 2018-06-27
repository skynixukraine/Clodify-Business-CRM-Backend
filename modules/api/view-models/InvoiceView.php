<?php
/**
 * Created by Skynix Team
 * Date: 11.04.18
 * Time: 13:28
 */

namespace viewModel;

use app\modules\api\components\Api\Processor;
use Yii;
use app\models\User;
use app\models\Invoice;


/**
 * Class InvoiceView
 * @package viewModel
 */
class InvoiceView extends ViewModelAbstract
{
    public function define()
    {
        if (User::hasPermission([User::ROLE_ADMIN, User::ROLE_FIN,])) {

            $id = Yii::$app->request->getQueryParam('id');
           $invoice = [];
           /** @var  $invoiceModel Invoice */
            $invoiceModel = Invoice::find()
                ->where(['id' => $id])
                ->with('user')
                ->one();

            if ($invoiceModel) {
                $invoice[] = [
                    'invoice_id'    => $invoiceModel->invoice_id,
                    "business_id"   => $invoiceModel->business_id,
                    "customer" =>  [
                        "id" => $invoiceModel->user->id,
                        "name" => $invoiceModel->user->first_name . ' ' . $invoiceModel->user->last_name ,
                    ],
                    "start_date"   => $invoiceModel->date_start,
                    "end_date"     => $invoiceModel->date_end,
                    "total_hours"  => $invoiceModel->total_hours,
                    "subtotal"     => $invoiceModel->subtotal > 0 ? '$' . $invoiceModel->subtotal : 0,
                    "discount"     => $invoiceModel->discount > 0 ? '$' . $invoiceModel->discount : 0,
                    "total"        => $invoiceModel->total > 0 ? '$' . $invoiceModel->total : 0,
                    "notes"        => $invoiceModel->note,
                    "created_date" => $invoiceModel->date_created,
                    "sent_date"    => $invoiceModel->date_sent,
                    "paid_date"    => $invoiceModel->date_paid,
                    "status"       => $invoiceModel->status,
                ];

                $this->setData($invoice);

            } else {
                $this->addError('data', 'Invoice not found');
            }

        } else {
            return $this->addError(Processor::ERROR_PARAM, Yii::t('app', 'You have no permission for this action'));
        }
    }
}