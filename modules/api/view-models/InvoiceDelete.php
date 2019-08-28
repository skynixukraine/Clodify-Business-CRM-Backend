<?php
/**
 * Created by Skynix Team
 * Date: 27.04.17
 * Time: 18:30
 */

namespace viewModel;

use app\models\FinancialIncome;
use app\models\FinancialReport;
use Yii;
use app\models\Invoice;
use app\models\User;
use app\modules\api\components\Api\Processor;

class InvoiceDelete extends ViewModelAbstract
{
    /**
     * @var Invoice
     */
    private $invoice;

    public function __construct()
    {
        $invoiceId = Yii::$app->request->getQueryParam('invoice_id');

        $this->invoice = Invoice::findOne($invoiceId);
    }

    public function define()
    {
        if (! User::hasPermission([User::ROLE_ADMIN, User::ROLE_FIN])) {
            return $this->addError(Processor::ERROR_PARAM, 'You have no permission for this action');
        }

        if (! $this->invoice) {
            return $this->addError(Processor::ERROR_PARAM, 'Invoice not found');
        }

        if ($this->invoice->is_withdrawn) {
            $isLocked = FinancialReport::find()
                    ->select('financial_reports.is_locked')
                    ->rightJoin('financial_income', 'financial_reports.id=financial_income.financial_report_id')
                    ->where(['financial_income.invoice_id' => $this->invoice->id])
                    ->asArray()
                    ->one()['is_locked'] ?? null;

            if ($isLocked) {
                return $this->addError(Processor::ERROR_PARAM, 'the invoice can not be deleted because financial report is locked');
            }
        }

        $this->invoice->is_delete = 1;

        $transaction = Invoice::getDb()->beginTransaction();

        try {
            if (! $this->invoice->save(true, ['is_delete'])) {
                $transaction->rollBack();
                return $this->addError(Processor::ERROR_PARAM, $this->invoice->getErrors());
            }

            foreach ($this->invoice->reports as $report) {
                $report->invoice_id = null;
                $report->save(false, ['invoice_id']);
            }

            if ($this->invoice->is_withdrawn) {
                FinancialIncome::deleteAll(['invoice_id' => $this->invoice->id]);
            }
        } catch (\Exception $exception) {
            $transaction->rollBack();
            return $this->addError(Processor::CODE_TEHNICAL_ISSUE, $exception->getMessage());
        }

        $transaction->commit();
    }
}