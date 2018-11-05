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
 * This is the model class for table "keys".
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

    /**
     * @return string
     */
    public static function tableName()
    {
        return 'keys';
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


}