<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use app\components\SkynixNavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use app\models\User;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= ($this->title ? Html::encode($this->title) : '') ?> - Skynix Ukraine</title>
    <link rel="icon" type="image/x-icon" href="/img/favicon.ico" />

    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    SkynixNavBar::begin([
        'brandLabel' => Html::img('/img/logo.png', ['alt'=> Yii::$app->params['applicationName'] ]),
        'brandUrl' => Yii::$app->homeUrl,
        'skynixLinks' => '
                        <ul class="nav navbar-nav navbar-right top-right-icon">
                            <li>
                                <a href="https://www.facebook.com/skynix.solutions/" target="_blank" class="ico-facebook"></a>
                            </li>
                            <li>
                                <a href="https://twitter.com/SkynixSolutions" target="_blank" class="ico-twitter"></a>
                            </li>
                           <!-- <li>
                                <a href="#" class="ico-in"></a>
                            </li>-->
                            <li>
                                <a href="http://skynix.solutions" class="ico-search"></a>
                            </li>
                        </ul>
                        ',
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top box-header-menu',
        ],
    ]);

    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right nav menu'],
        'items' => [
            ['label' => 'contact us', 'url' => ['site/contact']],
            ['label' => 'careers', 'url' => ['site/career']],
            ['label' => 'Solutions Store', 'url' => 'https://skynix.solutions'],
            ['label' => 'Blog', 'url' => '/blog'],

        ],
    ]);
    SkynixNavBar::end();
    ?>



    <div class="page">
        <!--<?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>-->
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
            <?= date('Y') ?> All Rights Reserved. Skynix ltd.
        </div>
        <div class="col-lg-2 col-xs-2 link">
            <?php
                if (Yii::$app->user->id != null && User::hasPermission([User::ROLE_DEV, User::ROLE_ADMIN, User::ROLE_PM])):?>
                    <a href="<?=Yii::$app->params['in_site'] . '/cp/index'?>" rel="nofollow">cp</a>
                    <a href="<?=Url::to(['site/logout'])?>" rel="nofollow">log out</a>
                <?php endif;?>
            <?php
                if (Yii::$app->user->id != null && User::hasPermission([User::ROLE_CLIENT, User::ROLE_FIN])):?>
                <a href="<?=Yii::$app->params['in_site'] . '/cp/user/index'?>">cp</a>
                <a href="<?=Url::to(['site/logout'])?>" rel="nofollow">log out</a>
            <?php endif;?>
            <?php
            if (Yii::$app->user->id != null && User::hasPermission([User::ROLE_GUEST])):?>
                <a href="<?=Url::to(['site/logout'])?>" rel="nofollow">log out</a>
            <?php endif;?>
            <?php
            if (Yii::$app->user->id ==null ):?>
                    <a href="<?=Url::to(['site/login'])?>" rel="nofollow">log in</a>

            <?php endif;?>

        </div>
    </div>
</footer>


<?php $this->endBody() ?>
<?php $this->registerJsFile('/js/layouts.js'); ?>
<?php $this->registerJsFile('/js/jquery.cookie.js'); ?>
<?php $this->registerJsFile('/js/jquery.tinycarousel.js'); ?>

<?php $this->registerJs('localStorageModule.storageFunction();'); ?>
<?php $this->registerJsFile('/js/local-storage.js'); ?>

<script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

    ga('create', 'UA-73439606-5', 'auto');
    ga('send', 'pageview');

</script>


</body>
</html>
<?php $this->endPage() ?>
