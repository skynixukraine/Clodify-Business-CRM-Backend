<?php
/**
 * Created by SkynixTeam.
 * User: igor
 * Date: 06.11.17
 * Time: 17:54
 */
namespace app\models;

use Yii;

/**
 * This is the model class for table "counterparties".
 *
 * @property integer $id
 * @property string $name
 */
class Counterparty extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'counterparties';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'string', 'max' => 255],
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
        ];
    }
}