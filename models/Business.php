<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "busineses".
 *
 * @property integer $id
 * @property string $name
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
        return $this->hasMany(Operation::className(), ['business_id' => 'id']);
    }

}
