<?php
/**
 * Created by Skynix Team
 * Date: 21.05.18
 * Time: 17:49
 */

namespace app\models;


class Storage
{
    /**
     * @param $key
     * @param $sourceFile
     * @return array
     */
    public function uploadBase64($key, $sourceFile)
    {
        return ['ObjectURL' => 'hello there!'];
    }

    /**
     * @param string $key
     * @return bool
     */
    public function download($key ='')
    {
        return true;
    }

    public function downloadToFile()
    {
        return true;
    }
}