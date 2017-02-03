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
use app\models\Contract;
use app\models\Project;
use app\models\ProjectCustomer;
use app\models\ContractTemplates;
use app\models\PaymentMethod;

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
    'options' => ['class' => 'horizontal'],
]) ?>
<div class="row">
    <div class="col-md-6 box box-primary box-body">
<?php
/** @var $model Contract*/
$contractId = $model->contract_id ? $model->contract_id : Contract::find()->max('contract_id') + 1;
echo $form->field( $model, 'contract_id')->textInput(['value' => $contractId]);?>

<?php
    if (User::hasPermission([User::ROLE_ADMIN, User::ROLE_FIN])) {
        $customers = User::allCustomersWhithReceive();
        $listCustomers = User::getCustomersDropDown($customers, 'id');
        echo $form->field($model, 'customer_id')
            ->dropDownList($listCustomers, [
                'prompt' => 'Choose...',
            ])
            ->label('Customer');
    }
?>

<?php
    if (User::hasPermission([User::ROLE_SALES])) {
        $projectsID = [];
        $customers = [];
        $projects = Project::getDevOrAdminOrPmOrSalesOrFinProjects(Yii::$app->user->id);
        foreach ($projects as $project) {
            $projectsID[] = $project->id;
        }
        $projectCustomers = ProjectCustomer::getProjectCustomer($projectsID)->all();
        foreach ($projectCustomers as $customer) {
            $customers[] = $customer->user;
        }
        $listCustomers = User::getCustomersDropDown($customers, 'id');
        echo $form->field($model, 'customer_id')
            ->dropDownList($listCustomers, [
                'prompt' => 'Choose...',
            ])
            ->label('Customer');
    }
?>

<?php
    $listTemplates = ContractTemplates::getAllTemplatesDropdown();
    echo $form->field($model, 'contract_template_id')
        ->dropDownList($listTemplates, [
            'prompt' => 'Choose...',
        ])
        ->label('Template');
?>

<?php
    $listMethods = PaymentMethod::getAllMethodsDropdown();
    echo $form->field($model, 'contract_payment_method_id')
        ->dropDownList($listMethods, [
            'prompt' => 'Choose...',
        ])
        ->label('Payment Method');
?>

<?php
$actNumber = $model->act_number ? $model->act_number : Contract::find()->max('act_number') + 1;
echo $form->field( $model, 'act_number')->textInput(['value' => $actNumber]);?>
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




<?= Html::submitButton( Yii::t('app', 'Save'), ['class' => 'btn btn-primary']) ?>
    </div>
</div>
<?php ActiveForm::end() ?>
<script>
    $(function(){
        contractCreateModule.init()
    });
</script>
