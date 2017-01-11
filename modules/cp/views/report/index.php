<?php
/**
 * Created by PhpStorm.
 * User: olha
 * Date: 09.02.16
 * Time: 16:31
 */
use yii\helpers\Url;
use yii\helpers\Html;
use app\models\User;
use app\models\Project;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use app\components\DateUtil;
use app\models\ProjectDeveloper;
use app\models\ProjectCustomer;

$this->registerJsFile(Yii::$app->request->baseUrl.'/js/jquery.dataTables.min.js');
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/dataTables.bootstrap.min.js');
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/admin-reports.js');
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/modal.bootstrap.js');
$this->title                    = Yii::t("app", "Reports");
$this->params['breadcrumbs'][]  = $this->title;

$this->params['menu'] = [

];
?>

<?php $form = ActiveForm::begin();?>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-2">
            <?php echo Html::label('Projects:');
             if (User::hasPermission([User::ROLE_ADMIN, User::ROLE_FIN])) {
                 $projects = Project::find()
                     ->where('is_delete=0')
                     ->all();
             } else if (User::hasPermission([User::ROLE_SALES])) {
                 $projects = Project::find()
                     ->leftJoin(  ProjectDeveloper::tableName(), ProjectDeveloper::tableName() . ".project_id=" . Project::tableName() . ".id")
                     ->where([ProjectDeveloper::tableName() . '.user_id' => Yii::$app->user->id])
                     ->andWhere(Project::tableName() . '.is_delete=0')
                     ->andWhere(ProjectDeveloper::tableName() . '.is_sales=1')
                     ->all();
             } else if (User::hasPermission([User::ROLE_CLIENT])) {
                 $projects = Project::find()
                     ->leftJoin(ProjectCustomer::tableName(), ProjectCustomer::tableName() . '.project_id=' . Project::tableName() . '.id')
                     ->where([ProjectCustomer::tableName() . '.user_id' => Yii::$app->user->id])
                     ->andWhere(Project::tableName() . '.is_delete=0')
                     ->all();
             }
                 $listReport = ArrayHelper::map( $projects, 'id', 'name' );

                 $listReport = ArrayHelper::merge(['' => 'allprojects'], $listReport);




            echo Html::dropDownList('project', null, $listReport, ['class'=>"form-control"]) ?>
        </div>
        <div class="col-lg-2">
            <?php echo Html::label('Users:');
            $users = User::find()
                ->where('role IN ( "' .  User::ROLE_ADMIN . '" , "' .  User::ROLE_PM . '", "'  .  User::ROLE_DEV . '")
             AND is_delete=0 AND is_active=1')->groupBy(User::tableName() . '.id ')->all();
            if (User::hasPermission([User::ROLE_SALES])) {
                $projectIDs = [];
                foreach ($projects as $project) {
                    $projectIDs[] = $project->id;
                }
                $users = User::find()
                    ->where('role IN ( "' .  User::ROLE_ADMIN . '" , "' .  User::ROLE_PM . '", "'  .  User::ROLE_DEV . '")
             AND is_delete=0 AND is_active=1')
                    ->leftJoin(ProjectDeveloper::tableName(), ProjectDeveloper::tableName() . '.user_id=' . User::tableName() . '.id')
                    ->where([ProjectDeveloper::tableName() . '.project_id' => $projectIDs])
                    ->groupBy(User::tableName() . '.id ')
                    ->all();
            }
            $listUsers = User::getCustomersDropDown( $users, 'id' );
            $listUsers = ArrayHelper::merge(['' => 'allusers'], $listUsers);
            echo Html::dropDownList('users', null, $listUsers, ['class'=>"form-control"])
            ?>
        </div>
        <div class="col-lg-2">
            <?php echo Html::label('From date:');?>
            <div class="input-group date">
                <?php echo Html::textInput( 'date', null, ['id'=>"project-date_start", 'class'=>"form-control pull-right active"])?>
               <span class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                </span>
            </div>
        </div>
        <div class="col-lg-2">
            <?php echo Html::label('To date:');?>
            <div class="input-group date">
                <?php echo Html::textInput( 'date', null, ['id'=>"project-date_end", 'class'=>"form-control pull-right active"])?>
                <span class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                </span>
            </div>
        </div>
    </div>
</div>
<?php ActiveForm::end();?>

<div style="margin-bottom: -35px; margin-top: 16px; margin-left: 16px;">
<!--    --><?//= Html::a('Download PDF', ['report/download?id=']) ?>
    Total Hours: <span id="hours" style="font-weight: bold;"></span> hours,
    Total Cost: <span id="cost" style="font-weight: bold;"></span>
</div>
    <table id="report-table" class="table table-hover box ">
        <thead>
            <tr>
                <th class="id-col"><?=Yii::t('app', 'Report ID')?></th>
                <th><?=Yii::t('app', 'Task')?></th>
                <th id="role"><?=Yii::t('app', 'Hours')?></th>
                <th id="role"><?=Yii::t('app', 'Cost')?></th>
                <th><?=Yii::t('app', 'Project')?></th>
                <th><?=Yii::t('app', 'Reporter')?></th>
                <th class="date-col"><?=Yii::t('app', 'Added')?></th>
                <th class="date-col"><?=Yii::t('app', 'Reported')?></th>
                <?php if ( User::hasPermission([User::ROLE_ADMIN, User::ROLE_CLIENT, User::ROLE_FIN, User::ROLE_SALES])):?>
                    <th><?=Yii::t('app', 'Is invoiced')?></th>
                <?php endif;?>
            </tr>
        </thead>
    </table>
<?php
//\app\models\Team::findOne('team_leader_id');
/*$a = \app\models\Report::reportsPM();
$reports = [];
foreach($a as $b){
    $reports[] = $b->user_id;
}
var_dump($reports);
exit();*/
?>
<script>

    $(function(){

        adminReportModule.init({
            editUrl     : '<?=Url::to(['report/index'])?>',
            deleteUrl   : '<?=Url::to(['report/index'])?>',
            findUrl     : '<?=Url::to(['report/find'])?>',
            invoiceUrl  : '<?=Url::to(['invoice/view?id='])?>',
            canDelete   : <?=( User::hasPermission([User::ROLE_ADMIN]) ? 'true' : 'false')?>,
        })
    });


</script>