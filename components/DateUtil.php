<?php
/**
 * Created by PhpStorm.
 * User: olha
 * Date: 04.02.16
 * Time: 17:47
 */

namespace app\components;


class DateUtil
{
    public static function convertData($date)
    {
        if($date) {

            if(($date_explode = explode("/", $date)) && count($date_explode)==3) {

                $data = [$date_explode[2], $date_explode[1], $date_explode[0]];
                $time = "00:00:00";
                $dateData = [implode("-", $data), $time];
                $date = implode(' ', $dateData);
            }
        }
        return $date;
    }

}