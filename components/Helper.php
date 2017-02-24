<?php
/**
 * Created by Skynix Team
 * Date: 24.01.17
 * Time: 14:42
 */

namespace app\components;


class Helper
{

    /*
    Formatting time in seconds to  06:30 look if parameter is integer
    Formatting time  to 6.5 look if parameter is string
    */
    public function timeLength($time)
    {
        if (is_string($time) && strstr($time, ":")) {
            $timeArr = explode(':', $time);
            $hours = $timeArr[0];
            $minutes = round($timeArr[1]/60*100, 2);

            return (float) $hours . '.' . $minutes;
        } elseif (is_float($time)) {
            $m=(int)round($time / 60);
            $m %= 60;
            $h=floor($time / 3600);

            return $h.":".substr("0".$m,-2);
        } elseif (is_int($time)) {
            $h=floor($time / 3600);

            return $h.":00";
        }

    }

}