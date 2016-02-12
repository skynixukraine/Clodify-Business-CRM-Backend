<?php
/**
 * Created by PhpStorm.
 * User: olha
 * Date: 01.02.16
 * Time: 14:48
 */
use yii\helpers\Url;
use app\models\Project;
use app\models\User;
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/jquery.dataTables.min.js');
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/dataTables.bootstrap.min.js');
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/jquery.slimscroll.min.js');
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/project.js');
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/modal.bootstrap.js');
$this->title                    = Yii::t("app", "Manage Projects");
$this->params['breadcrumbs'][]  = $this->title;

$this->params['menu'] = [

];
?>

<table class="table table-hover" id="project_table">
    <thead>
    <tr>
        <th><?=Yii::t('app', 'ID')?> </th>
        <th><?=Yii::t('app', 'Name')?></th>
        <th><?=Yii::t('app', 'Jira Code')?></th>
        <th><?=Yii::t('app', 'Total Logged, h')?></th>
        <th><?=Yii::t('app', 'Total Paid, h')?></th>
        <th><?=Yii::t('app', 'Date Start')?></th>
        <th><?=Yii::t('app', 'Date End')?></th>
        <th><?=Yii::t('app', 'Developers')?></th>
        <th><?=Yii::t('app', 'Clients')?></th>
        <th><?=Yii::t('app', 'Status')?></th>
        <?php if ( User::hasPermission([User::ROLE_ADMIN, User::ROLE_CLIENT])):?>
        <th><?=Yii::t('app', 'Actions')?></th>
        <?php endif;?>
    </tr>
    </thead>

</table>

<script>

    $(function(){

        projectModule.init({
            editUrl     : '<?=Url::to(['project/edit'])?>',
            createUrl   : '<?=Url::to(['project/create'])?>',
            deleteUrl   : '<?=Url::to(['project/delete'])?>',
            activateUrl : '<?=Url::to(['project/activate'])?>',
            suspendUrl  : '<?=Url::to(['project/suspend'])?>',
            updateUrl   : '<?=Url::to(['project/index'])?>',
            findUrl     : '<?=Url::to(['project/find'])?>',
            canDelete   : <?=( User::hasPermission([User::ROLE_ADMIN]) ? 'true' : 'false')?>,
            canEdit     : <?=( User::hasPermission([User::ROLE_ADMIN, User::ROLE_CLIENT]) ? 'true' : 'false')?>,
            canCreate   : <?=( User::hasPermission([User::ROLE_ADMIN]) ? 'true' : 'false')?>,
            canActivate : <?=( User::hasPermission([User::ROLE_ADMIN, User::ROLE_CLIENT]) ? 'true' : 'false')?>,
            canSuspend  : <?=( User::hasPermission([User::ROLE_ADMIN, User::ROLE_CLIENT]) ? 'true' : 'false')?>,
            canUpdate   : <?=( User::hasPermission([User::ROLE_ADMIN, User::ROLE_CLIENT]) ? 'true' : 'false')?>
        })
    });

</script>


