<?php
/**
 * Created by Skynix Team
 * Date: 23.07.17
 * Time: 15:17
 */

namespace viewModel;

use app\components\DateUtil;
use app\models\FinancialReport;
use app\models\User;
use app\modules\api\components\Api\Processor;
use yii;

/**
 * Class FinancialReportUpdate
 * @package viewModel
 */
class FinancialReportUpdate extends ViewModelAbstract
{

    public function define()
    {
        $id = Yii::$app->request->getQueryParam('id');

        if (User::hasPermission([User::ROLE_ADMIN, User::ROLE_FIN,])) {

            $financialReport = FinancialReport::findOne($id);

            if ($financialReport) {

                if (!$financialReport->is_locked) {

                    if (isset($this->postData['income']) && User::hasPermission([User::ROLE_ADMIN])) {

                        $this->postData['income'] = $this->getElement('income');

                    } else {
                        unset($this->postData['income']);
                    }

                    if (isset($this->postData['expense_constant'])) {

                        $this->postData['expense_constant'] = $this->getElement('expense_constant');
                    }

                    if (isset($this->postData['investments'])) {

                        $this->postData['investments'] = $this->getElement('investments');
                    }

                    if (isset($this->postData['spent_corp_events'])) {

                        $this->postData['spent_corp_events'] = $this->getElement('spent_corp_events');

                    }

                    $financialReport->setAttributes(
                        array_intersect_key($this->postData, array_flip($this->model->safeAttributes())), false
                    );

                    $financialReport->setScenario(FinancialReport::SCENARIO_FINANCIAL_REPORT_UPDATE);

                    if ($financialReport->validate()) {
                        $financialReport->save(true);
                    } else {
                        return $this->addError(Processor::ERROR_PARAM,
                            Yii::t('yii', 'Sorry, but the entered data is not correct'));
                    }

                } else {
                    return $this->addError(Processor::ERROR_PARAM,
                        Yii::t('yii', 'Sorry, but this report period is locked. It is not editable'));
                }

            } else {
                return $this->addError(Processor::ERROR_PARAM,
                    Yii::t('yii', 'This financial report not exist. It is not editable'));
            }

        } else {
            return $this->addError(Processor::ERROR_PARAM,
                Yii::t('yii', 'You have no permission for this action'));
        }
    }


    /**
     * @param $attributName
     * @return string
     */
    private function getElement($attributName)
    {
        return json_encode($this->postData[$attributName]);
    }

}