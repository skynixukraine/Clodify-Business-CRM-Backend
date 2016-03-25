<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

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
        'brandLabel' => Html::img('/img/logo.png', ['alt'=> Yii::$app->params['applicationName'] ]),
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top box-header-menu',
        ],
    ]);

    echo Nav::widget([
        'options' => ['class' => 'collapse navbar-collapse navbar-nav navbar-right nav menu'],
        'items' => [
            ['label' => 'КОНТАКТИ', 'url' => ['/site/index']],
            ['label' => 'КАР\'ЄРА', 'url' => ['/site/login']],
            ['label' => 'МАГАЗИН РІШЕНЬ', 'url' => ['/site/contact']],

        ],
    ]);
    NavBar::end();
    ?>



    <div>
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


<footer class="container">
    <div class="row">
        <div class="col-lg-8 col-lg-offset-2 col-md-8 col-md-offset-2 col-sm-10 col-xs-10 footer-txt">
            <?= date('Y') ?> Усі права захищені. Skynix ltd.
        </div>
        <div class="col-lg-2 col-xs-2 link">
            <a href="login.html">УВІЙТИ</a>
        </div>
    </div>
</footer>


<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
