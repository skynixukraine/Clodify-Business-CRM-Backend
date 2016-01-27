<?php
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

?>

<div class="col-md-6" style="float: none">

    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title"><?=Yii::t('app', 'Fill the info below.')?></h3>
        </div><!-- /.box-header -->
        <!-- form start -->

        <?php
        $form = ActiveForm::begin([
            'id' => 'create-user-form',
            'options' => ['enctype' => 'multipart/form-data'],
            'fieldConfig' => [
                'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
                'labelOptions' => ['class' => 'control-label'],
            ],
        ]);
        ?>
        <div class="box-body">

            <div style="display: inline-block">
                <?php $report=\app\models\Report::find()->all();
                $listReport=\yii\helpers\ArrayHelper::map($report, 'id', 'reporter_name');
                echo $form->field($model, 'reporter_name', [
                    'template' => "{label}\n{error}\n{input}\n{hint}",
                    'options' => [
                        'style' => 'width: 300px'
                    ]
                ])->dropDownList($listReport, ['prompt'=>'Choose...']);?>
            </div>

            <div style="display: inline-block">
                <?php echo $form->field($model, 'task', [
                    'template' => "{label}\n{error}\n{input}\n{hint}",
                    'options' => [
                        'style' => 'width: 600px'
                    ]
                ])->textInput( array('data-max-chars' => 500))->label('Text field with task description');?>
            </div>

            <div style="display: inline-block">
                <?php echo $form->field($model, 'hours', [
                    'template' => "{label}\n{error}\n{input}\n{hint}",
                    'options' => [
                        'style' => 'width: 50px'
                    ]
                ])->textInput();?>
            </div>

            <div>
                <?= Html::submitButton('Submit',['class'=>'btn btn-primary'])?>
            </div>

        <?php ActiveForm::end(); ?>

    </div>
</div>
