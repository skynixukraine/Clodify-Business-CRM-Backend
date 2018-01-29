<?php
use yii\bootstrap\ActiveForm;
use app\models\Story;
use yii\helpers\Url;

/* @var $model \app\models\Story */
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
                <div class="form-group">
                    <?= $form->field($model, 'first_name', [
                        'template' => "{label}\n{error}\n{input}\n{hint}",
                        'options'   => [
                        ]
                    ])->textInput( array('class' => 'field-size form-control', 'data-max-chars'    => 150 ) ) ?>
                </div>
                <div class="form-group">
                    <?= $form->field($model, 'last_name', [
                        'template' => "{label}\n{error}\n{input}\n{hint}",
                        'options'   => [
                        ]
                    ])->textInput( array('class' => 'field-size form-control', 'data-max-chars'    => 150 ) ) ?>
                </div>
                <div class="form-group">
                    <?= $form->field($model, 'phone', [
                        'template' => "{label}\n{error}\n{input}\n{hint}",
                        'options'   => [
                        ]
                    ])->textInput( array('class' => 'field-size form-control', 'data-max-chars'    => 150 ) ) ?>
                </div>
                <div class="form-group">
                    <?= $form->field($model, 'email', [
                        'template' => "{label}\n{error}\n{input}\n{hint}",
                        'options'   => [
                        ]
                    ])->textInput( array('class' => 'field-size form-control', 'data-max-chars'    => 150 ) ) ?>
                </div>
                <div class="form-group">
                    <?= $form->field($model, 'location', [
                        'template' => "{label}\n{error}\n{input}\n{hint}",
                        'options'   => [
                        ]
                    ])->textInput( array('class' => 'field-size form-control', 'data-max-chars'    => 255 ) ) ?>
                </div>
            </div><!-- /.box-body -->

            <div class="box-footer">
                <button type="submit" class="btn btn-primary"><?=Yii::t('app', 'Submit')?></button>
            </div>
        <?php ActiveForm::end(); ?>

    </div>
</div>
<?php

  //  $this->registerCssFile(Yii::$app->request->baseUrl.'/css/bootstrap.min.css');
   // $this->registerJsFile('/js/bootstrap.min.js');
    //$this->registerJsFile('/js/modal.bootstrap.js');

    $this->registerJsFile('/js/jquery.field-size.js');
?>
