<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "milestones".
 *
 * @property int $id
 * @property int $project_id
 * @property string $name
 * @property string $status
 * @property int $estimated_amount
 * @property string $start_date
 * @property string $end_date
 * @property string $closed_date
 *
 * @property Project $project
 */
class Milestone extends \yii\db\ActiveRecord
{

    const SCENARIO_CREATE   = 'on-create';
    const SCENARIO_CLOSE    = 'on-close';

    const STATUS_NEW        = 'NEW';
    const STATUS_CLOSED     = 'CLOSED';
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'milestones';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['project_id', 'estimated_amount'], 'integer', 'on' => self::SCENARIO_CREATE ],
            [['project_id', 'estimated_amount', 'start_date', 'end_date'], 'required', 'on' => self::SCENARIO_CREATE ],
            [['estimated_amount'], 'integer', 'on' => self::SCENARIO_CLOSE ],
            [['name'], 'string', 'on' => self::SCENARIO_CREATE],
            [['start_date', 'end_date'], 'safe', 'on' => self::SCENARIO_CREATE],
            [['project_id'], 'exist', 'skipOnError' => true, 'targetClass' => Project::className(), 
                'targetAttribute' => ['project_id' => 'id'],
                'on' => self::SCENARIO_CREATE
            ],
            ['project_id', function () {
                if(($milestone = self::find()->where(['project_id' => $this->project_id, 'status' => self::STATUS_NEW])->one())) {
                    $this->addError('project_id', Yii::t('app', 'OPENed milestone :m already exists', [':m' => $milestone->name]));
                } elseif ( ($project = Project::findOne( $this->project_id ) ) ) {

                    if ( $project->type !== Project::TYPE_FIXED_PRICE ) {

                        $this->addError('project_id', Yii::t('app', 'This is not possible create milestones for non FIXED PRICE projects'));

                    }

                } else {

                    $this->addError('project_id', Yii::t('app', 'Project is not found'));

                }
            }, 'on' => self::SCENARIO_CREATE],
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
            'name'          => 'Name',
            'status'        => 'Status',
            'estimated_amount' => 'Estimated Amount',
            'start_date'    => 'Start Date',
            'end_date'      => 'End Date',
            'closed_date'   => 'Closed Date',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProject()
    {
        return $this->hasOne(Project::className(), ['id' => 'project_id']);
    }
}
