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
            [['name', 'name_alt'], 'string', 'max' => 45],
            [['address', 'address_alt', 'represented_by', 'represented_by_alt'], 'string', 'max' => 255],
            [['bank_information', 'bank_information_alt'], 'string', 'max' => 1500],
            [['is_default'], 'boolean'],
            [['business_id'], 'number']
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
            'name_alt' => 'Name Alt',
            'address' => 'Address',
            'address_alt' => 'Address alt',
            'represented_by' => 'Represented By',
            'represented_by_alt' => 'Represented By Alt',
            'bank_information' => 'Bank Information',
            'bank_information_alt' => 'Bank Information Alt',
            'is_default' => 'Is Default',
            'business_id' => 'Business Id'
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


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOperations()
    {
        return $this->hasMany(Operation::className(), ['business_id' => 'id']);
    }

}
