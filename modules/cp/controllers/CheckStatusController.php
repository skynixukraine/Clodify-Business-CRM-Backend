<?php
/**
 * Created by SkynixTeam.
 * User: igor
 * Date: 04.09.17
 * Time: 15:58
 */
namespace app\modules\cp\controllers;

use app\models\Career;



class CheckStatusController extends DefaultController
{
    public function actionIndex()
    {
        $f = Career::find()->all();
        return $this->render('index', ['f' => $f]);
    }
}