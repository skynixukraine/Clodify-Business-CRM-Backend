<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "delayed_salary".
 *
 * @property int $id
 * @property int $user_id
 * @property int $month
 * @property int $value
 * @property int $raised_by
 * @property int $is_applied
 */
class DelayedSalary extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'delayed_salary';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'month', 'value'], 'required'],
            [['user_id', 'month', 'is_applied', 'raised_by'], 'integer'],
            [['value'], 'number'],
            [['month'], 'number', 'max' => 12, 'min' => 1],
            ['user_id', function() {
                $user =  User::find()->where(['id' => $this->user_id, 'is_active' => 1, 'is_delete' => 0])->one();
                    if (! $user) {
                        $this->addError('user_id', Yii::t('app', 'Not active user'));
                    }
            }]
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
            'month' => 'Month',
            'value' => 'Value',
            'raised_by' => 'Raised By',
            'is_applied' => 'Is Applied',
        ];
    }

    /**
     * @return array
     *
     */
    public function getInfo()
    {
        $arr = [];
        $arr['id']        = $this->id;
        $arr['value']     = $this->value;
        $arr['month']     = $this->month;
        $arr['raised_by'] = $this->raised_by;
        return $arr;
    }
}
