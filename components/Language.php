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
    public static function getUrl()
    {
        if ( ( $domain = Yii::$app->getRequest()->serverName) &&
             strstr( Yii::$app->params['in_site'], $domain) === false ) {

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
}