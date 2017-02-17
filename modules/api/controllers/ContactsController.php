<?php
/**
 * Created by Skynix Team
 * Date: 08.02.17
 * Time: 16:03
 */

namespace app\modules\api\controllers;

use app\modules\api\components\Api\Processor;
use app\models\Contact;

class ContactsController extends DefaultController
{

    public function actionIndex()
    {

        $this->di
            ->set('yii\db\ActiveRecordInterface', 'app\models\Contact')
            ->set('viewModel\ViewModelInterface', 'viewModel\Contacts')
            ->set('app\modules\api\components\Api\Access', [
                'methods'       => [ Processor::METHOD_POST ],
                'checkAccess'   => false
            ])
            ->get('Processor')
            ->respond();

    }

    public function actionAttachment()
    {

        $this->di
            ->set('app\models\Contact', ['scenario' => Contact::SCENARIO_ATTACH_FILES])
            ->set('yii\db\ActiveRecordInterface', 'app\models\Contact')
            ->set('viewModel\ViewModelInterface', 'viewModel\ContactsAttach')
            ->set('app\modules\api\components\Api\Access', [
                'methods'       => [ Processor::METHOD_POST ],
                'checkAccess'   => false
            ])
            ->get('Processor')
            ->respond();

    }

}