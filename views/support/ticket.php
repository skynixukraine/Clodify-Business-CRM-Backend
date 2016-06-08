<?php
/**
 * Created by PhpStorm.
 * User: lera
 * Date: 02.06.16
 * Time: 18:23
 */
use yii\helpers\Html;
use yii\helpers\Url;
use app\components\DateUtil;
use app\models\SupportTicketComment;
use app\models\User;
use yii\widgets\ActiveForm;
/**
 * @var $model \app\models\SupportTicket
 * @var $develop\app\models\SupportTicketComment
 */
?>
<header>
    <h1><?= Html::encode($model->subject)?></h1>
</header>
<div class="container-fluid">
    <div class="row">
        <section class="col-lg-6 col-lg-offset-3 sect3">
            <article>
                <?php $form = ActiveForm::begin();?>
                <div class="form-group">
                    <p>Status: <?= Html::encode($model->status)?></p>
                    <p>Description: <?= Html::encode($model->description)?></p>
                    <p>Posted: <?= Html::encode(DateUtil::convertDatetimeWithoutSecund($model->date_added))?></p>
                    <p>Resolved : <?= Html::encode(DateUtil::convertDatetimeWithoutSecund($model->date_completed))?></p>
                <?php if(isset(Yii::$app->user->identity->role) && User::hasPermission([User::ROLE_ADMIN, User::ROLE_PM])):?>
                    <div class="form-group">
                        <?php $developer = \app\models\User::find()->where(User::tableName() . ".is_delete=0 AND " . User::tableName() . ".is_active=1 AND " .
                            User::tableName() . ".role IN ('" . User::ROLE_PM . "', '" . User::ROLE_DEV . "', '" . User::ROLE_ADMIN . "')")->groupBy(User::tableName() . '.id ')->all();;
                        $listUsers = User::getCustomersDropDown( $developer, 'id' );
                        //$listDevelop = \yii\helpers\ArrayHelper::map( $listUsers, 'id', 'first_name' );

                        echo $form->field( $model, 'assignee', [

                            'options' => [

                            ]
                        ])->dropDownList( $listUsers, ['prompt' => 'Assign the ticket to'] )->label(false);?>
                    </div>
                    <div class="col-lg-12">
                        <div class="btn-group" style="float: right;">
                            <?= Html::button( Yii::t('app', 'COMPLETE'), ['class' => 'btn btn-large btn-primary complete button',
                                'style' => ' margin-top: 10px; margin-right: 10px;']) ?>
                            <?= Html::button(Yii::t('app', 'CANCEL'), ['class' => 'btn btn-large btn-primary off-button',
                                'style' => ' margin-top: 10px;']) ?>
                        </div>
                    </div>
                <?php endif?>

                    <?php if(isset(Yii::$app->user->identity->role) && User::hasPermission([User::ROLE_ADMIN, User::ROLE_PM, User::ROLE_GUEST])):?>
                        <h2>Your comment</h2>
                            <?php echo $form->field($model, 'comment')->textarea(['required' => 'required'])->label(false);?>
                            <?= Html::submitButton( Yii::t('app', 'Post Comment'), ['class' => 'btn btn-primary', 'style' => 'float: right; margin-top: 10px;']) ?>
                    <?php endif?>
                <?php $comments = SupportTicketComment::find()->where('support_ticket_id=:id', [':id' => $model->id])->all();?>
                <?php /** @var $comment SupportTicketComment */?>
                <?php foreach($comments as $comment):?>
                        <h2><?php echo $comment->id?></h2>
                        <span><?php echo $comment->date_added?></span>
                        <span><?php echo User::findOne($comment->user_id)->first_name?></span>
                        <div>
                            <span><?php echo $comment->comment?></span>
                        </div>
                <?php endforeach;?>
                </div><br>
                <?php ActiveForm::end();?>
            </article>
        </section>
    </div>
</div>
<script src="https://code.jquery.com/jquery-1.12.4.min.js"; integrity="sha256-ZosEbRLbNQzLpnKIkEdrPv7lOy9C27hHQ+Xp8a4MxAQ=" crossorigin="anonymous"></script>
<script>
    var button = '.complete';
    $('.button').on('click', function() {
        $.ajax({
            type: "GET",
            url: 'complete',
            data: 'query='+<?php echo $model->id?>,
            dataType: 'json',
            beforeSend: function(){
            },
            success: function(response) {
            }
        });
    });
    $('.off-button').on('click', function() {
        $.ajax({
            type: "GET",
            url: 'cancel',
            data: 'query='+<?php echo $model->id?>,
            dataType: 'json',
            beforeSend: function(){
            },
            success: function(response) {
            }
        });
    });

</script>