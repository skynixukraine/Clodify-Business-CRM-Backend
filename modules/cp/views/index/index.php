<?php
/**
 * Created by WebAIS.
 * User: Wolf
 * Date: 02.10.2015
 * Time: 11:25
 */
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use app\models\Report;
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/jquery.dataTables.min.js');
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/dataTables.bootstrap.min.js');
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/jquery.slimscroll.min.js');
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/report.js');
$this->title                    = Yii::t("app", "My Report");
$this->params['breadcrumbs'][]  = $this->title;

$this->params['menu'] = [

];
?>

<div class = "box">
    <div class = "box-body no-padding">
        <table class = "table">
            <?php $reports = Report::getToDaysReports(Yii::$app->user->id);
            /** @var  $report Report */
            foreach($reports as $report):?>
            <tbody>
            <tr>
                <td><?= Html::encode($report->id)?></td>
                <td><?= Html::encode($report->getProject()->one()->name)?></td>
                <td><?= Html::encode($report->task)?></td>
                <td class="hour"><?= Html::encode($report->hours)?></td>
                <td>
                    <a href="<?=Url::toRoute(['index/delete', 'id' => $report->id])?>"><i class="fa fa-times delete" style="cursor: pointer"></i></a>
                    <!--a href="<?=Url::to(['index/save'])?>"><i class="fa fa-edit edit" style="cursor: pointer"></i></a-->
                    <i class="fa fa-edit edit" style="cursor: pointer"></i>
                </td>
            </tr>
            </tbody>
            <?php endforeach;?>
        </table>
    </div>
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-8">
        </div>
        <div class="col-lg-4">
            <label id="totalHours"></label>
        </div>
    </div>

</div>

<h4 class = "box-title" style="text-align: center">NEW REPORT</h4>

<?php $form = ActiveForm::begin();?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-2">

                <?php $projects = \app\models\Project::getDeveloperProjects( Yii::$app->user->id );
                $listReport = \yii\helpers\ArrayHelper::map( $projects, 'id', 'name' );
                echo $form->field( $model, 'project_id', [

                        'options' => [

                    ]
                ])->dropDownList( $listReport, ['prompt' => 'Choose...'] )->label('Project');?>
            </div>

            <div class="col-lg-7">
                <?php echo $form->field( $model, 'task', [

                        'options' => [

                    ]
                ])->textInput()->label( 'Text field with task description' );?>
            </div>

            <div class="col-lg-1">
                <?php echo $form->field( $model, 'hours', [

                        'options' => [

                        ]
                ])->textInput();?>
            </div>
            <div class="col-lg-1" style="top: 24px">
                    <button type = "submit" class = "btn btn-primary"><?= Yii::t('app', 'Submit')?></button>
            </div>
        </div>
    </div>
<?php ActiveForm::end();?>
<script>
    $(function(){reportModule.init()})
</script>


