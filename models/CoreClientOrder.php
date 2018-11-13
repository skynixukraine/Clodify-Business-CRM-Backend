<?php
/**
 * Create By Skynix Team
 * Author: oleksii
 * Date: 11/5/18
 * Time: 9:57 PM
 */

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "orders".
 *
 * @property integer $id
 * @property string $client_id
 * @property string $status
 * @property float $amount
 * @property string $ref
 * @property string $payment
 * @property string $created
 * @property string $paid
 * @property string $notes
 *
 * @package app\models
 */
class CoreClientOrder extends ActiveRecord
{
    const STATUS_NEW        = 'NEW';
    const STATUS_ONREVIEW   = 'ONREVIEW';
    const STATUS_PAID       = 'PAID';
    const STATUS_CANCELED   = 'CANCELED';

    /**
     * @return string
     */
    public static function tableName()
    {
        return 'orders';
    }

    public function rules()
    {
        return [
            [['id', 'client_id'], 'integer'],
            [['amount'], 'float'],
            [['client_id'], 'required'],
            [['status', 'ref'], 'string', 'max' => 255],
            [['payment', 'notes'], 'string', 'max' => 1000],
            [['created', 'paid'], 'string', 'safe'],
        ];
    }

    public static function getDb()
    {
        return Yii::$app->dbCore;
    }


}