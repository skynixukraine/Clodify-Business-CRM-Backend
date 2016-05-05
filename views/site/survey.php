<?php
/**
 * Created by PhpStorm.
 * User: lera
 * Date: 05.05.16
 * Time: 10:32
 */
?>
<!DOCTYPE html>
<html>

  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Skynix</title>
    <link rel="stylesheet" href="style/style.css">
    <script src="https://code.jquery.com/jquery-1.12.3.min.js" integrity="sha256-aaODHAgvwQW1bFOGXMeX+pC4PZIPsvn2h1sArYOhgXQ=" crossorigin="anonymous"></script>
    <script src="js/main.js"></script>

  </head>

  <body>
    <section class="survey-wrap">
      <article>
        <header class="question">
          <h1>Чи подобається вам погода в квітні?</h1></header>
        <p> Подумайте про гарні та погані сторони цієї пори, зважте всі за і проти та як омого точніше обиріть один із варіантів.
          <br> Згадайте про перепади температур, та про відключення опалення, а також про гарні сторони коли все розквітає.</p>
      </article>
      <form>
        <fieldset>
          <div>
            <input type="radio" id="radio-1" name="radio" value="Дуже подобається">
            <label class="my-label" for="radio-1"><span>Дуже подобається</span></label>
          </div>
          <div>
            <input type="radio" id="radio-2" name="radio" value="Жахлива пора, бо в мене алергія на квіти">
            <label class="my-label" for="radio-2"><span>Жахлива пора, бо в мене алергія на квіти</span></label>
          </div>
          <div>
            <input type="radio" id="radio-3" name="radio" value="Подобається але могло бути й краще">
            <label class="my-label" for="radio-3"><span>Подобається але могло бути й краще</span></label>
            <div class="tooltip">
              <span class="tooltip-over">?</span>
              <p class="tooltip-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incidiminim veniam, quis</p>
            </div>
          </div>
          <div>
            <input type="radio" id="radio-4" name="radio" value="Не подобається, бо більше незручностей">
            <label class="my-label" for="radio-4"><span>Не подобається, бо більше незручностей</span></label>
          </div>
          <div>
            <input type="radio" id="radio-5" name="radio" value="Я до цього ставлюсь нормально">
            <label class="my-label" for="radio-5"><span>Я до цього ставлюсь нормально</span></label>
            <div class="tooltip">
              <span class="tooltip-over">?</span>
              <p class="tooltip-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incidiminim veniam, quis</p>
            </div>
          </div>
        </fieldset>
        <input type="submit" id="submit" class="sub" value="Проголосувати" disabled>
      </form>
    </section>
  </body>

</html>