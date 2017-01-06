<?php
/**
 * Created by PhpStorm.
 * User: valer
 * Date: 10.10.2016
 * Time: 22:32
 */

use yii\helpers\Url;
use app\models\User;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets;
$this->title = Yii::t('app', 'Update the user #{0}', [$model->id]);
$this->params['breadcrumbs'][]  = $this->title;
if( User::hasPermission( [User::ROLE_ADMIN] ) ) {
    $this->params['menu'] = [
        [
            'label' => Yii::t('app', 'Manage Users'),
            'url' => Url::to(['user/index'])
        ]
    ];
}
/** @var $model User */
?>
<?php $form = ActiveForm::begin([
    'options' => [
        'class' => 'horizontal'
    ]
]);?>

    <div class="form-group">
        <?php echo $form->field( $model, 'first_name')->textInput(["class" => "form-control"])->label( 'First Name' );?>
        <?php echo $form->field( $model, 'last_name')->textInput(["class" => "form-control"])->label( 'Last Name' );?>
        <?php echo $form->field( $model, 'middle_name')->textInput(["class" => "form-control"])->label( 'Middle Name' );?>
        <?php echo $form->field( $model, 'company')->textInput(["class" => "form-control"])->label( 'Company' );?>
        <?php echo $form->field( $model, 'salary', ['inputOptions' => ['autocomplete' => 'off']])->textInput(["class" => "form-control"])->label( 'Salary' );?>
        <?php echo $form->field( $model, 'password', ['inputOptions' => ['autocomplete' => 'off']])->passwordInput(["class" => "form-control", 'value' => ''])->label( 'Password' );?>


        <?php echo $form->field($model, 'role')->dropDownList([

            User::ROLE_ADMIN      => 'ADMIN',
            User::ROLE_CLIENT  => 'CLIENT',
            User::ROLE_DEV        => 'DEV',
            User::ROLE_FIN    => 'FIN',
            User::ROLE_PM   => 'PM',
            User::ROLE_SALES =>'SALES',
        ],
            ['prompt' => 'Choose...']
        );?>
        <?php echo $form->field( $model, 'email')->textInput(["class" => "form-control"])->label( 'Email' );?>
        <?php echo $form->field( $model, 'phone')->textInput(["class" => "form-control"])->label( 'Phone' );?>

        <div>
            <?= Html::submitButton( Yii::t('app', 'Save'), ['class' => 'btn btn-primary']) ?>
        </div>
    </div>
<?php ActiveForm::end();?>

