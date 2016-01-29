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
$this->title                    = Yii::t("app", "My Report");
$this->params['breadcrumbs'][]  = $this->title;

$this->params['menu'] = [

];
?>

<?php $i = 1;?>
<div class = "box">
    <div class = "box-header">
        <h3 class = "box-title">Reports of this day</h3>
    </div>
    <!-- /.box-header -->
    <div class = "box-body no-padding">
    <table class = "table">
        <thead>
        <tr>
            <th style = "width: 30px">#</th>
            <th><?= Yii::t('app', 'Project name')?></th>
            <th><?= Yii::t('app', 'Task')?></th>
            <th><?= Yii::t('app', 'Hours')?></th>
            <th></th>

        </tr>
        </thead>
        <?php $reports = Report::getToDaysReports(Yii::$app->user->id);
        /** @var  $report Report */
        foreach($reports as $report):?>
        <tbody>
        <tr>
            <td><?= Html::encode($i++)?></td>
            <td><?= Html::encode($report->getProject()->one()->name)?></td>
            <td><?= Html::encode($report->task)?></td>
            <td><?= Html::encode($report->hours)?></td>
            <td>
                <?= Yii::t('app', 'Edit')?>
                <?= Yii::t('app', 'Delete')?>

            </td>

        </tr>
        </tbody>
        <?php endforeach;?>
    </table>
        <!-- /.box-body -->
    </div>
</div>

<h4 class = "box-title">Add new report</h4>

<?php $form = ActiveForm::begin();?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-2">

                <?php $projects = \app\models\Project::getDeveloperProjects( Yii::$app->user->id );
                //var_dump($projects);
                $listReport = \yii\helpers\ArrayHelper::map( $projects, 'id', 'name' );
                echo $form->field( $model, 'project_id', [

                        'options' => [

                    ]
                ])->dropDownList( $listReport, ['prompt' => 'Choose...'] );?>
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

            <div class="col-lg-2">
                <button type = "submit" class = "btn btn-primary"><?= Yii::t('app', 'Submit')?></button>
            </div>
        </div>
    </div>
<?php ActiveForm::end();?>