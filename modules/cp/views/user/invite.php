<?php
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use app\models\User;
/**
 * Created by PhpStorm.
 * User: olha
 * Date: 28.01.16
 * Time: 10:33
 */
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/jquery.dataTables.min.js');
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/dataTables.bootstrap.min.js');
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/jquery.slimscroll.min.js');
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/genPass.js');
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/modal.bootstrap.js');
$this->title                    = Yii::t("app", "Invite User");
$this->params['breadcrumbs'][]  = $this->title;

$this->params['menu'] = [

];
?>

<?php $form = ActiveForm::begin();
/** @var $model User */ ?>
    <?php echo $form->field( $model, 'first_name')
        ->textInput( [ 'class'        => 'form-control',
                     'placeholder'  => 'First name',
        ])-> label( 'First name' );?>

    <?php echo $form->field( $model, 'last_name')
        ->textInput( ['class'   => 'form-control',
                    'placeholder'   => 'Last name'
        ])-> label( 'Last name' );?>

    <?php echo $form->field( $model, 'email')
        ->textInput( ['class'         => 'form-control',
                    'placeholder'   => 'Enter email',
                    'type'          => 'email',
                    'pattern'       => '^([0-9a-zA-Z]([-.w]*[0-9a-zA-Z])*@([0-9a-zA-Z][-w]*[0-9a-zA-Z].)+[a-zA-Z]{2,9})$',
        ])-> label( 'Email' );?>

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-9">
            <?php echo $form->field( $model, 'password',  [

                'template' =>   '{label} ' .
                                '<input class="form-control" placeholder="Enter password" style="display:none">' .
                                '{input}' . '{error}'

            ])->input('password',['class' => 'form-control','placeholder' => 'Enter password'
            ])->label('Password');?>

            </div>
            <div class="col-lg-3">
                <?= Html::button( Yii::t('app', 'Generate'), ['class' => 'btn btn-primary generate']) ?>
            </div>
        </div>
    </div>

    <div>
        <?php echo $form->field($model, 'role')->dropDownList([
            User::ROLE_ADMIN    => 'ADMIN',
            User::ROLE_DEV      => 'DEV',
            User::ROLE_FIN      => 'FIN',
            User::ROLE_CLIENT   => 'CLIENT',
            User::ROLE_PM       => 'PM'
        ],
          ['prompt' => 'Choose...']
        );?>
    </div>
        <div>
            <?= Html::submitButton( Yii::t('app', 'Invite'), ['class' => 'btn btn-primary']) ?>
        </div>
        <script>
            $(function(){inviteModule.init();})
        </script>

<?php ActiveForm::end();?>
