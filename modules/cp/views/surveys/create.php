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
use kartik\datetime\DateTimePicker;
use wbraganca\dynamicform\DynamicFormWidget;
use app\models\Surveys;
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/jquery.dataTables.min.js');
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/dataTables.bootstrap.min.js');
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/jquery.slimscroll.min.js');
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/jquery.datetimepicker.js');
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/survey_options.js');
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
        'class' => 'horizontal',
        'id'=>'dynamic-form'
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
<!--tttttttttttttttttttttttttttttttttttttttttttttttttt-->
       <!-- <div class="form-group">
            <?php /*echo $form->field( $model, 'date_start', [

                'template' => '{label} ' .
                    ' <div class="input-group date" id="date">' .
                    '<input type="button" class="form-control" id="date">' .
                    ' <span class="input-group-addon"> ' .
                    ' <span class="glyphicon glyphicon-calendar"></div>' .
                    ' {error}'

            ]);*/?>

        </div>-->
        <div class="form-group">
            <?php echo DateTimePicker::widget([
                    'name' => 'date_start',
                    'options' => ['placeholder' => 'Select operating time ...'],
                    'convertFormat' => true,
                    'pluginOptions' => [
                    'format' => 'dd-MM-YY H:i',
                    'startDate' => 'date_start',
                    'todayHighlight' => true
                    ]
                    ]);?>
         </div>
<!--llllllllllllllllllllllllllllllllllllllllllllllllllllllllllllll-->

       <!-- <div class="form-group">
            <?php /*echo $form->field( $model, 'date_end', [

                'template' => '{label} ' .
                    ' <div class="input-group date">{input}' .
                    ' <span class="input-group-addon"><i class="fa fa-calendar"></i></span> </div> ' .
                    ' {error}'

            ])->textInput( ['class'=>'form-control pull-right active',
                'type'=>'text']);*/?>
        </div>-->
        <div class="form-group">
            <?php echo DateTimePicker::widget([
                'name' => 'date_end',
                'options' => ['placeholder' => 'Select operating time ...'],
                'convertFormat' => true,
                'pluginOptions' => [
                    'format' => 'dd-MM-YY H:i',
                    'startDate' => 'date_end',
                    'todayHighlight' => true
                ]
            ]);?>
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

        <?php DynamicFormWidget::begin([
            'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
            'widgetBody' => '.container-items', // required: css class selector
            'widgetItem' => '.item', // required: css class
            'limit' => 4, // the maximum times, an element can be cloned (default 999)
            'min' => 1, // 0 or 1 (default 1)
            'insertButton' => '.add-item', // css class
            'deleteButton' => '.remove-item', // css class
            'model' => $survayOptions[0],
            'formId' => 'dynamic-form',
            'formFields' => [
                'name',
                'description',
            ],
        ]); ?>
        <div class="container-items"><!-- widgetContainer -->
            <?php foreach ($survayOptions as $i => $survayOption): ?>
                <div class="item panel panel-default"><!-- widgetBody -->
                    <div class="panel-heading">
                        <h3 class="panel-title pull-left">Address</h3>
                        <div class="pull-right">
                            <button type="button" class="add-item btn btn-success btn-xs"><i class="glyphicon glyphicon-plus"></i></button>
                            <button type="button" class="remove-item btn btn-danger btn-xs"><i class="glyphicon glyphicon-minus"></i></button>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-body">
                        <?php
                        // necessary for update action.
                        if (! $survayOption->isNewRecord) {
                            echo Html::activeHiddenInput($survayOption, "[{$i}]id");
                        }
                        ?>
                        <div class="row">
                            <div class="col-sm-6">
                                <?= $form->field($survayOption, "[{$i}]name")->textInput(['maxlength' => true]) ?>
                            </div>

                        </div><!-- .row -->
                        <div class="row">

                            <div class="col-sm-4">
                                <?= $form->field($survayOption, "[{$i}]description")->textarea(['maxlength' => true]) ?>
                            </div>
                        </div><!-- .row -->
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <?php DynamicFormWidget::end(); ?>

        <div class="push"></div>
          <!--  <div class="input-group-addon">
                <span><i class="fa fa-plus" style="cursor: pointer"></i></span>
            </div>-->

                <div class="col-md-12" id="add">
                    <?= Html::submitButton( Yii::t('app', 'Save'), ['class' => 'btn btn-primary', 'style' => 'float: right; margin-top: 10px;' ]) ?>
                </div>

    </div>


</div>
<?php ActiveForm::end();?>

