<?php

namespace app\models;

use Yii;


/**
 * This is the model class for table "teammates".
 *
 * @property integer $team_id
 * @property integer $user_id
 */
class Teammate extends \yii\db\ActiveRecord
{


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'teammates';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['team_id', 'user_id'], 'required'],
            [['team_id', 'user_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'team_id' => 'Team ID',
            'user_id' => 'User ID',
        ];
    }

    public static function teammateUser($teamId)
    {
        return self::find()
            ->where(Teammate::tableName() . '.team_id=:idTeam',
                [
                    ':idTeam' => $teamId
                ])
            ->count(Teammate::tableName() . '.user_id');


    }
    public function getUse($userId)
    {
        return  User::find()
            ->leftJoin(Teammate::tableName(), Teammate::tableName() . '.user_id=' . User::tableName() . '.id')
            ->where(User::tableName() . '.id=:usId',[
                ':usId'=>$userId
            ])
            ->one();
    }
}
