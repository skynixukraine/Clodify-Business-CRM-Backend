<?php
/**
 * Created by Skynix Team
 * Date: 05.05.17
 * Time: 10:49
 */

namespace app\models;
use Yii;

class Storage
{
    private $aws;
    private $s3;

    function __construct()
    {
        $this->aws = Yii::$app->awssdk->getAwsSdk();
        $this->s3 = $this->aws->createS3();
    }

    /**
     * @param $bucket
     * @param $keyname
     * @param $filepath
     * @return mixed
     */
    public function upload($bucket,$keyname,$filepath)
    {
        $result = $this->s3->putObject(array(
            'Bucket' => $bucket,
            'Key' => $keyname,
            'SourceFile' => $filepath,
            'ContentType' => 'image',
            'ACL' => 'bucket-owner-full-control',
            'StorageClass' => 'REDUCED_REDUNDANCY',
            "Cache-Control" => "max-age=315360000",
            'Metadata' => array(
                'param1' => 'value 1',
                'param2' => 'value 2'
            )
        ));
        return $result;
    }

    /**
     * get the last object from s3
     * @param string $bucket
     * @param string $key
     * @return mixed
     */
    public function download($bucket='',$key ='')
    {
        $file = $this->s3->getObject([
            'Bucket' => $bucket,
            'Key' => $key,
        ]);
        return $file;
    }
    public function downloadToFile($bucket='',$key ='', $pathToFile = '') {

        $result = $this->s3->getObject([
            'Bucket' => $bucket,
            'Key' => $key,
            'SaveAs' => $pathToFile
        ]);
        return $result;
    }

    /**
     * get the all object from prefix s3
     * @param string $bucket
     * @param string $key
     * @return mixed
     */
    public function getListFileUser($bucket='',$prefix ='')
    {
        $file = $this->s3->listObjects([
            'Bucket' => $bucket,
            'Prefix' => $prefix,
        ]);
        return $file;
    }
}