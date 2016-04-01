<?php
/**
 * Created by PhpStorm.
 * User: lera
 * Date: 16.03.16
 * Time: 12:10
 */

use yii\helpers\Url;
use app\models\User;
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/jquery.dataTables.min.js');
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/dataTables.bootstrap.min.js');
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/jquery.slimscroll.min.js');
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/teams.js');
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/modal.bootstrap.js');
$this->title                    = Yii::t("app", "My Teams");
$this->params['breadcrumbs'][]  = $this->title;
?>
<table id="teams-table" class="table table-hover display">
    <thead>
    <tr>
        <th><?=Yii::t('app', ' ')?></th>
        <th class="id-col"><?=Yii::t('app', 'Team ID')?></th>
        <th><?=Yii::t('app', 'Name')?></th>
        <th><?=Yii::t('app', 'Team Leader')?></th>
        <th><?=Yii::t('app', 'Number of Teammates')?></th>
        <th class="date-col"><?=Yii::t('app', 'Date of Creation')?></th>
        <!--<th><?=Yii::t('app', 'List of teammates')?></th>-->
    </tr>
    </thead>
</table>
<div style="margin-top: 5%;">
    <h3>List of Teammates </h3>
    <table id="teams-show-table" class="table table-hover display">
        <thead>
        <tr>
            <th class="id-col"><?=Yii::t('app', 'User ID')?></th>
            <th><?=Yii::t('app', 'First Name')?></th>
            <th><?=Yii::t('app', 'Last Name')?></th>
            <th><?=Yii::t('app', 'Email')?></th>
            <th><?=Yii::t('app', 'Phone')?></th>
            <th><?=Yii::t('app', 'Project')?></th>
        </tr>
        </thead>
</table>
    </div>
<script>
    $(function(){
        TeamModule.init({
            findUrl     : '<?=Url::to(['teams/find'])?>',
            viewUrl     : '<?=Url::to(['teams/view'])?>',
            findTeamUrl : '<?=Url::to(['teams/find2'])?>',
            canView   : <?=( User::hasPermission([User::ROLE_PM, User::ROLE_DEV]) ? 'true' : 'false')?>
        })
    });
</script>