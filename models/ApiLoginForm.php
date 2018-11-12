<?php

namespace app\models;


use Yii;
use app\models\CoreClient;


/**
 * ApiLoginForm is the model behind the login form used by API.
 */
class ApiLoginForm extends \yii\db\ActiveRecord
{
    /**
     * This function generates/returns access token by passed email/password pair
     * @return \app\modules\api\models\ApiAccessToken|array|null|\yii\db\ActiveRecord
     */
    public $email;
    public $_client = false;

    public function login()
    {
        $client = $this->getClient();

        if(!$client) {
            return false;
        }

        if( !($clientKey = CoreClientKey::find()->where(['client_id' => $client->id])->one()) ||
            ( ( strtotime( $clientKey->valid_until ) < strtotime("now" ) ) ) ) {

            $clientKey = CoreClientKey::generateNewToken( $client );

        }
        $clientKey->save();

        return $clientKey;

    }


    public static function getDb()
    {
        return Yii::$app->dbCore;
    }


    /**
     * Finds user by [[username]]
     *
     * @return CoreClient|null
     */
    public function getClient()
    {
        if ($this->_client === false) {
            $this->_client = CoreClient::findOne(['email' => $this->email]);
        }

        return $this->_client;
    }

}