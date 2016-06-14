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
use app\models\SupportTicket;
/**
 * @var $model \app\models\SupportTicket
 * @var $develop\app\models\SupportTicketComment
 * @var $query User
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
                <?php if(isset(Yii::$app->user->identity->role) && User::hasPermission([User::ROLE_ADMIN, User::ROLE_PM])):?>
                    <div class="col-lg-12">
                        <?php if($model->status == \app\models\SupportTicket::STATUS_COMPLETED || $model->status == \app\models\SupportTicket::STATUS_CANCELLED):?>
                        <div class="form-group">
                            <?php $developer = \app\models\User::find()->where(User::tableName() . ".is_delete=0 AND " . User::tableName() . ".is_active=1 AND " .
                                User::tableName() . ".role IN ('" . User::ROLE_PM . "', '" . User::ROLE_DEV . "', '" . User::ROLE_ADMIN . "')")->groupBy(User::tableName() . '.id ')->all();;
                            $listUsers = User::getCustomersDropDown( $developer, 'id' );
                            //$listDevelop = \yii\helpers\ArrayHelper::map( $listUsers, 'id', 'first_name' );

                            echo $form->field( $model, 'assignee', [

                                'options' => []
                            ])->dropDownList( $listUsers, ['prompt' => 'Assign the ticket to', 'class'=>'dev divider',
                                'style'=>'width: 100%;height: 40px; display: none;'] )->label(false);?>
                        </div>
                        <?php else: ?>
                        <div class="form-group">
                            <?php $developer = \app\models\User::find()->where(User::tableName() . ".is_delete=0 AND " . User::tableName() . ".is_active=1 AND " .
                                User::tableName() . ".role IN ('" . User::ROLE_PM . "', '" . User::ROLE_DEV . "', '" . User::ROLE_ADMIN . "')")->groupBy(User::tableName() . '.id ')->all();;
                            $listUsers = User::getCustomersDropDown( $developer, 'id' );
                            //$listDevelop = \yii\helpers\ArrayHelper::map( $listUsers, 'id', 'first_name' );

                            echo $form->field( $model, 'assignee', [

                                'options' => []
                            ])->dropDownList( $listUsers, ['prompt' => 'Assign the ticket to', 'class'=>'dev divider',
                                'style'=>'width: 100%;height: 40px;'] )->label(false);?>
                        </div>
                        <?php endif;?>
                    </div>
                    <div class="col-lg-12">
                        <?php if($model->status == \app\models\SupportTicket::STATUS_COMPLETED || $model->status == \app\models\SupportTicket::STATUS_CANCELLED):?>
                            <div class="btn-group" style="float: right; display: none;">
                                <?= Html::button( Yii::t('app', 'COMPLETE'), ['class' => 'btn btn-large btn-primary',
                                    'style' => ' margin-top: 10px; margin-right: 10px;']) ?>
                                <?= Html::button(Yii::t('app', 'CANCEL'), ['class' => 'btn btn-large btn-primary',
                                    'style' => ' margin-top: 10px;']) ?>
                            </div>
                        <?php else: ?>
                            <div class="btn-group" style="float: right;">
                                <?= Html::button( Yii::t('app', 'COMPLETE'), ['class' => 'btn btn-large btn-primary complete button',
                                    'style' => ' margin-top: 10px; margin-right: 10px;']) ?>
                                <?= Html::button(Yii::t('app', 'CANCEL'), ['class' => 'btn btn-large btn-primary off-button cancel',
                                    'style' => ' margin-top: 10px;']) ?>
                                </div>
                        <?php endif;?>
                    </div>
                <?php endif?>
                <div class="form-group">
                    <div id="butt">
                        <p>Status: <?= Html::encode($model->status)?></p>
                    </div>
                    <p>Description: <?= Html::encode($model->description)?></p>
                    <p>Posted: <?= Html::encode(DateUtil::convertDatetimeWithoutSecund($model->date_added))?></p>
                    <p>Resolved : <span class="resolved"><?= Html::encode(DateUtil::convertDatetimeWithoutSecund($model->date_completed))?></span></p>
                    <p>Cancelled: <span class="cancel"><?= Html::encode(DateUtil::convertDatetimeWithoutSecund($model->date_cancelled))?></span></p>

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
    var em = '#butt';
    $('.button').on('click', function() {
        $.ajax({
            type: "GET",
            url: 'complete',
            data: 'query=' + '&ticket=' +<?php echo $model->id?>,
            dataType: 'json',
            beforeSend: function(){
            },
            success: function(response) {
                $('#butt').text('Status: COMPLETED');
                var myDate = response.date;
               /* var date = new Date(response.date);
                var response = response.date;
                var day = date.getDate();
                if (day<10) {
                    day = "0"+day;
                }
                var month = date.getMonth()+1;
                if (month<10) {
                    month = "0"+ month;
                }
                var year = date.getFullYear();
                var dateArr = response.split(' ');
                var stringDate = [];
                stringDate.push(year, month, day);
                var time = dateArr[4];
                time = time.split(':');
                time.splice(2,1);
                time = time.join(':');
                var output = stringDate.join('-');*/
                //$('.resolved').append('<p>' +output+ ' ' + time +'</p>');
                $('.resolved').text(myDate);
                    return response;
                // }
            }

        });
    });
    $('.complete').bind('click', function(){
        $('.off-button').css('display', 'none');
        $('.complete').css('display', 'none');
        $('#butt').text('Status: COMPLETED');
        $('.dev').css('display', 'none');
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
                $('#butt').text('Status: CANCELLED');
                var myDate = response.date;
                $('.cancel').text(myDate);
                return response;
            }
        });
    });
    $('.cancel').bind('click', function(){
        $('.off-button').css('display', 'none');
        $('.complete').css('display', 'none');
        $('#butt').text('Status: CANCELLED');
        $('.dev').css('display', 'none');
    });
    $('.dev').on('change', function(){
        var id = $(this).val();
        console.log(id);
        $.ajax({
            type: "GET",
            url: 'develop',
            data: 'query=' + id + '&ticket=' + <?php echo $model->id?>,
            dataType: 'json',
            beforeSend: function(){
            },
            success: function(response) {
                $('#butt').text('Status: ASSIGNED');
                    return response;
            }
        });
    })

</script>