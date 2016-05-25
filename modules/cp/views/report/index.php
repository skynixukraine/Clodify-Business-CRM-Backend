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
             if ( User::hasPermission([User::ROLE_ADMIN, User::ROLE_FIN])) {
                 $projects = Project::find()->all();
                 $listReport = ArrayHelper::map( $projects, 'id', 'name' );
                 $listReport = ArrayHelper::merge(['' => 'allprojects'], $listReport);
             }

            if ( User::hasPermission([User::ROLE_PM])){
                 $projects = Project::ProjectsCurrentUser(Yii::$app->user->id);
                 $listReport = ArrayHelper::map( $projects, 'id', 'name' );
                 $listReport = ArrayHelper::merge(['' => 'ownprojects'], $listReport);
             }
            if (User::hasPermission([User::ROLE_CLIENT])){
                $projects = Project::ProjectsCurrentClient(Yii::$app->user->id);
                $listReport = ArrayHelper::map( $projects, 'id', 'name' );
                $listReport = ArrayHelper::merge(['' => 'ownprojects'], $listReport);
            }

            echo Html::dropDownList('project', null, $listReport, ['class'=>"form-control"]) ?>
        </div>
        <div class="col-lg-2">
            <?php echo Html::label('Users:');
            $users = User::find()->where('role IN ( "' .  User::ROLE_ADMIN . '" , "' .  User::ROLE_PM . '", "'  .  User::ROLE_DEV . '") AND is_delete=0 AND is_active=1')->groupBy(User::tableName() . '.id ')->all();
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

    <table id="report-table" class="table table-hover box ">
        <thead>
            <tr>
                <th class="id-col"><?=Yii::t('app', 'Report ID')?></th>
                <th><?=Yii::t('app', 'Task')?></th>
                <?php if ( User::hasPermission([User::ROLE_ADMIN])):?>
                    <th id="role"><?=Yii::t('app', 'Hours')?></th>
                <?php endif;?>
                <th><?=Yii::t('app', 'Project')?></th>
                <th class="date-col"><?=Yii::t('app', 'Date added')?></th>
                <th><?=Yii::t('app', 'Reporter name')?></th>
                <th class="date-col"><?=Yii::t('app', 'Date report')?></th>
                <?php if ( User::hasPermission([User::ROLE_ADMIN, User::ROLE_CLIENT, User::ROLE_FIN])):?>
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
            canDelete   : <?=( User::hasPermission([User::ROLE_ADMIN]) ? 'true' : 'false')?>,
            canSeeHours: <?=( User::hasPermission([User::ROLE_ADMIN]) ? 'true' : 'false')?>,
            canSeeInvoice : <?=( User::hasPermission([User::ROLE_ADMIN, User::ROLE_CLIENT, User::ROLE_FIN]) ? 'true' : 'false')?>
        })
    });

</script>