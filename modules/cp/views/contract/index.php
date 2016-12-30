<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use app\models\User;
use app\models\Contract;
use yii\helpers\ArrayHelper;
use app\models\ProjectCustomer;
use app\models\ProjectDeveloper;

$this->registerJsFile(Yii::$app->request->baseUrl.'/js/jquery.dataTables.min.js');
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/dataTables.bootstrap.min.js');
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/jquery.slimscroll.min.js');
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/modal.bootstrap.js');
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/check-form.js');
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/contract-create.js');

$this->params['menu'] = [
    [
        'label' => Yii::t('app', 'Create a Contract'),
        'url' => Url::to(['contract/create'])
    ]
];
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-2">
<?php echo Html::label('Customers:');
if (User::hasPermission([User::ROLE_ADMIN, User::ROLE_FIN])) {
    $customers = User::find()
        ->where(User::tableName() . ".is_delete=0 AND " . User::tableName() . ".is_active=1 AND " .
            User::tableName() . ".role IN ('" . User::ROLE_CLIENT . "')")
        ->groupBy(User::tableName() . ".id")
        ->rightJoin(Contract::tableName(), Contract::tableName() . '.customer_id=' . User::tableName() . '.id')
        ->all();
} else if (User::hasPermission([User::ROLE_SALES])) {
    // for sales role displays not all customers, but only customers, that was assigned on common with SALES projects
    // with checked receive_invoices
    $customers = User::find()
        ->where(User::tableName() . ".is_delete=0 AND " . User::tableName() . ".is_active=1 AND " .
            User::tableName() . ".role IN ('" . User::ROLE_CLIENT . "')")
        ->groupBy(User::tableName() . ".id")
        ->rightJoin(Contract::tableName(), Contract::tableName() . '.customer_id=' . User::tableName() . '.id')
        ->leftJoin(ProjectCustomer::tableName(), ProjectCustomer::tableName() . '.user_id=' . User::tableName() . '.id')
        ->leftJoin(ProjectDeveloper::tableName(), ProjectDeveloper::tableName() . '.user_id=' . Yii::$app->user->id)
        ->andWhere([ProjectDeveloper::tableName() . '.is_sales' => 1])
        ->andWhere([ProjectCustomer::tableName() . '.receive_invoices' => 1])
        ->andWhere(ProjectCustomer::tableName() . '.project_id=' . ProjectDeveloper::tableName() . '.project_id')
        ->all();
}
$listReport = User::getCustomersDropDown( $customers, 'id' );
$listReport = ArrayHelper::merge(['' => 'allcustomers'], $listReport);
echo Html::dropDownList('customers', null, $listReport, ['class'=>"form-control"]) ?>
        </div>
    </div>
</div>

<table class="table table-hover box " id="contract_table">
    <thead>
    <tr>
        <th><?=Yii::t('app', 'ID')?> </th>
        <th><?=Yii::t('app', 'Initiator')?></th>
        <th><?=Yii::t('app', 'Customer')?></th>
        <th><?=Yii::t('app', 'Act Number')?></th>
        <th><?=Yii::t('app', 'Start Date')?></th>
        <th><?=Yii::t('app', 'End Date')?></th>
        <th><?=Yii::t('app', 'Act Date')?></th>
        <th><?=Yii::t('app', 'Total')?></th>
        <th><?=Yii::t('app', 'Total Hours')?></th>
        <th><?=Yii::t('app', 'Expenses')?></th>
        <th class="actions-col extend"><?=Yii::t('app', 'Actions')?></th>
    </tr>
    </thead>
</table>

<script>

    $(function(){

        contractCreateModule.init({
            editUrl     : '<?=Url::to(['contract/edit'])?>',
            deleteUrl   : '<?=Url::to(['contract/delete'])?>',
            findUrl     : '<?=Url::to(['contract/find'])?>',
            viewUrl     : '<?=Url::to(['contract/view'])?>',
            canDelete   : <?=( User::hasPermission([User::ROLE_ADMIN, User::ROLE_FIN]) ? 'true' : 'false')?>,
            canEdit     : <?=( User::hasPermission([User::ROLE_ADMIN, User::ROLE_SALES, User::ROLE_FIN]) ? 'true' : 'false')?>,
            canInvoice  : <?=( User::hasPermission([User::ROLE_ADMIN, User::ROLE_SALES, User::ROLE_FIN]) ? 'true' : 'false')?>,
            canView     : <?=( User::hasPermission([User::ROLE_ADMIN, User::ROLE_SALES, User::ROLE_FIN]) ? 'true' : 'false')?>,
        })
    });

</script>