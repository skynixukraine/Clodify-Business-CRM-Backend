<?php
/**
 * Created by PhpStorm.
 * User: olha
 * Date: 22.02.16
 * Time: 16:23
 */
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use app\models\User;
use app\models\Project;
use app\models\ProjectDeveloper;
use app\models\Report;
use app\components\DateUtil;
use kato\DropZone;
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/jquery.dataTables.min.js');
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/dataTables.bootstrap.min.js');
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/jquery.slimscroll.min.js');
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/modal.bootstrap.js');
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/dropzone.js');
$this->title                    = Yii::t("app", "My Profile");
$this->params['breadcrumbs'][]  = $this->title;

$this->params['menu'] = [

];
?>
<div class="nav-tabs-custom">
<ul class="nav nav-tabs">
    <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true">General</a></li>
    <li><a href="#tab_2" data-toggle="tab">Photo</a></li>
    <li><a href="#tab_3" data-toggle="tab">Sing</a></li>
    <li><a href="#tab_4" data-toggle="tab">Projects</a></li>
</ul>
    <?php $form = ActiveForm::begin();?>
<div class="tab-content">
        <div id="tab_1" class="tab-pane active">
            <span>Hello <?php echo $model->first_name?>.
                <?php if ( User::hasPermission([ User::ROLE_ADMIN, User::ROLE_PM, User::ROLE_FIN, User::ROLE_DEV])):?>
                    <?php echo Yii::$app->user->identity->role?> </span>.<br/>
                <?php endif?>
            <span>You are joined Skynix at <?php echo $model->date_signup?></span>.<br/>
            <span>Last time you visited Skynix at <?php echo $model->date_login?></span>.<br/>
            <?php if ( User::hasPermission([ User::ROLE_ADMIN, User::ROLE_PM, User::ROLE_FIN, User::ROLE_DEV])):?>
                <span>Today you have reported

                    <?php $hoursReportThisDay = Report::sumHoursReportsOfThisDay(Yii::$app->user->id, date('Y-m-d'));
                        if($hoursReportThisDay == null) {
                            echo '0';
                        }else {
                            echo $hoursReportThisDay;
                        }?> hours
                </span><br/>

                <span>This week you have reported

                    <?php $hoursReportThisWeek = Report::getReportHours(Yii::$app->user->id, date('Y-m-d') );
                        if($hoursReportThisWeek == null) {
                            echo '0';
                        }else {
                            echo $hoursReportThisWeek;
                        }?> hours
                </span><br/>
                <span>This month you have reported
                    <?php $hoursReportThisMonth = Report::getReportHoursMonth(Yii::$app->user->id, date('Y-m-d'));
                        if($hoursReportThisMonth == null) {
                            echo '0';
                        }else {
                            echo $hoursReportThisMonth;
                        }?> hours
                </span><br/>
            <?php endif?>
            <span>If you need to change your password or change email <a href="#"> click here</a></span><br/>

                            <?php /** @var $model User */?>
                            <?php echo $form->field( $model, 'first_name' )->textInput();?>
                            <?php echo $form->field( $model, 'last_name' )->textInput();?>
                            <?php echo $form->field( $model, 'phone' )->textInput();?>
                            <?php echo $form->field( $model, 'email' )->textInput(['readonly'=> true]);?>
                            <?php if ( User::hasPermission([ User::ROLE_CLIENT])):?>
                                <?php echo $form->field( $model, 'company' )->textInput();?>
                            <?php endif?>
                                 <?php echo $form->field( $model, 'tags' )->textInput()->label( 'Your primary skills' );?>
                                <?php echo $form->field( $model, 'about' )->textarea()->label('About Me');?>

                            <?= Html::submitButton( Yii::t('app', 'Save'), ['class' => 'btn btn-primary']) ?>


        </div>
    <div id="tab_2" class="tab-pane">
        <?php
            echo \kato\DropZone::widget([
                'options' => [
                    'url'   =>'upload',
                    'maxFilesize' => '5',
                    'acceptedFiles' => 'image/jpg, image/jpeg, image/png, image/gif',
                ],
                'clientEvents' => [
                    'complete' => "function(file){
                        $(file.previewElement).on('click', function(){
                            var img = $(file.previewElement);
                            setAsDefault(file.name);
                            $(img).css('border', '3px solid blue');
                        })
                    }",
                    'removedfile' => "function(file){alert(file.name + ' is removed')}"
                ],
            ]);
        ?>

        <script type="text/javascript">
            $(document).ready(function (){
                var html = '';
                <?php $photos = []; ?>
                <?php if (is_dir(Yii::getAlias("@app") . "/data/" . Yii::$app->user->id . "/photo")): ?>
                    <?php foreach (\yii\helpers\FileHelper::findFiles( Yii::getAlias("@app") . "/data/" . Yii::$app->user->id . '/photo/') as $photo): ?>
                            html +=
                                '<div onclick="setAsDefault(\'<?=basename($photo)?>\', \'photo\')" class="dz-preview dz-image-preview">' +
                                    '<div class="dz-image">' +
                                        '<img data-dz-thumbnail="" width="120" height="120" alt="" src="/cp/index/getphoto?entry=<?=$photo?>" style="<?=$defaultPhoto!=basename($photo) ?: 'border: 3px solid blue'?>" />' +
                                    '</div>' +
                                '</div>';
                    <?php endforeach ?>
                $('#previews').html(html);
                <?php endif; ?>
                <?php $sings = []; ?>
                html = '';
                <?php if (is_dir(Yii::getAlias("@app") . "/data/" . Yii::$app->user->id . "/sing")): ?>
                    <?php foreach (\yii\helpers\FileHelper::findFiles( Yii::getAlias("@app") . "/data/" . Yii::$app->user->id . '/sing/') as $sing): ?>
                            html +=
                                '<div onclick="setAsDefault(\'<?=basename($sing)?>\', \'sing\')" class="dz-preview dz-image-preview">' +
                                    '<div class="dz-image">' +
                                        '<img data-dz-thumbnail="" width="120" height="120" alt="" src="/cp/index/getphoto?entry=<?=$sing?>" style="<?=$defaultSing!=basename($sing) ?: 'border: 3px solid blue'?>" />' +
                                    '</div>' +
                                '</div>';
                    <?php endforeach ?>
                $('#previews1').html(html);
                <?php endif; ?>

                setAsDefault = function(photo, request) {
                    var params = {
                        url: '<?=Yii::$app->getUrlManager()->getBaseUrl() ?>' + request,
                        data: {
                            photo: photo,
                            sing: photo
                        },
                        method: 'POST',
                        dataType: 'json',
                        success: function (response) {
                            if (response.success) {
                               /* alert('Now its your default photo')*/;
                            } else {
                                alert('Error! ' + response.error)
                            }
                        }
                    };
                    $.ajax(params);
                };
                $('#tab_2 img').click(function() {

                    setBorder(this, '#tab_2 img');

                });

                $('#tab_3 img').click(function() {

                    setBorder(this, '#tab_3 img');

                });

                setBorder = function(element, selector) {
                    $(selector).css('border', "0");
                    $(element).css('border', '3px solid blue');
                };
            });
        </script>
        <?php  if($photoUser = User::getUserPhoto()){
            echo $photoUser;
        };?>

        </div>
        <div id="tab_3" class="tab-pane" >

            <?php
            echo \app\models\Dropzone::widget([
                'options' => [
                    'url'   =>'uploaded',
                    'maxFilesize' => '2',
                    'acceptedFiles' => 'image/jpg, image/jpeg, image/png, image/gif',
                ],
                'clientEvents' => [
                    'complete' => "function(file){
                    $(file.previewElement).on('click', function(){
                            setAsDefault(file.name);
                        })
                    }",
                    'removedfile' => "function(file){alert(file.name + ' is removed')}"
                ],
            ]);
            ?>


        </div>
    <div id="tab_4" class="tab-pane">
        <?php if(User::hasPermission([User::ROLE_ADMIN, User::ROLE_DEV])):?>
            <div class="box-header with-border">
            <div class="box-body">
                <table class="table box">
                    <thead>
                    <tr>
                        <th><?=Yii::t('app', 'Customer')?></th>
                        <th><?=Yii::t('app', 'Project Name')?></th>
                        <th><?=Yii::t('app', 'Status')?></th>
                        <th><?=Yii::t('app', 'Actions')?></th>
                    </tr>
                    </thead>
                    <?php $projects = Project::ProjectsCurrentUser(Yii::$app->user->id);
                    foreach($projects as $project):?>
                        <tbody>
                        <tr>
                            <?php /** @var $project Project */?>
                            <td><?= Html::encode($project->getCustomers()->one()->first_name  . $project->getCustomers()->one()->last_name)?></td>
                            <td><?= Html::encode($project->name)?></td>
                            <td><?= Html::encode($project->getProjectDevelopers()->one()->status)?></td>
                            <?php if(($project->getProjectDevelopers()->one()->status) == (ProjectDeveloper::STATUS_ACTIVE)):?>

                                <td>
                                    <a href='<?= Url::toRoute(['setting/suspend', 'id' => $project->id])?>'>
                                        <i class="fa fa-clock-o suspend" style="cursor: pointer"
                                           data-toggle="tooltip" data-placement="top" title="Suspend"></i>
                                    </a>
                                </td>
                            <?php endif;?>
                            <?php if(($project->getProjectDevelopers()->one()->status) == (ProjectDeveloper::STATUS_INACTIVE)):?>

                                <td>
                                    <a href='<?= Url::toRoute(['setting/activate', 'id' => $project->id])?>'>
                                        <i class="fa fa-check-square-o activate" style="cursor: pointer"
                                           data-toggle="tooltip" data-placement="top" title="Activate"></i>
                                    </a>
                                </td>
                            <?php endif;?>
                        </tr>
                        </tbody>
                    <?php endforeach;?>
                </table>
            </div>
        </div>
        <?php endif;?>
    </div>
    <?php ActiveForm::end();?>
    </div>
</div>
<!--<script>
    $(function() {
        var myDropzone = new Dropzone("#my-dropzone");
        myDropzone.on("click", function(file) {

        });
    });
</script>-->
