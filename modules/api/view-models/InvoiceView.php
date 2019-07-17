<?php
/**
 * Created by Skynix Team
 * Date: 11.04.18
 * Time: 13:28
 */

namespace viewModel;

use app\components\DateUtil;
use app\models\Report;
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

            $reports = $invoiceModel->getReports()
                ->select(['reports.user_id', 'CONCAT(first_name, " ",  last_name) as reporter_name', 'sum(hours) as hours'])
                ->leftJoin('users', 'reports.user_id=users.id')
                ->where(['is_approved' => 1, 'reports.status' => Report::STATUS_INVOICED])
                ->groupBy('reports.user_id')
                ->all();

            $parties = array_map(static function (Report $report) {
                return [
                    'user_id' => $report->user_id,
                    'name' => $report->reporter_name,
                    'hours' => $report->hours
                ];
            }, $reports);

            if ($invoiceModel) {
                $invoice[] = [
                    'id'            => $invoiceModel->id,
                    'invoice_id'    => $invoiceModel->invoice_id,
                    "payment_method_id"   => $invoiceModel->payment_method_id,
                    "customer" =>  [
                        "id" => $invoiceModel->user->id,
                        "name" => $invoiceModel->user->first_name . ' ' . $invoiceModel->user->last_name ,
                    ],
                    "start_date"   => DateUtil::reConvertData( $invoiceModel->date_start ),
                    "end_date"     => DateUtil::reConvertData( $invoiceModel->date_end ),
                    "total_hours"  => $invoiceModel->total_hours,
                    "subtotal"     => $invoiceModel->subtotal > 0 ? $invoiceModel->subtotal : 0,
                    "discount"     => $invoiceModel->discount > 0 ? $invoiceModel->discount : 0,
                    "total"        => $invoiceModel->total > 0 ? $invoiceModel->total : 0,
                    "currency"     => $invoiceModel->currency,
                    "notes"        => $invoiceModel->note,
                    "created_date" => $invoiceModel->date_created,
                    "sent_date"    => $invoiceModel->date_sent,
                    "paid_date"    => $invoiceModel->date_paid,
                    "status"       => $invoiceModel->status,
                    'is_withdrawn' => $invoiceModel->is_withdrawn,
                    'parties'      => $parties,
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