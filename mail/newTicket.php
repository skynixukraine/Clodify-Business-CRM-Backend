<?php
/**
 * Created by PhpStorm.
 * User: lera
 * Date: 02.06.16
 * Time: 19:24
 */
use yii\helpers\Url;
?>
<?php if($active == 0):?>
    <h1>Your Skynix ticket #<a href="<?=Yii::$app->params['en_site'] . Url::to(['/support/ticket?id=' . $id])?>"><?= $id ?></a></h1>
<?php else: ?>
    <h1>Your Skynix ticket #<a href="<?=Yii::$app->params['en_site'] . Url::to(['/site/login?email=' . $email])?>"><?= $id ?></a></h1>
<?php endif;?>
