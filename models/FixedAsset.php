<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "fixed_assets".
 *
 * @property integer $id
 * @property string $name
 * @property double $cost
 * @property integer $inventory_number
 * @property string $amortization_method
 * @property string $date_of_purchase
 * @property string $date_write_off
 *
 * @property FixedAssetOperation[] $fixedAssetsOperations
 * @property Operation[] $operations
 */
class FixedAsset extends \yii\db\ActiveRecord
{

    /**
     *  at date_of_purchase month amortization = cost / 2
        other mothes no amortization
        at date_write_off month amortization = cost / 2
     * @var
     */
    const AMORTIZATION_METHOD_5050 = '50/50';


    /**
     * num months = date_write_off - date_of_purchase
        amortization = ( cost / num months )
     * @var
     */
    const AMORTIZATION_METHOD_LINEAR = 'LINEAR';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'fixed_assets';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cost'], 'number'],
            [['inventory_number'], 'integer'],
            [['amortization_method'], 'in', 'range' => [ self::AMORTIZATION_METHOD_LINEAR, self::AMORTIZATION_METHOD_5050 ]],
            [['date_of_purchase', 'date_write_off'], 'safe'],
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
            'cost' => 'Cost',
            'inventory_number' => 'Inventory Number',
            'amortization_method' => 'Amortization Method',
            'date_of_purchase' => 'Date Of Purchase',
            'date_write_off' => 'Date Write Off',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFixedAssetsOperations()
    {
        return $this->hasMany(FixedAssetOperation::className(), ['fixed_asset_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOperations()
    {
        return $this->hasMany(Operation::className(), ['id' => 'operation_id', 'business_id' => 'operation_business_id'])->viaTable('fixed_assets_operations', ['fixed_asset_id' => 'id']);
    }
}
