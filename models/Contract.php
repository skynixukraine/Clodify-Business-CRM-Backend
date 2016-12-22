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
 * @property  integer customer_id
 * @property integer act_number
 * @property number total
 * @property string start_date
 * @property string end_date
 * @property string act_date
 */
class Contract extends ActiveRecord
{
    public function rules()
    {
        return [
            [['customer_id', 'act_number'], 'integer'],
            ['total', 'number'],
            [['customer_id', 'act_number', 'total', 'start_date', 'end_date', 'act_date'], 'required']
        ];
    }

    public static function tableName()
    {
        return 'contracts';
    }

    public function attributeLabels()
    {
        return [
            'customer_id' => 'Customer ID',
            'act_number'  => 'Act number',
            'total'       => 'Total price',
            'start_date'  => 'Start date',
            'end_date'    => 'End date',
            'act_date'    => 'Act date'
        ];
    }


}