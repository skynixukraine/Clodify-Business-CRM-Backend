<?php
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use app\models\SupportTicket;

/* @var $this yii\web\View
 */
$this->title = 'Skynix Support';
$this->registerJsFile('/js/bootstrap.min.js');
$this->registerJsFile('/js/jQuery-2.1.4.min.js');

?>﻿
<?php $form = ActiveForm::begin()?>
<header>
    <h1>Skynix Support</h1>
   <!-- <nav class ="center_nav">
        <ul class="nav nav-pills" >
            <li>
                <a href="#"><h3>вернуться на главную страницу</h3></a>
            </li>

        </ul>
    </nav>-->
</header>
<div class="container-fluid">
    <div class="row">
        <section class="col-lg-6 col-lg-offset-3 sect3">
            <article>
                <!--<header>
                    <h3>Подзаголовок</h3>
                </header>-->
                <p contenteditable="true">
                <div class="form-group">
                    <?php echo $form->field( $model, 'subject', [

                        'options' => [
                            'class'=>'supportticket-subject'

                        ]
                    ])->textInput(array('placeholder' => 'Enter the subject or your question'))->label( false );?>


                </div><br>
            </article>

            <div class="col-md-12">
                <?= Html::submitButton( Yii::t('app', 'Submit Request'), [
                    'class' => 'btn btn-primary off-button',
                    'style' => 'float: right; margin-top: 10px;',
                    'disabled'  =>  'disabled',
                    ])
                ?>
            </div>

        </section>
    </div>
</div>
<?php ActiveForm::end();?>
<script src="https://code.jquery.com/jquery-1.12.4.min.js"; integrity="sha256-ZosEbRLbNQzLpnKIkEdrPv7lOy9C27hHQ+Xp8a4MxAQ=" crossorigin="anonymous"></script>
<script>
    var supportTicket = $('.supportticket-subject');
    supportTicket.change(function(){
        var thisSup = $(this);
        var saveButton = $('.off-button');
        if(thisSup.val() == ""){
            saveButton.removeAttr('disabled').css('background', '#337ab7');
        }
    })
</script>
