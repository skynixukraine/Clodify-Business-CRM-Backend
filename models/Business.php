<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "busineses".
 *
 * @property integer $id
 * @property string $name
 * @property string $name_ua
 * @property string $address
 * @property string $address_ua
 * @property string $represented_by
 * @property string $represented_by_ua
 * @property string $bank_information
 * @property string $bank_information_ua
 * @property integer $invoice_increment_id
 *
 * @property Operation[] $operations
 */
class Business extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'busineses';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'address'], 'string', 'max' => 255],
            [['name', 'address', 'director_id', 'is_default'], 'required'],
            [['is_default'], 'boolean'],
            [['director_id'], 'validateDirectorId']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'address' => 'Address',
            'director_id' => 'Director ID',
            'is_default' => 'Is Default'
        ];
    }

    public function validateDirectorId($attribute){
        $directorUser = $this->getUser()->one();
        if(is_null($directorUser)) {
            return $this->addError($attribute, 'Cannot find user by director_id');
        }

        $allowed = ['CLIENT', 'ADMIN', 'SALES', 'FIN'];

        if(!in_array($directorUser->role, $allowed)) {
            return $this->addError($attribute, 'director cannot have this role');
        }
    }

    public function getUser(){
        return $this->hasOne(User::className(), ['id' => 'director_id']);
    }

    public function afterSave($insert, $changedAttributes)
    {
        if($this->is_default == 1) {
            Business::updateAll(
                ['is_default' => 0],
                'id != :id',
                [
                    ':id' => $this->id
                ]
            );
        }
        parent::afterSave($insert, $changedAttributes); // TODO: Change the autogenerated stub
    }


}
