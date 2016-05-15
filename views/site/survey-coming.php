<?php
/**
 * Created by Skynix.
 * User: alekseyyp
 * Date: 5/15/16
 * Time: 10:56
 */
use yii\helpers\Html;

/**
 * @var $survey \app\models\SurveysOption
 * @var $model \app\models\Surveys
 */
$this->title = $model->question;
?>
<?php $this->registerCssFile('/css/survey.css'); ?>

    <section class="survey-wrap">
        <article>
            <header class="question">
                <h1> <?= Html::encode($model->question)?></h1>
            </header>

            <p><?= nl2br( Html::encode($model->description) )?></p>

        </article>
        <section>

            The survey start on <?=date('d M, Y \a\t H:i', strtotime($model->date_start))?>
            <br>
            And will go up to <?=date('d M, Y \a\t H:i', strtotime($model->date_end))?>

        </section>

    </section>
