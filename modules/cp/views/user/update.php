<?php
use yii\web\View;
use yii\helpers\Url;

$this->title = Yii::t('app', 'Update the user #{0}', [$model->id]);
$this->params['breadcrumbs'][] = $this->title;
$this->params['menu'] = [
    [
        'label' => Yii::t('app', 'Back to list'),
        'url'   => Url::to(['user/index'])
    ]
];
?>
<div id="createfilter">

    <?=$this->render("_form", array(
        'model'         => $model
    ))?>

</div>
