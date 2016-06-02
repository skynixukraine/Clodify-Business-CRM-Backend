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
 */
?>
<header>
    <h1><?= Html::encode($model->subject)?></h1>
</header>
<div class="container-fluid">
    <div class="row">
        <section class="col-lg-6 col-lg-offset-3 sect3">
            <article>
                <p contenteditable="true">
                <div class="form-group">
                    <p>Status: <?= Html::encode($model->status)?></p>
                    <p>Description: <?= Html::encode($model->description)?></p>
                    <p>Posted: <?= Html::encode(DateUtil::convertDatetimeWithoutSecund($model->date_added))?></p>
                    <p>Resolved : <?= Html::encode(DateUtil::convertDatetimeWithoutSecund($model->date_completed))?></p>

                <?php if(User::hasPermission([User::ROLE_ADMIN, User::ROLE_PM, User::ROLE_GUEST])):?>
                    <h2>Your comment</h2>
                    <?php $form = ActiveForm::begin();?>
                        <?php echo $form->field($model, 'comment')->textarea(['required' => 'required'])->label(false);?>
                     <?= Html::submitButton( Yii::t('app', 'Post Comment'), ['class' => 'btn btn-primary', 'style' => 'float: right; margin-top: 10px;']) ?>
                    <?php ActiveForm::end();?>
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

            </article>

        </section>
    </div>
</div>
