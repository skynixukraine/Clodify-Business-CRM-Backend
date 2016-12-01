<?php
/**
 * Created by PhpStorm.
 * User: olha
 * Date: 22.02.16
 * Time: 16:23
 */
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use app\models\User;
use app\models\Project;
use app\models\ProjectDeveloper;
use app\models\Report;
use app\components\DateUtil;
use kato\DropZone;


$this->registerCssFile(Yii::$app->request->baseUrl.'/css/my-profile.css');
$this->title                    = Yii::t("app", "My Profile");
$this->params['breadcrumbs'][]  = $this->title;
$this->params['menu'] = [
];

?>
<div class="container profile">
    <v class="row">
        <div class="col-lg-12">
            <h1><?=Yii::t('app', 'Profile')?></h1>
        </div>
        <?php $form = ActiveForm::begin(); ?>
                <div class="my-profile-form col-lg-12">
                    <div class="row">
                        <fieldset class = "col-lg-6">
                            <?php /** @var $model User */?>
                            <?php echo $form->field( $user, 'first_name' )->textInput(['readonly' => true]);?>
                            <?php echo $form->field( $user, 'last_name' )->textInput(['readonly' => true]);?>
                        </fieldset>
                        <fieldset class = "col-lg-6">
                            <?php echo $form->field( $user, 'tags' )->textInput(['readonly' => true])->label( 'Your primary skills' );?>
                            <?php echo $form->field( $user , 'about')->textArea(['readonly' => true]);?>
                        </fieldset>
                    </div>
                </div>
        <?php $form = ActiveForm::end(); ?>
    </div>
</div>


</div>