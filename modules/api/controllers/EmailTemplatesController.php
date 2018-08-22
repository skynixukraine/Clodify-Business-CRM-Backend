<?php
/**
 * Created by SkynixTeam.
 * User: Oleg
 * Date: 08.11.18
 * Time: 11:47
 */

namespace app\modules\api\controllers;
use app\models\EmailTemplate;

use app\modules\api\components\Api\Processor;

class EmailTemplatesController extends DefaultController
{

    public function actionFetch()
    {
        $this->di
            ->set('yii\db\ActiveRecordInterface', 'app\models\EmailTemplate')
            ->set('viewModel\ViewModelInterface', 'viewModel\EmailTemplateFetch')
            ->set('app\modules\api\components\Api\Access', [
                'methods' => [ Processor::METHOD_GET],
                'checkAccess' => true
            ])
            ->get('Processor')
            ->respond();
    }



}
