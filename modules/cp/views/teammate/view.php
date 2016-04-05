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
<?php if ( User::hasPermission([User::ROLE_ADMIN, User::ROLE_FIN])) : ?>
    <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">
        APPEND
    </button>
    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Append a new teammate to the team: <?php echo $model->name; ?></h4>
                </div>
                <div class="modal-body">
                    <?php $teammates = \app\models\User::find()->where(User::tableName() . ".is_delete=0 AND " . User::tableName() . ".is_active=1 AND " .
                        User::tableName() . ".role IN ('" . User::ROLE_PM . "', '" . User::ROLE_DEV . "')")->all();
                    $listReport = \yii\helpers\ArrayHelper::map( $teammates, 'id', 'first_name' );
                    //var_dump($listReport);
                    //exit();
                    echo $form->field( $model, 'teammate', [

                        'options' => [

                        ]
                    ])->dropDownList( $listReport, ['prompt' => 'Choose...'] )->label('Teammate');?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <?= Html::submitButton( Yii::t('app', 'Save'), ['class' => 'btn btn-primary']) ?>
                </div>
            </div>
        </div>
    </div>
<?php endif;?>

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
        <?php if ( User::hasPermission([User::ROLE_ADMIN])) : ?>
        <th><?=Yii::t('app', 'Actions')?></th>
        <?php endif;?>
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
