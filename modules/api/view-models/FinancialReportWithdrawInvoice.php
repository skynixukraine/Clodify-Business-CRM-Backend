<?php

declare(strict_types=1);

namespace viewModel;

use app\models\FinancialIncome;
use app\models\FinancialReport;
use app\models\Invoice;
use app\models\User;
use app\modules\api\components\Api\Processor;
use Yii;

class FinancialReportWithdrawInvoice extends ViewModelAbstract
{
    /**
     * @var FinancialReport
     */
    private $report;

    /**
     * @var Invoice
     */
    private $invoice;

    public function __construct()
    {
        $id = Yii::$app->request->getQueryParam('id');
        $invoiceId = Yii::$app->request->getQueryParam('invoice_id');

        $this->report = FinancialReport::findOne($id);

        if ($this->report) {
            $this->invoice = Invoice::findOne($invoiceId);
        }
    }

    /**
     * {@inheritDoc}
     */
    public function define()
    {
        if (! User::hasPermission([User::ROLE_ADMIN, User::ROLE_FIN, User::ROLE_SALES])) {
            return $this->addError(Processor::ERROR_PARAM, 'You have no permission for this action');
        }

        if ($this->report === null) {
            return $this->addError(Processor::ERROR_PARAM, 'Financial report not found');
        }

        if ($this->invoice === null) {
            return $this->addError(Processor::ERROR_PARAM, 'Invoice not found');
        }

        if ($this->invoice->is_withdrawn) {
            return $this->addError(Processor::ERROR_PARAM, 'Invoice already withdrawn');
        }

        if (! isset($this->postData['parties']) || ! is_array($this->postData['parties'])) {
            return $this->addError(Processor::ERROR_PARAM, 'Parties must be passed as array');
        }

        $parties = $this->postData['parties'];

        foreach ($parties as $part) {
            if (! isset($part['id'], $part['amount'])) {
                return $this->addError(Processor::ERROR_PARAM, 'Each item of parties must contain id and amount');
            }
        }

        $amountSum = array_reduce($parties, static function (float $carry, array $part) {
            return $carry + $part['amount'];
        }, 0.0);

        if ($amountSum > $this->invoice->total) {
            return $this->addError(Processor::ERROR_PARAM, 'Distribute invoice amount properly between parties. Distributed amount is bigger');
        }

        if ($amountSum < $this->invoice->total) {
            return $this->addError(Processor::ERROR_PARAM, 'Distribute invoice amount properly between parties. Distributed amount is smaler');
        }

        $transaction = FinancialIncome::getDb()->beginTransaction();

        try {
            foreach ($parties as $part) {
                $income = new FinancialIncome();
                $income->invoice_id = $this->invoice->id;
                $income->financial_report_id = $this->report->id;
                $income->amount = $part['amount'];
                $income->added_by_user_id = Yii::$app->user->identity->getId();
                $income->developer_user_id = $part['id'];
                $income->from_date = strtotime($this->invoice->date_start);
                $income->to_date = strtotime($this->invoice->date_end);

                if (! $income->save()) {
                    return $this->addError(Processor::ERROR_PARAM, $income->getErrors());
                }
            }

            $this->invoice->is_withdrawn = true;
            if (! $this->invoice->save()) {
                return $this->addError(Processor::ERROR_PARAM, $this->invoice->getErrors());
            }
        } catch (\Exception $exception) {
            $transaction->rollBack();
            Yii::error($exception->getMessage());
            return $this->addError(Processor::ERROR_PARAM, 'Data hasn\'t been saved. Something went wrong');
        }

        $transaction->commit();
    }
}