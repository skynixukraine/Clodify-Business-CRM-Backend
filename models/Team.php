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
 * @property integer $team_leader_id
 *
 * @property User $user
 */
class Team extends \yii\db\ActiveRecord
{
    public $teammate;
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
            [['user_id', 'name'], 'required'],
            [['user_id', 'is_deleted', 'team_leader_id'], 'integer'],
            [['date_created'], 'safe'],
            [['name'], 'string', 'max' => 150]
        ];


    }
    /**
     * @inheritdoc
     */
    /*public static function isUserHasPermission($userId)
    {
        return self::find()->andWhere(['user_id'=>$userId])->count();

    }*/
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
            'team_leader_id' => 'Team Leader'
        ];
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getLeader()
    {
        return $this->hasOne(User::className(), ['id' => 'team_leader_id']);
    }

   /* public static function hasTeam($currentUserId)
    {
        $users_id = Team::find()
            ->leftJoin(Teammate::tableName(), Teammate::tableName() . '.team_id=id')
            ->where(Team::tableName() . '.is_deleted=0')
            ->all();*/

    public static function hasTeam($currentUserId)
    {
        $users_id = Team::find()->where(Team::tableName() . '.is_deleted=0')->all();

        /*$userId = [];
        foreach($users_id as $id){
            $userId[] = $id->user_id;
        }*/

        $user_id = Teammate::find()->all();
        foreach ($user_id as $id) {
            $userId[] = $id->user_id;
        }

        if (in_array($currentUserId, $userId)) {

            return true;

        } else {

            return false;

        }
    }

    public function afterSave($insert, $changedAttributes)
    {
        $modelTeammate = new Teammate();
        $modelTeammate->team_id = $this->id;
        $modelTeammate->user_id = $this->team_leader_id;

        if ($modelTeammate->validate()) {

            $modelTeammate->save();

        }
        parent::afterSave($insert, $changedAttributes); // TODO: Change the autogenerated stub
    }
}
