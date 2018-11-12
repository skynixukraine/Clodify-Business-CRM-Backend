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
 * This is the model class for table "client_keys".
 *
 * @property integer $id
 * @property string $client_id
 * @property string $access_key
 * @property string $valid_until
 *
 * @package app\models
 */
class CoreClientKey extends ActiveRecord
{
    const IS_ACTIVE = 1;
    const ACCESS_KEY_LENGTH = 39;
    const EXPIRATION_PERIOD = "30 days";

    /**
     * @return string
     */
    public static function tableName()
    {
        return 'client_keys';
    }

    public function rules()
    {
        return [
            [['access_key'], 'string', 'max' => 45]
        ];
    }

    public static function getDb()
    {
        return Yii::$app->dbCore;
    }

    /**
     * This function generates a new Access Token for a passed user
     * @param \app\models\User $user
     * @return CoreClientKey
     */
    public static function generateNewToken( \app\models\CoreClient $client)
    {
        $accessKey = CoreClientKey::find()->where(['client_id' => $client->id])->one();
        if (!$accessKey) {
            $accessKey = new CoreClientKey();
            $accessKey->client_id       = $client->id;
        }
        $accessKey->access_key  = Yii::$app->security->generateRandomString( self::ACCESS_KEY_LENGTH );
        $accessKey->valid_until   = date('Y-m-d H:i:s', strtotime("now +" . self::EXPIRATION_PERIOD ));
        return $accessKey;
    }


}