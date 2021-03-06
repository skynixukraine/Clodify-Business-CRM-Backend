<?php

namespace app\models;

use app\components\DateUtil;
use Yii;

/**
 * This is the model class for table "financial_income".
 *
 * @property int $id
 * @property int $date
 * @property int $from_date
 * @property int $to_date
 * @property double $amount
 * @property string $description
 * @property int $project_id
 * @property int $added_by_user_id
 * @property int $developer_user_id
 * @property int $financial_report_id
 * @property int invoice_id
 *
 * @property Project $project
 * @property User $addedByUser
 * @property User $developerUser
 */
class FinancialIncome extends \yii\db\ActiveRecord
{

    public $sumAmount;

    const SCENARIO_FINANCIAL_INCOME_CREATE = 'api-financial_income-create';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'financial_income';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['from_date', 'to_date'], 'required'],
            [['date', 'from_date', 'to_date', 'project_id', 'developer_user_id'], 'integer'],
            [['added_by_user_id', 'financial_report_id'], 'integer', 'on' => self::SCENARIO_FINANCIAL_INCOME_CREATE],
            [['amount'], 'number'],
            [['description'], 'string'],
            [['project_id'], 'exist', 'skipOnError' => true, 'targetClass' => Project::className(), 'targetAttribute' => ['project_id' => 'id']],
            [['invoice_id'], 'exist', 'skipOnError' => true, 'targetClass' => Invoice::class, 'targetAttribute' => ['invoice_id' => 'id']],
            [['added_by_user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['added_by_user_id' => 'id']],
            ['project_id', function () {
                //if a project_type=FIXED_PRICE, check that the milestone is CLOSED, otherwise output an error: Please CLOSE the milestone to add financial income
                if(($project = $this->getProject()->one()) &&
                    ( $project->type === Project::TYPE_FIXED_PRICE) ) {

                    $finReportRange = DateUtil::getUnixMonthDateRangesByDate( $this->getFinancialReport()->one()->report_date );

                    if ( ($milestone = Milestone::find()->where(['project_id' => $this->project_id, 'status' => Milestone::STATUS_NEW])->one()) ) {

                        $this->addError('project_id', Yii::t('app', 'Please CLOSE the milestone to add financial income'));

                    } else if (!($milestone = Milestone::find()
                        ->where(['project_id' => $this->project_id, 'status' => Milestone::STATUS_CLOSED])
                        ->andWhere(['between', 'closed_date', $finReportRange->fromDate, $finReportRange->toDate])->one())) {

                        $this->addError('project_id',
                            Yii::t('app', 'In order to add income to the project it should have a closed milestone during the period when the income is entered. '.
                                'Entering income without having a closed milestone is prohibited. ' .
                                'This project has no closed milestones during ${s} -  ${e}', [
                                's'    => $finReportRange->fromDate,
                                'e'    => $finReportRange->toDate
                            ]));

                    }


                }
            }],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'                => 'ID',
            'date'              => 'Date',
            'amount'            => 'Amount',
            'description'       => 'Description',
            'project_id'        => 'Project ID',
            'added_by_user_id'  => 'Added By User ID',
            'developer_user_id' => 'Developer User ID',
        ];
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
    public function getFinancialReport()
    {
        return $this->hasOne(FinancialReport::className(), ['id' => 'financial_report_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAddedByUser()
    {
        return $this->hasOne(User::className(), ['id' => 'added_by_user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDeveloperUser()
    {
        return $this->hasOne(User::className(), ['id' => 'developer_user_id']);
    }

    /** Save the  field’s value in the database if this is s new record */
    public function beforeSave($insert)
    {
        $this->date = time();
        return parent::beforeSave($insert);
    }
}
