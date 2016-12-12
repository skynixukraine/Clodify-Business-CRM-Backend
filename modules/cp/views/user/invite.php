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
    <div class="row">
        <div class="col-md-6 box box-primar box-body">
            <div>
                <?php echo $form->field($model, 'role')->dropDownList([
                    User::ROLE_ADMIN    => 'ADMIN',
                    User::ROLE_DEV      => 'DEV',
                    User::ROLE_FIN      => 'FIN',
                    User::ROLE_CLIENT   => 'CLIENT',
                    User::ROLE_PM       => 'PM',
                    User::ROLE_SALES    => 'SALES',
                ],
                    ['prompt' => 'Choose...']
                );?>
            </div>
            <?php echo $form->field( $model, 'first_name')
                ->textInput( [ 'class'        => 'form-control',
                               'placeholder'  => 'First name',
                ])-> label( 'First name' );?>

            <?php echo $form->field( $model, 'last_name')
                ->textInput( ['class'   => 'form-control',
                              'placeholder'   => 'Last name',
                ])-> label( 'Last name' );?>
            <?php echo $form->field( $model, 'middle_name')
                ->textInput( ['class'   => 'form-control',
                    'placeholder'   => 'Middle name',
                ])-> label( 'Middle name' );?>
            <?php echo $form->field( $model, 'company')
                ->textInput( [ 'class'        => 'form-control',
                    'placeholder'  => 'Company',
                ])-> label( 'Company' );?>

            <?php echo $form->field( $model, 'email')
                ->textInput( ['class'       => 'form-control',
                              'placeholder'   => 'Enter email',
                              'type'          => 'email',
                ])-> label( 'Email' );?>
            <?php echo $form->field( $model, 'phone')->textInput(["class" => "form-control"])->label( 'Phone' );?>
            <?php echo $form->field( $model, 'salary')->textInput(["class" => "form-control"])->label( 'Salary' );?>
            <div>
                <?= Html::submitButton( Yii::t('app', 'Invite'), ['class' => 'btn btn-primary']) ?>
            </div>
        </div>
    </div>

<?php ActiveForm::end();?>

