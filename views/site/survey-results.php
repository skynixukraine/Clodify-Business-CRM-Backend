<?php
/**
 * Created by PhpStorm.
 * User: lera
 * Date: 14.05.16
 * Time: 17:43
 */
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * @var $survey \app\models\SurveysOption
 * @var $model \app\models\Survey
 */

$this->title = $model->question;
$colors = ['success', 'info', 'warning', 'danger'];
?>
<?php $this->registerCssFile('/css/survey.css'); ?>

<section class="survey-wrap">
    <article>
        <header class="question">
            <h1> <?= Html::encode($model->question)?></h1>
        </header>

        <p><?= nl2br( Html::encode($model->description) )?></p>

    </article>
    <section class="survey-results">

        <h2><?=$model->total_votes?> people took a part in this survey.</h2>
        <fieldset>
            <?php foreach($model->surveys as $key=>$survey):?>
                <div class="progress-group">
                    <span class="progress-text"><?=Html::encode($survey->name);?></span>
                    <span class="progress-number"><b><?=$survey->votes?></b>/<?=$model->total_votes?></span>
                    <div class="progress sm">
                        <div class="progress-bar progress-bar-<?=(isset($colors[$key]) ? $colors[$key] : 'success') ?>" style="width: <?=round(($survey->votes / $model->total_votes) * 100 )?>%">
                            <?=round(($survey->votes / $model->total_votes) * 100 )?>%
                        </div>
                    </div>
                </div>

            <?php endforeach ?>
        </fieldset>
    </section>


</section>
