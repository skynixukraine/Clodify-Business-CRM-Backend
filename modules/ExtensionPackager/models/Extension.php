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
    
    public $path1;
    public $path2;
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
            [['type', 'path1', 'path2'], 'string'],
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

    public static function extensionType($path1, $path2, $id)
    {
        $path = Yii::getAlias("@app") . "/data/extensions/" . $id . "/SkynixExtension/app";
        if( !file_exists( $path ) ) {

            mkdir($path);
            chmod($path, 0777 );
        }
        $path .= "/code";
        if( !file_exists( $path ) ) {

            mkdir($path);
            chmod($path, 0777 );
        }
        $path .= "/" . $path1;
        if( !file_exists( $path ) ) {

            mkdir($path);
            chmod($path, 0777 );
        }
        $path .= "/" . $path2;
        if( !file_exists( $path ) ) {

            mkdir($path);
            chmod($path, 0777 );
        }
        exec('rm -rf ' . Yii::getAlias("@app") . '/data/extensions/' . $id . '/temp/.git');
        $folder = exec('cd ' . Yii::getAlias("@app") . '/data/extensions/' . $id . '/temp/ && ls');
        exec('mv ' . Yii::getAlias("@app") . '/data/extensions/' . $id . '/temp/' . $folder . '/* ' . $path . '/');
        exec('rm -rf ' . Yii::getAlias("@app") . '/data/extensions/' . $id . '/temp');
        
        return true;
    }

    public static function themeType($path1, $path2, $id)
    {
        $path = Yii::getAlias("@app") . "/data/extensions/" . $id . "/SkynixExtension/app";
        if( !file_exists( $path ) ) {

            mkdir($path);
            chmod($path, 0777 );
        }
        $path .= "/design";
        if( !file_exists( $path ) ) {

            mkdir($path);
            chmod($path, 0777 );
        }
        $path .= "/frontend";
        if( !file_exists( $path ) ) {

            mkdir($path);
            chmod($path, 0777 );
        }
        $path .= "/" . $path1;
        if( !file_exists( $path ) ) {

            mkdir($path);
            chmod($path, 0777 );
        }
        $path .= "/" . $path2;
        if( !file_exists( $path ) ) {

            mkdir($path);
            chmod($path, 0777 );
        }
        exec('rm -rf ' . Yii::getAlias("@app") . '/data/extensions/' . $id . '/temp/.git');
        $folder = exec('cd ' . Yii::getAlias("@app") . '/data/extensions/' . $id . '/temp/ && ls');
        exec('mv ' . Yii::getAlias("@app") . '/data/extensions/' . $id . '/temp/' . $folder . '/* ' . $path . '/');
        exec('rm -rf ' . Yii::getAlias("@app") . '/data/extensions/' . $id . '/temp');

        return true;
    }

    public static function languageType($path1, $path2, $id)
    {
        $path = Yii::getAlias("@app") . "/data/extensions/" . $id . "/SkynixExtension/app";
        if( !file_exists( $path ) ) {

            mkdir($path);
            chmod($path, 0777 );
        }
        $path .= "/i18n";
        if( !file_exists( $path ) ) {

            mkdir($path);
            chmod($path, 0777 );
        }        
        $path .= "/" . $path1;
        if( !file_exists( $path ) ) {

            mkdir($path);
            chmod($path, 0777 );
        }
        $path .= "/" . $path2;
        if( !file_exists( $path ) ) {

            mkdir($path);
            chmod($path, 0777 );
        }
        exec('rm -rf ' . Yii::getAlias("@app") . '/data/extensions/' . $id . '/temp/.git');
        $folder = exec('cd ' . Yii::getAlias("@app") . '/data/extensions/' . $id . '/temp/ && ls');
        exec('mv ' . Yii::getAlias("@app") . '/data/extensions/' . $id . '/temp/' . $folder . '/* ' . $path . '/');
        exec('rm -rf ' . Yii::getAlias("@app") . '/data/extensions/' . $id . '/temp');

        return true;
    }
}
