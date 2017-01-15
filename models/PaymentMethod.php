<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * This is the model class for table "payment_methods".
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 */
class PaymentMethod extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'payment_methods';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 45],
            [['description'], 'string', 'max' => 1000]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'description' => 'Description',
        ];
    }

    public static function getAllMethodsDropdown()
    {
        $result = [];
        $records = self::find()->all();
        foreach ($records as $record) {
            $result[$record->id] = $record->name;
        }
        return $result;
    }

}
