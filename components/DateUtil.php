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

    /** Convert date from format dd/mm/yyyy to format Y-m-d */
    public static function convertData( $date )
    {
        if( $date ) {

            if( ( $date_explode = explode("/", $date) ) && count($date_explode) == 3 ) {

                $data = [$date_explode[2], $date_explode[1], $date_explode[0]];
                $date = implode("-", $data);
            }
        }
        return $date;
    }

    /** Convert date from format Y-m-d to format dd/mm/yyyy */
    public static function  reConvertData($date)
    {
        if( $date ){

            if( ( $date_explode = explode("-", $date)) && count($date_explode) == 3 ){

                $date = [$date_explode[2], $date_explode[1], $date_explode[0]];
                $date = implode("/", $date);
            }
        }
        return $date;

    }

    public static function compareDates($date1, $date2)
    {
        if( $date1 && $date2 ) {

            if( ( $date_start = explode("/", $date1) ) && ( $date_end = explode("/", $date2) )
                && count($date_start) == 3 && count($date_end) == 3 ) {

                if($date_start[2] < $date_end[2]){
                    return true;
                }
                if($date_start[2] == $date_end[2]){

                    if($date_start[1] < $date_end[1]){
                        return true;
                    }
                    if($date_start[1] == $date_end[1]){

                        if($date_start[0] <= $date_end[0]){
                            return true;

                        }else{
                            return false;
                        }

                    }else{
                        return false;
                    }

                }else{
                    return false;
                }
            }
        }
    }

}