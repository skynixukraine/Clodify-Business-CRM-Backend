<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "invoices".
 *
 * @property integer $id
 * @property string $subtotal
 * @property string $discount
 * @property string $total
 * @property string $date_created
 * @property string $date_paid
 * @property string $date_sent
 * @property string $status
 *
 * @property Reports[] $reports
 */
class Invoice extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'invoices';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id'], 'integer'],
            [['subtotal', 'discount', 'total'], 'number'],
            [['date_created', 'date_paid', 'date_sent'], 'safe'],
            [['status'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'subtotal' => 'Subtotal',
            'discount' => 'Discount',
            'total' => 'Total',
            'date_created' => 'Date Created',
            'date_paid' => 'Date Paid',
            'date_sent' => 'Date Sent',
            'status' => 'Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReports()
    {
        return $this->hasMany(Reports::className(), ['invoice_id' => 'id']);
    }
}
