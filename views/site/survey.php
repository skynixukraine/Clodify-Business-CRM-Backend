<?php
/**
 * Created by PhpStorm.
 * User: lera
 * Date: 05.05.16
 * Time: 10:32
 */
use yii\widgets\ActiveForm;
use yii\helpers\Html;
?>

<!-- <?php $this->registerJsFile('/js/jQuery-2.1.4.min.js'); ?> -->
<?php $this->registerJsFile('/js/survey.js'); ?>
<?php $this->registerCssFile('/css/survey.css'); ?>

<?php $form = ActiveForm::begin(['options' => [
            'class' => 'horizontal',
            'id'=>'survey-voice',
        ]]);?>
<section class = "form-sent">
      <p></p>
    </section>
    <section class="survey-wrap">
      <article>
        <header class="question">

          <!--<h1>Чи подобається вам погода в квітні?</h1>-->
           <h1> <?= Html::encode($model->question)?>?</h1>
            <!--<h1>
               <?php /*echo $form->field( $model, 'question' )
                    ->template([])
                    ->label(false);*/?>?
            </h1>-->
        </header>
          <div class="row">
              <div class="col-md-12">
                <p style="word-break: break-all;"><?= Html::encode($model->description)?></p>
              </div>
          </div>
      </article>
        <fieldset>
            <?php foreach($model->surveys as $survey):?>
          <div>
             <label class="my-label">
                 <?php
                 echo Html::input('radio','answer',$survey->id);
                 echo $survey->name;
                  ?>
             <!--<input type="radio" name="radio" value="Дуже подобається" >-->
            <!--<span>Дуже подобається</span>-->
            </label>
          </div>
            <?php endforeach ?>
         <!-- <div>

            <label class="my-label">
            <input type="radio"  name="radio" value="Жахлива пора, бо в мене алергія на квіти" >
            <span>Жахлива пора, бо в мене алергія на квіти</span>
            </label>
          </div>
          <div>

            <label class="my-label" >
           <input type="radio"  name="radio" value="Подобається але могло бути й краще" >
            <span>Подобається але могло бути й краще</span>
            </label>
            <div class="tooltip-survey">
              <span class="tooltip-over">?</span>
              <p class="tooltip-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incidiminim veniam, quis</p>
            </div>
          </div>
          <div>

            <label class="my-label">
            <input type="radio" name="radio" value="Не подобається, бо більше незручностей" >
            <span>Не подобається, бо більше незручностей</span>
            </label>
          </div>
          <div>

            <label class="my-label">
            <input type="radio" name="radio" value="Я до цього ставлюсь нормально" >
            <span>Я до цього ставлюсь нормально</span>
            </label>
            <div class="tooltip-survey">
              <span class="tooltip-over">?</span>
              <p class="tooltip-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incidiminim veniam, quis</p>
            </div>
          </div>-->
        </fieldset>
        <input type="submit" id="submit" class="sub" value="Проголосувати" disabled>

       
    </section>
     <div class = "loader">
            <img src="/img/loader.gif" >
        </div>

<?php ActiveForm::end();?>

   <script src="https://code.jquery.com/jquery-1.12.3.min.js" integrity="sha256-aaODHAgvwQW1bFOGXMeX+pC4PZIPsvn2h1sArYOhgXQ=" crossorigin="anonymous"></script>
  <script>
    $(function() {

  myModule.changeFunction();
  myModule.ajaxFormSubmit();
  var myHtml = $("html");

  if (myHtml.width() < 1170) {
    myModule.tooltipSmallScreen();
  }

  if (myHtml.width() > 1170) {
    myModule.tooltipLargeScreen();
  }

})
  </script>

