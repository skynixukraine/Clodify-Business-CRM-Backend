<?php
/**
 * Created by SkynixTeam.
 * User: igor
 * Date: 06.11.17
 * Time: 10:10
 */

namespace app\models;

use Yii;

/**
 * This is the model class for table "report_actions".
 *
 * @property integer $id
 * @property integer $report_id
 * @property integer $user_id
 * @property string $action
 * @property string $datetime
 */
class ReportAction extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'report_actions';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['report_id', 'user_id'], 'integer'],
            [['datetime'], 'integer'],
            [['action'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'report_id' => 'Report ID',
            'user_id' => 'User ID',
            'action' => 'Action',
            'datetime' => 'Datetime',
        ];
    }
}