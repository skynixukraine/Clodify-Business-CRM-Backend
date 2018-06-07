<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "busineses".
 *
 * @property integer $id
 * @property string $name
 * @property string $name_ua
 * @property string $address
 * @property string $address_ua
 * @property string $represented_by
 * @property string $represented_by_ua
 * @property string $bank_information
 * @property string $bank_information_ua
 * @property integer $invoice_increment_id
 *
 * @property Operation[] $operations
 */
class Business extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'busineses';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'name_ua', 'address', 'address_ua'], 'string', 'max' => 255],
            [['bank_information', 'bank_information_ua'], 'string', 'max' => 1500],
            [['invoice_increment_id'], 'integer'],
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
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOperations()
    {
        return $this->hasMany(Operation::className(), ['business_id' => 'id']);
    }

}
