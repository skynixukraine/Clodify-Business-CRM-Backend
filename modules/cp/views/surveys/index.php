<?php
/**
 * Created by PhpStorm.
 * User: lera
 * Date: 05.05.16
 * Time: 15:06
 */
use yii\helpers\Url;
use yii\helpers\Html;
use app\models\User;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;

$this->registerJsFile(Yii::$app->request->baseUrl.'/js/jquery.dataTables.min.js');
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/dataTables.bootstrap.min.js');
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/modal.bootstrap.js');
$this->title                    = Yii::t("app", "Take a Survey");

$this->params['breadcrumbs'][]  = $this->title;

$this->params['menu'] = [

];
?>
<table class="table table-hover box" id="surveys_table">
    <thead>
    <tr>
        <th><?=Yii::t('app', 'ID')?> </th>
        <th><?=Yii::t('app', 'Shortcode')?></th>
        <th><?=Yii::t('app', 'Question ')?></th>
        <th><?=Yii::t('app', 'Date Start')?></th>
        <th><?=Yii::t('app', 'Date End')?></th>
        <th><?=Yii::t('app', 'Is Private?')?></th>
        <th><?=Yii::t('app', 'Votes')?></th>

    </tr>
    </thead>
</table>


