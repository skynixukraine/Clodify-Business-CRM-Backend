<?php
/**
 * Created by PhpStorm.
 * User: olha
 * Date: 16.02.16
 * Time: 14:20
 */
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use app\models\Invoice;
use app\models\User;
use app\models\Report;
use app\models\ProjectCustomer;

$this->registerJsFile(Yii::$app->request->baseUrl.'/js/jquery.dataTables.min.js');
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/dataTables.bootstrap.min.js');
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/jquery.slimscroll.min.js');
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/modal.bootstrap.js');
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/invoice-create.js');
$this->title                    = Yii::t("app", "Create an Invoice");
$this->params['breadcrumbs'][]  = $this->title;

$this->params['menu'] = [
    [
        'label' => Yii::t('app', 'Invoices'),
        'url' => Url::to(['invoice/index'])
    ]
];
?>

<?php $form = ActiveForm::begin([
    'options' => [
        'class' => 'horizontal'
    ]
]);
?>
<div class="row">
    <div class="col-md-6 box box-primary box-body">
            <?php $customers = User::allCustomersWhithReceive();
            $listCustomers = ArrayHelper::map( $customers, 'id', 'first_name' );
            /** @var $model Invoice */
            echo $form->field($model, 'user_id')
                      ->dropDownList( $listCustomers,  [
                          'prompt' => 'Choose...',
                      ] )
                      ->label( 'Customers' );

            ?>

            <?php echo $form->field( $model, 'date_start', [

                'template' => '{label} ' .
                    ' <div class="input-group ">{input}' .
                    ' <span class="input-group-addon"><i class="fa fa-calendar"></i></span> </div> ' .
                    ' {error}'

            ])->textInput( ['class'=>'form-control pull-right active', 'type'=>'text', 'id'=>"date_start"] );?>

            <?php echo $form->field( $model, 'date_end', [

                'template' => '{label} ' .
                    ' <div class="input-group ">{input}' .
                    ' <span class="input-group-addon"><i class="fa fa-calendar"></i></span> </div> ' .
                    ' {error}'

            ])->textInput( ['class'=>'form-control pull-right active', 'type'=>'text', 'id'=>"date_end"] );?>

            <?php echo $form->field( $model, 'contract_number')->textInput();?>
            <?php echo $form->field( $model, 'act_of_work')->textInput();?>
            <?php echo $form->field( $model, 'discount')->textInput();?>
            <?php echo $form->field( $model, 'total')->textInput();?>
            <?php echo $form->field( $model, 'total_hours')->textInput(['readonly'=> true]);?>
            <?php echo $form->field( $model, 'note')->textarea();?>

            <?= Html::submitButton( Yii::t('app', 'Create'), ['class' => 'btn btn-primary']) ?>
        </div>
    </div>

<?php ActiveForm::end();?>
    <table class = "table" id="invoice-create-table">
        <thead>
        <tr>
            <th><?=Yii::t('app', 'ID Report')?> </th>
            <th><?=Yii::t('app', 'Dev Name')?> </th>
            <th><?=Yii::t('app', 'Project Name')?></th>
            <th><?=Yii::t('app', 'Reported')?></th>
            <th><?=Yii::t('app', 'Task')?></th>
            <th><?=Yii::t('app', 'Hours')?></th>
        </tr>
        </thead>
  </table>
<script>
    $(function(){

        invoiceCreateModule.init({
            findUrl     : '<?=Url::to(['report/find'])?>'
        })
    });
</script>