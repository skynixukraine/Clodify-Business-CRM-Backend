<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = Yii::t('app', 'Careers in Skynix');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container career">

    <div class="row">
        <div class="col-lg-12">
            <h1><?=Yii::t('app', 'Careers')?></h1>

        </div>



        <div class="col-lg-12 col-xs-12"><h2>We are always open for new talent!</h2></div>
        <div class="col-lg-8 col-sm-8 col-xs-12 left-panel">
            <article >
                <h3>You are welcome to obtain a Product Manager position.</h3>
                <p>
                    In this role you will primarily work to create a variety of products for e-commerce  system Magento.

                </p>
                <h3>Requirements:</h3>
                <ul>
                    <li>Higher education in one of the following areas: business, management, economics, commerce;</li>
                    <li>Knowledge of english at least at intermediate level;</li>
                    <li>Good knowledge of the digital economy and e-commerce;</li>
                    <li>Flawless written and spoken communication skills;</li>
                    <li>Creative and analytical thinking;</li>
                    <li>Ability to work in a team</li>
                </ul>
                <h3>will be a plus:</h3>
                <ul>
                    <li>Fluent english;</li>
                    <li>Work experience in a similar position;</li>
                    <li>Knowledge of JIRA  and SCRUM</li>
                </ul>
                <h3>job responsibilities:</h3>
                <ul>
                    <li>Definition of product strategy and tactical action plan;</li>
                    <li>Gathering and prioritization requirements for products, the establishment of appropriate documentation;</li>
                    <li>Development of activities for promoting products on the market;</li>
                    <li>Forming of information-analytical database;</li>
                    <li>Creating, updating and maintenance of content products;</li>
                    <li>Control of the process of product development;</li>
                    <li>Negotiations with customers and technical support</li>
                </ul>
                <div class="shadow-bottom"></div>
                <button class="btn read-more">READ MORE &gt; &gt;</button>
            </article>
            <article >
                <h3>We invite you to obtain af Front-end developer position.</h3>
                <p>
                    In this role you will primarily create user interfaces, HTML templates  and themes for Magento, Wordpress, and othe systems using Photoshop mockups.
                </p>

                <div class="shadow-bottom"></div>
                <button class="btn read-more">READ MORE &gt; &gt;</button>
            </article>


        </div>
        <div class="col-lg-4 col-sm-4 col-xs-12 right-panel">
            <div class="offer">
                <h3>WE OFFER:</h3>
                <ul>
                    <li>Permanent Work;</li>
                    <li>Official employment;</li>
                    <li>Paid vacations and sick leaves;</li>
                    <li>And other bonuses</li>
                </ul>
            </div>
            <div class="need">
                <h3>You need:</h3>
                <ul>
                    <li>Send us your resume;</li>
                    <li>Pass an interview in office or via Skype;</li>
                    <li>Perform a test task</li>
                </ul>
            </div>
            <button class="btn btn-primary apply">APPLY NOW</button>
        </div>




    </div>
</div>
<?php $this->registerJsFile('/js/career.js'); ?>