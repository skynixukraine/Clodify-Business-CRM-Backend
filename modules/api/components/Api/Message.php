<?php
/**
 * Created by Skynix Team
 * Date: 12/17/16
 * Time: 07:18
 */

namespace app\modules\api\components\Api;
use Yii;

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

                $message = Yii::t("app", "Successful response");
                break;

            case Processor::CODE_TOKEN_EXPIRED :

                $message = Yii::t("app", "Your token is expired");
                break;

            case Processor::CODE_TOKEN_UNDEFINED :

                $message = Yii::t("app", "Your token is undefined");
                break;

            case Processor::CODE_METHOD_NOT_ALLOWED :

                $message = Yii::t("app", "This HTTP method disallowed");
                break;

            case Processor::CODE_NOT_ATHORIZED :

                $message = Yii::t("app", "You are not authorized to access this action");
                break;


            case Processor::CODE_TEHNICAL_ISSUE :

                $message = Yii::t("app", "Please contact technical support");
                break;

            case Processor::CODE_UNPROCESSABLE_JSON :

                $message = Yii::t("app", "Your JSON data can not be processed by our server");
                break;

            case Processor::CODE_DELETE_ERROR :

                $message = Yii::t("app", "You can not delete entry using this request");
                break;

            case Processor::CODE_INSERT_ERROR :

                $message = Yii::t("app", "You can not insert entry using this request");
                break;

            case Processor::CODE_UPDATE_ERROR :

                $message = Yii::t("app", "You can not update entry using this request");
                break;

            case Processor::CODE_ACTION_RESTRICTED :

                $message = Yii::t("app", "The action is not allowed for you");
                break;
        }
        return $message;
    }
}