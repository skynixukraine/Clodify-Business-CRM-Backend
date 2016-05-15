<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ContactForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

$this->title = 'Contact Skynix & Request a quote';
$this->params['breadcrumbs'][] = $this->title;
?>

<section class="container contact">

    <div class="row">
        <div class="col-lg-12">


            <h1>Contact Skynix</h1>

            <?php if (Yii::$app->session->hasFlash('contactFormSubmitted')): ?>

            <div class="alert alert-success">
                Thank you for contacting us. We will respond to you as soon as possible.
            </div>

            <?php else: ?>


        </div>
        <div class="col-lg-12 col-xs-12 contact-txt">
               If you have business inquiries or other questions, please fill out the following form to contact us.
            Thank you.
        </div>

    </div>


   


        <div class="row">
            <div class="col-lg-12">

                <?php $form = ActiveForm::begin(['id' => 'contact-form']); ?>

                    <?= $form->field($model, 'name') ?>

                    <?= $form->field($model, 'email') ?>

                    <?= $form->field($model, 'subject') ?>

                    <?= $form->field($model, 'body')->textArea(['rows' => 6]) ?>

                    <?= $form->field($model, 'verifyCode')->widget(Captcha::className(), [
                        'template' => '<div class="row"><div class="col-md-2 col-sm-3 col-md-offset-1 col-xs-3 img-captcha">{image}</div>
                        <div class="col-md-4 col-sm-4 col-xs-3 input-captcha">{input}',
                    ]) ?>

                    <div class="col-md-5 col-sm-5 col-xs-6 btn-box">
                        <?= Html::submitButton('Submit', ['class' => 'btn btn-submit', 'name' => 'contact-button']) ?>
                    </div>
                    </div>
                </div>

                <?php ActiveForm::end(); ?>

            </div>
        </div>

    <?php endif; ?>

</section>


