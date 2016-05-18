<?php
/**
 * Created by Skynix.
 * User: Wolf
 * Date: 18.05.2016
 * Time: 12:42
 */

namespace app\models;


class Dropzone extends \kato\DropZone
{
    public $id = 'myDropzone1';
    public $uploadUrl = '/site/upload';
    public $dropzoneContainer = 'myDropzone1';
    public $previewsContainer = 'previews1';
    public $autoDiscover = false;
}