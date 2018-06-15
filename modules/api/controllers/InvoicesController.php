<?php
/**
 * Created by Skynix Team
 * Date: 21.04.17
 * Time: 17:33
 */

namespace app\modules\api\controllers;

use app\models\Invoice;
use app\modules\api\components\Api\Processor;

class InvoicesController extends DefaultController
{

    public function actionFetch()
    {
        $this->di
            ->set('yii\db\ActiveRecordInterface', 'app\models\Invoice')
            ->set('viewModel\ViewModelInterface', 'viewModel\InvoicesFetch')
            ->set('app\modules\api\components\Api\Access', [
                'methods' => [Processor::METHOD_GET],
                'checkAccess' => true
            ])
            ->get('Processor')
            ->respond();
    }

    public function actionCreate()
    {
        $this->di
            ->set('app\models\Invoice', ['scenario' => Invoice::SCENARIO_INVOICE_CREATE])
            ->set('yii\db\ActiveRecordInterface', 'app\models\Invoice')
            ->set('viewModel\ViewModelInterface', 'viewModel\InvoiceCreate')
            ->set('app\modules\api\components\Api\Access', [
                'methods'       => [ Processor::METHOD_POST ],
                'checkAccess'   => true
            ])
            ->get('Processor')
            ->respond();
    }

    public function actionDelete()
    {
        $this->di
            ->set('yii\db\ActiveRecordInterface', 'app\models\Invoice')
            ->set('viewModel\ViewModelInterface', 'viewModel\InvoiceDelete')
            ->set('app\modules\api\components\Api\Access', [
                'methods'       => [ Processor::METHOD_DELETE ],
                'checkAccess'   => true
            ])
            ->get('Processor')
            ->respond();
    }

    /**
     * see  https://jira.skynix.co/browse/SCA-132
     */
    public function actionView()
    {
        $this->di
            ->set('yii\db\ActiveRecordInterface', 'app\models\Invoice')
            ->set('viewModel\ViewModelInterface', 'viewModel\InvoiceView')
            ->set('app\modules\api\components\Api\Access', [
                'methods' => [Processor::METHOD_GET ],
                'checkAccess' => true
            ])
            ->get('Processor')
            ->respond();
    }

    /**
     * see  https://jira.skynix.co/browse/SCA-154
     */
    public function actionPaid()
    {
        $this->di
            ->set('yii\db\ActiveRecordInterface', 'app\models\Invoice')
            ->set('viewModel\ViewModelInterface', 'viewModel\InvoicePaid')
            ->set('app\modules\api\components\Api\Access', [
                'methods' => [Processor::METHOD_PUT ],
                'checkAccess' => true
            ])
            ->get('Processor')
            ->respond();
    }

    public function actionDownload()
    {
        $this->di
            ->set('yii\db\ActiveRecordInterface', 'app\models\Invoice')
            ->set('viewModel\ViewModelInterface', 'viewModel\InvoiceDownload')
            ->set('app\modules\api\components\Api\Access', [
                'methods'     => [Processor::METHOD_GET],
                'checkAccess' => true
            ])
            ->get('Processor')
            ->respond();
    }
}