<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use app\components\Language;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => Yii::$app->params['applicationName'],
        'brandUrl' => Language::getUrl(),
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => [
            ['label' => 'Home', 'url' => Language::getUrl() . '/site/index'],
            ['label' => 'Contact', 'url' => Language::getUrl() . '/site/contact'],
            Yii::$app->user->isGuest ?
                ['label' => 'Login', 'url' =>  Yii::$app->params['in_site'] .'/site/login' ] :
                [
                    'label' => 'Logout (' . Yii::$app->user->identity->first_name . ')',
                    'url' => ['/site/logout'],
                    'linkOptions' => ['data-method' => 'post']
                ],
        ],
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?php if (\Yii::$app->getSession()->hasFlash("success") ) : ?>
            <div class="alert alert-success alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-check"></i><?=Yii::t("app", "Alert")?>!</h4>
                <?=Yii::$app->getSession()->getFlash("success");?>
                <script>
                    setTimeout(function(){$(".alert.alert-success").slideUp()}, 5000);
                </script>
            </div>
        <?php endif; ?>
        <?php if (\Yii::$app->getSession()->hasFlash("error") ) : ?>
            <div class="alert alert-warning alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-check"></i><?=Yii::t("app", "Alert")?>!</h4>
                <?=Yii::$app->getSession()->getFlash("error");?>
                <script>
                    setTimeout(function(){$(".alert.alert-warning").slideUp()}, 5000);
                </script>
            </div>
        <?php endif; ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; Skynix <?= date('Y') ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
