<?php
namespace app\commands;


class ExampleController extends \yii\console\Controller
{
    // The command "yii example/create test" will call "actionCreate('test')"
    public function actionCreate($name) { echo 'test'; }

    // The command "yii example/index city" will call "actionIndex('city', 'name')"
    // The command "yii example/index city id" will call "actionIndex('city', 'id')"
    public function actionWorkeddays($userId, $reportDate, $workingDays = 21) {

        echo "Checking: " . $reportDate . " \n";

        $reportDate = strtotime($reportDate);
        $numDays = \app\models\SalaryReportList::getNumOfWorkedDays($userId, $reportDate, $workingDays);

        echo "User " . $userId . " worked " . $numDays . " days \n";

    }

    // The command "yii example/add test" will call "actionAdd(['test'])"
    // The command "yii example/add test1,test2" will call "actionAdd(['test1', 'test2'])"
    public function actionAdd(array $name) {  }
}

