<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "reports".
 *
 * @property integer $id
 * @property integer $project_id
 * @property integer $user_id
 * @property string $reporter_name
 * @property integer $invoice_id
 * @property double $hours
 * @property double $cost
 * @property string $task
 * @property string $date_added
 * @property string $date_paid
 * @property string $date_report
 * @property integer $is_working_day
 * @property string $status
 * @property integer $is_delete
 * @property integer $is_approved
 *
 *
 * @property Invoices $invoice
 * @property Projects $project
 * @property Users $user
 */
class Report extends \yii\db\ActiveRecord
{
    public $dateFilter;
    public $dateStartReport;
    public $dateEndReport;

    const STATUS_NEW        = "NEW";
    const STATUS_INVOICED   = "INVOICED";
    const STATUS_DELETED    = "DELETED";
    const STATUS_PAID       = "PAID";
    const STATUS_WONTPAID   = "WONTPAID";
    const SALARY_HOURS      = 168;
    const ACTIVE            = 0;
    const APPROVED          = 1;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'reports';
    }

    /**
     * @inheritdoc
     */

        public function rules()
    {
        return [
            [['project_id', 'user_id', 'task', 'hours', 'date_report'], 'required'],
            [['task'], 'trim'],
            [['project_id', 'user_id', 'invoice_id', 'is_working_day', 'is_delete'], 'integer'],
            [['project_id'], 'validateProjectReport'],
            // 12 hours according to https://jira.skynix.co/browse/SCA-118
            [['hours'], 'double', 'min'=>0.1,'max'=>12.0],
            [['date_added', 'date_paid'], 'safe'],
            [['status'], 'string'],
            [['reporter_name'], 'string', 'max' => 150],
            [['task'], 'string', 'min' => 20, 'max' => 500 ],
            ['date_report', 'date', 'format' => 'php:Y-m-d']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'            => 'ID',
            'project_id'    => 'Project ID',
            'user_id'       => 'User ID',
            'reporter_name' => 'Reporter Name',
            'invoice_id'    => 'Invoice ID',
            'task'          => 'Task',
            'date_added'    => 'Date Added',
            'date_paid'     => 'Date Paid',
            'status'        => 'Status',
            'is_delete'     => 'Is Delete',
            'cost'          => 'Cost'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInvoice()
    {
        return $this->hasOne(Invoice::className(), ['id' => 'invoice_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProject()
    {
        return $this->hasOne(Project::className(), ['id' => 'project_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public  function  validateProjectReport($attribute, $params)
    {
        $r = ProjectDeveloper::findOne(['user_id' => $this->user_id, 'project_id' => $this->project_id]);
        if( !$r ) {
            $this->addError($attribute, 'Sorry, but you are not connected to this project.');
        }

        if( $r && $r->project->is_delete == 1) {
            $this->addError($attribute, 'Sorry, but this project is deleted.');
        }
    }

    public function getDatePeriods() {
        $periods  = [
            [
                "id" => 1,
                "date_period" =>  "Today's reports"
            ],
            [
                "id" => 2,
                "date_period" =>  "This week reports"
            ],
            [
                "id" => 3,
                "date_period" =>  "This month reports"
            ],
            [
                "id" => 4,
                "date_period" =>  "Last month reports"
            ],
        ];
        return $periods;
    }

    /** Save the  field’s value in the database if this is s new record */
    public function beforeSave($insert)
    {
       // var_dump($this->total);
       // exit();
        if( $this->isNewRecord ){

            if( !$this->date_added ){

                $this->date_added = date('Y-m-d H:i:s');
            }

            if( !$this->reporter_name ) {
            
                /** @var $pDev ProjectDeveloper */
                /** @var $aliasUser User */

                if ( ($pDev = ProjectDeveloper::findOne([
                                    'user_id'       => Yii::$app->user->id,
                                    'project_id'    => $this->project_id]) ) &&
                    $pDev->alias_user_id && ( $aliasUser = User::findOne( $pDev->alias_user_id )) ) {


                    $this->reporter_name =  $aliasUser->first_name . ' ' . $aliasUser->last_name;

                } else {

                    $this->reporter_name =   Yii::$app->user->getIdentity()->first_name . ' ' .
                        Yii::$app->user->getIdentity()->last_name;

                }

            }

        }

        /*else
            $this->modified = new CDbExpression('NOW()');*/
        return parent::beforeSave(trim($insert)); // TODO: Change the autogenerated stub
    }

    public function afterSave($insert, $changedAttributes)
    {

		if (!$this->is_delete) {
			$project = Project::findOne($this->project_id);

			$user = $this->user_id ? User::findOne($this->user_id):User::findOne(Yii::$app->user->id);

            //if the field was updated it was necessary to substract the old value of cost
			if (!$insert && isset($changedAttributes['hours'])) {
				$project->cost -= round($changedAttributes['hours'] * ($user->salary / self::SALARY_HOURS), 2);
				$project->total_logged_hours -= $changedAttributes['hours'];
			}

			$project->cost = $project->cost +
                ( $this->cost > 0 ?$this->cost : round($this->hours * ($user->salary / self::SALARY_HOURS), 2) );
            $project->total_logged_hours += $this->hours;
			$project->save();
		}

        parent::afterSave($insert, $changedAttributes);

    }
	
	
    /** Select reports for the current day and not deleted project */
    public static function getReports($userId, $filter)
    {
        $query = self::find();
        $query->from( Report::tableName())
              ->leftJoin( Project::tableName(), Project::tableName() . ".id=project_id");

        switch( $filter ){

            case 1:
                $query->where('user_id=:userId AND date_added=CURDATE() AND reports.is_delete=0',
                [
                    ':userId' => $userId
                ]);
                break;
            case 2:
                $query->where('user_id=:userId AND WEEK(date_added)=WEEK(CURDATE())
                                AND YEAR(date_added) = YEAR(CURDATE()) AND reports.is_delete=0',
                    [
                        ':userId' => $userId
                    ]);
                break;
            case 3:
                $query->where('user_id=:userId AND MONTH(date_added)=MONTH(CURDATE())
                                AND YEAR(date_added) = YEAR(CURDATE())  AND reports.is_delete=0',
                    [
                        ':userId' => $userId
                    ]);
                break;
            case 4:
                $query->where('user_id=:userId AND MONTH(date_added)=MONTH(CURDATE() - INTERVAL 1 MONTH)
                                AND YEAR(date_added) = YEAR(CURDATE()) AND reports.is_delete=0',
                    [
                        ':userId' => $userId
                    ]);
                break;
        }
        $query->all();
        return $query;
    }

    public static function sumHoursReportsOfThisDay($currUser, $dateReport)
    {
        return self::find()

            ->where(Report::tableName() . '.date_report =:DateReport AND ' .
                    Report::tableName() . '.user_id=:userId AND ' .
                    Report::tableName() . '.is_delete=0',
                [
                    ':userId' => $currUser,
                    ':DateReport' => $dateReport,
                ])
            ->sum(Report::tableName() . '.hours');
    }

    public static function sumHoursReportsOfThisDayV2($currUser, $dateReport)
    {
        $hours = self::find()

            ->where(Report::tableName() . '.date_report =:DateReport AND ' .
                Report::tableName() . '.user_id=:userId AND ' .
                Report::tableName() . '.is_delete=0',
                [
                    ':userId' => $currUser,
                    ':DateReport' => $dateReport,
                ])
            ->all();//sum(Report::tableName() . '.hours');
        $allhours = [];

        $sum = 0;
        $mun = 0;
        foreach($hours as $hour) {

            $allhours[] = $hour->hours;
        }

        foreach($allhours as $allhour) {
            if(floor($allhour)>0) {
                $sum = $sum + 60*floor($allhour);
            }
            if(($mun = ($allhour - floor($allhour))*100)>0) {
                $sum = $sum + $mun;
            }
        }
        return $sum/60;
    }


    public static function reportsPM()
    {
        if ( ( $teamspm = Team::find()
                    ->where(Team::tableName() . '.team_leader_id=:UserId', [ ':UserId' => Yii::$app->user->id])
                    ->andWhere('is_deleted=0')
                    ->all() ) ) {

            $tea = [];
            foreach($teamspm as $teams){
                $tea[] = $teams->id;
            }


            return Teammate::find()
                ->where(Teammate::tableName() . '.team_id IN ("' . implode(', ', $tea) . '")')
                ->all();

        }

        //var_dump($tea);
        //exit();

    }
    public static function reportsSales()
    {
        return self::find()
            ->where (Report::tableName() . ".is_delete=0 AND " . "user_id =:Id",  [':Id' => Yii::$app->user->id])->all();
    }
    /*the total amount report for the current week*/
    public static function getReportHours($currUser)
    {
        return self::find()
            ->where ('TO_DAYS(NOW()) - TO_DAYS(date_report) <= 7 AND ' . Report::tableName() . '.user_id=:userId',[':userId' => $currUser] )->sum('hours');
    }

    public static function getReportHoursMonth($userId)
    {
        return self::find()
            ->where('MONTH(`date_report`) = MONTH(NOW()) AND YEAR(`date_report`) = YEAR(NOW()) AND ' . Report::tableName() . '.user_id=:userId',[':userId' => $userId])
            ->sum('hours');
    }

    /**
     * @param $userId
     * @return mixed
     */
    public static function getReportCostPerMonthPerUser($userId)
    {
        return self::find()
            ->where('MONTH(`date_report`) = MONTH(NOW()) AND YEAR(`date_report`) = YEAR(NOW()) AND ' . Report::tableName() . '.user_id=:userId',[':userId' => $userId])
            ->sum('cost');
    }

    public function hoursDelete()
    {
		$project = $this->project;
		
		//$project = Project::findOne($this->project_id);
		$user = User::findOne(Yii::$app->user->id);

		/** @var $project Project */
		$project->cost -= round($this->hours * ($user->salary / self::SALARY_HOURS), 2);
		$project->total_logged_hours -= $this->hours;
        if ($project->save(true, ['total_logged_hours', 'cost'])){
            return parent::beforeDelete(); // TODO: Change the autogenerated stub
        }
        return false;
    }

    public static function getReportsOnInvoice($invoiceId)
    {
        return self::find()
            ->where([Report::tableName() . '.invoice_id' => $invoiceId])
            ->all();
    }

    public static function getReportsCostOnInvoice($invoiceId)
    {
        return self::find()
            ->where([Report::tableName() . '.invoice_id' => $invoiceId])
            ->sum('cost');
    }

    public static function getReportsCostByProjectAndDates($projectId, $fromDate, $toDate)
    {
        return self::find()
            ->where([Report::tableName() . '.project_id' => $projectId])
            ->andWhere(['between', 'date_report', $fromDate, $toDate])
            ->sum('cost');
    }

    /**
     * 
     */
    public static function approveTodayReports()
    {
        self::updateAll(['is_approved' => 1], 'date_added=CURDATE() AND date_report=CURDATE() AND is_delete=0 AND is_approved=0');
    }

    /**
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function getAllTodayUsers()
    {
        return self::find()->where('date_added=CURDATE() AND is_delete=0 AND is_approved=0')->all();
    }

}