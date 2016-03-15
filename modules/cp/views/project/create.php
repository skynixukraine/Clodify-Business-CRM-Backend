<?php
/**
 * Created by PhpStorm.
 * User: olha
 * Date: 02.02.16
 * Time: 16:18
 */
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets;
use app\models\Project;
use app\models\User;
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/jquery.dataTables.min.js');
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/dataTables.bootstrap.min.js');
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/jquery.slimscroll.min.js');
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/project.js');
$this->title                    = Yii::t("app", $title );
$this->params['breadcrumbs'][]  = $this->title;

$this->params['menu'] = [
    [
        'label' => Yii::t('app', 'Manage Projects'),
        'url'   => Url::to(['project/index'])
    ]
];
?>

<?php $form = ActiveForm::begin([
    'options' => [
        'class' => 'horizontal'
    ]
]);?>
    <div class="form-group">
        <?php echo $form->field( $model, 'name', [

            'options' => [

            ]
        ])->textInput(["class" => "form-control"])->label( 'Project name' );?>
    </div>
    <div class="form-group">
        <?php echo $form->field( $model, 'jira_code', [

            'options' => [

            ]
        ])->textInput(["class" => "form-control"])->label( 'JIRA' );?>
    </div>

    <div class="form-group">
        <?php echo $form->field( $model, 'date_start', [

            'template' => '{label} ' .
                ' <div class="input-group date">{input}' .
                ' <span class="input-group-addon"><i class="fa fa-calendar"></i></span> </div> ' .
                ' {error}'

        ])->textInput( ['class'=>'form-control pull-right active',
            'type'=>'text']);?>


    </div>
    <div class="form-group">
        <?php echo $form->field( $model, 'date_end', [

            'template' => '{label} ' .
                ' <div class="input-group date">{input}' .
                ' <span class="input-group-addon"><i class="fa fa-calendar"></i></span> </div> ' .
                ' {error}'

        ])->textInput( ['class'=>'form-control pull-right active',
            'type'=>'text']);?>
    </div>

    <?php if( $model->status != null ):?>
        <div class="form-group">
            <div>
                <?php echo $form->field($model, 'status')->dropDownList([

                    Project::STATUS_ONHOLD      => 'ONHOLD',
                    Project::STATUS_INPROGRESS  => 'INPROGRESS',
                    Project::STATUS_DONE        => 'DONE',
                    Project::STATUS_CANCELED    => 'CANCELED'
                ],
                    ['prompt' => 'Choose...']
                );?>
            </div>
        </div>
    <?php endif;?>

    <?php if( User::hasPermission([User::ROLE_ADMIN]) ):?>
    <div class="form-group">
        <?php
        $customers = User::allCustomers();
        $listCustomers = \yii\helpers\ArrayHelper::map( $customers, 'id', 'first_name' );
        echo $form->field( $model, 'customers' )
            ->listBox($listCustomers,
                [
                    'multiple'  => "true",
                    'class'     => "form-control"
                ])
            ->label('Clients');
        ?>
    </div>
    <div class="form-group">
        <?php
        $developers = User::allDevelopers();
        $listDevelopers = \yii\helpers\ArrayHelper::map( $developers, 'id', 'first_name' );
        echo $form->field( $model, 'developers' )
            ->listBox($listDevelopers,
                [
                    'multiple'  => "true",
                    'class'     => "form-control"
                ]);
        ?>
    </div>
    <?php endif;?>
    <div>
        <?= Html::submitButton( Yii::t('app', 'Save'), ['class' => 'btn btn-primary']) ?>
    </div>
<?php ActiveForm::end();?>

<script>
    $(function(){

        $('.date').datepicker({
            format : 'dd/mm/yyyy'
        });
    });
</script>