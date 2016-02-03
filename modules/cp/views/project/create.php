<?php
/**
 * Created by PhpStorm.
 * User: olha
 * Date: 02.02.16
 * Time: 16:18
 */
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets;
use app\models\Project;
use app\models\User;
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/jquery.dataTables.min.js');
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/dataTables.bootstrap.min.js');
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/jQuery-2.1.4.min.js');
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/bootstrap-datepicker.js');
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/bootstrap.min.js');
$this->registerCssFile(Yii::$app->request->baseUrl.'/css/bootstrap.css');
$this->registerCssFile(Yii::$app->request->baseUrl.'/css/bootstrap.min.css');
$this->registerCssFile(Yii::$app->request->baseUrl.'/css/datepicker.css');
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/project.js');
$this->title                    = Yii::t("app", "Create Projects");
$this->params['breadcrumbs'][]  = $this->title;

$this->params['menu'] = [

];
?>

<?php $form = ActiveForm::begin();?>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-3">
            <?php echo $form->field( $model, 'name', [

                'options' => [

                ]
            ])->textInput()->label( 'Name project' );?>
        </div>
        <div class="col-lg-2">
            <?php echo $form->field( $model, 'jira_code', [

                'options' => [

                ]
            ])->textInput()->label( 'Jira code' );?>
        </div>
        <div class="col-lg-2">
            <div class="input-prepend date" id="dp3" data-date=<?php date("Y-m-d H:i:s")?> data-date-format="dd.mm.yyyy" style="display: inline-block">
                <div class="input-group date">
                    <?php echo $form->field( $model, 'date_start', [

                        'options' => [

                        ]
                    ])->textInput( ['class'=>'form-control pull-right active',
                        'id'=>'reservation',
                        'type'=>'text']);?>
                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                </div>
            </div>
        </div>
        <div class="col-lg-2">
            <div class="input-prepend date" id="dp2" data-date=<?php date("Y-m-d H:i:s")?> data-date-format="dd.mm.yyyy" style="display: inline-block">
                <div class="input-group date">
                    <?php echo $form->field( $model, 'date_end', [

                        'options' => [

                        ]
                    ])->textInput( ['class'=>'form-control pull-right active',
                        'id'=>'reservation',
                        'type'=>'text']);?>
                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div>
                <?php echo $form->field($model, 'status')->dropDownList([
                    '1'    => 'NEW',
                    '2'    => 'ONHOLD',
                    '3'    => 'INPROGRESS',
                    '4'    => 'DONE',
                    '5'    => 'CANCELED'
                ],
                    ['prompt' => 'Choose...']
                );?>
            </div>
        </div>

    </div>

    <div class="row">
        <div class="col-lg-6">
            <?php $modelUser = new User();
            $customers = User::allCustomers();
            $listCustomers = \yii\helpers\ArrayHelper::map( $customers, 'id', 'first_name' );
            echo $form->field( $modelUser, 'id' )
                ->listBox($listCustomers,
                    [
                        'multiple'=>"",
                        'class'=>"form-control"
                    ]);
            ?>
        </div>
        <div class="col-lg-6">
            <?php
            $developers = User::allDevelopers();
            $listDevelopers = \yii\helpers\ArrayHelper::map( $developers, 'id', 'first_name' );
            echo $form->field( $modelUser, 'id' )
                ->listBox($listDevelopers,
                    [
                        'multiple'=>"",
                        'class'=>"form-control"
                    ]);
            ?>
        </div>
    </div>
</div>
<div>
    <?= Html::submitButton( Yii::t('app', 'Create/Edit'), ['class' => 'btn btn-primary']) ?>
</div>

<?php ActiveForm::end();?>

<script>
    $(function(){
        $('#dp3').datepicker();
    });
    $(function(){
        $('#dp2').datepicker();
    });
</script>