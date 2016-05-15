<?php
/**
 * Created by WebAIS Company.
 * URL: webais.company
 * Developer: alekseyyp
 * Date: 01.02.16
 * Time: 12:10
 */

use yii\widgets\ActiveForm;
use yii\helpers\Html;

$this->title                    = Yii::t("app", "Email Tester Tool");
$this->params['breadcrumbs'][]  = $this->title;

$this->params['menu'] = [

];
?>


<?php $form = ActiveForm::begin();?>

<?php echo $form->field( $model, 'email')
                    ->textInput( ['class'   => 'form-control']);?>


<?php echo $form->field( $model, 'subject')
    ->textInput( ['class'   => 'form-control']);?>


<?php echo $form->field( $model, 'body')
    ->textarea( [ 'class'   => 'form-control']);?>


<?php echo $form->field( $model, 'textbody')
    ->textarea([ 'class'   => 'form-control']);?>



<div>
    <?= Html::submitButton( Yii::t('app', 'Send'), ['class' => 'btn btn-primary']) ?>
</div>

<?php ActiveForm::end();?>

