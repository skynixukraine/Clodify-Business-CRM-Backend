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
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/modal.bootstrap.js');
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/ajaxReportPage.js');
$this->title                    = Yii::t("app", "My Report");
$this->params['breadcrumbs'][]  = $this->title;

$this->params['menu'] = [

];
?>
<?php $form = ActiveForm::begin([
                'options' => [
                                'class' => 'horizontal'
                                ]]);
/** @var $model Report */?>
    <?php echo $form->field( $model, 'dateFilter', [


            'options' => [
                           'style' => [
                                        'width'=>"170px"
                                      ]
                         ]
        ])->dropDownList( [
                            '1' => 'Today`s Reports',
                            '2' => 'This week reports',
                            '3' => 'This month reports',
                            '4' => 'Last month reports',
                        ], ['class'=>"form-control", 'id'=>'dateFilter', 'selected' => 1] )->label('Date filter :', [
        'style' => [
            'display' => 'none'
        ]
    ]);?>
    <?php if($model->dateFilter == 1):?>
        <label style="visibility: hidden"></label>
    <?php else:?>
        <label>Your reports from <?php echo $model->dateStartReport?> to <?php echo $model->dateEndReport?></label>
    <?php endif;?>

<?php ActiveForm::end();?>

<div class = "box">
    <div class = "box-body no-padding">
        <table class = "table load load-table">

            <?php $reports = Report::getReports(Yii::$app->user->id, $model->dateFilter);
            /** @var  $report Report */
            foreach($reports->each() as $report):?>
            <tbody>
            <tr>
                <td class = "report-id"><?= Html::encode($report->id)?></td>
                <td><?= Html::encode($report->getProject()->one()->name)?></td>
                <td><?= Html::encode($report->date_report)?></td>
                <td><?= Html::encode($report->task)?></td>
                <td class="hour"><?= Html::encode(round($report->hours, 2))?></td>
                <td>
                    <?php if($report->invoice_id == null):?>
                        <i class="fa fa-times delete" style="cursor: pointer" data-toggle="tooltip" data-placement="top" title="Delete"></i>
                    <?php endif;?>
                    <?php if($report->invoice_id != null):?>
                        <i class="fa fa-times delete" style="cursor: pointer" data-toggle="tooltip" data-placement="top" title="Delete"></i>
                    <?php endif;?>
                </td>
            </tr>
            </tbody>
            <?php endforeach;?>
        </table>
    </div>
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-6">
        </div>
        <div class="col-lg-6 text-right">
            <label id="totalHours" class = "text-right col-xs-12"></label>
        </div>
    </div>

</div>

<?php $form = ActiveForm::begin();
/** @var $model Report */?>

    <div class="container-fluid">
        <div class="row form-add-report">
            <div class="col-xs-3 col-sm-2 " ">

                <?php $projects = \app\models\Project::getUsersProjects( Yii::$app->user->id );
                $listReport = \yii\helpers\ArrayHelper::map( $projects, 'id', 'name' );
                echo $form->field( $model, 'project_id', [

                        'options' => [

                    ]
                ])->dropDownList( $listReport, ['prompt' => 'Choose...'] )->label('Project');?>
            </div>

            <div class="col-xs-3 col-md-2" >
                    <?php echo $form->field( $model, 'date_report', [

                        'template' => '{label} ' .
                            ' <div class="input-group date">{input}' .
                            ' <span class="input-group-addon"><i class="fa fa-calendar"></i></span></div> ' .
                            ' {error}'

                    ])->textInput( ['class'=>'form-control pull-right active',
                                    'type'=>'text', 'id'=>"date_report"]);?>
            </div>

            <div class="col-xs-5  col-sm-6 col-md-7 field-task">
                <?php echo $form->field( $model, 'task', [

                        'options' => []

                ])->textInput([
                    /*'pattern' => '^(\S+\s{0,1})+$',*/ /*'maxlength'=>'500', 'size' => '500'*/
                ])->label( 'Text field with task description' );?>
            </div>

            <div class="col-xs-1 " >
                <?php echo $form->field( $model, 'hours', [

                        'options' => []

                ])->textInput();?>
            </div>
            
        </div>
    </div>
<?php ActiveForm::end();?>
<script>
    $(function(){

        ajaxReportPageModule.init({
            deleteUrl:  '<?=Url::toRoute(['index/delete'])?>',
            saveUrl:    '<?=Url::to(['index/save'])?>',
            indexUrl:   '<?=Url::to(['index/index'])?>'
        });

})
</script> 