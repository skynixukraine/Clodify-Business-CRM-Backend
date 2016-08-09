<?php
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use app\models\SupportTicket;

/**
 * @var $subject \app\models\SupportTicket
 *  * @var $model \app\models\SupportTicket
 */

$this->title = 'Skynix Support';
$this->registerJsFile('/js/bootstrap.min.js');
$this->registerJsFile('/js/jQuery-2.1.4.min.js');

?>﻿
<?php $form = ActiveForm::begin()?>
<header>
    <h1>Skynix Support</h1>
</header>
<?php /*var_dump(SupportTicket::supportSearch());exit();*/?>
<div class="container-fluid">
    <div class="row">
        <section class="col-lg-6 col-lg-offset-3 sect3">
            <article>
                <div class="form-group">
                    <?php echo $form->field( $model, 'subject', [

                        'options' => [
                            'class'=>'supportticket-subject subject',
                            'type'=>'text',

                        ]
                    ])->textInput(array('placeholder' => 'Enter the subject or your question', 'type'=>'text', 'autofocus'=>'autofocus'))->label( false );?>

                </div><br>
                <table id="table-result">
                    <span class="quest" style="display: none;">Are you looking for the following subject?</span>
                    <?php $subject = SupportTicket::getSupport(null);?>
                </table>
            </article>
            <div class="col-md-12">
                <?php echo Html::a(Yii::t('app', 'Submit Request'), null, ['class' => 'btn btn-primary off-button',
                    'style' => 'float: right; margin-top: 10px;',
                    'disabled'  =>  'disabled']) ?>
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

        }
    });
    $(document).keydown(function(e){
        if (e.keyCode == 9 ) {

            return false;
        }
    });
        var input = '#supportticket-subject';
        $("input").on('change keydown paste input', function (event) {

            var saveButton = $('.off-button');
                $.ajax({
                    type: "GET",
                    url: '',
                    dataType: 'json',
                    data: 'query=' + $(input).val(),
                    beforeSend: function () {
                    },
                    success: function (response) {
                        var subjects = '';
                        if (response.error) {
                            $(document).keydown(function(e){
                                console.log(e.keyCode);
                                saveButton.attr('href', '/support/submit-request');
                                if (e.keyCode == 9 ) {
                                    return false;
                                }
                                if (e.keyCode == 13 ) {
//                                    saveButton.attr('href', '/support/submit-request');
                                    window.location.pathname = '/support/submit-request';
                                }
                            });
                            saveButton.removeAttr('disabled').css('background', '#337ab7');
                            $('#table-result').html('');
                            return;
                        }
                        $.each(response, function (e, i) {
                            subjects += '<p><a href="/support/ticket?id=' + e + '">Ticket ' + i + ' ' + e + '</a></p>';

                        });
                        $('#table-result').html(subjects).prepend('<span>Are you looking for the following subject?</span>');

                    },
                    error: function (response) {
                        var saveButton = $('.off-button');
                        //saveButton.removeAttr('disabled').css('background', '#337ab7');
                        saveButton.attr('disabled', 'disabled');
                        console.log('error');
                    }
                });
            });
</script>
