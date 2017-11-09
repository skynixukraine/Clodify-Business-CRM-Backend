<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "reference_book".
 *
 * @property integer $id
 * @property string $name
 * @property integer $code
 */
class ReferenceBook extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'reference_book';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['code'], 'integer'],
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
            'code' => 'Code',
        ];
    }
}
