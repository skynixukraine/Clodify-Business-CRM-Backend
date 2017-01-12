<?php
/**
 * Created by Skynix Team
 * Date: 7/14/16
 * Time: 10:12 AM
 */
use yii\helpers\Html;
use app\assets\AppAsset;
?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>

</head>
<body>
<?php $this->beginBody() ?>

<?= $content; ?>

<?php $this->endBody() ?>
</body>
</html>
