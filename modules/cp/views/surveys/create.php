<?php
/**
 * Created by PhpStorm.
 * User: lera
 * Date: 07.05.16
 * Time: 14:13
 */
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets;
use app\models\Surveys;
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/jquery.dataTables.min.js');
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/dataTables.bootstrap.min.js');
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/jquery.slimscroll.min.js');
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/survey_options.js');
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/jquery.js');
$this->registerCssFile(Yii::$app->request->baseUrl.'/css/bootstrap-datetimepicker.css');
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/jquery.datetimepicker.js');
$this->title                    = Yii::t("app", $title );
$this->params['breadcrumbs'][]  = $this->title;

$this->params['menu'] = [
    [
        'label' => Yii::t('app', 'Take a Survey'),
        'url'   => Url::to(['surveys/index'])
    ]
];
?>
<?php $form = ActiveForm::begin([
    'options' => [
        'class' => 'horizontal'
    ]
]);?>
<div class="row">
    <div class="col-md-6 box box-primary box-body">
        <div class="form-group">
            <?php echo $form->field( $model, 'shortcode', [

                'options' => [

                ]
            ])->textInput(["class" => "form-control", "autocomplete"=>"off"])->label( 'Shortcode' );?>
        </div>
        <div class="form-group">
            <?php echo $form->field( $model, 'question', [

                'options' => [

                ]
            ])->textInput(["class" => "form-control"])->label( 'Question' );?>
        </div>

        <div class="form-group">
            <?php echo $form->field( $model, 'date_start', [

                'template' => '{label} ' .
                    ' <div class="input-group date" id="date">' .
                    '<input type="button" class="form-control">' .
                    ' <span class="input-group-addon"> ' .
                    ' <span class="glyphicon glyphicon-calendar"></div>' .
                    ' {error}'

            ]);?>
          <!--  <div class='col-sm-6'>
                <div class="form-group">
                    <div class='input-group date' id='datetimepicker1'>
                        <input type='text' class="form-control" title=""/>
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                    </div>
                </div>
            </div>
        </div>-->
        <div class="form-group">
            <?php echo $form->field( $model, 'date_end', [

                'template' => '{label} ' .
                    ' <div class="input-group date">{input}' .
                    ' <span class="input-group-addon"><i class="fa fa-calendar"></i></span> </div> ' .
                    ' {error}'

            ])->textInput( ['class'=>'form-control pull-right active',
                'type'=>'text']);?>
        </div>
        <div class="form-group">
            <?php echo $form->field( $model, 'is_private', [

                'options' => [

                ]
            ])->checkbox();?>
        </div>
        <div class="form-group">
        <?php echo $form->field( $model, 'description', [

            'options' => [

            ]
        ])->textarea()->label( 'Description' );?>
        </div>
        <h4>Survey Options : </h4>
        <div class="form-group">
            <?php echo $form->field( $model, 'name', [

                'options' => [

                ]
            ])->textInput(["class" => "form-control"])->label( 'Name' );?>
        </div>
        <div>
        <?php echo $form->field( $model, 'descriptions', [

            'options' => [

            ]
        ])->textarea()->label( 'Description' );?>
        </div>
        <div class="input-group-addon">
            <span><i class="fa fa-plus"></i></span>
        </div>
            <div class="col-md-12">
                <?= Html::submitButton( Yii::t('app', 'Save'), ['class' => 'btn btn-primary', 'style' => 'float: right; margin-top: 10px;' ]) ?>
            </div>
        </div>
</div>
<?php ActiveForm::end();?>

<script>
    /*$(function () {
        $('#datetimepicker1').datetimepicker();
    });*/
    $(function () {
        $('#date').datetimepicker({
            format:'d.m.Y H:i'
        });
    });
</script>

