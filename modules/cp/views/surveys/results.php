<?php
/**
 * Created by PhpStorm.
 * User: lera
 * Date: 06.05.16
 * Time: 12:07
 */

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets;
use yii\widgets\ActiveForm;
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/jquery.dataTables.min.js');
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/dataTables.bootstrap.min.js');
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/jquery.slimscroll.min.js');
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/user.js');
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/modal.bootstrap.js');
$this->title                    = Yii::t("app", "Results");
$this->params['breadcrumbs'][]  = $this->title;

$this->params['menu'] = [];

?>
<?php $form = ActiveForm::begin();?>
<div class="row">
    <div class="col-md-6">
        <?php /** @var $model \app\models\Surveys */?>
        <span> Result: <?php /*echo $model->result ;*/?> people took a part in this survey<span>
    </div>
</div>
<?php ActiveForm::end();?>
<div class="row">
        <div class="col-md-6 box box-primary box-body">
            <div class="form-group">
                <div class="progress-group">
                    <span class="progress-text">Options1</span>
                    <span class="progress-number">20</span>
                    <div class="progress sm">
                        <div class="progress-bar progress-bar-aqua" style="width: 80%"></div>
                    </div>
                </div>
                <div class="progress-group">
                    <span class="progress-text">Options2</span>
                    <span class="progress-number">20</span>
                    <div class="progress sm">
                        <div class="progress-bar progress-bar-aqua" style="width: 60%"></div>
                    </div>
                </div>
                <div class="progress-group">
                    <span class="progress-text">Options3</span>
                    <span class="progress-number">20</span>
                    <div class="progress sm">
                        <div class="progress-bar progress-bar-aqua" style="width: 100%"></div>
                    </div>
                </div>
            </div>
        </div>
</div>

