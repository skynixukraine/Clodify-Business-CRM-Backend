<?php
/**
 * Created by Skynix Team
 * Date: 24.01.17
 * Time: 14:42
 */

namespace app\components;


class Helper
{

    /*  Formatting time in seconds to  hours:minutes look */
    public function timeLength($sec)
    {
        $m=floor(($sec / 60) % 60);
        $h=floor($sec / 3600);

        return $h.":".substr("0".$m,-2);
    }

}