<?php
/**
 * Created by PhpStorm.
 * User: alekseyyp
 * Date: 3/22/16
 * Time: 21:49
 */

namespace app\components;
use Yii;

class Language
{
    private static $language;

    public static function getUrl()
    {
        if ( ( $domain = Yii::$app->getRequest()->serverName) ) {

            if( count( Yii::$app->getRequest()->acceptableLanguages ) ) {

                foreach ( Yii::$app->getRequest()->acceptableLanguages as $lang) {

                    if ( $lang == 'en-US' ) {

                        return Yii::$app->params['en_site'];

                    } else if ( $lang == 'ru' || $lang == 'ua') {

                        return Yii::$app->params['ua_site'];

                    }

                }

            }

        }
        return Yii::$app->params['en_site'];
    }

    public static function getRedirectUrl()
    {
        if ( ( $domain      = Yii::$app->getRequest()->serverName ) &&
                ( $siteDomain = str_replace(array("http://", "https://", ":" . Yii::$app->params['port']), "", Yii::$app->params['in_site']) ) &&
            ( $domain == $siteDomain ) ) {

            return self::getUrl();

        }
    }
    public static function getCpRedirectUrl()
    {
        if ( ( $domain      = Yii::$app->getRequest()->serverName ) &&
            ( $siteDomain = str_replace(array("http://", "https://", ":" . Yii::$app->params['port']), "", Yii::$app->params['in_site']) ) &&
            ( $domain != $siteDomain ) ) {

            return Yii::$app->params['in_site'];

        }
    }

    public static function getDefaultUrl()
    {
        return Yii::$app->params['in_site'];
    }

    public static function getLanguage()
    {
        if ( !self::$language ) {

            if ( ( $domain      = Yii::$app->getRequest()->serverName ) &&
                ( strstr($domain, "ua.") !== false ) ) {

                self::$language = 'ua';

            } else {

                self::$language = 'en';

            }

        }
        return self::$language;
    }
}