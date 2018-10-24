<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "project_debts".
 *
 * @property int $id
 * @property int $project_id
 * @property int $amount
 * @property int $financial_report_id
 *
 * @property FinancialReport $financialReport
 * @property Project $project
 */
class ProjectDebt extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'project_debts';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['project_id', 'amount', 'financial_report_id'], 'integer'],
            [['financial_report_id'], 'exist', 'skipOnError' => true, 'targetClass' => FinancialReport::className(), 'targetAttribute' => ['financial_report_id' => 'id']],
            [['project_id'], 'exist', 'skipOnError' => true, 'targetClass' => Project::className(), 'targetAttribute' => ['project_id' => 'id']],
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
            'amount'        => 'Amount',
            'financial_report_id' => 'Financial Report ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFinancialReport()
    {
        return $this->hasOne(FinancialReport::className(), ['id' => 'financial_report_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProject()
    {
        return $this->hasOne(Project::className(), ['id' => 'project_id']);
    }
}
