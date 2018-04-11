<?php
/**
 * Created by Skynix Team
 * Date: 11.04.17
 * Time: 18:28
 */

namespace viewModel;

use app\modules\api\components\Api\Processor;
use Yii;
use app\components\DateUtil;
use app\models\User;
use app\models\Invoice;
use yii\helpers\ArrayHelper;

/**
 * Class FinancialReportView
 * @package viewModel
 */
class FinancialReportView extends ViewModelAbstract
{
    public function define()
    {
        if (User::hasPermission([User::ROLE_ADMIN, User::ROLE_FIN,])) {
            $id = Yii::$app->request->getQueryParam('id');

            $invoice = Invoice::find()
                ->where(['id' => $id])
                ->one();

            if ($invoice) {

                                                                                   "customer": {
                                                                                       "id" : 123,
                                                                                       "name": "John Doe"
                                                                                   },
                                                                                   "start_date": "01/02/2017",
                                                                                   "end_date": "04/02/2017",
                                                                                   "total_hours": 11.3,
                                                                                   "subtotal": "$8400",
                                                                                   "discount": "$500",
                                                                                   "total": "$7900",
                                                                                   "notes": "",
                                                                                   "created_date": "04/02/2017",
                                                                                   "sent_date": "",
                                                                                   "paid_date": "",
                                                                                   "status": "New"








                                                                       


                $this->setData($invoice);
            }

        } else {
            return $this->addError(Processor::ERROR_PARAM, Yii::t('yii', 'You have no permission for this action'));
        }
    }
}