<?php
/**
 * Created by PhpStorm.
 * User: olha
 * Date: 16.02.16
 * Time: 12:01
 */
use yii\helpers\Url;
use app\models\Invoice;
use app\models\User;

$this->registerJsFile(Yii::$app->request->baseUrl.'/js/jquery.dataTables.min.js');
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/dataTables.bootstrap.min.js');
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/jquery.slimscroll.min.js');
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/modal.bootstrap.js');
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/invoice.js');
$this->title                    = Yii::t("app", "Invoices");
if( User::hasPermission([User::ROLE_ADMIN, User::ROLE_FIN] )) {
    $this->params['breadcrumbs'][] = $this->title;

    $this->params['menu'] = [
        [
            'label' => Yii::t('app', 'Create an Invoice'),
            'url' => Url::to(['invoice/create'])
        ]
    ];
}
?>

    <table class="table table-hover box " id="invoice_table">
        <thead>
        <tr>
            <th><?=Yii::t('app', 'ID')?> </th>
            <th><?=Yii::t('app', 'Client Name')?></th>
            <th><?=Yii::t('app', 'Subtotal')?></th>
            <th><?=Yii::t('app', 'Discount')?></th>
            <th><?=Yii::t('app', 'Total')?></th>
            <th><?=Yii::t('app', 'Date Start')?></th>
            <th><?=Yii::t('app', 'Date End')?></th>
            <th><?=Yii::t('app', 'Date Create')?></th>
            <th><?=Yii::t('app', 'Date Sent')?></th>
            <th><?=Yii::t('app', 'Date Paid')?></th>
            <th><?=Yii::t('app', 'Status')?></th>
            <?php if ( User::hasPermission([User::ROLE_ADMIN, User::ROLE_FIN])) : ?>
                <th class="actions-col extend"><?=Yii::t('app', 'Actions')?></th>
            <?php endif;?>
        </tr>
        </thead>
    </table>

<script>

    $(function(){

        invoiceModule.init({
            paidUrl     : '<?=Url::to(['invoice/paid'])?>',
            canceledUrl : '<?=Url::to(['invoice/canceled'])?>',
            deleteUrl   : '<?=Url::to(['invoice/delete'])?>',
            findUrl     : '<?=Url::to(['invoice/find'])?>',
            viewUrl     : '<?=Url::to(['invoice/view'])?>',
            canDelete   : <?=( User::hasPermission([User::ROLE_ADMIN, User::ROLE_FIN]) ? 'true' : 'false')?>,
            canView     : <?=( User::hasPermission([User::ROLE_ADMIN, User::ROLE_FIN]) ? 'true' : 'false')?>,
            canPaid     : <?=( User::hasPermission([User::ROLE_ADMIN, User::ROLE_FIN]) ? 'true' : 'false')?>,
            canCanceled : <?=( User::hasPermission([User::ROLE_ADMIN, User::ROLE_FIN]) ? 'true' : 'false')?>
        })
    });

</script>