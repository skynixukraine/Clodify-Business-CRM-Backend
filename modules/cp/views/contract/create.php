<?php
/**
 * Created by Skynix Team
 * Date: 22.12.16
 * Time: 17:08
 */
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\User;

$this->registerJsFile(Yii::$app->request->baseUrl.'/js/jquery.dataTables.min.js');
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/dataTables.bootstrap.min.js');
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/jquery.slimscroll.min.js');
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/modal.bootstrap.js');
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/check-form.js');
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/contract-create.js');


$this->params['menu'] = [
    [
        'label' => Yii::t('app', 'Manage Contracts'),
        'url' => Url::to(['contract/index'])
    ]
];
$form = ActiveForm::begin([
    'options' => ['class' => 'form-horizontal'],
]) ?>
<?php
    $customers = User::allCustomersWhithReceive();
    $listCustomers = User::getCustomersDropDown($customers, 'id');
    echo $form->field($model, 'customer_id')
        ->dropDownList($listCustomers, [
            'prompt' => 'Choose...',
        ])
        ->label('Customer');
        ?>

<?php echo $form->field( $model, 'act_number')->textInput();?>
<?php echo $form->field( $model, 'start_date', [

    'template' => '{label} ' .
        ' <div class="input-group date">{input}' .
        ' <span class="input-group-addon"><i class="fa fa-calendar"></i></span> </div> ' .
        ' {error}'

])->textInput( ['class'=>'form-control pull-right active',
    'type'=>'text']);?>
<?php echo $form->field( $model, 'end_date', [

    'template' => '{label} ' .
        ' <div class="input-group date">{input}' .
        ' <span class="input-group-addon"><i class="fa fa-calendar"></i></span> </div> ' .
        ' {error}'

])->textInput( ['class'=>'form-control pull-right active',
    'type'=>'text']);?>
<?php echo $form->field( $model, 'act_date')->textInput( ['class'=>'form-control pull-right active',
    'type'=>'text']);?>
<?php echo $form->field( $model, 'total')->textInput();?>




<?= Html::submitButton( Yii::t('app', 'Create'), ['class' => 'btn btn-primary']) ?>

<?php ActiveForm::end() ?>
<script>
    $(function(){
        contractCreateModule.init()
    });
</script>
