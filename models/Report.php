<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "reports".
 *
 * @property integer $id
 * @property integer $project_id
 * @property integer $user_id
 * @property string $reporter_name
 * @property integer $invoice_id
 * @property string $task
 * @property string $date_added
 * @property string $date_paid
 * @property string $status
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
            [['project_id', 'user_id', 'invoice_id'], 'integer'],
            [['date_added', 'date_paid'], 'safe'],
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
        return $this->hasOne(Projects::className(), ['id' => 'project_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'user_id']);
    }
}
