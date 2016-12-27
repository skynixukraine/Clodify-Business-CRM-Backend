<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use app\models\User;

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
            canDelete   : <?=( User::hasPermission([User::ROLE_ADMIN, User::ROLE_FIN]) ? 'true' : 'false')?>,
            canEdit     : <?=( User::hasPermission([User::ROLE_ADMIN, User::ROLE_SALES, User::ROLE_FIN]) ? 'true' : 'false')?>,
            canInvoice  : <?=( User::hasPermission([User::ROLE_ADMIN, User::ROLE_SALES, User::ROLE_FIN]) ? 'true' : 'false')?>,
            canView     : <?=( User::hasPermission([User::ROLE_ADMIN, User::ROLE_SALES, User::ROLE_FIN]) ? 'true' : 'false')?>,
        })
    });

</script>