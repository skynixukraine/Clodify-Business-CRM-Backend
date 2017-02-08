<?php
/**
 * Created by Skynix Team
 * Date: 08.02.17
 * Time: 16:03
 */

namespace app\modules\api\controllers;

use app\modules\api\components\Api\Processor;

class ContactsController extends DefaultController
{

    public function actionIndex()
    {

        $this->di
            ->set('yii\db\ActiveRecordInterface', 'app\models\ContactForm')
            ->set('viewModel\ViewModelInterface', 'viewModel\Contacts')
            ->set('app\modules\api\components\ApiProcessor\ApiProcessorAccess', [
                'methods'       => [ Processor::METHOD_POST ],
                'checkAccess'   => false
            ])
            ->get('Processor')
            ->respond();

    }

    public function actionAttachment()
    {

        $this->di
            ->set('yii\db\ActiveRecordInterface', 'app\models\ContactForm')
            ->set('viewModel\ViewModelInterface', 'viewModel\ContactsAttachment')
            ->set('app\modules\api\components\ApiProcessor\ApiProcessorAccess', [
                'methods'       => [ Processor::METHOD_POST ],
                'checkAccess'   => false
            ])
            ->get('Processor')
            ->respond();

    }

}