<?php
/**
 * Created by Skynix Team
 * Date: 17.10.18
 * Time: 14:48
 */

namespace app\commands;

use app\models\FinancialIncome;
use app\models\FinancialReport;
use app\models\SalaryReport;
use app\models\SalaryReportList;
use app\models\WorkHistory;
use Yii;
use app\models\Report;
use app\models\Setting;
use app\models\Review;
use yii\log\Logger;

class ReviewController extends DefaultController
{
    /**
     *
     */
    public function actionMonthlyReview()
    {
        Yii::getLogger()->log('actionMonthlyReview', Logger::LEVEL_INFO);
        try {

            /** @var FinancialReport $financialReport
             * @var SalaryReport $salaryReport
             */
            if ( ( $financialReport = FinancialReport::find()
                ->where(['is_locked' => 1 ])
                ->orderBy(['report_date' => SORT_DESC])
                ->one() ) &&
                ($salaryReport = SalaryReport::findSalaryReport($financialReport))) {

                Yii::getLogger()->log('Got a financial report #' . $financialReport->id, Logger::LEVEL_INFO);
                Yii::getLogger()->log('Got a salary report #' . $salaryReport->id, Logger::LEVEL_INFO);

                $salaryReportListAndUsers = SalaryReportList::find()
                    ->where([SalaryReportList::tableName() . '.salary_report_id' => $salaryReport->id])
                    ->all();


                /** @var SalaryReportList $sList */
                foreach($salaryReportListAndUsers as $sList) {

                    $review = new Review;
                    $dateFrom = date('Y-m-01', strtotime($salaryReport->report_date));
                    $dateTo = date('Y-m-t', strtotime($salaryReport->report_date));

                    if ( Review::find()->where([
                            'date_from' => $dateFrom,
                            'date_to' => $dateTo,
                            'user_id' => $sList->user_id])->count() == 0) {
                        //The Review does not exist, generating a new one

                        Yii::getLogger()->log('A new Review for ' . $sList->user_id, Logger::LEVEL_INFO);

                        $review = new Review();

                        $review->user_id    = $sList->user_id;
                        $review->date_from  = $dateFrom;
                        $review->date_to    = $dateTo;

                        $workHistoryFails = WorkHistory::find()->where([
                            'type'      => WorkHistory::TYPE_USER_FAILS,
                            'user_id' => $sList->user_id])
                            ->andWhere(['between', 'date_start', $dateFrom, $dateTo])->count();

                        $workHistoryEffords = WorkHistory::find()->where([
                            'type'      => WorkHistory::TYPE_USER_EFFORTS,
                            'user_id' => $sList->user_id])
                            ->andWhere(['between', 'date_start', $dateFrom, $dateTo])->count();

                        $scoreLoyalty = 100 - (intval($sList->day_off) + intval($sList->hospital_days)) *
                            (100/$sList->worked_days) - ($workHistoryFails - $workHistoryEffords)*10;

                        $review->score_loyalty = $this->correctValue($scoreLoyalty);

                        $scorePerformance = 100 - (100/$salaryReport->number_of_working_days) * $sList->non_approved_hours;

                        $review->score_performance = $this->correctValue($scorePerformance);

                        $laborExpensesRato = Setting::getLaborExpensesRatio();

                        $financialIncome = FinancialIncome::find()
                            ->where(['developer_user_id' => $sList->user_id, 'financial_report_id' => $financialReport->id])
                            ->sum('amount');

                        $score_earnings = 0.2 * intval($financialIncome) - (intval($sList->subtotal) * $laborExpensesRato);

                        $review->score_earnings = $this->correctValue($score_earnings);

                        $score_total = (50*$review->score_earnings+25*$review->score_loyalty+25*$review->score_performance)/100;

                        $notes              = [];
                        $workHistoryItems = WorkHistory::find()->where([
                            'user_id' => $sList->user_id])
                            ->andWhere(['between', 'date_start', $dateFrom, $dateTo])->all();

                        /** @var WorkHistory $item */
                        foreach ( $workHistoryItems as $item ) {

                            $notes[] = [
                                'id'        => $item->id,
                                'type'      => $item->type,
                                'note'      => $item->title
                            ];
                        }
                        $notesInString = json_encode($notes);

                        $review->notes = $notesInString;
                        $review->score_total = $this->correctValue($score_total);
                        $review->save();

                    }

                }

            }

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
