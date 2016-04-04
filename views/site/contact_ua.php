<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ContactForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

$this->title = 'Зв\'яжіться з нами';
$this->params['breadcrumbs'][] = $this->title;
?>


<section class="container page contact">



    <div class="row">
        <div class="col-lg-12">


            <h1><?= Html::encode($this->title) ?></h1>

            <?php if (Yii::$app->session->hasFlash('contactFormSubmitted')): ?>

            <div class="alert alert-success">
                Дякуємо Вам за звернення до нас. Ми відповімо вам як можна швидше.
            </div>

            <?php else: ?>


        </div>
        <div class="col-lg-12 col-xs-12 contact-txt">
              Якщо у вас є ділова пропозиція або інші питання, будь ласка, заповніть наступну
            форму, щоб зв'язатися з нами. Дякую.
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
                        <?= Html::submitButton('Відправити', ['class' => 'btn btn-submit', 'name' => 'contact-button']) ?>
                </div>
                </div>
            </div>

                <?php ActiveForm::end(); ?>

            </div>
        </div>

    <?php endif; ?>
</section>

