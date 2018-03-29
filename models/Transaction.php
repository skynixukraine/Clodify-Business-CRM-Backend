<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "transactions".
 *
 * @property integer $id
 * @property string $type
 * @property string $name
 * @property integer $date
 * @property string $amount
 * @property string $currency
 * @property integer $reference_book_id
 * @property integer $counterparty_id
 * @property integer $operation_id
 * @property integer $operation_business_id
 *
 * @property Counterparty $counterparty
 * @property Operation $operation
 * @property ReferenceBook $referenceBook
 */
class Transaction extends \yii\db\ActiveRecord
{

    const DEBIT = "DEBIT";
    const CREDIT = "CREDIT";
    const SCENARIO_TRANSACTION_CREATE = 'api-operation-create';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'transactions';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['reference_book_id', 'operation_id', 'operation_business_id'], 'required', 'on' => [self::SCENARIO_TRANSACTION_CREATE]],
            [['id', 'date', 'reference_book_id', 'counterparty_id', 'operation_id', 'operation_business_id'], 'integer'],
            [['type', 'currency'], 'string'],
            [['amount'], 'number'],
            [['name'], 'string', 'max' => 255],
            [['counterparty_id'], 'exist', 'skipOnError' => true, 'targetClass' => Counterparty::className(), 'targetAttribute' => ['counterparty_id' => 'id']],
            [['operation_id', 'operation_business_id'], 'exist', 'skipOnError' => true, 'targetClass' => Operation::className(), 'targetAttribute' => ['operation_id' => 'id', 'operation_business_id' => 'business_id']],
            [['reference_book_id'], 'exist', 'skipOnError' => true, 'targetClass' => ReferenceBook::className(), 'targetAttribute' => ['reference_book_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'Type',
            'name' => 'Name',
            'date' => 'Date',
            'amount' => 'Amount',
            'currency' => 'Currency',
            'reference_book_id' => 'Reference Book ID',
            'counterparty_id' => 'Counterparty ID',
            'operation_id' => 'Operation ID',
            'operation_business_id' => 'Operation Business ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCounterparty()
    {
        return $this->hasOne(Counterparty::className(), ['id' => 'counterparty_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOperation()
    {
        return $this->hasOne(Operation::className(), ['id' => 'operation_id', 'business_id' => 'operation_business_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReferenceBook()
    {
        return $this->hasOne(ReferenceBook::className(), ['id' => 'reference_book_id']);
    }

    public static function getDebitTransactionById($id)
    {
        $transaction = self::find()
            ->andWhere(['type' => self::DEBIT])
            ->andWhere(['operation_id' => $id])
            ->one();
        return $transaction;
    }

    public static function getCreditTransactionById($id)
    {
        $transaction = self::find()
            ->andWhere(['type' => self::CREDIT])
            ->andWhere(['operation_id' => $id])
            ->one();
        return $transaction;
    }
}
