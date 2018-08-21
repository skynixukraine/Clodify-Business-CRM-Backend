<?php

namespace app\models;

use Yii;
use yii\log\Logger;

/**
 * This is the model class for table "busineses".
 *
 * @property integer $id
 * @property string $name
 * @property integer director_id
 * @property string $address
 * @property integer $is_default
 * @property integer $is_delete
 *
 * @property Operation[] $operations
 */
class Business extends \yii\db\ActiveRecord
{

    const ATTACH_LOGO_BUSINESS = 'api-attach-logo';
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
        parent::afterSave($insert, $changedAttributes);
    }


    /**
     * @param $logo
     * @return mixed
     */
    public static function uploadLogo($logo, $businessId)
    {


        Yii::getLogger()->log( "S3 uploadPhoto " . var_export($logo, 1), Logger::LEVEL_WARNING);

        $s = new Storage();
        if (is_string($logo)) {
            $pathFile = 'businesses/' . $businessId . '/logo';
            return $s->uploadBase64($pathFile, $logo);
        }
    }

    public function getUser(){
        return $this->hasOne(User::className(), ['id' => 'director_id']);
    }

    public function getDirector(){
        return User::findOne($this->director_id)->toArray(['id', 'first_name', 'last_name']);
    }



}
