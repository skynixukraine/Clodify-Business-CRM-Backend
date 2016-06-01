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

<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ;?>
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
                    ])-> label( 'Your Email Address' );?>
            <?php endif?>

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
                    'acceptedFiles' => 'image/jpg, image/jpeg, image/png, image/gif',
                ],
                'clientEvents' => [
                    'complete' => "function(file){console.log(file)}",
                    'removedfile' => "function(file){alert(file.name + ' is removed')}"
                ],
            ]);
            ?>
        </div>
    </div>
</div>
<?php ActiveForm::end();?>
<script>
    var input = '#supportticket-email';
    $(input).blur(function(event){
        $.ajax({
            type: "GET",
            url: '',
            dataType: 'json',
            data: 'query='+$(input).val(),
            beforeSend: function(){
            },
            success: function(response) {
            }
        });
    })
</script>

