<?php
use yii\helpers\Url;
use app\models\User;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

$this->registerJsFile(Yii::$app->request->baseUrl.'/js/jquery.dataTables.min.js');
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/dataTables.bootstrap.min.js');
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/jquery.slimscroll.min.js');
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/user.js');
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/modal.bootstrap.js');

if( User::hasPermission( [User::ROLE_ADMIN ]) ){
    $this->title = Yii::t("app", "Manage Users");
}

if( User::hasPermission( [User::ROLE_FIN, User::ROLE_SALES, User::ROLE_PM, User::ROLE_DEV ]) ){
    $this->title = Yii::t("app", "Co-workers");
}

if( User::hasPermission( [User::ROLE_CLIENT ]) ){
    $this->title = Yii::t("app", "Employees");
}


$this->params['breadcrumbs'][]  = $this->title;
if( User::hasPermission( [User::ROLE_ADMIN] ) ) {
    $this->params['menu'] = [
        [
            'label' => Yii::t('app', 'Invite User'),
            'url' => Url::to(['user/invite'])
        ]
    ];
}

?>
<table id="user-table" class="table table-hover box">
    <thead>
    <tr>
        <?php if ( User::hasPermission([User::ROLE_ADMIN])):?>
            <th><?=Yii::t('app', 'ID')?></th>
        <?php endif;?>
        <th><?=Yii::t('app', 'Photo')?></th>
        <th><?=Yii::t('app', 'Name')?></th>
        <?php if ( User::hasPermission([User::ROLE_ADMIN, User::ROLE_FIN, User::ROLE_SALES])):?>
            <th><?=Yii::t('app', 'Role')?></th>
        <?php endif;?>
        <th><?=Yii::t('app', 'Email')?></th>
        <th><?=Yii::t('app', 'Phone')?></th>
        <th class="date-col"><?=Yii::t('app', 'Last Login')?></th>
        <th class="date-col"><?=Yii::t('app', 'Joined')?></th>
        <?php if ( User::hasPermission([User::ROLE_ADMIN])):?>
            <th><?=Yii::t('app', 'Status')?></th>
        <?php endif;?>
        <?php if ( User::hasPermission([User::ROLE_ADMIN, User::ROLE_FIN])):?>
            <th class="date-col"><?=Yii::t('app', 'Salary')?></th>
            <th class="date-col"><?=Yii::t('app', 'Salary Up')?></th>
        <?php endif;?>
        <?php if ( User::hasPermission([User::ROLE_ADMIN])):?>
            <th class="actions-col extend"><?=Yii::t('app', 'Actions')?></th>
        <?php endif;?>
    </tr>
    </thead>
</table>
<script>

    $(function(){

        userModule.init({
            canSeeID        : '<?=( User::hasPermission([User::ROLE_ADMIN]) ? 'true' : 'false')?>',
            canSeeRole      : '<?=( User::hasPermission([User::ROLE_ADMIN, User::ROLE_FIN, User::ROLE_SALES]) ? 'true' : 'false')?>',
            editUrl         : '<?=Url::to(['user/update'])?>',
            deleteUrl       : '<?=Url::to(['user/delete'])?>',
            findUrl         : '<?=Url::to(['user/find'])?>',
            loginAsUserUrl  : '<?=Url::to(['user/loginas'])?>',
            activateUrl     : '<?=Url::to(['user/activate'])?>',
            canDelete       : <?=( User::hasPermission([User::ROLE_ADMIN]) ? 'true' : 'false')?>,
            canLoginAs      : <?=( User::hasPermission([User::ROLE_ADMIN]) ? 'true' : 'false')?>,
            canEdit         : <?=( User::hasPermission([User::ROLE_ADMIN]) ? 'true' : 'false')?>,
            showSales       : <?=( User::hasPermission([User::ROLE_ADMIN, User::ROLE_FIN]) ? 'true' : 'false')?>,
            showUserStatus  : <?=( User::hasPermission([User::ROLE_ADMIN]) ? 'true' : 'false')?>,
            canFilterByRole   : '<?=( User::hasPermission([User::ROLE_ADMIN, User::ROLE_FIN, User::ROLE_SALES]) ? 'true' : 'false')?>',
            canFilterByStatus : '<?=( User::hasPermission([User::ROLE_ADMIN]) ? 'true' : 'false')?>'

        })
    });

</script>