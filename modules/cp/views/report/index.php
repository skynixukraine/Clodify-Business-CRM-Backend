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
            <?php echo Html::label('Report:');
            $projects = Project::find()->all();
            $listReport = ArrayHelper::map( $projects, 'id', 'name' );
            $listReport = ArrayHelper::merge(['' => 'allprojects'], $listReport);
            echo Html::dropDownList('project', null, $listReport, ['class'=>"form-control"]) ?>
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

<table id="report-table" class="table table-hover">
    <thead>
    <tr>
        <th class="id-col"><?=Yii::t('app', 'Report ID')?></th>
        <th><?=Yii::t('app', 'Task')?></th>
        <th class="date-col"><?=Yii::t('app', 'Date added')?></th>
        <th><?=Yii::t('app', 'Project')?></th>
        <th><?=Yii::t('app', 'Reporter name')?></th>
        <th class="date-col"><?=Yii::t('app', 'Date report')?></th>
        <th><?=Yii::t('app', 'Is invoiced')?></th>
        <!--th><//?=Yii::t('app', 'Actions')?></th-->
    </tr>
    </thead>
</table>

<script>

    $(function(){

        adminReportModule.init({
            editUrl     : '<?=Url::to(['report/index'])?>',
            deleteUrl   : '<?=Url::to(['report/index'])?>',
            findUrl     : '<?=Url::to(['report/find'])?>',
            canDelete   : <?=( User::hasPermission([User::ROLE_ADMIN]) ? 'true' : 'false')?>
        })
    });

</script>