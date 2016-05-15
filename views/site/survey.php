<?php
/**
 * Created by PhpStorm.
 * User: lera
 * Date: 05.05.16
 * Time: 10:32
 */
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * @var $survey \app\models\SurveysOption
 * @var $model \app\models\Surveys
 */

$this->title = $model->question;
$canVote     = $model->canVote();
$usersVote   = $model->getUsersVote();
///var_dump($usersVote); exit;
?>

<?php $this->registerJsFile('/js/survey.js', ['depends' => [yii\web\JqueryAsset::className()]]); ?>
<?php $this->registerCssFile('/css/survey.css'); ?>

<section class = "form-sent">
    <p></p>
</section>
<section class="survey-wrap">
    <article>
        <header class="question">
           <h1> <?= Html::encode($model->question)?></h1>
        </header>

        <p><?= nl2br( Html::encode($model->description) )?></p>

    </article>
    <i>(The survey will be closed on <?=date('d M, Y \a\t H:i', strtotime($model->date_end))?> and results will be published on this page)
    <form id='survey-voice'>
    <input type="hidden" name="id" value="<?=$model->id?>">
    <fieldset>
            <?php foreach($model->surveys as $survey):?>
          <div>
             <label class="my-label <?=( $usersVote && $usersVote == $survey->id ? 'checked-radio' : '' )?>">
                 <?=Html::input('radio','answer',$survey->id);?>
                 <span><?=Html::encode($survey->name);?></span>

                 <?php if ( $survey->description ): ?>

                     <div class="tooltip-survey">
                         <span class="tooltip-over">?</span>
                         <p class="tooltip-text">

                             <?=nl2br(Html::encode($survey->description))?>

                         </p>
                     </div>

                 <?php endif;?>
            </label>
          </div>
            <?php endforeach ?>
        </fieldset>
        <?php if ( $canVote ) : ?>
            <input type="submit" id="submit" class="sub" value="Проголосувати" disabled>
        <?php endif;?>
        </form>
       
    </section>
     <div class = "loader">
            <img src="/img/loader.gif" >
     </div>


<?php

if ( $canVote ) {

    $this->registerJs('

          myModule.changeFunction({
            submitUrl : "' . Url::to(['site/submit-survey']) . '"
          });
          myModule.ajaxFormSubmit();
          var myHtml = $("html");

          if (myHtml.width() < 1170) {
            myModule.tooltipSmallScreen();
          }

          if (myHtml.width() > 1170) {
            myModule.tooltipLargeScreen();
          }

    ');

}
