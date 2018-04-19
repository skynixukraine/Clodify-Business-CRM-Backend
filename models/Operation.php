<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "operations".
 *
 * @property integer $id
 * @property integer $business_id
 * @property string $name
 * @property string $status
 * @property integer $date_created
 * @property integer $date_updated
 * @property integer $operation_type_id
 * @property integer $is_deleted
 *
 * @property Business $business
 * @property OperationType $operationType
 */
class Operation extends \yii\db\ActiveRecord
{
    const DONE = "DONE";
    const SCENARIO_OPERATION_CREATE = 'api-operation-create';
    const SCENARIO_OPERATION_UPDATE = 'api-operation-update';
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'operations';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['business_id', 'operation_type_id'], 'required', 'on' => [self::SCENARIO_OPERATION_CREATE]],
            [['id', 'business_id', 'date_created', 'date_updated', 'operation_type_id'], 'integer', 'on' => [self::SCENARIO_OPERATION_CREATE, self::SCENARIO_OPERATION_UPDATE]],
            [['status'], 'string' , 'on' => [self::SCENARIO_OPERATION_CREATE, self::SCENARIO_OPERATION_UPDATE]],
            [['name'], 'string', 'max' => 255, 'on' => [self::SCENARIO_OPERATION_CREATE, self::SCENARIO_OPERATION_UPDATE]],
            [['business_id'], 'exist', 'skipOnError' => true, 'targetClass' => Business::className(), 'targetAttribute' => ['business_id' => 'id']],
            [['operation_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => OperationType::className(), 'targetAttribute' => ['operation_type_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'business_id' => 'Business ID',
            'name' => 'Name',
            'status' => 'Status',
            'date_created' => 'Date Created',
            'date_updated' => 'Date Updated',
            'operation_type_id' => 'Operation Type ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBusiness()
    {
        return $this->hasOne(Business::className(), ['id' => 'business_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOperationType()
    {
        return $this->hasOne(OperationType::className(), ['id' => 'operation_type_id']);
    }

    public function getTransactions()
    {
        return $this->hasMany(Transaction::className(), ['operation_id' => 'id']);
    }
}
