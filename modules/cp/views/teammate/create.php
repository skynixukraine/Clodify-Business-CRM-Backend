<?php
/**
 * Created by PhpStorm.
 * User: olha
 * Date: 14.04.16
 * Time: 13:55
 */
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\User;
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/jquery.dataTables.min.js');
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/dataTables.bootstrap.min.js');
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/jquery.slimscroll.min.js');
$this->params['menu'] = [
    [
        'label' => Yii::t('app', 'Company Teams'),
        'url'   => Url::to(['teammate/index'])
    ]
];
?>
<?php $form = ActiveForm::begin([
    'options' => [
        'class' => 'horizontal'
    ]
]);?>
<?php /** @var $model \app\models\Team*/?>
    <div class="row">
        <div class="col-md-6 box box-primary box-body">
            <div class="form-group">
                <?php echo $form->field( $model, 'name', [

                    'options' => [

                    ]
                ])->textInput(["class" => "form-control"])->label( 'Team name' );?>
            </div>
            <div class="form-group">
                <?php $team_leader = \app\models\User::find()->where(User::tableName() . ".is_delete=0 AND " . User::tableName() . ".is_active=1 AND " .
                    User::tableName() . ".role IN ('" . User::ROLE_PM . "', '" . User::ROLE_DEV . "')")->all();
                $listLeader = \yii\helpers\ArrayHelper::map( $team_leader, 'id', 'first_name' );

                echo $form->field( $model, 'team_leader_id', [

                    'options' => [

                    ]
                ])->dropDownList( $listLeader, ['prompt' => 'Choose...'] )->label('Team Leader');?>
            </div>
            <div class="form-group">
                <?= Html::submitButton( Yii::t('app', 'Save'), ['class' => 'btn btn-primary']) ?>
            </div>
        </div>
    </div>

<?php ActiveForm::end(); ?>
