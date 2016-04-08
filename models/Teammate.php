<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "teammates".
 *
 * @property integer $team_id
 * @property integer $user_id
 *  @property string $status
 */
class Teammate extends \yii\db\ActiveRecord
{
<<<<<<< Updated upstream
=======
    const STATUS_NEW        = "NEW";

>>>>>>> Stashed changes
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
}
