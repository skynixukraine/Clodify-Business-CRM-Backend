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
 * @property string $task
 * @property string $date_added
 * @property string $date_paid
 * @property string $date_report
 * @property integer $is_working_day
 * @property string $status
 * @property integer $is_delete
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
            [['project_id', 'user_id', 'task', 'hours'], 'required'],
            [['project_id', 'user_id', 'invoice_id', 'is_working_day', 'is_delete'], 'integer'],
            [['project_id'], 'validateProjectReport'],
            [['hours'], 'double', 'min'=>0.1,'max'=>10.0],
            [['date_added', 'date_paid', 'date_report'], 'safe'],
            [['status'], 'string'],
            [['reporter_name'], 'string', 'max' => 150],
            [['task'], 'string', 'min' => 20, 'max' => 500 ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'project_id' => 'Project ID',
            'user_id' => 'User ID',
            'reporter_name' => 'Reporter Name',
            'invoice_id' => 'Invoice ID',
            'task' => 'Task',
            'date_added' => 'Date Added',
            'date_paid' => 'Date Paid',
            'status' => 'Status',
            'is_delete' => 'Is Delete',
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
       // var_dump($this->user_id);
       // var_dump($this->project_id);
        $r = ProjectDeveloper::findOne(['user_id' => $this->user_id, 'project_id' => $this->project_id]);
       // var_dump($r);
       // exit;
        if( !$r ) {

            $this->addError($attribute, 'Sorry, but you can not report this project.');

        }
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

                $this->reporter_name =   Yii::$app->user->getIdentity()->first_name . ' ' .
                                         Yii::$app->user->getIdentity()->last_name;
            }
        }/*else
            $this->modified = new CDbExpression('NOW()');*/
        return parent::beforeSave($insert); // TODO: Change the autogenerated stub
    }

    /** Select reports for the current day and not deleted project */
    public static function getReports($userId, $filter)
    {
        $query = self::find();
        $query->from( Report::tableName())
              ->leftJoin( Project::tableName(), Project::tableName() . ".id=project_id");

        switch( $filter ){

            case 1:
                $query->where('user_id=:userId AND date_added=CURDATE() AND projects.is_delete=0
                               AND reports.is_delete=0',
                [
                    ':userId' => $userId
                ]);
                break;
            case 2:
                $query->where('user_id=:userId AND WEEK(date_added)=WEEK(CURDATE())
                                AND YEAR(date_added) = YEAR(CURDATE()) AND projects.is_delete=0
                                AND reports.is_delete=0',
                    [
                        ':userId' => $userId
                    ]);
                break;
            case 3:
                $query->where('user_id=:userId AND MONTH(date_added)=MONTH(CURDATE())
                                AND YEAR(date_added) = YEAR(CURDATE())  AND projects.is_delete=0
                                AND reports.is_delete=0',
                    [
                        ':userId' => $userId
                    ]);
                break;
            case 4:
                $query->where('user_id=:userId AND MONTH(date_added)=MONTH(CURDATE() - INTERVAL 1 MONTH)
                                AND YEAR(date_added) = YEAR(CURDATE()) AND projects.is_delete=0
                                AND reports.is_delete=0',
                    [
                        ':userId' => $userId
                    ]);
                break;
        }
        $query->all();
        return $query;
    }

    public static function sumHoursReportsOfThisDay($currUser)
    {
        return self::find()
            ->where(Report::tableName() . '.date_added = CURDATE() AND ' .
                    Report::tableName() . '.user_id=:userId AND ' .
                    Report::tableName() . '.is_delete=0',
                [
                    ':userId' => $currUser,
                ])
            ->sum(Report::tableName() . '.hours');
    }

}