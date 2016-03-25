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
<table id="team-table" class="table table-hover">
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
<script>
    $(function(){
        TeamsModule.init({
            editUrl     : '<?=Url::to(['teams/update'])?>',
            deleteUrl   : '<?=Url::to(['teams/delete'])?>',
            findUrl     : '<?=Url::to(['teams/find'])?>',
            canDelete   : <?=( User::hasPermission([User::ROLE_ADMIN]) ? 'true' : 'false')?>
        })
    });
</script>