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
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/myprofile.js');
$this->registerCssFile(Yii::$app->request->baseUrl.'/css/my-profile.css');
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
        <?= Html::submitButton( Yii::t('app', 'Save'), (['class' => 'btn btn-primary submit-form','disabled' => 'disabled', 'form' => 'w0', 'style' => ' background: gray;'])) ?>
    </ul>
    <?php $form = ActiveForm::begin(); ?>
    <div class="tab-content">
        <div id="tab_1" class="tab-pane active col-xs-12">
            <div class="row">
                <div class="col-sm-6">
                    <div class="box box-inform">
                        <div class="box-body">
                            <span>Hello <?php echo $model->first_name?>
                                <?php if ( User::hasPermission([ User::ROLE_CLIENT])):?><br><?php endif?>
                                <?php if ( User::hasPermission([ User::ROLE_ADMIN, User::ROLE_PM, User::ROLE_FIN, User::ROLE_DEV])):?>
                                <?php echo Yii::$app->user->identity->role?> </span><br/>
                            <?php endif?>
                            <span>You are joined Skynix on <?php echo $model->date_signup?></span><br/>
                            <span>Last time you visited Skynix on <?php echo $model->date_login?></span><br/>
                            <?php if ( User::hasPermission([ User::ROLE_ADMIN, User::ROLE_PM, User::ROLE_FIN, User::ROLE_DEV])):?>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="box box-inform">
                        <div class="box-body">
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
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 change-span">
                    <span>If you need to change your password or change email <a href="#"> click here</a></span><br/>
                </div>
            </div>
            <div class="my-profile-form col-sm-12">
                <div class="row">
                    <fieldset class = "col-sm-6">
                        <?php /** @var $model User */?>
                        <?php echo $form->field( $model, 'first_name' )->textInput();?>
                        <?php echo $form->field( $model, 'last_name' )->textInput();?>
                        <?php echo $form->field( $model, 'phone' )->textInput();?>
                    </fieldset>
                    <fieldset class = "col-sm-6">
                        <?php echo $form->field( $model, 'email' )->textInput(['readonly'=> true]);?>
                        <?php if ( User::hasPermission([ User::ROLE_CLIENT])):?>
                            <?php echo $form->field( $model, 'company' )->textInput();?>
                        <?php endif?>
                        <?php echo $form->field( $model, 'tags' )->textInput()->label( 'Your primary skills' );?>
                        <?php echo $form->field( $model, 'about' )->textarea()->label('About Me');?>
                    </fieldset>
                </div>
            </div>
        </div>
        <?php echo $form->field($model, 'photo', ['options' => ['style' => 'display: none']])->textInput(['class' => 'photouser', 'style' => 'display: none'])->label(false)?>
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
                        '<div onclick="setAsDefaultPhoto(\'<?=basename($photo)?>\', \'photo\')" class="dz-preview dz-image-preview">' +
                        '<div class="dz-image">' +
                        '<img  data-dz-thumbnail="" width="120" height="120" alt="" src="/cp/index/getphoto?entry=<?=$photo?>" style="<?=$defaultPhoto!=basename($photo) ?: 'border: 3px solid blue'?>" />' +
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
                        '<div onclick="setAsDefaultSing(\'<?=basename($sing)?>\', \'sing\')" class="dz-preview dz-image-preview">' +
                        '<div class="dz-image">' +
                        '<img data-dz-thumbnail="" width="120" height="120" alt="" src="/cp/index/getphoto?entry=<?=$sing?>" style="<?=$defaultSing!=basename($sing) ?: 'border: 3px solid blue'?>" />' +
                        '</div>' +
                        '</div>';
                    <?php endforeach ?>
                    $('#previews1').html(html);
                    <?php endif; ?>
                    setAsDefaultPhoto = function(photo, request) {
                        console.log(photo);
                        $('.photouser').val(photo);
                    };
                    setAsDefaultSing = function(photo, request) {
                        console.log(photo);
                        $('.singuser').val(photo);
                    };
                    $('#tab_2 .dz-image img').click(function() {
                        setBorder(this, '#tab_2 img');
                    });
                    $('#tab_3 .dz-image img').click(function() {
                        setBorder(this, '#tab_3 img');
                    });

                    setBorder = function(element, selector) {
                        $(selector).css('border', "0");
                        $(element).css('border', '3px solid blue');
                    };
                });
            </script>
        </div>
        <?php echo $form->field($model, 'sing', ['options' => ['style' => 'display: none']])->textInput(['class' => 'singuser', 'style' => 'display: none'])->label(false);?>
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
                                    <?php $active = ($project->getProjectDevelopers()->one()->status) == (ProjectDeveloper::STATUS_ACTIVE)?>
                                    <td>
                                        <!--<a href='<?/*= Url::toRoute(['setting/suspend', 'id' => $project->id])*/?>'>-->
                                        <input class="<?=$active?'activate':'suspend'?>" type="checkbox"
                                            <?=$active ? 'checked' : '' ?> style="cursor: pointer"
                                               name="Project[<?=$project->id?>]" data-toggle="tooltip"
                                               data-placement="top" title="<?=Yii::t('app', $active
                                            ? 'Untick the checkbox to hide the project from your lists'
                                            : 'Tick the checkbox to start using the project for your reports')?>"
                                        />
                                    </td>
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
<script>
    $(function() {
        MyProfileModule.init();
    });
    var inputCheck = $('input[type=checkbox]');
    inputCheck.each(function(){
        var thisCheck = $(this);
        if(!thisCheck.prop('checked')){
            thisCheck.parent().parent('tr').css("color", "grey");
            /*console.log(thisCheck.parent().parent('tr'));*/
        }
        thisCheck.click(function(){
            var check = $(this);
            if(!check.prop('checked')){
                check.parent().parent('tr').css("color", "grey");
            }
            else{
                check.parent().parent('tr').css("background-color", "white");
            }
        })
    });
</script>
