<?php

namespace app\modules\ExtensionPackager\models;

use Yii;


/**
 * This is the model class for table "extensions".
 *
 * @property integer $id
 * @property string $name
 * @property string $repository
 * @property string $type
 * @property string $version
 * @property string $package
 */
class Extension extends \yii\db\ActiveRecord
{
    const TYPE_EXTENSION = "EXTENSION";
    const TYPE_THEME     = "THEME";
    const TYPE_LANGUAGE  = "LANGUAGE";
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'extensions';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type'], 'string'],
            [['name', 'repository', 'version', 'package'], 'string', 'max' => 250],            
            [['name', 'repository', 'type'], 'required'],
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
            'repository' => 'Repository',
            'type' => 'Type',
            'version' => 'Version',
            'package' => 'Package',
        ];
    }

    public static function getPathExtension($id)
    {
        $path = Yii::getAlias("@app") . "/data";
        if ( !file_exists( $path) ) {

            mkdir($path);
            chmod ( $path, 0777 );
        }
        $path .= "/extensions";
        if ( !file_exists( $path) ) {

            mkdir($path);
            chmod ( $path, 0777 );
        }

        $path .= "/" . $id . "/";
        if ( !file_exists( $path) ) {

            mkdir($path);
            chmod ( $path, 0777 );
        }
        
        return $path;
    }

    public static function createExtensionFolder($id)
    {
        $path = Yii::getAlias("@app") . "/data/extensions/" . $id . "/SkynixExtension/";
        if ( !file_exists( $path) ) {

            mkdir($path);
            chmod ( $path, 0777 );
        }
        
        $path = Yii::getAlias("@app") . "/data/extensions/" . $id . "/temp/";

        if ( !file_exists( $path) ) {

            mkdir($path);
            chmod ( $path, 0777 );
        }
        return $path;
    }
}
