<?php
use yii\helpers\Url;
use app\models\User;
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/jquery.dataTables.min.js');
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/dataTables.bootstrap.min.js');
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/jquery.slimscroll.min.js');
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/modal.bootstrap.js');
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/manager-teams.js');
$this->title                    = Yii::t("app", "Manage Teams");
$this->params['breadcrumbs'][]  = $this->title;
    $this->params['menu'] = [

    ];
?>
<table id="teams-table" class="table table-hover">
<thead>
<tr>
    <th class="id-col"><?=Yii::t('app', 'Team ID')?></th>
    <th><?=Yii::t('app', 'Name')?></th>
    <th><?=Yii::t('app', 'Team Leader')?></th>
    <th><?=Yii::t('app', 'Number of Teammates')?></th>
    <th class="date-col"><?=Yii::t('app', 'Date of Creation')?></th>
    <?php if ( User::hasPermission([User::ROLE_ADMIN, User::ROLE_FIN])) : ?>
        <th class="actions-col extend"><?=Yii::t('app', 'Actions')?></th>
    <?php endif;?>
</tr>
</thead>
</table>
<script>
    $(function(){

        managerTeamsModule.init({
            deleteUrl   : '<?=Url::to(['teammate/delete'])?>',
            findUrl     : '<?=Url::to(['teammate/find'])?>',
            canDelete   : <?=( User::hasPermission([User::ROLE_ADMIN, User::ROLE_FIN]) ? 'true' : 'false')?>,
            canAction   : <?=( User::hasPermission([User::ROLE_ADMIN, User::ROLE_FIN]) ? 'true' : 'false')?>

            })
    });

</script>
