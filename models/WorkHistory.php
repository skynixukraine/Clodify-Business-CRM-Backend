<?php
/**
 * Created by Skynix Team
 * Date: 19.04.17
 * Time: 13:08
 */

namespace app\models;


use yii\db\ActiveRecord;

class WorkHistory extends ActiveRecord
{

    public static function tableName()
    {
        return 'work_history';
    }

    public function getUser() {
        $this->hasOne(User::className(),['user_id'=>'id']);
    }

}