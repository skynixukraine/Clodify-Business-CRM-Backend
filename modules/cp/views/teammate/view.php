<?php
/**
 * Created by PhpStorm.
 * User: lera
 * Date: 25.03.16
 * Time: 16:45
 */
use yii\helpers\Url;
use app\models\Teammate;
use app\models\User;
use app\models\Report;
use app\models\PaymentMethod;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/jquery.dataTables.min.js');
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/teammate-view.js');
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/dataTables.bootstrap.min.js');
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/jquery.slimscroll.min.js');
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/modal.bootstrap.js');
$this->title                    = Yii::t("app", $title);
$this->params['breadcrumbs'][]  = $this->title;

$this->params['menu'] = [
    [
        'label' => Yii::t('app', 'Teammate'),
        'url' => Url::to(['teammate/index'])
    ]
];
?>
<?php $form =  ActiveForm::begin();?>
<?php /** @var $model \app\models\Team*/ ?>
<ul>
<li>ID: <?php echo $model->id; ?></li>
<li>Team Name: <?php echo $model->name; ?></li>
<li>Team Leader: <?php echo $model->getUser()->one()->first_name . ' ' . $model->getUser()->one()->last_name; ?></li>
<li> Date of Creation: <?php echo $model->date_created ?></li>
</ul>

<?php  ActiveForm::end();?>
<table id="teammates-table" class="table table-hover">
    <thead>
    <tr>
        <th class="id-col"><?=Yii::t('app', 'User ID')?></th>
        <th><?=Yii::t('app', 'First Name')?></th>
        <th><?=Yii::t('app', 'Last Name')?></th>
        <th><?=Yii::t('app', 'Email')?></th>
        <th><?=Yii::t('app', 'Phone')?></th>
        <th><?=Yii::t('app', 'Projects')?></th>
        <th><?=Yii::t('app', 'Actions')?></th>
    </tr>
    </thead>
</table>
<script>
    $(function(){
        TeammateModule.init({
            deleteUrl   : '<?=Url::to(['teammate/delete'])?>',
            findUrl     : '<?=Url::to(['teams/find'])?>',
            canDelete   : <?=( User::hasPermission([User::ROLE_ADMIN]) ? 'true' : 'false')?>
        })
    });
</script>
