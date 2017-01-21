<?php
/**
 * Created by Skynix Team
 * Date: 7/15/16
 * Time: 17:29
 */

namespace app\modules\api\components;
use Yii;
use app\modules\api\components\Api\Processor;

class Message
{
    /**
     * @param $code
     * @return string
     */
    public static function get( $code )
    {
        
        $message = "";
         switch ( $code ) {

             case Processor::CODE_SUCCESS :

                 $message = Yii::t("yii", "Successful response");
                 break;

             case Processor::CODE_TOKEN_EXPIRED :

                 $message = Yii::t("yii", "Your token is expired");
                 break;

             case Processor::CODE_TOKEN_UNDEFINED :

                 $message = Yii::t("yii", "Your token is undefined");
                 break;

             case Processor::CODE_METHOD_NOT_ALLOWED :

                 $message = Yii::t("yii", "This HTTP method disallowed");
                 break;

             case Processor::CODE_NOT_ATHORIZED :

                 $message = Yii::t("yii", "You are not authorized to access this action");
                 break;


             case Processor::CODE_TEHNICAL_ISSUE :

                 $message = Yii::t("yii", "Please contact technical support");
                 break;

             case Processor::CODE_UNPROCESSABLE_JSON :

                 $message = Yii::t("yii", "Your JSON data can not be processed by our server");
                 break;

             case Processor::CODE_DELETE_ERROR :

                 $message = Yii::t("yii", "You can not delete entry using this request");
                 break;

             case Processor::CODE_INSERT_ERROR :

                 $message = Yii::t("yii", "You can not insert entry using this request");
                 break;

             case Processor::CODE_UPDATE_ERROR :

                 $message = Yii::t("yii", "You can not update entry using this request");
                 break;

             case Processor::CODE_ACTION_RESTRICTED :

                 $message = Yii::t("yii", "The action is not allowed for you");
                 break;
         }
        return $message;
    }
}