<?php

namespace app\models;

use Yii;
use yii\base\Model;

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
            [['project_id', 'user_id'], 'required'],
            [['project_id', 'user_id', 'invoice_id', 'is_working_day', 'is_delete'], 'integer'],
            [['project_id'], 'validateProjectReport'],
            [['hours'], 'double', 'min'=>0.1,'max'=>10.0],
            [['date_added', 'date_paid', 'date_report'], 'safe'],
            [['status'], 'string'],
            [['reporter_name'], 'string', 'max' => 150],
            [['task'], 'string', 'max' => 500]
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
        return $this->hasOne(Invoices::className(), ['id' => 'invoice_id']);
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
        return $this->hasOne(Users::className(), ['id' => 'user_id']);
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

    public function beforeSave($insert)
    {
        if( $this->isNewRecord ){

            if( !$this->date_added ){

                $this->date_added = date('Y-m-d H:i:s');
            }

            if( !$this->date_report ){

                $this->date_report = date('Y-m-d H:i:s');
            }

            if( !$this->reporter_name ) {

                $this->reporter_name =   Yii::$app->user->getIdentity()->first_name . ' ' .
                                         Yii::$app->user->getIdentity()->last_name;
            }
        }/*else
            $this->modified = new CDbExpression('NOW()');*/
        return parent::beforeSave($insert); // TODO: Change the autogenerated stub
    }

    public static function getToDaysReports($userId)
    {
        return self::find()
                    ->leftJoin( Project::tableName(), Project::tableName() . ".id=project_id")
                    ->where('user_id=:userId AND date_added=CURDATE() AND projects.is_delete=0 AND reports.is_delete=0',
                        [
                            ':userId' => $userId
                        ])->all();
    }

}