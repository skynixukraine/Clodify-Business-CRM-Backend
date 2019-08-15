<?php
/**
 * Create By Skynix Team
 * Author: oleksii
 * Date: 6/9/18
 * Time: 10:41 PM
 */

namespace viewModel;

use app\models\FinancialIncome;
use app\models\FinancialReport;
use app\models\User;
use app\modules\api\components\Api\Processor;
use Yii;

/**
 * @see https://jira.skynix.co/browse/SCA-176
 * Class FinancialIncomeCreate
 * @package viewModel
 */
class FinancialIncomeCreate extends ViewModelAbstract
{
    /** @var  FinancialIncome */
    protected $model;

    public function define()
    {

        if (User::hasPermission([User::ROLE_ADMIN, User::ROLE_SALES])) {

            if ( ($id = Yii::$app->request->getQueryParam('id') ) &&
                ( $financialReport = FinancialReport::findOne($id) )) {
                if (!$financialReport->is_locked) {

                    $this->model->financial_report_id   = $id;
                    $this->model->added_by_user_id      = Yii::$app->user->id;
                    if ( $this->validate() ) {
                        $this->model->save();

                        if (User::hasPermission([User::ROLE_SALES])) {
                            setlocale(LC_MONETARY, 'en_US');
                            $reportDate = strtotime($financialReport->report_date);
                            $reportMonthYear = date('m/Y', $reportDate);

                            foreach (User::getAdmins() as $admin) {
                                $amount = money_format('$%.2n', $this->model->amount ?? 0.0);
                                $projectName = $this->model->project ? $this->model->project->name : 'null';
                                $addedByUser = ($addedByUser = $this->model->addedByUser)
                                    ? ($addedByUser->first_name . ' ' . $addedByUser->last_name) : 'null';
                                $developerUser = ($developerUser = $this->model->developerUser)
                                    ? ($developerUser->first_name . ' ' . $developerUser->last_name) : 'null';
                                $date =  date('d/m/Y', $this->model->date) ?? 'null';
                                $fromDate = $this->model->from_date
                                    ? ($this->model->from_date < 10 ? '0' . $this->model->from_date : $this->model->from_date)
                                    . '/' . $reportMonthYear : 'null';
                                $toDate = $this->model->to_date
                                    ? ($this->model->to_date < 10 ? '0' . $this->model->to_date : $this->model->to_date)
                                    . '/' . $reportMonthYear : 'null';

                                Yii::$app->mailer->compose()
                                    ->setFrom([Yii::$app->params['fromEmail'] => 'Clodify Notification'])
                                    ->setTo($admin->email)
                                    ->setSubject('Financial income with ID ' . $this->model->id . ' has been created')
                                    ->setHtmlBody(
                                        '<p>Hi, ' . $admin->getFullName() . '</p>'
                                        . '<p>The financial income has been created with attributes:</p>'
                                        . '<ul><li>ID: ' . ($this->model->id ?? 'null') . '</li>'
                                        . '<li>Amount: ' . $amount . '</li>'
                                        . '<li>Description: ' . ($this->model->description ?? 'null') . '</li>'
                                        . '<li>Project: ' . $projectName . '</li>'
                                        . '<li>Added by: ' . $addedByUser . '</li>'
                                        . '<li>Developer user: ' . $developerUser . '</li>'
                                        . '<li>Financial report ID: ' . ($this->model->financial_report_id ?? 'null') . '</li>'
                                        . '<li>Date: ' . $date . '</li>'
                                        . '<li>From date: ' . $fromDate . '</li>'
                                        . '<li>To date: ' . $toDate . '</li></ul>'
                                    )
                                    ->send();
                            }
                        }
                    }

                } else {
                    return $this->addError(Processor::ERROR_PARAM, Yii::t('app', 'Financial Report is locked any operations are forbidden'));
                }

            } else {
                return $this->addError(Processor::ERROR_PARAM, Yii::t('app', 'You are trying to add income for not existent financial report'));
            }

        } else {
            return $this->addError(Processor::ERROR_PARAM, Yii::t('app', 'You have no permission for this action'));
        }

    }
}