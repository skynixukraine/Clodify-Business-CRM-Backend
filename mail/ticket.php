<?php
/**
 * Created by PhpStorm.
 * User: lera
 * Date: 02.06.16
 * Time: 19:24
 */
use yii\helpers\Url;
?>
<h1>New Ticket #<a href="<?=Yii::$app->params['url_crm'] . Url::to(['/site/login', 'ticket' => $id])?>"><?= $id ?></a></h1>
