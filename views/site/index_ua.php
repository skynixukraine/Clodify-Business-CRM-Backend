<?php
use yii\helpers\Url;
/* @var $this yii\web\View
 */

$this->title = 'Вітаємо у Скайнікс - компанія з розробки програмного забезпечення';
?>


    <section class="container-fluid" id="about_skynix">
        <div class="row">
            <div class="col-lg-12 col-xs-12">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12 col-xs-12">

                            <h1>ПРО СКАЙНІКС </h1>
                        </div>
                        <div class="col-lg-12 col-xs-12 about-txt1">
                            Компанія Скайнікс займається створенням, зміцненням та поліпшенням програмного забезпечення.
                            Головною метою компанії є сприяння змінам та розвитку ІТ технологій.
                        </div>
                        <div class="col-lg-12 col-xs-12 about-txt2">
                            Ми створюємо інноваційні програмні рішення для бізнесу, що працюють.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="container" id="working_fields">
        <div class="row">
            <div class="col-lg-12 col-xs-12">
                <h2>МИ ПРАЦЮЄМО В ТАКИХ ОБЛАСТЯХ:</h2>
            </div>
            <div class="col-lg-4 col-sm-4 col-xs-6 web-network">
                <div>Корпоративні<br>веб-сайти</div>
            </div>
            <div class="col-lg-4 col-sm-4 col-xs-6 hi">
                <div>Блоги, форуми,<br>Соціальні мережі</div>
            </div>
            <div class="col-lg-4 col-sm-4 col-xs-6 phonegap">
                <div>Мобільні iOS & Android<br>Phonegap додатки</div>
            </div>
            <div class="col-lg-4 col-sm-4 col-xs-6 ecommerce">
                <div>Рішення<br>Електронної комерції</div>
            </div>
            <div class="col-lg-4 col-sm-4 col-xs-6 email">
                <div>Теми та імейл<br>шаблони</div>
            </div>
            <div class="col-lg-4 col-sm-4 col-xs-6 support">
                <div>Технічна<br>підтримка</div>
            </div>
        </div>
    </section>

    <section class="container" id="technology">
        <div class="row">
            <div class="col-lg-12 col-xs-12">
                <h3>
                    <span class="brand-name">СКАЙНІКС</span> прагне збагатити, урізноманітнити та спростити ваше життя
                    за допомогою найкращих технологій.
                </h3>
            </div>
            <div class="col-lg-12 col-xs-12 technology-txt">
                Ми підтримуємо широкий вибір мов програмування і представляємо деякі з наших повсякденних технологій:
            </div>
        </div>
        <div class="row scheme">
            <div class="col-lg-12 col-xs-12 ">
                <div class="backend">
                    <strong>РОЗРОБКА ХАРД РІШЕНЬ</strong><br>
                    <ul>
                        <li>PHP5</li>
                        <li>Yii Framework 2</li>
                        <li>Zend Framework 2</li>
                        <li>Magento 2</li>
                        <li>Wordpress</li>
                    </ul>
                </div>
                <div class="arrow-box">
                    <div class="arrow-left">
                        <div class="dot"></div>
                        <div class="angle"></div>
                    </div>
                    <div class="arrow-right">
                        <div class="dot"></div>
                        <div class="angle"></div>
                    </div>
                </div>
                <div class="frontend">
                    <strong>РОЗРОБКА ІНТЕРФЕЙСІВ</strong><br>
                    <ul>
                        <li>HTML5</li>
                        <li>CSS3</li>
                        <li>jQuery</li>
                        <li>Sencha ExtJS</li>
                        <li>AngularJS</li>
                        <li>Bootstrap</li>
                        <li>Foundation</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <section class="container-fluid" id="evaluation">
        <div class="row">
            <div class="col-lg-12">
                <div class="box-evaluation">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-lg-7 col-md-12 evaluation-txt">
                                <p>Потрібно оцінити вартість проекту або ідеї?</p>
                            </div>
                            <div class="col-lg-5 col-md-12">
                                <a href="<?=Url::to(['site/contact'])?>">Безкоштовна оцінка проекту</a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

<?php $this->registerJsFile('/js/local-storage.js'); ?>
<?php $this->registerJsFile('/js/jQuery-2.1.4.min.js'); ?>