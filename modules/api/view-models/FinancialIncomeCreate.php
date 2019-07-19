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

                        if (User::hasPermission([User::ROLE_ADMIN])) {
                            $admin = User::findOne(Yii::$app->user->identity->getId());

                            if ($admin) {
                                Yii::$app->mailer->compose()
                                    ->setFrom([Yii::$app->params['fromEmail'] => 'Clodify Notification'])
                                    ->setTo($admin->email)
                                    ->setSubject('Financial income with ID ' . $this->model->id . ' has been created')
                                    ->setHtmlBody(
                                        '<p>Hi, ' . $admin->getFullName() . '</p>'
                                        . '<p>The financial income has been created with attributes:</p>'
                                        . '<ul><li>ID: ' . ($this->model->id ?? 'null') . '</li>'
                                        . '<li>Amount: ' . ($this->model->amount ?? 'null') . '</li>'
                                        . '<li>Description: ' . ($this->model->description ?? 'null') . '</li>'
                                        . '<li>Project ID: ' . ($this->model->project_id ?? 'null') . '</li>'
                                        . '<li>Added by user ID: ' . ($this->model->added_by_user_id ?? 'null') . '</li>'
                                        . '<li>Developer user ID: ' . ($this->model->developer_user_id ?? 'null') . '</li>'
                                        . '<li>Financial report ID: ' . ($this->model->financial_report_id ?? 'null') . '</li>'
                                        . '<li>Date: ' . (date('d/m/Y', $this->model->date) ?? 'null') . '</li>'
                                        . '<li>From date: ' . (date('d/m/Y', $this->model->from_date) ?? 'null') . '</li>'
                                        . '<li>To date: ' . (date('d/m/Y', $this->model->to_date) ?? 'null') . '</li></ul>'
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