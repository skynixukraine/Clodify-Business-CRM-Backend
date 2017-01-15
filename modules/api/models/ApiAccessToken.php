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

    const EXPIRATION_PERIOD = "30 days";
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
            [['access_token'], 'string'],
            [['access_token'], 'string', 'max' => 40]
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

    /**
     * This function generates a new Access Token for a passed user
     * @param \app\models\User $user
     * @return ApiAccessToken
     */
    public static function generateNewToken( \app\models\User $user )
    {
        $accessToken = new ApiAccessToken();
        $accessToken->user_id = $user->id;
        $accessToken->access_token = Yii::$app->security->generateRandomString();
        $accessToken->exp_date = date('Y-m-d H:i:s', strtotime("now +" . self::EXPIRATION_PERIOD ));
        $accessToken->save();
        return $accessToken;
    }
}
