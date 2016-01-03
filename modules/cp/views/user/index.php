<?php
use yii\helpers\Url;
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/jquery.dataTables.min.js');
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/dataTables.bootstrap.min.js');
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/jquery.slimscroll.min.js');
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/user.js');
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/modal.bootstrap.js');
$this->title                    = Yii::t("app", "Manage Users");
$this->params['breadcrumbs'][]  = $this->title;

$this->params['menu'] = [
    [
        'label' => Yii::t('app', 'Invite User'),
        'url'   => Url::to(['user/invite'])
    ]
];

?>
<table id="user-table" class="table table-hover">
    <thead>
    <tr>
        <th class="id-col"><?=Yii::t('app', 'ID')?></th>
        <th><?=Yii::t('app', 'Name')?></th>
        <th><?=Yii::t('app', 'Email')?></th>
        <th><?=Yii::t('app', 'Phone')?></th>
        <th class="date-col"><?=Yii::t('app', 'Login Date')?></th>
        <th class="date-col"><?=Yii::t('app', 'Signup Date')?></th>
        <th class="actions-col extend"><?=Yii::t('app', 'Actions')?></th>
    </tr>
    </thead>
</table>
<script>

    $(function(){

        userModule.init({
            editUrl     : '<?=Url::to(['user/update'])?>',
            deleteUrl   : '<?=Url::to(['user/delete'])?>',
            findUrl     : '<?=Url::to(['user/find'])?>'
        })
    })

</script>