<?php
/**
 * Created by Skynix Team
 * Date: 19.04.17
 * Time: 9:36
 */

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * Class Language
 * @package app\models
 */
class Language extends ActiveRecord
{

    /**
     * @return string
     */
    public static function tableName()
    {
        return 'languages';
    }

    public function getProfile(){
        $this->hasOne(Profile::className(),['profile_id'=>'id']);
    }

}