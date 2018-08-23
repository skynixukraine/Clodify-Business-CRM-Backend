<?php

namespace app\models;


/**
 * This is the model class for table "invoice_templates".
 *
 * @property integer $id
 * @property string $name
 * @property string $body

 */
class InvoiceTemplate extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'invoice_templates';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'body'], 'required']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Id',
            'name' => 'Name',
            'body' => 'Body'
        ];
    }



}
