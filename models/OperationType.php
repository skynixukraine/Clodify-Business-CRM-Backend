<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "operation_types".
 *
 * @property integer $id
 * @property string $name
 *
 * @property Operation[] $operations
 */
class OperationType extends \yii\db\ActiveRecord
{
    const TYPE_AMORTIZATION = 8;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'operation_types';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
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
        return $this->hasMany(Operation::className(), ['operation_type_id' => 'id']);
    }

    public static function validCount($int)
    {
        if ($int <= self::find()->count()) {
            return true;
        } else {
            return false;
        }
    }

}
