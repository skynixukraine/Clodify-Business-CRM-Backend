<?php
/**
 * Created by Skynix Team.
 * User: igor
 * Date: 19.10.17
 * Time: 11:25
 */

namespace app\models;

use Yii;

/**
 * This is the model class for table "settings".
 *
 * @property integer $id
 * @property string $key
 * @property integer $value
 * @property string $type
 */
class Setting extends \yii\db\ActiveRecord
{
    const CORP_EVENTS_FACTOR    = 'corp_events_percentage';
    const BONUSES_FACTOR        = 'bonuses_percentage';
    const LABOR_EXPENSES_RATIO  = 'LABOR_EXPENSES_RATIO';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'settings';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['value'], 'integer'],
            [['type'], 'string'],
            [['key'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'key' => 'Key',
            'value' => 'Value',
            'type' => 'Type',
        ];
    }

    /**
     * @return float|int
     */
    public static function getCorpEventsFactor()
    {
        $settingRow = Setting::find()
            ->where(['key' => self::CORP_EVENTS_FACTOR])
            ->one();
        return $settingRow->value/100;
    }

    /**
     * @return float|int
     */
    public static function getBonusesFactor()
    {
        $settingRow = Setting::find()
            ->where(['key' => self::BONUSES_FACTOR])
            ->one();
        return $settingRow->value/100;
    }


    public static function getLaborExpensesRatio()
    {
        $settingRow = Setting::find()
            ->where(['key' => self::LABOR_EXPENSES_RATIO])
            ->one();
        return 1 + ((int)$settingRow->value)/100;
    }
}
