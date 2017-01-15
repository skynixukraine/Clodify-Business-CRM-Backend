<?php
/**
 * Created by Skynix Team
 * Date: 12.01.17
 * Time: 11:13
 */

namespace app\models;


use yii\db\ActiveRecord;

/**
 * This is the model class for table "contract_templates".
 * @property integer id
 * @property string name
 * @property string content

 */

class ContractTemplates extends ActiveRecord
{

    public static function tableName()
    {
        return 'contract_templates';
    }

    public static function getAllTemplatesDropdown()
    {
        $result = [];
        $records = self::find()->all();
        foreach ($records as $record) {
            $result[$record->id] = $record->name;
        }
        return $result;
    }
}