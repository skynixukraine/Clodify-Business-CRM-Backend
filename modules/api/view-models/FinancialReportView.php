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
use app\models\FinancialReport;
use yii\helpers\ArrayHelper;

class FinancialReportView extends ViewModelAbstract
{
    public function define()
    {
        if (User::hasPermission([User::ROLE_ADMIN, User::ROLE_FIN,])) {
        $id = Yii::$app->request->getQueryParam('id');

        $financialReport = FinancialReport::find()
            ->where([FinancialReport::tableName() . '.id' => $id])
            ->one();
            $data = ArrayHelper::toArray($financialReport, [
                'app\models\FinancialReport' => [
                    'id',
                    'report_data' => function ($financialReport) {
                         return DateUtil::convertDateFromUnix($financialReport->report_data);
                    },
                    'currency',
                    'expense_salary',
                    'income' => function ($financialReport) {
                         return json_decode($financialReport->income);
                    },
                    'expense_constant'=> function ($financialReport) {
                         return json_decode($financialReport->expense_constant);
                    },
                    'investments' => function ($financialReport) {
                         return json_decode($financialReport->expense_constant);
                    },
                ],

            ]);

            $this->setData($data);
        } else {
            return $this->addError(Processor::ERROR_PARAM, Yii::t('yii', 'You have no permission for this action'));
        }
    }
}