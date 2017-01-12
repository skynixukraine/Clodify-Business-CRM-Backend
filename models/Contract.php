<?php
/**
 * Created by Skynix Team
 * Date: 22.12.16
 * Time: 16:47
 */

namespace app\models;


use yii\db\ActiveRecord;

/**
 * This is the model class for table "contracts".
 * @property integer id
 * @property  integer customer_id
 * @property  integer contract_id
 * @property integer act_number
 * @property number total
 * @property string start_date
 * @property string end_date
 * @property string act_date
 * @property integer created_by
 */
class Contract extends ActiveRecord
{
    public function rules()
    {
        return [
            [['customer_id', 'act_number', 'contract_id', 'created_by', 'id'], 'integer'],
            ['total', 'number'],
            [['customer_id', 'act_number', 'total', 'start_date', 'end_date', 'act_date', 'contract_id'], 'required'],
            [['act_number', 'contract_id'], 'unique']
        ];
    }

    public static function tableName()
    {
        return 'contracts';
    }

    public function attributeLabels()
    {
        return [
            'contract_id' => 'ID',
            'customer_id' => 'Customer ID',
            'act_number'  => 'Act number',
            'total'       => 'Total price',
            'start_date'  => 'Start date',
            'end_date'    => 'End date',
            'act_date'    => 'Act date'
        ];
    }


}