<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Login UA';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="container site-login" id="contact">




    <div class="row">
        <div class="col-lg-12">

            <!--<h1>Login</h1>-->
            <h1><?= Html::encode($this->title) ?></h1>
        </div>
        <!--<div class="col-lg-12 col-xs-12 contact-txt">
            Please fill out the following fields to login:
        </div>-->
        <div class="col-lg-12 col-xs-12 contact-txt">
            Будь ласка, заповніть наступні поля для входу:
        </div>
    </div>








    <?php $form = ActiveForm::begin([
        'id' => 'login-form',
        'options' => ['class' => 'form-horizontal'],
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-1 control-label'],
        ],
    ]); ?>

        <?= $form->field($model, 'email') ?>



        <?= $form->field($model, 'password')->passwordInput() ?>

        <?= $form->field($model, 'rememberMe')->checkbox([
            'template' => "<div class=\"col-lg-offset-1 col-lg-3\">{input} {label}</div>\n<div class=\"col-lg-8\">{error}</div>",
        ]) ?>

        <div class="form-group">
            <div class="col-lg-offset-1 col-lg-11">
                <?= Html::submitButton('Login', ['class' => 'btn btn-login', 'name' => 'login-button']) ?>
            </div>
        </div>

    <?php ActiveForm::end(); ?>

    <div class="col-lg-offset-1" style="color:#999;">
        You may login with your email address and password.
    </div>

</div>

