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
    <h1><!--<?= Html::encode($this->title) ?>-->Страница не найдена (#404)</h1>

    <p>
        Сталася помилка під час вище веб-сервер обробки вашого запиту.
    </p>
    <p>
        Будь ласка, зв'яжіться з нами, якщо ви думаєте, що це помилка сервера. Дякую.
    </p>

</div>
