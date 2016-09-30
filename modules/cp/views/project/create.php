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
use yii\helpers\ArrayHelper;
use app\models\Project;
use app\models\User;
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/jquery.dataTables.min.js');
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/dataTables.bootstrap.min.js');
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/jquery.slimscroll.min.js');
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/project.js');
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/check-form.js');
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
<div class="row">
    <div class="col-md-6 box box-primary box-body">
            <div class="form-group">
                <?php echo $form->field( $model, 'name', [

                    'options' => [

                    ]
                ])->textInput(["class" => "form-control", "autocomplete"=>"off"])->label( 'Project name' );?>
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
        <div class = "box">
            <div class = "box-body no-padding">
                <table class = "table load one">
                    <thead>
                    <tr>
                        <th>Assign</th>
                        <th>Invoices Receiver</th>
                        <th>Customer Name</th>
                    </tr>
                    </thead>
                    <?php $customers = User::allCustomers();
                    /** @var  $customers User */
                    foreach($customers as $customer):?>

                        <tbody>
                        <tr>
                            <td><input type="checkbox" title="" name="Project[customers][]"
                                <?=($model->isInCustomers($customer->id))?'checked':''?>  value = "<?=$customer->id?>">
                            </td>
                            <td><input type="radio" title=""  name="Project[invoice_received]"
                                <?=($model->isInvoiced($customer->id))?'checked':''?>  value = "<?=$customer->id?>">
                            </td>
                            <td><?= Html::encode($customer->first_name . ' ' . $customer->last_name)?></td>


                        </tr>
                        </tbody>
                    <?php endforeach;?>
                </table>
            </div>
        </div>
                <div class = "box">
                    <div class = "box-body no-padding">
                        <table class = "table load two">
                            <thead>
                            <tr>
                                <th>Assign</th>
                                <th>Sales</th>
                                <th>PM</th>
                                <th>Developer Name</th>
                                <th class = "alias-name">Alias Name</th>
                            </tr>
                            </thead>
                            <?php $developers = User::allDevelopers();
                            /** @var  $developers User */
                            foreach($developers as $developer):?>

                                <tbody>
                                <tr>
                                    <td><input type="checkbox" title="" name="Project[developers][]"
                                            <?=($model->isInDevelopers($developer->id))
                                                ?'checked':''?> value = "<?=$developer->id?>">
                                    </td>
                                    <td><input type="radio" title=""  name="Project[is_sales]"
                                            <?=($model->isSales($developer->id))
                                                ?'checked':''?>  value = "<?=$developer->id?>">
                                    </td>
                                    <td><input type="radio" title=""  name="Project[is_pm]"
                                            <?=($model->isPm($developer->id))
                                                ?'checked':''?>  value = "<?=$developer->id?>">
                                    </td>
                                    <td><?= Html::encode($developer->first_name . ' ' . $developer->last_name)?></td>
                                    <td>
                                        <?php
                                        if ( User::hasPermission([User::ROLE_ADMIN, User::ROLE_PM, User::ROLE_DEV, User::ROLE_SALES])) {
                                            $users = User::find()->where('role IN ( "' .  User::ROLE_ADMIN . '" , "' .  User::ROLE_PM . '", "'  .  User::ROLE_DEV . '", "'  .  User::ROLE_SALES . '")
                                             AND is_delete=0 AND is_active=1 AND id != ' . $developer->id)->all();
                                            $listUsers = User::getCustomersDropDown( $users, 'id' );
                                            $listUser = ArrayHelper::merge([], $listUsers);
                                            //var_dump($listUser);
                                        }
                                        $model->setAlias(isset($aliases[$developer->id]) ? $aliases[$developer->id] : []);
                                        echo $form->field($model, 'alias')
                                            ->dropDownList( $listUser,  [
                                                'prompt' => 'Not Set',
                                                'name' => "Project[alias][$developer->id]"
                                            ] )
                                            ->label( '' );
                                       // var_dump($developer);die();
                                        ?>
                                    </td>

                                </tr>
                                </tbody>
                            <?php endforeach;?>
                        </table>
                    </div>
                </div>
            <?php endif;?>
            <div>
                <?= Html::submitButton( Yii::t('app', 'Save'), ['class' => 'btn btn-primary']) ?>
            </div>
    </div>
</div>
        <?php ActiveForm::end();?>

<script>
    $(function(){

        $('.date').datepicker({
            format : 'dd/mm/yyyy'
        });
    });
</script>