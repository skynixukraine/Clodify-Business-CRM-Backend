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
use yii\console\Controller;
use yii\log\Logger;

class ReviewController extends Controller
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


            \Yii::getLogger()->log($monthReport, Logger::LEVEL_ERROR);

            \Yii::getLogger()->log($monthReport['report_date'], Logger::LEVEL_ERROR);
            $month = date("n",strtotime($monthReport['report_date']));
            \Yii::getLogger()->log($month, Logger::LEVEL_ERROR);

            //return;
            if(is_null($monthReport))
                return;

            if(!$monthReport['is_locked'] == 0)
                return;



            $salaryReport = \Yii::$app->db->createCommand("
                SELECT * FROM salary_reports                     
                WHERE MONTH(FROM_UNIXTIME(salary_reports.report_date)) =:search_month;", [
                ':search_month'  => $month
            ])->queryOne();

            \Yii::getLogger()->log($salaryReport, Logger::LEVEL_ERROR);

            $salaryReportListAndUsers = \Yii::$app->db->createCommand("
                SELECT * FROM salary_report_lists
                LEFT JOIN users ON salary_report_lists.user_id = users.id                                         
                WHERE salary_report_lists.salary_report_id =:salary_report_id;", [
                ':salary_report_id'  => $salaryReport['id']
            ])->queryAll();

            \Yii::getLogger()->log($salaryReportListAndUsers, Logger::LEVEL_ERROR);

            if(empty($salaryReportListAndUsers))
                return;

            foreach($salaryReportListAndUsers as $salaryReportListAndUser){

                $review = new Review;
                $dateFrom = date('Y-m-01', strtotime($monthReport['report_date']));
                $dateTo = date('Y-m-t', strtotime($monthReport['report_date']));
                $review->user_id = $salaryReportListAndUser['user_id'];
                $review->date_from = $dateFrom;
                $review->date_to = $dateTo;

                \Yii::getLogger()->log($monthReport['report_date'], Logger::LEVEL_ERROR);

                \Yii::getLogger()->log($dateFrom, Logger::LEVEL_ERROR);

                \Yii::getLogger()->log($dateTo, Logger::LEVEL_ERROR);

                $workHistoryFails = \Yii::$app->db->createCommand("
                SELECT COUNT(*) FROM work_history WHERE work_history.type='fails' AND date_start >= :date_from AND  date_start <= :date_to", [
                    ':date_from'  => $dateFrom, ':date_to' => $dateTo
                ])->queryOne();

                \Yii::getLogger()->log($workHistoryFails, Logger::LEVEL_ERROR);

                //return;

                $workHistoryEffords = \Yii::$app->db->createCommand("
                SELECT COUNT(*) FROM work_history WHERE work_history.type='efforts' AND date_start >= :date_from AND  date_start <= :date_to", [
                    ':date_from'  => $dateFrom, ':date_to' => $dateTo
                ])->queryOne();

                //return;
                $score_loyalty = 100 - ($salaryReportListAndUser['day_off'] + $salaryReportListAndUser['hospital_days'])*
                    (100/$salaryReportListAndUser['worked_days']) - ($workHistoryFails['COUNT(*)'] - $workHistoryEffords['COUNT(*)'])*10;


                //return;
                $review->score_loyalty = $this->correctValue($score_loyalty);

                //(SELECT COUNT(*) FROM reports WHERE date_report BETWEEN date_from AND date_to GROUP BY project_id
                $reportsPerformance = \Yii::$app->db->createCommand("
                SELECT COUNT(*) FROM reports WHERE date_report>=:date_from AND date_report<=:date_to GROUP BY project_id", [
                    ':date_from'  => $dateFrom, ':date_to' => $dateTo
                ])->queryOne();
//return;
                $score_performance = 100 - $salaryReportListAndUser['non_approved_hours'] - (5 - $reportsPerformance['COUNT(*)'])*10 ;
                $review->score_performance = $this->correctValue($score_performance);

                $laborExpensesRato = \Yii::$app->db->createCommand("
                SELECT * FROM settings WHERE settings.key='LABOR_EXPENSES_RATIO'")->queryOne();

                \Yii::getLogger()->log($laborExpensesRato, Logger::LEVEL_ERROR);
                //return;
                $fin_income = \Yii::$app->db->createCommand("
                SELECT SUM(amount) FROM financial_income
                WHERE financial_report_id=:financial_report_id AND developer_user_id=:developer_user_id", [
                        ':financial_report_id'  => $monthReport['id'],
                        ':developer_user_id' => $salaryReportListAndUser['user_id']
                    ])->queryOne();
                \Yii::getLogger()->log($fin_income, Logger::LEVEL_ERROR);

                if($fin_income['SUM(amount)'] == 'null')
                    $fin_income['SUM(amount)'] = 0;

                //return;

                //( SalaryReportList→subtotal * (1 + Settings→LABOR_EXPENSES_RATIO / 100)  - (SELECT SUM(amount) FROM financial_income WHERE financial_report_id=? AND developer_user_id=?)  ) * 0.1
                $score_earnings = ($salaryReportListAndUser['subtotal'] * ( 1 + $laborExpensesRato['value']/100) - $fin_income['SUM(amount)']) *0.1;
                $review->score_earnings = $this->correctValue($score_earnings);
                $score_total = (50*$review->score_earnings+25*$review->score_loyalty+25*$review->score_performance)/100;
                $review->score_total = $this->correctValue($score_total);
                $review->save();
            }

            Yii::getLogger()->log('actionApproveToday: Weekday ' .  date('N'), Logger::LEVEL_INFO);

        } catch (\Exception $e) {
            \Yii::error($e->getMessage());
            echo $e->getMessage();
        }
    }


    private function correctValue($number){
        if($number < 0)
            return 0;

        if($number > 100)
            return 100;
    }
    /**
     *
     */


}
