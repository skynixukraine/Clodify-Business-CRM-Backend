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

User::hasPermission([User::ROLE_ADMIN]) ? $this->params['menu'] = [
                                            [
                                                'label' => Yii::t('app', 'Create a Project'),
                                                'url' => Url::to(['project/create'])
                                            ]
                                        ] : $this->params['menu'] = []

?>

    <table class="table table-hover box" id="project_table">
        <thead>
            <tr>
                <th><?=Yii::t('app', 'ID')?> </th>
                <th><?=Yii::t('app', 'Name')?></th>
                <th><?=Yii::t('app', 'JIRA')?></th>
                <th><?=Yii::t('app', 'Total Logged, h')?></th>
                <th><?=Yii::t('app', 'Cost')?></th>
                <?php if ( User::hasPermission([User::ROLE_ADMIN, User::ROLE_CLIENT, User::ROLE_FIN, User::ROLE_SALES])):?>
                <th id="role"><?=Yii::t('app', 'Total Paid, h')?></th>
                <?php endif;?>
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
            deleteUrl   : '<?=Url::to(['project/delete'])?>',
            activateUrl : '<?=Url::to(['project/activate'])?>',
            suspendUrl  : '<?=Url::to(['project/suspend'])?>',
            findUrl     : '<?=Url::to(['project/find'])?>',
            canDelete   : <?=( User::hasPermission([User::ROLE_ADMIN]) ? 'true' : 'false')?>,
            canEdit     : <?=( User::hasPermission([User::ROLE_ADMIN, User::ROLE_CLIENT]) ? 'true' : 'false')?>,
            canActivate : <?=( User::hasPermission([User::ROLE_ADMIN, User::ROLE_CLIENT]) ? 'true' : 'false')?>,
            canSuspend  : <?=( User::hasPermission([User::ROLE_ADMIN, User::ROLE_CLIENT]) ? 'true' : 'false')?>,
            canSeeHours : <?=( User::hasPermission([User::ROLE_ADMIN, User::ROLE_CLIENT, User::ROLE_FIN, User::ROLE_SALES]) ? 'true' : 'false')?>
        })
    });

</script>



