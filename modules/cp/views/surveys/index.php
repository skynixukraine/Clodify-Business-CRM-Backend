<?php
/**
 * Created by PhpStorm.
 * User: lera
 * Date: 05.05.16
 * Time: 15:06
 */
use yii\helpers\Url;
use yii\helpers\Html;
use app\models\User;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;

$this->registerJsFile(Yii::$app->request->baseUrl.'/js/jquery.dataTables.min.js');
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/dataTables.bootstrap.min.js');
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/modal.bootstrap.js');
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/survey_options.js');
$this->title                    = Yii::t("app", "Surveys List");

$this->params['breadcrumbs'][]  = $this->title;

if( User::hasPermission( [User::ROLE_ADMIN, User::ROLE_DEV, User::ROLE_PM, User::ROLE_FIN, User::ROLE_CLIENT] ) ) {
    $this->params['menu'] = [
        [
            'label' => Yii::t('app', 'Create survey'),
            'url' => Url::to(['surveys/create'])
        ]
    ];
}
?>
<table class="table table-hover box" id="surveys_table">
    <thead>
    <tr>
        <th><?=Yii::t('app', 'ID')?> </th>
        <th><?=Yii::t('app', 'Shortcode')?></th>
        <th><?=Yii::t('app', 'Question ')?></th>
        <th><?=Yii::t('app', 'Date Start')?></th>
        <th><?=Yii::t('app', 'Date End')?></th>
        <th><?=Yii::t('app', 'Is Private?')?></th>
        <th><?=Yii::t('app', 'Votes')?></th>
        <?php if ( User::hasPermission([User::ROLE_ADMIN, User::ROLE_FIN, User::ROLE_CLIENT, User::ROLE_DEV, User::ROLE_PM ])) : ?>
            <th class="actions-col extend"><?=Yii::t('app', 'Actions')?></th>
        <?php endif;?>

    </tr>
    </thead>
</table>
<script>
    $(function(){
        surveysModule.init({
            findUrl     : '<?=Url::to(['surveys/find'])?>',
            deleteUrl   : '<?=Url::to(['surveys/delete'])?>',
            editUrl     : '<?=Url::to(['surveys/edit'])?>',
            codeUrl     : '<?=Yii::$app->params['en_site'].Yii::$app->urlManager->createUrl(['/s'])?>',
            canDelete   : <?=( User::hasPermission([User::ROLE_ADMIN, User::ROLE_FIN, User::ROLE_CLIENT, User::ROLE_DEV, User::ROLE_PM]) ? 'true' : 'false')?>,
            canAction   : <?=( User::hasPermission([User::ROLE_ADMIN, User::ROLE_FIN, User::ROLE_CLIENT, User::ROLE_DEV, User::ROLE_PM]) ? 'true' : 'false')?>,
            canEdit     : <?=( User::hasPermission([User::ROLE_ADMIN, User::ROLE_FIN, User::ROLE_CLIENT, User::ROLE_DEV, User::ROLE_PM]) ? 'true' : 'false')?>,
        })
    });

</script>
