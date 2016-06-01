<?php
/**
 * Created by PhpStorm.
 * User: olha
 * Date: 26.05.16
 * Time: 17:52
 */
use yii\helpers\Url;
use yii\widgets\ActiveForm;

use app\modules\ExtensionPackager\models\Extension;

//$this->registerJsFile(Yii::$app->request->baseUrl.'/js/modal.bootstrap.js');



$this->title = Yii::t("app", $title );

$this->params['menu'][]  =
    [
        'label' => Yii::t('app', 'Manage Extensions'),
        'url'   => Url::to(['/ExtensionPackager/extension/index'])
    ];
$this->params['breadcrumbs'][]  = $this->title;
?>

<div class="box box-primary">
    <?php $form = ActiveForm::begin(
        [
            'options' => [
                'enctype' => 'multipart/form-data'
            ]
        ]);?>

        <div class="box-body">
            <?php echo $form->field($model, 'name')->textInput();?>
            <?php echo $form->field($model, 'type')->dropDownList([
                Extension::TYPE_EXTENSION    => 'EXTENSION',
                Extension::TYPE_LANGUAGE     => 'LANGUAGE',
                Extension::TYPE_THEME        => 'THEME',
            ],
                ['prompt' => 'Choose a Type']
            );?>
            <?php echo $form->field($model, 'repository')->textInput();?>
            <?php echo $form->field($modelUpload, 'picture')->fileInput()->label('Cover Picture');?>
            <?php echo $form->field($modelUpload, 'license')->fileInput()->label('License');?>
            <?php echo $form->field($modelUpload, 'user_guide')->fileInput()->label('User Guide');?>
            <?php echo $form->field($modelUpload, 'installation_guide')->fileInput()->label('Installation Guide');?>
        </div>

        <div class="box-footer">
            <button type="submit" class="btn btn-primary"><?= Yii::t('app', 'Save')?></button>
        </div>

    <?php $form = ActiveForm::end()?>
</div>

