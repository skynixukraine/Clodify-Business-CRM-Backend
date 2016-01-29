<?php
use yii\helpers\Url;
use yii\helpers\Html;
use app\models\User;
/**
 * Created by PhpStorm.
 * User: olha
 * Date: 29.01.16
 * Time: 9:27
 */
/** @var  $model User */
?>

<h1>Hello, <?= $user?>,</h1><br>
<h2>Welcome to Skynix company!</h2><br>
<h2><?= $adminName?> has invited you to the time tracking system.</h2><br>
<h2>Your login is <?= $email?></h2><br>
<h2>Your password is <?= $password?></h2><br>
<h2>To start using time tracking system please click this <a href=<?= Url::to(['/site/invite', 'hash' => $hash], true)?>>link</a></h2><br>