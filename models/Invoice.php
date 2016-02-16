<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * This is the model class for table "invoices".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $subtotal
 * @property string $discount
 * @property string $total
 * @property string $date_start
 * @property string $date_end
 * @property string $date_created
 * @property string $date_paid
 * @property string $date_sent
 * @property string $status
 *
 * @property Report[] $reports
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
            [['id', 'user_id'], 'integer'],
            [['subtotal', 'discount', 'total'], 'number'],
            [['date_start', 'date_end', 'date_created', 'date_paid', 'date_sent'], 'safe'],
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
            'user_id' => 'User ID',
            'subtotal' => 'Subtotal',
            'discount' => 'Discount',
            'total' => 'Total',
            'date_start' => 'Date Start',
            'date_end' => 'Date End',
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
        return $this->hasMany(Report::className(), ['invoice_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
