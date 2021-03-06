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
use yii\log\Logger;

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
    const SCENARIO_UPDATE_VALIDATION      = 'update';

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
            [['amount'], 'number'],
            [['client_id'], 'required'],
            [['status'], 'string', 'max' => 255],
            [['notes'], 'string', 'max' => 1000],
            [['payment_id', 'recurrent_id'], 'required', 'on' => [self::SCENARIO_UPDATE_VALIDATION]],
            [['payment_id', 'recurrent_id'], 'integer', 'on' => [self::SCENARIO_UPDATE_VALIDATION]],
            [['created', 'paid'], 'string'],
            [['created', 'paid'], 'safe'],
        ];
    }

    public static function getDb()
    {
        return Yii::$app->dbCore;
    }


    public function checkGateway()
    {

        $data = '<oper>cmt</oper>
                <wait>0</wait>
                <test>' . Yii::$app->params['merchantTestMode'] . '</test>
                <payment>
                <prop name="id" value="' . $this->id . '" />
                <prop name="ref" value="' . $this->ref . '" />
                </payment>';

        $signature = sha1 (md5($data . Yii::$app->params['merchantPassword']));

        $xml = '<?xml version="1.0" encoding="UTF-8"?>
            <request version="1.0">
                <merchant>
                    <id>' . Yii::$app->params['merchantId'] . '</id>
                    <signature>' . $signature . '</signature>
                </merchant>
                <data>
                    ' . $data . ' 
                </data>
            </request>';
        $response = Yii::$app->privatbankApi->post('check_pay', $xml)->send()->content;
        $response = new \SimpleXMLElement($response);
        $responseData = (array)$response->data;
        if ( isset($responseData['error'])) {

            \Yii::getLogger()->log('Something went wrong with API ' . $responseData['error']->message, Logger::LEVEL_WARNING);
            $this->status = self::STATUS_CANCELED;

        } else {

            \Yii::getLogger()->log($responseData, Logger::LEVEL_INFO);
            $this->status = self::STATUS_PAID;
            
        }
        $this->save(false, ['status']);
    }

    /**
     * @param $model
     * @return mixed
     */
    function defaultVal() : Array
    {
        $list['id'] = $this->id;
        $list['status'] = $this->status;
        $list['amount'] = $this->amount;
        $list['payment_id'] = $this->payment_id;
        $list['recurrent_id'] = $this->recurrent_id;
        $list['created'] = $this->created;
        $list['paid'] = $this->paid;
        $list['notes'] = $this->notes;

        return $list;
    }

}