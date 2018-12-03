<?php
/**
 * Created by Skynix Team
 * Date: 17.10.18
 * Time: 14:48
 */

namespace app\commands;

use Yii;
use app\models\Report;
use app\models\Review;
use yii\log\Logger;

class ReviewController extends DefaultController
{
    /**
     *
     */
    public function actionMonthlyReview()
    {
        Yii::getLogger()->log('actionApproveToday: running', Logger::LEVEL_INFO);
        Yii::getLogger()->flush();
        try {
            Yii::getLogger()->log('actionApproveToday: running', Logger::LEVEL_INFO);
            Report::approveTodayReports();

            $monthReport = \Yii::$app->db->createCommand("
                SELECT * FROM financial_reports                     
                WHERE MONTH(financial_reports.report_date) =:past_month;", [
                ':past_month'  => date('n', strtotime(date('Y-m')." -1 month"))
            ])->queryOne();


            //\Yii::getLogger()->log($monthReport, Logger::LEVEL_ERROR);

            //\Yii::getLogger()->log($monthReport['report_date'], Logger::LEVEL_ERROR);
            $month = date("n",strtotime($monthReport['report_date']));
            //\Yii::getLogger()->log($month, Logger::LEVEL_ERROR);

            //return;
            if(is_null($monthReport))
                return;

            if(!$monthReport['is_locked'] == 1)
                return;

            // somehow salaryReport for 11 month returns 10 from MONTH(FROM_UNIXTIME(salary_reports.report_date))
            // for 11 month in returns 'FROM_UNIXTIME(salary_reports.report_date)' => '2018-10-31 22:00:00'
            // that is why search_month = $month-1
            $salaryReport = \Yii::$app->db->createCommand("
                SELECT * FROM salary_reports                     
                WHERE MONTH(FROM_UNIXTIME(salary_reports.report_date)) =:search_month;", [
                ':search_month'  => $month-1
            ])->queryOne();

            //\Yii::getLogger()->log($salaryReport, Logger::LEVEL_ERROR);


            $salaryReportListAndUsers = \Yii::$app->db->createCommand("
                SELECT * FROM salary_report_lists
                LEFT JOIN users ON salary_report_lists.user_id = users.id                                         
                WHERE salary_report_lists.salary_report_id =:salary_report_id;", [
                ':salary_report_id'  => $salaryReport['id']
            ])->queryAll();

            //\Yii::getLogger()->log($salaryReportListAndUsers, Logger::LEVEL_ERROR);

            if(empty($salaryReportListAndUsers))
                return;

            foreach($salaryReportListAndUsers as $salaryReportListAndUser){

                $review = new Review;
                $dateFrom = date('Y-m-01', strtotime($monthReport['report_date']));
                $dateTo = date('Y-m-t', strtotime($monthReport['report_date']));
                \Yii::getLogger()->log($dateFrom, Logger::LEVEL_ERROR);
                \Yii::getLogger()->log($dateTo, Logger::LEVEL_ERROR);
                $review->user_id = $salaryReportListAndUser['user_id'];
                $review->date_from = $dateFrom;
                $review->date_to = $dateTo;

                ///\Yii::getLogger()->log($monthReport['report_date'], Logger::LEVEL_ERROR);

                //\Yii::getLogger()->log($dateFrom, Logger::LEVEL_ERROR);

                //\Yii::getLogger()->log($dateTo, Logger::LEVEL_ERROR);

                $workHistoryFails = \Yii::$app->db->createCommand("
                SELECT COUNT(*) FROM work_history WHERE work_history.type='fails' AND date_start >= :date_from AND  date_start <= :date_to", [
                    ':date_from'  => $dateFrom, ':date_to' => $dateTo
                ])->queryOne();

                //\Yii::getLogger()->log($workHistoryFails, Logger::LEVEL_ERROR);

                //return;

                $workHistoryEffords = \Yii::$app->db->createCommand("
                SELECT COUNT(*) FROM work_history WHERE work_history.type='efforts' AND date_start >= :date_from AND  date_start <= :date_to", [
                    ':date_from'  => $dateFrom, ':date_to' => $dateTo
                ])->queryOne();


                if(intval($salaryReportListAndUser['worked_days']) == 0) {
                    $salaryReportListAndUser['worked_days'] = 1;
                }

                $score_loyalty = 100 - (intval($salaryReportListAndUser['day_off']) + intval($salaryReportListAndUser['hospital_days']))*
                    (100/$salaryReportListAndUser['worked_days']) - (intval($workHistoryFails['COUNT(*)']) - intval($workHistoryEffords['COUNT(*)']))*10;


                $review->score_loyalty = $this->correctValue($score_loyalty);

                $reportsPerformance = \Yii::$app->db->createCommand("
                SELECT COUNT(*) FROM reports WHERE date_report>=:date_from AND date_report<=:date_to GROUP BY project_id", [
                    ':date_from'  => $dateFrom, ':date_to' => $dateTo
                ])->queryOne();


                $score_performance = 100 - (100/$monthReport['num_of_working_days'])*intval($salaryReportListAndUser['non_approved_hours']);
                \Yii::getLogger()->log($score_performance, Logger::LEVEL_ERROR);

                $review->score_performance = $this->correctValue($score_performance);

                $laborExpensesRato = \Yii::$app->db->createCommand("
                SELECT * FROM settings WHERE settings.key='LABOR_EXPENSES_RATIO'")->queryOne();

                //\Yii::getLogger()->log($laborExpensesRato, Logger::LEVEL_ERROR);
                //return;
                $fin_income = \Yii::$app->db->createCommand("
                SELECT SUM(amount) FROM financial_income
                WHERE financial_report_id=:financial_report_id AND developer_user_id=:developer_user_id", [
                        ':financial_report_id'  => $monthReport['id'],
                        ':developer_user_id' => $salaryReportListAndUser['user_id']
                    ])->queryOne();
                //\Yii::getLogger()->log($fin_income, Logger::LEVEL_ERROR);

                $score_earnings = 0.2 * intval($fin_income['SUM(amount)']) - (intval($salaryReportListAndUser['subtotal']) * ( 1 + intval($laborExpensesRato['value'])/100));

                //\Yii::getLogger()->log('score earnings ' . intval($fin_income['SUM(amount)']), Logger::LEVEL_ERROR);
                $review->score_earnings = $this->correctValue($score_earnings);

                $score_total = (50*$review->score_earnings+25*$review->score_loyalty+25*$review->score_performance)/100;
                \Yii::getLogger()->log($score_total, Logger::LEVEL_ERROR);
                $review->score_total = $this->correctValue($score_total);
                $review->save();
                \Yii::getLogger()->log($review->getErrors(), Logger::LEVEL_ERROR);

            }

            Yii::getLogger()->log('actionApproveToday: Weekday ' .  date('N'), Logger::LEVEL_INFO);

        } catch (\Exception $e) {
            \Yii::error($e->getMessage());
            echo $e->getMessage();
        }
    }


    private function correctValue($number){

        $number = ceil($number);

        if($number < 0)
            return 0;

        if($number > 100)
            return 100;

        return intval($number);

    }
    /**
     *
     */


}
