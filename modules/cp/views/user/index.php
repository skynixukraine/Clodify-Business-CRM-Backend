<?php
use yii\helpers\Url;
use app\models\User;
use yii\widgets\ActiveForm;

$this->registerJsFile(Yii::$app->request->baseUrl.'/js/jquery.js');
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

?>
<?php
$form = ActiveForm::begin();
$items = [
    'ALL USERS' => 'ALL USERS',
    'PM'        => 'PM',
    'ADMIN'     => 'ADMIN',
    'SALES'     => 'SALES',
    'FIN'       => 'FIN',
    'PM'        => 'PM',
    'DEV'       => 'DEV',
    'CLIENT'    => 'CLIENT'
];
echo $form->field($model, 'role',[
    'options' => [
        'style' => [
            'width'=>"170px"
        ]
    ]])->dropDownList($items);
ActiveForm::end();
?>

<table id="user-table" class="table table-hover box">
    <thead>
    <tr>
        <th class="id-col"><?=Yii::t('app', 'ID')?></th>
        <th><?=Yii::t('app', 'Name')?></th>
        <th><?=Yii::t('app', 'Role')?></th>
        <th><?=Yii::t('app', 'Email')?></th>
        <th><?=Yii::t('app', 'Phone')?></th>
        <th class="date-col"><?=Yii::t('app', 'Login Date')?></th>
        <th class="date-col"><?=Yii::t('app', 'Signup Date')?></th>
        <th class="date-col"><?=Yii::t('app', 'Is Active')?></th>
        <?php if ( User::hasPermission([User::ROLE_ADMIN, User::ROLE_FIN, User::ROLE_SALES])) : ?>
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
            canDelete       : <?=( User::hasPermission([User::ROLE_ADMIN]) ? 'true' : 'false')?>,
            canLoginAs      : <?=( User::hasPermission([User::ROLE_ADMIN]) ? 'true' : 'false')?>,
            canEdit         : <?=( User::hasPermission([User::ROLE_ADMIN]) ? 'true' : 'false')?>
        })
    });

</script>