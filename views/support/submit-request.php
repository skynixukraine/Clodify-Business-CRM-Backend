<?php
/**
 * Created by PhpStorm.
 * User: lera
 * Date: 01.06.16
 * Time: 9:00
 */
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use app\models\User;
use  kato\DropZone;
/**
 * @var $subject \app\models\SupportTicket
 * @var $model \app\models\SupportTicket
 */
$this->title = 'Create a ticket and submit the request to Skynix Team';
?>
<?php $form = ActiveForm::begin(['action' => 'create','options' => ['enctype' => 'multipart/form-data']]) ;?>
<header>
    <h1>Skynix Team</h1>
</header>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-6 box box-primary box-body col-lg-offset-3">

                <?php echo $form->field( $model, 'subject')
                    ->textInput([
                        'class'  => 'form-control',
                    ])-> label();?>
            <?php if(Yii::$app->user->isGuest):?>
                <?php echo $form->field( $model, 'email')
                    ->textInput([
                        'class' => 'form-control ',
                        'placeholder'   => 'Enter email',
                        'type'          => 'email',
                        'required'         => 'required'
                    ])-> label( 'Your Email Address' );?>
            <?php endif?>
            <?php echo $form->field( $model, 'password')
                ->textInput([
                    'class' => 'form-control ',
                    'placeholder'   => 'password',
                    'type'          => 'password',
                    'style'         => 'display: none'
                ])-> label( 'Your Password', ['class'=> 'password','style'=>'display:none;']);?>

                <?php echo $form->field( $model, 'description')
                    ->textarea([
                        'class'  => 'form-control',
                    ])-> label();?>
            <!--Upload file Dropzone-->
            <?php
            echo \kato\DropZone::widget([
                'options' => [
                    'url'   =>  'upload',
                    'maxFilesize' => '5',
                    'maxFiles'=> '5',
                    'dictMaxFilesExceeded'=>' You can not add more than 5 files',
                    'acceptedFiles' => 'image/jpg, image/jpeg, image/png, image/gif',
                ],
                'clientEvents' => [
                    'complete' => "function(file){console.log(file)}",
                    'maxfilesexceeded' => ' function(file){
                                                            alert("You can not add more than 5 files");
                                                            this.removeFile(file);
                                                        }',
                ],
            ]);
            ?>
            <div class="col-md-12">
                <?= Html::submitButton( Yii::t('app', 'Create a Ticket'), ['class' => 'btn btn-primary', 'style' => 'float: right; margin-top: 10px;']) ?>
            </div>
        </div>
    </div>
</div>
<?php ActiveForm::end();?>
<script src="https://code.jquery.com/jquery-1.12.4.min.js"; integrity="sha256-ZosEbRLbNQzLpnKIkEdrPv7lOy9C27hHQ+Xp8a4MxAQ=" crossorigin="anonymous"></script>
<script>
    var input = '#supportticket-email';
    $(input).blur(function(event){
        $.ajax({
            type: "GET",
            url: 'us',
            dataType: 'json',
            data: 'query='+$(input).val(),
            beforeSend: function(){
            },
            success: function(response) {
                if(response.success == true) {
                    $('#supportticket-password').css('display', 'block');
                    $('.password').css('display', 'block');
                }
                if(response.success == false) {
                    $('#supportticket-password').css('display', 'none');
                    $('.password').css('display', 'none');
                }
            }
        });
    });
</script>

