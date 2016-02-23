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
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/jquery.dataTables.min.js');
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/dataTables.bootstrap.min.js');
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/jquery.slimscroll.min.js');
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/modal.bootstrap.js');
$this->title                    = Yii::t("app", "Settings");
$this->params['breadcrumbs'][]  = $this->title;

$this->params['menu'] = [

];
?>

<ul>
    <?php  $currentUser = User::find()->where('id=:ID', [':ID' => Yii::$app->user->id])->one();
    //var_dump($currentUser);
   // exit();
    /** @var $currentUser \app\models\User */?>
    <li>First Name: <?php echo $currentUser->first_name?></li>
    <li>Last Name: <?php echo $currentUser->last_name?></li>
    <li>Email: <?php echo $currentUser->email?></li>
</ul>

<?php if(User::hasPermission([User::ROLE_ADMIN, User::ROLE_DEV])):?>
<div class="box-body">
    <table class="table">
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
