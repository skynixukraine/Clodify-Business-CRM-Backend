<?php
/**
 * Created by Skynix Team
 * Date: 05.04.17
 * Time: 17:27
 */

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * Class Career
 * @package app\models
 */
class Career extends ActiveRecord
{
    const IS_ACTIVE = 1;

    /**
     * @return string
     */
    public static function tableName()
    {
        return 'careers';
    }

}