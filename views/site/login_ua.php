<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Ввійти';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="container page login">

    <div class="row">
        <div class="col-lg-12">


            <h1><?= Html::encode($this->title) ?></h1>
        </div>

        <div class="col-lg-12 col-xs-12 contact-txt">
            Будь ласка, заповніть наступні поля для входу:
        </div>
    </div>


    <?php $form = ActiveForm::begin([
        'id' => 'login-form',
        'options' => ['class' => 'form-horizontal'],
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-8 col-md-8 col-sm-10 col-xs-9\">{input}</div>\n<div class=\"col-lg-9 col-lg-offset-3 col-md-9 col-md-offset-3 col-sm-9 col-sm-offset-2 col-xs-offset-3 \">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-3 col-md-3 col-sm-2 col-xs-3 control-label'],
        ],
    ]); ?>

        <?= $form->field($model, 'email') ?>
        <?= $form->field($model, 'password')->passwordInput() ?>
        <?= $form->field($model, 'rememberMe')->checkbox([
            'template' => "<div class=\"col-lg-offset-3 col-lg-3 col-md-offset-3 col-md-4 col-sm-offset-2 col-sm-6 col-xs-offset-3 col-xs-8 \">{input} {label}</div>\n
    <div class=\"col-lg-offset-3 col-lg-9 col-md-offset-3 col-md-9 \">{error}</div>",
        ]) ?>


        <div class="form-group box-login-btn">
            <div class="col-lg-offset-6 col-lg-5 col-md-offset-6 col-md-5 col-xs-12">
                <?= Html::submitButton('Ввійти', ['class' => 'btn btn-login', 'name' => 'login-button']) ?>
            </div>
        </div>

    <?php ActiveForm::end(); ?>



</section>

