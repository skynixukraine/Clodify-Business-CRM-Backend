<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "work_history".
 *
 * @property int $id
 * @property int $user_id
 * @property string $date_start
 * @property string $date_end
 * @property string $type
 * @property string $title
 *
 * @property User $user
 */
class WorkHistory extends \yii\db\ActiveRecord
{

    const TYPE_USER_FAILS       = 'fails';

    const TYPE_USER_EFFORTS     = 'efforts';

    const TYPE_ADMIN_BENEFITS   = 'benefits';

    const TYPE_PUBLIC           = 'public';


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'work_history';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id'], 'integer'],
            [['date_start', 'date_end'], 'required'],
            [['type', 'title'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
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
            'date_start' => 'Date Start',
            'date_end' => 'Date End',
            'type' => 'Type',
            'title' => 'Title',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @param $type
     * @param $userId
     * @param $title
     * @param null $dateStart
     * @return WorkHistory
     */
    public static function create($type, $userId, $title, $dateStart = null, $dataEnd = null)
    {
        $workHistory = new WorkHistory();
        $workHistory->type      = $type;
        $workHistory->user_id   = $userId;
        $workHistory->title     = $title;
        if ( $dateStart == null ) {

            $workHistory->date_start = $workHistory->date_end = date('Y-m-d H:i:s');

        } else {

            $workHistory->date_start = $dateStart;

        }
        if ( $dataEnd ) {

            $workHistory->date_end = $dataEnd;

        }
        $workHistory->save();
        return $workHistory;

    }
}
