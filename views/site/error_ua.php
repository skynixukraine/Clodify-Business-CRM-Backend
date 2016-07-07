<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;

$this->title = $name;
?>
<div class="container site-error">



    <div class="alert alert-danger">
        <!--<?= nl2br(Html::encode($message)) ?>-->
    </div>
    <h1><!--<?= Html::encode($this->title) ?>-->Сторінка не знайдена (#404)</h1>

    <p>
        Сталася помилка під час обробки Вашого запиту веб-сервером .
    </p>
    <p>
        Будь ласка, зв’яжіться з нами, якщо Ви думаєте, що це помилка сервера. Дякуємо.
    </p>

</div>
