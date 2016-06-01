<?php
/**
 * Created by PhpStorm.
 * User: olha
 * Date: 26.05.16
 * Time: 16:39
 */
use yii\helpers\Url;
use app\models\User;
use yii\widgets\ActiveForm;

$this->registerJsFile(Yii::$app->request->baseUrl.'/js/jquery.dataTables.min.js');
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/dataTables.bootstrap.min.js');
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/modal.bootstrap.js');
$this->registerJsFile(Yii::getAlias('@extension-assets') . '/js/extension.js');
$this->title                    = Yii::t("app", $title );
$this->params['menu'][]  =
    [
        'label' => Yii::t('app', 'Add a New Extension'),
        'url'   => Url::to(['/ExtensionPackager/extension/create'])
    ];
$this->params['breadcrumbs'][]  = $this->title;
?>
<table class="table table-hover box" id="extension_table">
    <thead>
    <tr>
        <th><?=Yii::t('app', 'ID')?> </th>
        <th><?=Yii::t('app', 'Name')?></th>
        <th><?=Yii::t('app', 'Package ')?></th>
        <th><?=Yii::t('app', 'Version')?></th>
        <th><?=Yii::t('app', 'Type')?></th>
        <th><?=Yii::t('app', 'Actions')?></th>
    </tr>
    </thead>
</table>
<script>
    $(function(){
        extensionModule.init({
            findUrl     : '<?=Url::to(['extension/find'])?>',
            deleteUrl   : '<?=Url::to(['extension/delete'])?>',
            editUrl     : '<?=Url::to(['extension/create'])?>',
            downloadUrl : '<?=Url::to(['extension/download'])?>'
        })
    });
</script>