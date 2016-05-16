<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use yii\web\View;
use app\models\User;
use app\models\Team;
$this->registerCssFile(Yii::$app->request->baseUrl.'/css/bootstrap.min.css');
$this->registerCssFile('https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css');
$this->registerCssFile('https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css');
$this->registerCssFile('/css/admin.css');
$this->registerCssFile(Yii::$app->request->baseUrl.'/css/dataTables.bootstrap.css');
$this->registerCssFile(Yii::$app->request->baseUrl.'/css/AdminLTE.min.css');
$this->registerCssFile(Yii::$app->request->baseUrl.'/css/_all-skins.min.css');
$this->registerCssFile(Yii::$app->request->baseUrl.'/css/datepicker.css');
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/jQuery-2.1.4.min.js', array('position'  => View::POS_BEGIN));
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/jquery.cookie.js', array('position'  => View::POS_BEGIN));
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/bootstrap.min.js', array('position'  => View::POS_BEGIN));
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/bootstrap-datepicker.js', array('position'  => View::POS_BEGIN));
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/app.js');

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) . ' - ' . Yii::$app->params['applicationName']?></title>
    <?php $this->head() ?>
    <link rel="icon" type="image/x-icon" href="/img/favicon.ico" />
</head>
<body>
<body class="skin-blue sidebar-mini">
<?php $this->beginBody() ?>
<div class="wrapper">

    <header class="main-header">
        <!-- Logo -->
        <a href="<?=Url::to("/cp")?>" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini"><b>FPP</b></span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg"><?= Html::img('/img/skynix-logo-white.png')?></span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>
            <?php if( Yii::$app->request->cookies['admin'] ):?>
                <div style="float: right; padding-right: 10px;padding-top: 10px;">
                    <?php echo Html::a('Login Back', ['user/loginback'], ['class' => 'btn btn-block btn-default']);?>
                </div>
            <?php endif;?>

            <?php if ( isset( $this->params['menu'] ) && count($this->params['menu']) ) :?>

                <ul class="nav navbar-nav">

                    <?php foreach ( $this->params['menu'] as $item ) : ?>
                        <li <?=isset($item['active']) ? 'class="active"':''?>><a href="<?=$item['url'];?>"><?= $item['label'] ?> <span class="sr-only"></span></a></li>
                    <?php endforeach;?>
                </ul>

            <?php endif;?>
            

            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">

                    <!-- User Account: style can be found in dropdown.less -->
                    <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <img src="/img/avatar.png" class="user-image" alt="User Image"/>
                            <span class="hidden-xs"><?=Yii::$app->user->identity->first_name . " " . Yii::$app->user->identity->last_name?></span>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- User image -->
                            <li class="user-header">
                                <img src="/img/avatar.png" class="img-circle" alt="User Image" />
                                <p>
                                    <?=Yii::$app->user->identity->first_name . " " . Yii::$app->user->identity->last_name?>
                                    <small><?=Yii::t('app', 'Member since')?> <?=date("d M.Y", strtotime(Yii::$app->user->identity->date_signup))?></small>
                                </p>
                            </li>
                            <!-- Menu Footer-->
                            <li class="user-footer">
                                <div class="pull-right">
                                        <a href="<?=Url::to("/site/logout")?>" class="btn btn-default btn-flat"><?=Yii::t('app', 'Sign out')?></a>
                                </div>
                            </li>
                        </ul>
                    </li>

                </ul>
            </div>
        </nav>
    </header>
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
            <!-- Sidebar user panel -->
            <div class="user-panel">
                <div class="pull-left image">
                    <img src="/img/avatar.png" class="img-circle" alt="<?=Yii::t('app', 'User Image')?>" />
                </div>
                <div class="pull-left info" style="word-break: break-all; position: relative; float: left !important; width: 78%; left: 0;">
                    <p style="white-space: normal !important"><?=Yii::$app->user->identity->first_name?></p>
                    <p style="white-space: normal !important"><?= Yii::$app->user->identity->last_name?></p>

                    <a href="#"><i class="fa fa-circle text-success"></i> <?=Yii::t('app', 'Online')?></a>
                </div>
            </div>
            <!-- sidebar menu: : style can be found in sidebar.less -->
            <ul class="sidebar-menu">
                <li class="header"><?=Yii::t('app', 'MAIN NAVIGATION')?></li>
                <?php if ( User::hasPermission([User::ROLE_DEV, User::ROLE_ADMIN, User::ROLE_PM])) : ?>
                <li class="treeview<?=( Yii::$app->controller->id == "index" || Yii::$app->controller->id == "index" ? " active" : "")?>">
                    <a href="<?=Url::to(['index/index']);?>">
                        <i class="fa fa-home"></i> <span><?=Yii::t('app', "My Report")?></span>
                    </a>
                </li>
                <?php endif;?>

                <?php if ( User::hasPermission([User::ROLE_ADMIN, User::ROLE_PM, User::ROLE_CLIENT, User::ROLE_FIN])) : ?>
                <li class="treeview<?=( Yii::$app->controller->id == "user" ? " active" : "")?>">
                      <a href="<?=Url::to(['user/index']);?>">
                        <i class="fa fa-users"></i> <span><?=Yii::t('app', 'Manage Users')?></span>
                    </a>
                </li>
                <?php endif;?>

                <?php if ( User::hasPermission([User::ROLE_ADMIN, User::ROLE_CLIENT, User::ROLE_FIN, User::ROLE_DEV, User::ROLE_PM])) : ?>
                <li class="treeview<?=( Yii::$app->controller->id == "teammate" ? " active" : "")?>">
                    <a href="<?=Url::to(['teammate/index']);?>">
                        <i class="fa fa-wechat"></i> <span><?=Yii::t('app', 'Company Teams ')?></span>
                    </a>
                </li>
                <?php endif;?>

                <?php if ( User::hasPermission([User::ROLE_DEV, User::ROLE_PM]) && Team::hasTeam(Yii::$app->user->id) ) : ?>
                <li class="treeview<?=( Yii::$app->controller->id == "teams" ? " active" : "")?>">
                        <a href="<?=Url::to(['teams/index']);?>">
                            <i class="fa fa-users"></i> <span><?=Yii::t('app', 'My Team')?></span>
                        </a>
                </li>
                <?php endif;?>

                <?php if ( User::hasPermission([User::ROLE_ADMIN, User::ROLE_PM, User::ROLE_CLIENT, User::ROLE_FIN])) : ?>
                <li class="treeview<?=( Yii::$app->controller->id == "project" ? " active" : "")?>">
                    <a href="<?=Url::to(['project/index']);?>">
                        <i class="fa fa-edit"></i> <span><?=Yii::t('app', 'Manage Projects')?></span>
                    </a>
                </li>
                <?php endif;?>
                <?php if ( User::hasPermission([User::ROLE_ADMIN, User::ROLE_PM, User::ROLE_CLIENT, User::ROLE_FIN])) : ?>
                <li class="treeview<?=( Yii::$app->controller->id == "report" ? " active" : "")?>">
                    <a href="<?=Url::to(['report/index']);?>">
                        <i class="fa fa-puzzle-piece"></i> <span><?=Yii::t('app', 'Reports')?></span>
                    </a>
                </li>
                <?php endif;?>
                <?php if ( User::hasPermission([User::ROLE_ADMIN, User::ROLE_FIN, User::ROLE_CLIENT])) : ?>
                <li class="treeview<?=( Yii::$app->controller->id == "invoice" ? " active" : "")?>">
                    <a href="<?=Url::to(['invoice/index']);?>">
                        <i class="fa fa-money"></i> <span>Invoices</span>
                    </a>
                </li>
                <?php endif;?>
                <?php if ( User::hasPermission([User::ROLE_ADMIN, User::ROLE_DEV, User::ROLE_PM, User::ROLE_CLIENT, User::ROLE_FIN])) : ?>
                    <li class="treeview<?=( Yii::$app->controller->id == "surveys" ? " active" : "")?>">
                        <a href="<?=Url::to(['surveys/index']);?>">
                            <i class="fa  fa-question"></i> <span>Manage Surveys</span>
                        </a>
                    </li>
                <?php endif;?>
                <?php if ( User::hasPermission([User::ROLE_ADMIN, User::ROLE_DEV, User::ROLE_PM, User::ROLE_CLIENT, User::ROLE_FIN])) : ?>
                    <li class="treeview<?=( Yii::$app->controller->id == "setting" ? " active" : "")?>">
                        <a href="<?=Url::to(['setting/index']);?>">
                            <i class="fa fa-gears"></i> <span>My Profile</span>
                        </a>
                    </li>
                <?php endif;?>
                <?php if ( User::hasPermission([User::ROLE_ADMIN])) : ?>
                    <li class="treeview<?=( Yii::$app->controller->id == "tool" ? " active" : "")?>">
                        <a href="<?=Url::to(['tool/emailtester']);?>">
                            <i class="fa fa-mail-forward"></i> <span>Email Tester</span>
                        </a>
                    </li>
                <?php endif;?>
            </ul>
        </section>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                <?=$this->title?>
            </h1>
            <?php
                $links = isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [];
                array_unshift($links, array(
                        "url"       => Url::to("/cp"),
                        "label"     => Yii::t("app", "Cp")));
                echo Breadcrumbs::widget([
                'links' => $links,
                'tag'     => 'ol'
            ]) ?>
        </section>

        <!-- Main content -->
        <section class="content">
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
            <?=$content?>
        </section><!-- /.content -->
    </div><!-- /.content-wrapper -->
    <footer class="main-footer">
        <div class="pull-right hidden-xs">
            <b>Version</b> 1.2
        </div>
        <strong><?=Yii::t('app', 'Copyright')?> &copy; <?=date("Y")?> <?=Yii::t('app', 'Skynix Ltd. All rights reserved.')?>
    </footer>

    <div class='control-sidebar-bg'></div>
</div><!-- ./wrapper -->
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
