<?php
/**
 * Created by Skynix Team
 * Date: 05.04.17
 * Time: 17:29
 */

namespace viewModel;

use app\models\Career;

/**
 * Class CareersView
 * @package viewModel
 */
class CareersView extends ViewModelAbstract
{
    public $model;

    public function define()
    {
        $careers = Career::find()
                ->select(['id', 'title', 'description'])
                ->where(['is_active' => Career::IS_ACTIVE])
                ->asArray()
                ->all();

        if($careers) {
            $this->setData($careers);
        } else {
            $this->addError('data', 'Careers not found');
        }
    }

}