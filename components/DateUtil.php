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

    /**
     * @param $date
     * @return string
     */
    public static function convertDatetime( $date )
    {
        if( $date ) {
            $date_explode = explode(" ", trim($date));
            $date = self::convertData($date_explode[0] ) . " " . $date_explode[1];
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

    /** if $date1<$date2 return true */
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

                        if($date_start[0] < $date_end[0]){
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
    public static function convertDatetimeWithoutSecund( $date )
    {
        $timestamp = strtotime($date);
        $newDate = date('d/m/Y H:i', $timestamp);
        return $newDate;
    }

    public static function convertDateTimeWithoutHours($date) {
        $timestamp = strtotime($date);
        $newDate = date('d/m/Y', $timestamp);
        return $newDate;
    }

    /**
     * @param $date
     * @return false|string
     */
    public static function convertDateFromUnix($date, $formatDate = 'd-m-Y')
    {
        return date($formatDate, $date);
    }

    /**
     * @param $date
     * @return false|string
     */
    public static function convertDateToUnix($date)
    {
        return strtotime($date);
    }

    /**
     * @param $date
     * @return string
     *  return something like that 01/01/2016 ~ 31/01/2016
     */
    public static function dateRangeForFetch($date)
    {
        $range = '';
        $month_from_date = date('m', $date);
        $year_from_date = date('Y',$date);
        $count_of_days = date("t",mktime(0,0,0,$month_from_date ,1,$year_from_date));
        $range .= '01/'. $month_from_date . '/' . $year_from_date ;
        $range .= ' ~ ' . $count_of_days . '/' .$month_from_date . '/' . $year_from_date;
        return $range;
    }

}