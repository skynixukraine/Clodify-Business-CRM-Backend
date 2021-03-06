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
    const CORP_EVENTS_FACTOR            = 'corp_events_percentage';
    const BONUSES_FACTOR                = 'bonuses_percentage';
    const LABOR_EXPENSES_RATIO          = 'LABOR_EXPENSES_RATIO';
    const SSO_COOKIE_COMAIN_NAME        = 'SSO_COOKIE_COMAIN_NAME';

    const CLIENT_ID                     = 'client_id';
    const CLIENT_ACCESS_KEY             = 'access_key';
    const VACATION_DAYS                 = 'vacation_days';
    const VACATION_DAYS_UPGRADE_YEARS   = 'vacation_days_upgrade_years';
    const VACATION_DAYS_UPGRADED        = 'vacation_days_upgraded';

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


    public static function getLaborExpensesRatio( $randPart = 0 )
    {
        $settingRow = Setting::find()
            ->where(['key' => self::LABOR_EXPENSES_RATIO])
            ->one();
        return 1 + ((int)$settingRow->value + $randPart)/100;
    }

    /**
     * @return string
     */
    public static function getSSOCookieDomain()
    {
        $settingRow = Setting::find()
            ->where(['key' => self::SSO_COOKIE_COMAIN_NAME])
            ->one();
        return (string)$settingRow->value;
    }

    /**
     * @return int
     */
    public static function getClientId()
    {
        $settingRow = Setting::find()
            ->where(['key' => self::CLIENT_ID])
            ->one();
        return (int)$settingRow->value;
    }

    /**
     * @return string
     */
    public static function getClientAccessKey()
    {
        $settingRow = Setting::find()
            ->where(['key' => self::CLIENT_ACCESS_KEY])
            ->one();
        return (string)$settingRow->value;
    }
    
    /**
     * @return int
     */
    public static function getVacationDays()
    {
        $settingRow = Setting::find()
        ->where(['key' => self::VACATION_DAYS])
        ->one();
        return (int)$settingRow->value;
    }
    
    /**
     * @return int
     */
    public static function getVacationDaysUpgradeYears()
    {
        $settingRow = Setting::find()
        ->where(['key' => self::VACATION_DAYS_UPGRADE_YEARS])
        ->one();
        return (int)$settingRow->value;
    }
    
    /**
     * @return int
     */
    public static function getVacationDaysUpgraded()
    {
        $settingRow = Setting::find()
        ->where(['key' => self::VACATION_DAYS_UPGRADED])
        ->one();
        return (int)$settingRow->value;
    }
}
