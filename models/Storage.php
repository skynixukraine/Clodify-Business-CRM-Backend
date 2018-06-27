<?php
/**
 * Created by Skynix Team
 * Date: 05.05.17
 * Time: 10:49
 */

namespace app\models;
use Yii;
use yii\base\Exception;
use yii\log\Logger;

class Storage
{
    private $aws;
    private $s3;
    private $basket;

    function __construct()
    {
        $this->aws = Yii::$app->awssdk->getAwsSdk();
        $this->s3 = $this->aws->createS3();
        $this->basket = Yii::$app->params['basketAwssdk'];
    }

    /**
     * @param $bucket
     * @param $keyname
     * @param $filepath
     * @return mixed
     */
    public function upload($keyname,$filepath)
    {
        try {
            $result = $this->s3->putObject(array(
                'Bucket' => $this->basket,
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
        } catch (\Exception $e) {
            throw new $e;
        }

        return $result;
    }

    /**
     * @param $keyname
     * @param $file
     * @return mixed
     */
    public function uploadData($keyname, $file)
    {
        $result = $this->s3->putObject(array(
            'Bucket' => $this->basket,
            'Key'    => $keyname,
            'Body'   => $file
        ));
        return $result;
    }

    /**
     * get the last object from s3
     * @param string $bucket
     * @param string $key
     * @return mixed
     */
    public function download($key ='')
    {
        try {
        $file = $this->s3->getObject([
            'Bucket' => $this->basket,
            'Key' => $key,
        ]);
        } catch (\Exception $e) {
            return null;
        }

        return $file;
    }

    public function downloadToFile($key ='', $pathToFile = '') {

        $result = $this->s3->getObject([
            'Bucket' => $this->basket,
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
    public function getListFileUser($prefix ='')
    {
        try {
            $file = $this->s3->listObjects([
                'Bucket' => $this->basket,
                'Prefix' => $prefix,
            ]);
        } catch (\Exception $e) {
            return null;
        }

        return $file;
    }

    /**
     * @param $key
     * @param $sourceFile
     * @return mixed
     * @throws Exception
     */
    public function uploadBase64($key, $sourceFile)
    {
        try {
            $upload = $this->s3->putObject(array(
                'Bucket' => $this->basket,
                'Key'    => $key,
                'Body'   => $sourceFile
            ));
        } catch (Exception $e) {

            Yii::getLogger()->log( "S3 Unable Put Object " . var_export($e, 1), Logger::LEVEL_WARNING);
            throw $e;
        }
        return $upload;
    }
}