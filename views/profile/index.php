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
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/jquery.dataTables.min.js');
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/dataTables.bootstrap.min.js');
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/jquery.slimscroll.min.js');
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/modal.bootstrap.js');
// $this->registerJsFile(Yii::$app->request->baseUrl.'/js/dropzone.js');
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/myprofile.js');
$this->registerCssFile(Yii::$app->request->baseUrl.'/css/my-profile.css');
$this->title                    = Yii::t("app", "My Profile");
$this->params['breadcrumbs'][]  = $this->title;
$this->params['menu'] = [
];

var_dump($user->first_name);
?>
<?php $form = ActiveForm::begin(); ?>
<div class="tab-content">
    <div id="tab_1" class="tab-pane active col-xs-12">
        <div class="my-profile-form col-sm-12">
            <div class="row">
                <fieldset class = "col-sm-6">
                    <?php /** @var $model User */?>
                    <?php echo $form->field( $user, 'first_name' )->textInput(['readonly' => true]);?>
                    <?php echo $form->field( $user, 'last_name' )->textInput(['readonly' => true]);?>
                </fieldset>
                <fieldset class = "col-sm-6">
                    <?php echo $form->field( $user, 'tags' )->textInput(['readonly' => true])->label( 'Your primary skills' );?>
                    <?php echo $form->field( $user , 'about')->textArea(['readonly' => true]);?>
                </fieldset>
            </div>
        </div>
    </div>
</div>


