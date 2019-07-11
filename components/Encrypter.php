<?php

declare(strict_types=1);

namespace app\components;

use app\models\Setting;

class Encrypter extends \nickcv\encrypter\components\Encrypter
{
    public function init()
    {
        parent::init();

        $encryptionKey = Setting::findOne(['key' => 'encryption_key']);

        if ($encryptionKey) {
            $this->setGlobalPassword($encryptionKey->value);
        }
    }
}