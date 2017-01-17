<?php
use yii\helpers\Url;
use app\models\User;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

$this->registerJsFile(Yii::$app->request->baseUrl.'/js/jquery.dataTables.min.js');
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/dataTables.bootstrap.min.js');
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/jquery.slimscroll.min.js');
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/user.js');
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/modal.bootstrap.js');
$this->title                    = Yii::t("app", "Manage Users");
$this->params['breadcrumbs'][]  = $this->title;
if( User::hasPermission( [User::ROLE_ADMIN] ) ) {
    $this->params['menu'] = [
        [
            'label' => Yii::t('app', 'Invite User'),
            'url' => Url::to(['user/invite'])
        ]
    ];
}

  $form = ActiveForm::begin();
        /** @var $model User */ ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-2">
            <?php 
			echo Html::label('Roles:');
			$roles = ArrayHelper::merge(['' => 'All Roles'], User::getRoles());
			echo Html::dropDownList('roles', null, $roles, ['class'=>"form-control"]);
			?>
		</div>
		<div class="col-lg-2">
			<?php echo Html::label('Active Only: ');?>
			<div class="is_active"> <?php echo Html::checkbox('is_active', true ); ?> </div>
			
		</div>
    </div>
</div>

<?php ActiveForm::end();?>

<table id="user-table" class="table table-hover box">
    <thead>
    <tr>
        <th class="id-col"><?=Yii::t('app', 'ID')?></th>
        <th><?=Yii::t('app', 'Name')?></th>
        <th><?=Yii::t('app', 'Role')?></th>
        <th><?=Yii::t('app', 'Email')?></th>
        <th><?=Yii::t('app', 'Phone')?></th>
        <th class="date-col"><?=Yii::t('app', 'Last Login')?></th>
        <th class="date-col"><?=Yii::t('app', 'Joined')?></th>
        <?php if ( User::hasPermission([User::ROLE_ADMIN])) : ?>
            <th class="date-col"><?=Yii::t('app', 'Is Active')?></th>
        <?php endif;?>
        <?php if ( User::hasPermission([User::ROLE_ADMIN, User::ROLE_FIN])) : ?>
            <th class="date-col"><?=Yii::t('app', 'Salary')?></th>
            <th class="date-col"><?=Yii::t('app', 'Salary Up')?></th>
        <?php endif;?>
        <?php if ( User::hasPermission([User::ROLE_ADMIN])) : ?>
            <th class="actions-col extend"><?=Yii::t('app', 'Actions')?></th>
        <?php endif;?>
    </tr>
    </thead>
</table>
<script>

    $(function(){

        userModule.init({
            editUrl         : '<?=Url::to(['user/update'])?>',
            deleteUrl       : '<?=Url::to(['user/delete'])?>',
            findUrl         : '<?=Url::to(['user/find'])?>',
            loginAsUserUrl  : '<?=Url::to(['user/loginas'])?>',
            activateUrl     : '<?=Url::to(['user/activate'])?>',
            canDelete       : <?=( User::hasPermission([User::ROLE_ADMIN]) ? 'true' : 'false')?>,
            canLoginAs      : <?=( User::hasPermission([User::ROLE_ADMIN]) ? 'true' : 'false')?>,
            canEdit         : <?=( User::hasPermission([User::ROLE_ADMIN]) ? 'true' : 'false')?>,
            showSales       : <?=( User::hasPermission([User::ROLE_ADMIN, User::ROLE_SALES, User::ROLE_FIN]) ? 'true' : 'false')?>,
            showUserStatus  : <?=( User::hasPermission([User::ROLE_ADMIN]) ? 'true' : 'false')?>
        })
    });

</script>