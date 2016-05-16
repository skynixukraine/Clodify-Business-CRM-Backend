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
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/jquery.dataTables.min.js');
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/dataTables.bootstrap.min.js');
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/jquery.slimscroll.min.js');
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/modal.bootstrap.js');
$this->title                    = Yii::t("app", "My Profile");
$this->params['breadcrumbs'][]  = $this->title;

$this->params['menu'] = [

];
?>
<div class="nav-tabs-custom">
<ul class="nav nav-tabs">
    <li class="active"><a href="#tab_1" data-toggle="tab">General</a></li>
    <li><a href="#tab_2" data-toggle="tab">Sign</a></li>
    <li><a href="#tab_3" data-toggle="tab">Tab 3</a></li>
    <li class="pull-right"><a href="#" class="text-muted"><i class="fa fa-gear"></i></a></li>
    </ul>
<div class="tab-content">
        <div id="tab_1" class="tab-pane">
            <span>Hello <?php echo $model->first_name?> <?php echo Yii::$app->user->identity->role?> </span>.<br/>
            <span>You are joined Skynix at <?php echo $model->date_signup?></span>.<br/>
            <span>Last time you visited Skynix at <?php echo $model->date_login?></span>.<br/>
            <span>Today you have reported <?php echo $hoursReportThisDay = Report::sumHoursReportsOfThisDay(Yii::$app->user->id, date('Y-m-d')) ?> hours</span><br/>
            <span>This week you have reported <?php ?> hours</span><br/>
            <span>This month you have reported <?php ?> hours</span><br/>
            <span>If you need to change your password or change email <a href="#"> click here</a></span><br/>

            <?php $form = ActiveForm::begin();?>

                            <?php /** @var $model User */?>
                            <?php echo $form->field( $model, 'first_name' )->textInput();?>
                            <?php echo $form->field( $model, 'last_name' )->textInput();?>
                            <?php echo $form->field( $model, 'phone' )->textInput();?>
                            <?php echo $form->field( $model, 'email' )->textInput(['readonly'=> true]);?>
                            <?php if ( User::hasPermission([ User::ROLE_CLIENT])):?>
                                <?php echo $form->field( $model, 'company' )->textInput();?>
                            <?php endif?>
                            

                            <?= Html::submitButton( Yii::t('app', 'Save'), ['class' => 'btn btn-primary']) ?>


        </div>

    <div id="tab_2" class="tab-pane">
        <?php ActiveForm::end();?>

        <?php if(User::hasPermission([User::ROLE_ADMIN, User::ROLE_DEV])):?>
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
        <?php endif;?>
        </div>
    </div>
</div>