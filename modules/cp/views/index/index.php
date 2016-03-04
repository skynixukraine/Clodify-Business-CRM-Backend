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
use app\models\User;
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/jquery.dataTables.min.js');
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/dataTables.bootstrap.min.js');
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/jquery.slimscroll.min.js');
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/report.js');
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/modal.bootstrap.js');
$this->title                    = Yii::t("app", "My Report");
$this->params['breadcrumbs'][]  = $this->title;

$this->params['menu'] = [

];
?>
<?php $form = ActiveForm::begin(['options' => [
                                                'class' => 'horizontal'
                                            ]]);
/** @var $model Report */?>
    <?php echo $form->field( $model, 'dateFilter', [

            'options' => [

            ]
        ])->dropDownList( [
                            '1' => 'Today`s Reports',
                            '2' => 'This week reports',
                            '3' => 'This month reports',
                            '4' => 'Last month reports',
                        ], ['class'=>"form-control", 'id'=>'dateFilter', 'selected' => 1] )->label('Date filter :');?>


<?php ActiveForm::end();?>

<label>Reports</label>
<div class = "box">
    <div class = "box-body no-padding">
        <table class = "table load">
            <thead>
            <tr>
                <th>ID</th>
                <th>Project</th>
                <th>Task</th>
                <th>Hours</th>
                <th>Actions</th>
            </tr>
            </thead>
            <?php $reports = Report::getReports(Yii::$app->user->id, $model->dateFilter);
            /** @var  $report Report */

            foreach($reports->each() as $report):
                //var_dump($report);
                //exit();?>
            <tbody>
            <tr>
                <td><?= Html::encode($report->id)?></td>
                <td><?= Html::encode($report->getProject()->one()->name)?></td>
                <td  style="white-space: normal; word-break: break-all;"><?= Html::encode($report->task)?></td>
                <td class="hour"><?= Html::encode($report->hours)?></td>
                <td>
                    <?php if($report->invoice_id == null):?>
                    <i class="fa fa-edit edit" style="cursor: pointer" data-toggle="tooltip" data-placement="top" title="Edit"></i>
                    <?php endif;?>
                    <i class="fa fa-times delete" style="cursor: pointer" data-toggle="tooltip" data-placement="top" title="Delete"></i>
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

<?php $form = ActiveForm::begin();
/** @var $model Report */?>

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-2">

                <?php $projects = \app\models\Project::getDevOrAdminOrPmProjects( Yii::$app->user->id );
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

                <?php echo $form->field($model, 'total')
                    ->textInput(['style' => 'display: none',
                                 'id' => 'total'])
                    ->label(null,['style' => 'display: none']);?>
            </div>
            <div class="col-lg-1" style="top: 24px">
                    <button type = "submit" class = "btn btn-primary"><?= Yii::t('app', 'Submit')?></button>
            </div>
        </div>
    </div>
<?php ActiveForm::end();?>
<script>
    $(function(){
        reportModule.init({
            deleteUrl: '<?=Url::toRoute(['index/delete'])?>',
            saveUrl: '<?=Url::to(['index/save'])?>',
            indexUrl: '<?=Url::to(['index/index'])?>'
        })
    })
</script>


