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
        <!--<nav class="navbar navbar-static-top" role="navigation">-->
        <nav class="navbar navbar-static-top">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>
            <?php if( Yii::$app->request->cookies['admin'] ):?>
                <div style="float: right; padding-right: 10px;padding-top: 10px;">
                    <?php
                    if ($_SERVER['REQUEST_URI'] == '/ExtensionPackager/extension/index') {
                        echo Html::a('Login Back', ['/cp/user/loginback'], ['class' => 'btn btn-block btn-default']);;
                    } else {
                        echo Html::a('Login Back', ['user/loginback'], ['class' => 'btn btn-block btn-default']);
                    }
                    ?>
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

                            <?php if (Yii::$app->user->identity->photo != null):?>
                                <img src="<?=urldecode( Url::to (['/cp/index/getphoto', 'entry'=>Yii::getAlias('@app').
                                    '/data/'.Yii::$app->user->id.'/photo/'.Yii::$app->user->identity->photo ]))?>" class="user-image" alt="User Image"/>
                            <?php else:?>
                                 <img src="/img/avatar.png" class="user-image" alt="User Image"/>
                            <?php endif;?>
                            <span class="hidden-xs"><?=Yii::$app->user->identity->first_name . " " . Yii::$app->user->identity->last_name?></span>

                        </a>
                        <ul class="dropdown-menu">
                            <!-- User image -->
                            <li class="user-header">
                                <?php if (Yii::$app->user->identity->photo != null):?>
                                    <img src="<?=urldecode( Url::to (['/cp/index/getphoto', 'entry'=>Yii::getAlias('@app').
                                    '/data/'.Yii::$app->user->id.'/photo/'.Yii::$app->user->identity->photo ]))?>" class="img-circle" style="max-width: 100px; height: 100px;" alt="User Image" />
                                <?php else:?>
                                    <img src="/img/avatar.png" class="img-circle" style="max-width: 100px; height: 100px;" alt="User Image" />
                                <?php endif;?>
                                <p>
                                    <?=Yii::$app->user->identity->first_name . " " . Yii::$app->user->identity->last_name?>
                                    <?php if (Yii::$app->user->identity->photo != null):?>
                                         <small><?=Yii::t('app', 'Member since')?> <?=date("d M.Y", strtotime(Yii::$app->user->identity->date_signup))?></small>
                                    <?php else:?>
                                        <small><?=Yii::t('app', 'Member since')?> <?=date("d M.Y", strtotime(Yii::$app->user->identity->date_signup))?></small>
                                    <?php endif;?>
                                </p>
                            </li>
                            <!-- Menu Footer-->
                            <li class="user-footer">
                                <div class="pull-right">
                                        <a href="<?=Url::to(["/site/logout"])?>" class="btn btn-default btn-flat"><?=Yii::t('app', 'Sign out')?></a>
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
                    <?php if (Yii::$app->user->identity->photo != null):?>
                    <img src="<?=urldecode( Url::to (['/cp/index/getphoto', 'entry'=>Yii::getAlias('@app').
                        '/data/'.Yii::$app->user->id.'/photo/'.Yii::$app->user->identity->photo ]))?>" class="img-circle" style="max-width: 100px; height: 100px;" alt="<?=Yii::t('app', 'User Image')?>" />
                    <?php else:?>
                    <img src="/img/avatar.png" class="img-circle" style="max-width: 100px; height: 100px;" alt="<?=Yii::t('app', 'User Image')?>" />
                    <?php endif?>
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
                    <a href="<?=Url::to(['/cp/index/index']);?>">
                        <i class="fa fa-home"></i> <span><?=Yii::t('app', "My Report")?></span>
                    </a>
                </li>
                <?php endif;?>

                <?php if ( User::hasPermission([User::ROLE_ADMIN, User::ROLE_PM, User::ROLE_CLIENT, User::ROLE_FIN, User::ROLE_SALES])) : ?>
                <li class="treeview<?=( Yii::$app->controller->id == "user" ? " active" : "")?>">
                      <a href="<?=Url::to(['/cp/user/index']);?>">
                        <i class="fa fa-users"></i> <span><?=User::hasPermission([User::ROLE_SALES]) ? Yii::t('app', 'Developers') : Yii::t('app', 'Manage Users')?></span>
                    </a>
                </li>
                <?php endif;?>

                <?php if ( false && User::hasPermission([User::ROLE_ADMIN, User::ROLE_CLIENT, User::ROLE_FIN, User::ROLE_DEV, User::ROLE_PM])) : ?>
                <li class="treeview<?=( Yii::$app->controller->id == "teammate" ? " active" : "")?>">
                    <a href="<?=Url::to(['/cp/teammate/index']);?>">
                        <i class="fa fa-wechat"></i> <span><?=Yii::t('app', 'Company Teams ')?></span>
                    </a>
                </li>
                <?php endif;?>

                <?php  if ( false && User::hasPermission([User::ROLE_DEV, User::ROLE_PM]) && Team::hasTeam(Yii::$app->user->id) ) : ?>
                <li class="treeview<?=( Yii::$app->controller->id == "teams" ? " active" : "")?>">
                        <a href="<?=Url::to(['/cp/teams/index']);?>">
                            <i class="fa fa-users"></i> <span><?=Yii::t('app', 'My Team')?></span>
                        </a>
                </li>
                <?php endif;?>

                <?php if ( User::hasPermission([User::ROLE_ADMIN, User::ROLE_PM, User::ROLE_CLIENT, User::ROLE_FIN,  User::ROLE_SALES])) : ?>
                <li class="treeview<?=( Yii::$app->controller->id == "project" ? " active" : "")?>">
                    <a href="<?=Url::to(['/cp/project/index']);?>">
                        <i class="fa fa-edit"></i> <span><?=User::hasPermission([User::ROLE_SALES]) ? Yii::t('app', 'Projects') : Yii::t('app', 'Manage Projects')?></span>
                    </a>
                </li>
                <?php endif;?>
                <?php if ( User::hasPermission([User::ROLE_ADMIN, User::ROLE_PM, User::ROLE_CLIENT, User::ROLE_FIN, User::ROLE_SALES])) : ?>
                <li class="treeview<?=( Yii::$app->controller->id == "report" ? " active" : "")?>">
                    <a href="<?=Url::to(['/cp/report/index']);?>">
                        <i class="fa fa-puzzle-piece"></i> <span><?=Yii::t('app', 'Reports')?></span>
                    </a>
                </li>
                <?php endif;?>
                <?php if ( User::hasPermission([User::ROLE_ADMIN, User::ROLE_FIN, User::ROLE_CLIENT, User::ROLE_SALES])) : ?>
                <li class="treeview<?=( Yii::$app->controller->id == "invoice" ? " active" : "")?>">
                    <a href="<?=Url::to(['/cp/invoice/index']);?>">
                        <i class="fa fa-money"></i> <span>Invoices</span>
                    </a>
                </li>
                <?php endif;?>
                <?php if ( User::hasPermission([User::ROLE_ADMIN, User::ROLE_DEV, User::ROLE_PM, User::ROLE_CLIENT, User::ROLE_FIN, User::ROLE_SALES])) : ?>
                    <li class="treeview<?=( Yii::$app->controller->id == "surveys" ? " active" : "")?>">
                        <a href="<?=Url::to(['/cp/surveys/index']);?>">
                            <i class="fa  fa-question"></i> <span>Manage Surveys</span>
                        </a>
                    </li>
                <?php endif;?>
                <?php if ( User::hasPermission([User::ROLE_ADMIN, User::ROLE_SALES])) : ?>
                    <li class="treeview<?=( Yii::$app->controller->id == "extension" ? " active" : "")?>">
                        <a href="<?=Url::to(['/ExtensionPackager/extension/index']);?>">
                            <i class="fa fa-file-text-o"></i> <span>Manage Extensions</span>
                        </a>
                    </li>
                <?php endif;?>
                <?php if ( User::hasPermission([User::ROLE_ADMIN, User::ROLE_DEV, User::ROLE_PM, User::ROLE_CLIENT, User::ROLE_FIN, User::ROLE_SALES])) : ?>
                    <li class="treeview<?=( Yii::$app->controller->id == "setting" ? " active" : "")?>">
                        <a href="<?=Url::to(['/cp/setting/index']);?>">
                            <i class="fa fa-gears"></i> <span>My Profile</span>
                        </a>
                    </li>
                <?php endif;?>
                <?php if ( User::hasPermission([User::ROLE_ADMIN, User::ROLE_PM, User::ROLE_DEV, User::ROLE_SALES, User::ROLE_CLIENT, User::ROLE_FIN])) : ?>
                    <li class="treeview<?=( Yii::$app->controller->id == "tool" ? " active" : "")?>">
                        <a href="<?=Url::to(['/cp/tool/emailtester']);?>">
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
            <b>Version</b> <?=Yii::$app->params['version']?>
        </div>
        <strong><?=Yii::t('app', 'Copyright')?> &copy; <?=date("Y")?> <?=Yii::t('app', 'Skynix Ltd. All rights reserved.')?>
    </footer>

    <div class='control-sidebar-bg'></div>
</div><!-- ./wrapper -->
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
