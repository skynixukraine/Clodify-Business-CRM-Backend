<?php
/**
 * Created by PhpStorm.
 * User: olha
 * Date: 22.02.16
 * Time: 16:23
 */
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use app\models\User;
use app\models\Project;
use app\models\ProjectDeveloper;
use app\models\Report;
use app\components\DateUtil;
use kato\DropZone;

$this->title  = Yii::t("app", "Profile");
?>
<div class="container profile-page">
    <div class="row">
        <div class="col-lg-12">
            <h1><?=Yii::t('app', 'Profile')?></h1>
        </div>
    </div>
    <div class="row profile-image">
        <div class="im-centered">
            <div class="col-lg-12">
                <?php if ($user->photo != null):?>
                    <img src="<?=urldecode( Url::to (['/cp/index/getphoto', 'entry'=>Yii::getAlias('@app').
                        '/data/'.$user->id.'/photo/'.$user->photo ]))?>" class="img-circle" style="max-width: 100px; height: 100px;" alt="<?=Yii::t('app', 'User Image')?>" />
                <?php else:?>
                    <img src="/img/avatar.png" class="img-circle" style="max-width: 100px; height: 100px;" alt="<?=Yii::t('app', 'User Image')?>" />
                <?php endif?>
            </div>
        </div>
    </div>
    <div class="row">
            <div class="col-lg-6  left-panel">
                <article >
                     First name :
                </article>
            </div>
            <div class="col-lg-6  right-panel">
                <article>
                     <?php echo $user->first_name ?>
                </article>
            </div>
    </div>
    <div class="row">
        <div class="col-lg-6  left-panel">
            <article >
                Last name :
            </article>
        </div>
        <div class="col-lg-6  right-panel">
            <article>
                <?php echo $user->last_name ?>
            </article>
        </div>
    </div>
<?php if($user->tags) { ?>
    <div class="row">
        <div class="col-lg-6  left-panel">
            <article >
                Primary skills :
            </article>
        </div>
        <div class="col-lg-6  right-panel">
            <article>
                <?php echo $user->tags ?>
            </article>
        </div>
    </div>
    <?php }?>
    <?php if($user->about) { ?>
    <div class="row">
        <div class="col-lg-6  left-panel">
            <article >
                About :
            </article>
        </div>
        <div class="col-lg-6  right-panel">
            <article>
                <?php echo $user->about ?>
            </article>
        </div>
    </div>
    <?php }?>
</div>