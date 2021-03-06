<?php
/**
 * Created by SkynixTeam.
 * User: Oleg
 * Date: 20.08.18
 * Time: 16:01
 */

namespace viewModel;
use app\models\Storage;
use Yii;
use app\models\Business;
use app\modules\api\components\Api\Processor;

class BusinessGetDefaultLogo extends ViewModelAbstract
{
    public function define(){

        $businessId = Yii::$app->request->getQueryParam('id');

        if(!($business = Business::findOne($businessId))){
            return $this->addError(Processor::ERROR_PARAM, Yii::t('app','cannot find a business'));
        }

        $s = new Storage();
        $pathFile = 'businesses/' . $business->id. '/logo';

        try {
            $logo = $s->download($pathFile);
            if(isset($logo['Body'])) {
                $str = $logo['Body'];
                $base = base64_encode($str);
                $data = ['logo' => [$base]];
            } else {
                $data = ['logo' => null];
            }
        } catch (\Exception $e) {
            return $this->addError(Processor::ERROR_PARAM, Yii::t('app','cannot find image'));
        }

        $this->setData($data);

    }

}