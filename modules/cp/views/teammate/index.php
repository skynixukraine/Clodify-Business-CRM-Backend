<?php
use yii\helpers\Url;
use app\models\User;
use yii\widgets\ActiveForm;
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/jquery.dataTables.min.js');
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/dataTables.bootstrap.min.js');
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/jquery.slimscroll.min.js');
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/modal.bootstrap.js');
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/manager-teams.js');
$this->title                    = Yii::t("app", "Company Teams");
$this->params['breadcrumbs'][]  = $this->title;
if( User::hasPermission( [User::ROLE_ADMIN] ) ) {
    $this->params['menu'] = [
        [
            'label' => Yii::t('app', 'Create team'),
            'url' => Url::to(['teammate/create'])
        ]
    ];
}

?>

    <table id="teams-table" class="table table-hover box">
        <thead>
            <tr>
                <th class="id-col"><?=Yii::t('app', 'Team ID')?></th>
                <th><?=Yii::t('app', 'Name')?></th>
                <th><?=Yii::t('app', 'Team Leader')?></th>
                <th><?=Yii::t('app', 'Number of Teammates')?></th>
                <th class="date-col"><?=Yii::t('app', 'Date of Creation')?></th>
                <?php if ( User::hasPermission([User::ROLE_ADMIN, User::ROLE_FIN, User::ROLE_DEV, User::ROLE_PM])) : ?>
                    <th class="actions-col extend"><?=Yii::t('app', 'Actions')?></th>
                <?php endif;?>
            </tr>
        </thead>
    </table>

<script>
    $(function(){
        managerTeamsModule.init({
            deleteUrl   : '<?=Url::to(['teammate/deleteteam'])?>',
            findUrl     : '<?=Url::to(['teammate/find'])?>',
            viewUrl     : '<?=Url::to(['teammate/view'])?>',
            canView     : <?=( User::hasPermission([User::ROLE_ADMIN, User::ROLE_FIN, User::ROLE_DEV, User::ROLE_PM]) ? 'true' : 'false')?>,
            canDelete   : <?=( User::hasPermission([User::ROLE_ADMIN]) ? 'true' : 'false')?>,
            canAction   : <?=( User::hasPermission([User::ROLE_ADMIN, User::ROLE_FIN, User::ROLE_DEV, User::ROLE_PM]) ? 'true' : 'false')?>

            })
    });

</script>
