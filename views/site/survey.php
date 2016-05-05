<?php
/**
 * Created by PhpStorm.
 * User: lera
 * Date: 05.05.16
 * Time: 10:32
 */
?>

<section class = "form-sent">
      <p></p>
    </section>
    <section class="survey-wrap">
      <article>
        <header class="question">
          <h1>Чи подобається вам погода в квітні?</h1></header>
        <p> Подумайте про гарні та погані сторони цієї пори, зважте всі за і проти та як омого точніше обиріть один із варіантів.
          <br> Згадайте про перепади температур, та про відключення опалення, а також про гарні сторони коли все розквітає.</p>
      </article>
      <form method="POST"  >
        <fieldset>
          <div>
             <label class="my-label">
             <input type="radio" name="radio" value="Дуже подобається" >
            <span>Дуже подобається</span>
            </label>
          </div>
          <div>
           
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
            <div class="tooltip">
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
            <div class="tooltip">
              <span class="tooltip-over">?</span>
              <p class="tooltip-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incidiminim veniam, quis</p>
            </div>
          </div>
        </fieldset>
        <input type="submit" id="submit" class="sub" value="Проголосувати" disabled>
        </form>
       
    </section>
     <div class = "loader">
            <img src="/img/495.gif" >
        </div>
  </body>

  <script src="https://code.jquery.com/jquery-1.12.3.min.js" integrity="sha256-aaODHAgvwQW1bFOGXMeX+pC4PZIPsvn2h1sArYOhgXQ=" crossorigin="anonymous"></script>
  <script src="js/main.js"></script>
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

<?php $this->registerJsFile('/js/survey.js'); ?>
<?php $this->registerCssFile('/js/survey.css'); ?>