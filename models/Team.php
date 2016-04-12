<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "teams".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $name
 * @property string $date_created
 * @property integer $is_deleted
 *
 * @property User $user
 */
class Team extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'teams';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'name', 'is_deleted'], 'required'],
            [['user_id', 'is_deleted'], 'integer'],
            [['date_created'], 'safe'],
            [['name'], 'string', 'max' => 150]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'name' => 'Name',
            'date_created' => 'Date Created',
            'is_deleted' => 'Is Deleted',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
<<<<<<< Updated upstream
=======
    public static function hasTeam($currentUserId)
    {
        $users_id = Team::find()->where(Team::tableName() . '.is_deleted=0')->all();
        $userId = [];
        foreach($users_id as $id){
            $userId[] = $id->user_id;
        }
        $user_id = Teammate::find()->all();
        foreach($user_id as $id){
            $userId[] = $id->user_id;
        }
        if(in_array($currentUserId,$userId)){

            return true;

        } else {

            return false;

        }
    }

>>>>>>> Stashed changes
}
