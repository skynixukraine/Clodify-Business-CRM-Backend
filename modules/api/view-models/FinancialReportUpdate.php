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

            if (!$financialReport->is_locked) {

                if (isset($this->postData['report_date'])) {

                    $reportDate = $this->getDay($financialReport->report_date) .
                        $this->postData['report_date'] .
                        $this->getYear($financialReport->report_date);


                    $reportDate = DateUtil::convertDateToUnix($reportDate);

                        if (!FinancialReport::validateReportDate($reportDate)) {
                            return $this->addError(Processor::ERROR_PARAM, Yii::t('yii', 'The report is already created'));
                        }

                        $this->postData['report_date'] = $reportDate;
                    }

                    if (User::hasPermission([User::ROLE_ADMIN])) {

                        $this->postData['income'] = $this->getElement('income', $financialReport);

                    } else {
                        unset($this->postData['income']);
                    }

                    if (isset($this->postData['expense_constant'])) {

                        $this->postData['expense_constant'] = $this->getElement('expense_constant', $financialReport);
                    }

                    if (isset($this->postData['investments'])) {

                        $this->postData['investments'] = $this->getElement('investments', $financialReport);
                    }

                    if (isset($this->postData['spent_corp_events'])) {

                        $this->postData['spent_corp_events'] = $this->getElement('spent_corp_events', $financialReport);

                    }

                    $financialReport->setAttributes(
                        array_intersect_key($this->postData, array_flip($this->model->safeAttributes())), false
                    );

                    if ($financialReport->validate()) {
                        $financialReport->save();
                    }

                } else {
                    return $this->addError(Processor::ERROR_PARAM,
                        Yii::t('yii', 'Sorry, but this report period is locked. It is not editable'));
                }

            } else {
                return $this->addError(Processor::ERROR_PARAM,
                    Yii::t('yii', 'You have no permission for this action'));
            }
        }

    /**
     *
     * get values for converting date element
     * @param $attributes
     * @param FinancialReport $financialReport
     * @return array|null
     */
    private function getElement($attributName, FinancialReport $financialReport)
    {
        return $this->convertDateForElement(
            $this->postData[$attributName],
            $this->postData['report_date'],
            $financialReport);
    }

    /**
     *
     * convert date from day format to timestamp for db
     * @param $array
     * @param $month
     * @param $financialReport
     * @return null|array
     */
    private function convertDateForElement($array, $reportDateFromPost, $financialReport)
    {
        if (is_array($array)) {
            foreach ($array as &$arr) {
                if (!empty ($arr)) {
                   $arr['date'] = DateUtil::convertDateToUnix(
                       $arr['date'] . '.' .
                       $this->getMonth($reportDateFromPost) .
                       $this->getYear($financialReport->report_date));
                }
            }

            return json_encode($array);
        }

        return null;
    }

    /**
     * @param $data
     * @return false|string
     */
    private  function getDay($data)
    {
        return date("d.",$data);
    }

    /**
     * @param $data
     * @return false|string
     */
    private  function getYear($data)
    {
        return date(".Y",$data);
    }

    /**
     * @param $data
     * @return false|string
     */
    private function getMonth($data)
    {
        return date( "m",$data);
    }
}