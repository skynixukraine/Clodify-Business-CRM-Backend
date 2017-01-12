<?php

namespace app\modules\api\models;

use Yii;

/**
 * This is the model class for table "api_auth_access_tokens".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string  $access_token
 * @property string $exp_date
 */
class ApiAccessToken extends \yii\db\ActiveRecord
{

    const EXPIRATION_PERIOD = "10 days";
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'api_auth_access_tokens';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'access_token', 'exp_date'], 'required'],
            [['user_id'], 'integer'],
            [['access_token'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'            => 'ID',
            'user_id'       => 'User ID',
            'access_token'  => 'Access Token',
            'exp_date'      => 'Exp Date',
        ];
    }
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }
}
