<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "fixed_assets_operations".
 *
 * @property integer $fixed_asset_id
 * @property integer $operation_id
 * @property integer $operation_business_id
 *
 * @property FixedAsset $fixedAsset
 * @property Operation $operation
 */
class FixedAssetOperation extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'fixed_assets_operations';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fixed_asset_id', 'operation_id', 'operation_business_id'], 'required'],
            [['fixed_asset_id', 'operation_id', 'operation_business_id'], 'integer'],
            [['fixed_asset_id'], 'exist', 'skipOnError' => true, 'targetClass' => FixedAsset::className(), 'targetAttribute' => ['fixed_asset_id' => 'id']],
            [['operation_id', 'operation_business_id'], 'exist', 'skipOnError' => true, 'targetClass' => Operation::className(), 'targetAttribute' => ['operation_id' => 'id', 'operation_business_id' => 'business_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'fixed_asset_id' => 'Fixed Asset ID',
            'operation_id' => 'Operation ID',
            'operation_business_id' => 'Operation Business ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFixedAsset()
    {
        return $this->hasOne(FixedAsset::className(), ['id' => 'fixed_asset_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOperation()
    {
        return $this->hasOne(Operation::className(), ['id' => 'operation_id', 'business_id' => 'operation_business_id']);
    }
}
