<?php
use yii\helpers\Url;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View
 */

$this->title = 'Скайнікс Україна - розробка програмного забезпечення';
?>


<canvas id="canvas1"></canvas>
<canvas id="canvas2"></canvas>
<canvas id="canvas3"></canvas>

    <section class="container-fluid skynix-ua-sec" id="about_skynix">
        <div class="row">
            <div class="col-lg-12 col-xs-12">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12 col-xs-12">

                            <h1 class="my-upper">скайнікс україна </h1>
                        </div>
                        <div class="col-lg-12 col-xs-12 about-txt1">
                            Головним напрямом діяльності компанії є розробка програмного забезпечення та поліпшення існуючих рішень. Провідна мета - сприяння змінам та розвитку ІТ-технологій. Наша професійна команда завжди враховує думки і побажання клієнтів, спираючись у роботі тільки на найновіші та найсучасніші технології.
                        </div>
                        <div class="col-lg-12 col-xs-12 about-txt2">
                            Скайнікс Україна створює інноваційні програмні рішення для бізнесу, що працюють.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="container" id="working_fields">
        <div class="row">
            <div class="col-lg-12 col-xs-12">
                <h2 class="my-upper">Ми охоплюємо такі сфери:</h2>
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
                <h3>Якщо Ви прагнете збагатити, урізноманітнити та спростити своє життя за допомогою сучасних технологій, <span class="brand-name my-upper">СКАЙНІКС - </span>це <span class="brand-name my-upper">НАЙКРАЩИЙ ВИБІР.</span> 
                </h3>
            </div>
            <div class="col-lg-12 col-xs-12 technology-txt">
                Ми підтримуємо широкий вибір мов програмування і представляємо деякі з наших повсякденних технологій:
            </div>
        </div>
        <div class="row scheme">
            <div class="col-lg-12 col-xs-12 ">
                <div class="backend">
                    <strong class="my-upper">розробка хард рішень</strong><br>
                    <ul>
                        <li class="my-upper">php5</li>
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
                    <strong class="my-upper">розробка інтерфейсів</strong><br>
                    <ul>
                        <li class="my-upper">html5</li>
                        <li class="my-upper">css3</li>
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

    <section class="container" id="portfolio">
    <div class="row">
        <div class="col-lg-3 col-sm-2 col-xs-1 portfolio-header">
            <div class="line"></div>
        </div>
        <div class="col-lg-6 col-sm-8 col-xs-10 portfolio-header"><h2 class="my-upper">наші готові проекти</h2></div>
        <div class="col-lg-3 col-sm-2 col-xs-1 portfolio-header">
            <div class="line"></div>
        </div>

        <div class="col-lg-4 col-sm-6 col-xs-12 portfolio-sample">
            <a href="#" data-href="http://marketplace.skynix.solutions/" data-images="m2_marketplace_extension.jpg" rel="nofollow">
                <img src="../images/btn-marketplace-extension.jpg" width="289" height="214" alt="marketplace extension"/>
                <div class="mask"></div>
                <h3 class="name">Розширення Magento 2 Marketplace</h3>
            </a>
            <div class="info-box-hidden row" >

                <div class="col-lg-12 txt-center">
                    <p><strong class="my-upper">категорія: </strong>Magento 2.x Extension <strong class="padding-l-30 my-upper">клієнт: </strong>Skynix Solutions</p>
                    <p><strong class="my-upper">опис </strong></p><br>
                </div>

                <div class="col-lg-6 col-sm-12">

                    <p>Magento 2 Marketplace значно збільшує можливості стандартної площадки Magento 2. Завдяки цьому розширенню з’явилася змога розподілити функціональність магазину між багатьма продавцями, що працюють незалежно один від одного. Кожен охочий може зареєструватися й почати торгувати. Цей додаток перетворює звичайний інтернет-магазин на потужну платформу, таку як Amazon чи eBay.
                    </p>
                </div>
                <div class="col-lg-6 col-sm-12">
                    Особливості:<br>
                    <ul>
                        <li>Усі переваги Magento 2</li>
                        <li>Адаптивний дизайн</li>
                        <li>Унікальний профайл для кожного продавця із власним рейтингом та можливістю залишати відгуки</li>
                        <li>Сторінка реєстрації продавця</li>
                        <li>Підтримка платіжних систем PayPal та Braintree</li>
                    </ul>
                    Використані технології: Magento 2.x, PHP 5.6, MySQL 5.6, HTML5, CSS3, Bootstrap, jQuery 2.x

                </div>
            </div>
        </div>
        <div class="col-lg-4 col-sm-6 col-xs-12 portfolio-sample">
            <a href="#" data-href="https://handmade.works/" data-images="handmadeworks.jpg" rel="nofollow">
                <img src="../images/btn-handmade-works.jpg" width="289" height="214" alt="handmade works"/>
                <div class="mask"></div>
                <h3 class="name">Magento 2 Marketplace - Тема Handmade</h3>
            </a>
            <div class="info-box-hidden row" >

                <div class="col-lg-12 txt-center">
                    <p><strong class="my-upper">категорія: </strong>Magento 2.x Marketplace Theme <strong class="padding-l-30 my-upper">клієнт: </strong>Skynix Solutions</p>
                    <p><strong class="my-upper">опис: </strong></p><br>
                </div>
                <div class="col-lg-6 col-sm-12">
                    <p>Тема Handmade - спеціально розроблений унікальний дизайн для Magento 2 Marketplace. Це розширення перетворює звичайний інтернет-магазин на багатофункціональну торгову платформу, що підтримує необмежену кількість незалежних один від одного продавців.
                    </p>
                </div>
                <div class="col-lg-6 col-sm-12">
                    Особливості:<br>
                    <ul>
                        <li>
                            Усі переваги Magento 2
                        </li>
                        <li>
                            Адаптивний дизайн
                        </li>
                        <li>
                            Унікальний профайл для кожного продавця із власним рейтингом та можливістю залишати відгуки
                        </li>
                        <li>Сторінка реєстрації продавця</li>
                        <li>Корзина</li>
                        <li>Аккаунт покупця</li>
                    </ul>
                    Використані технології: Magento 2.x, PHP 5.6, MySQL 5.6, HTML5, CSS3, Bootstrap, jQuery 2.x
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-sm-6 col-xs-12 portfolio-sample">
            <a href="#" data-href="http://www.aftereden.nl/" data-images="after_eden_table_extension.png" rel="nofollow">
                <img src="../images/btn-after_eden.png" width="289" height="214" alt="after eden"/>
                <div class="mask"></div>
                <h3 class="name">After Eden - Таблиця розмірів для Magento 1.x </h3>
            </a>
            <div class="info-box-hidden row">
                <div class="col-lg-12 txt-center">
                    <p><strong class="my-upper">категорія: </strong>Magento 1.x Extension <strong class="padding-l-30 my-upper">клієнт: </strong>After Eden</p>
                    <p><strong class="my-upper">опис </strong></p><br>
                </div>
                <div class="col-lg-6 col-sm-12">
                    <p>Таблиця розмірів для Magento 1.9 надає покупцям змогу легко обирати необхідний розмір товару з тих, що є у магазині. Це розширення є універсальним та може бути легко встановлене на будь-яку версію Magento 1.x. 
                    </p>
                </div>
                <div class="col-lg-6 col-sm-12">
                    Особливості:<br>
                    <ul>
                        <li>Більш зручна сторінка продукту</li>
                        <li>Адаптивний дизайн</li>
                    </ul>
                    Використані технології: Magento 1.x, HTML5, CSS3, Bootstrap, jQuery 1.x
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-sm-6 col-xs-12 portfolio-sample">
            <a href="#" data-href="https://skynix.solutions/" data-images="skynix_solutions_theme.png" rel="nofollow">
                <img src="../images/btn-skynix_theme.png" width="289" height="214" alt="skynix theme"/>
                <div class="mask"></div>
                <h3 class="name">Magento 2 Тема Skynix Solutions</h3>
            </a>
            <div class="info-box-hidden row">
                <div class="col-lg-12 txt-center">
                    <p><strong class="my-upper">категорія: </strong>Magento 2.x Theme <strong class="padding-l-30 my-upper">клієнт: </strong>Skynix Solutions</p>
                    <p><strong class="my-upper">опис </strong></p><br>
                </div>
                <div class="col-lg-6 col-sm-12">
                    <p>Тема Skynix Solutions розроблена спеціально для Magento 2. Зберігаючи усі функціональні переваги платформи, вона повністю відповідає корпоративному стилю.
                    </p>
                </div>
                <div class="col-lg-6 col-sm-12">
                    Особливості:<br>
                    <ul>
                        <li>Усі переваги Magento 2.x</li>
                        <li>Адаптивний дизайн</li>
                        <li>Корзина</li>
                        <li>Аккаунт покупця</li>
                    </ul>
                    Використані технології: Magento 2.x, PHP 5.6, MySQL 5.6, HTML5, CSS3, Bootstrap, jQuery 2.x 
                </div>
            </div>
         </div>
        <div class="col-lg-4 col-sm-6 col-xs-12 portfolio-sample">
            <a href="#" data-href="http://infinite-beginnings.p.skynix.co/" data-images="infinite_beginnings1.jpg" rel="nofollow">
                <img src="../images/btn-infinite-beginnings.jpg" width="289" height="214" alt="infinite beginnings"/>
                <div class="mask"></div>
                <h3 class="name">Infinite Beginnings</h3>
            </a>
            <div class="info-box-hidden row" >
                <div class="col-lg-12 txt-center">
                    <p><strong class="my-upper">категорія: </strong> Wordpress Theme <strong class="padding-l-30 my-upper">клієнт: </strong> Web Mission Control Inc.</p>
                    <p><strong class="my-upper">опис </strong></p><br>
                </div>
                <div class="col-lg-6 col-sm-12">
                    <p>Infinite Beginnings це тема для Wordpress, що є сумісною з усіма наявними версіями системи. Створена на базі Bootstrap (це означає цілковиту адаптивність), вона є дочірньою до теми Enfold.<br>

                        Маючи усі переваги теми Wordpress Enfold, Infinite Beginnings має низку власних корисних особливостей. Ця тема добре підійде для бізнесу, будівництва, моди, електронної комерції, фотографії, портфоліо або туристичного сайту.

                    </p>
                </div>
                <div class="col-lg-6 col-sm-12">
                    Особливості:
                    <ul>
                        <li>
                            Створено можливість додавання власних типів постів та відповідні функції управління: події, послуги, ресурси та люди

                        </li>
                        <li>
                            Створено форму реєстрації замовлення та реалізовано його процес 
                        </li>
                        <li>
                            Розроблено невеличкий Javascript додаток, що забезпечує користувачів найбільш потрібним контентом у залежності від їх поведінки на сайті 
                        </li>
                    </ul>
                    Використані технології: PHP 5.6, MySQL 5.6, HTML5, CSS3, Bootstrap, jQuery 2.x
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-sm-6 col-xs-12 portfolio-sample">
            <a href="#" data-href="http://fisherman-id.p.skynix.co/" data-images="fisherman_id.jpg" rel="nofollow">
                <img src="../images/btn-fisherman.jpg" width="289" height="214" alt="fisherman"/>
                <div class="mask"></div>
                <h3 class="name">Fisherman ID</h3>
            </a>
            <div class="info-box-hidden row" >
                <div class="col-lg-12 txt-center">
                    <p><strong class="my-upper">категорія: </strong>Mobile App: iOS & Android <strong class="padding-l-30 my-upper">клієнт: </strong>Fisherman UK ltd.</p>
                    <p><strong class="my-upper">опис </strong></p><br>
                </div>
                <div class="col-lg-6 col-sm-12">
                    <p>Цей мобільний додаток створений, щоб зробити життя певної групи людей, а саме рибалок, набагато зручнішим. Fisherman ID надає змогу планувати поїздки та ділитися досягнутими результатами. Магазини із продажу відповідного спорядження можуть ефективно рекламувати свою продукцію. Складається із трьох частин: соціальна мережа, звітна система та реклама. 
                    </p>
                </div>
                <div class="col-lg-6 col-sm-12">
                    Додаток було створено із використанням найсучасніших технологій:<br>
                    Використані технології:<br>
                    <ul>
                        <li>HTML5, CSS3, Javascript</li>
                        <li>AngularJS</li>
                        <li>Twitter Bootstrap</li>
                        <li>Phonegap (iOS + Android)</li>
                    </ul>
                    Із серверної сторони:<br>
                    <ul>
                        <li>Yii2 Framework</li>
                        <li>MySQL Database</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-sm-6 col-xs-12 portfolio-sample">
            <a href="#" data-href="https://www.citrix.com/" data-images="citrix_cynergy.jpg" rel="nofollow">
                <img src="../images/btn-citrix-synergy.jpg" width="289" height="214" alt="citrix synergy"/>
                <div class="mask"></div>
                <h3 class="name">Citrix Synergy</h3>
            </a>
            <div class="info-box-hidden row" >
                <div class="col-lg-12 txt-center">
                    <p><strong class="my-upper">категорія: </strong>CMS & Web <strong class="padding-l-30 my-upper">клієнт: </strong>Citrix Systems</p>
                    <p><strong class="my-upper">опис </strong></p><br>
                </div>
                <div class="col-lg-6 col-sm-12">
                    <p>Цей інформаційний сайт було розроблено із використанням гнучкої CMS Adobe CQ. CMS дозволяє створювати для керування контентом різні ролі із різними рівнями доступу.
                    </p>
                </div>
                <div class="col-lg-6 col-sm-12">
                    Було використано наступні технології:<br>
                    <ul>
                        <li>Adobe CQ 5.6 - найсучасніша система управління контентом на Java</li>
                        <li>Foundation - платформа, що дозволяє створювати адаптивні сторінки</li>
                        <li>HTML5, CSS3, Javascript</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-sm-6 col-xs-12 portfolio-sample">
            <a href="#" data-href="http://www.castles.uk.com/" data-images="castles.jpg" rel="nofollow">
                <img src="../images/btn-сastles_estate_agents.jpg" width="289" height="214" alt="сastles estate agents"/>
                <div class="mask"></div>
                <h3 class="name">Castles - Агент з нерухомості</h3>
            </a>
            <div class="info-box-hidden row" >
                <div class="col-lg-12 txt-center">
                    <p><strong class="my-upper">категорія: </strong>Wordpress Plugin <strong class="padding-l-30 my-upper">клієнт: </strong>Castles Estate Agents ltd.</p>
                    <p><strong class="my-upper">опис </strong></p><br>
                </div>
                <div class="col-lg-6 col-sm-12">
                    <p>Вебсайт створено на Wordpress із використанням спеціального розширення, що додає на сайт каталог нерухомості. Список вилучається зовні за допомогою ExpertAgent API. Для кожної одиниці нерухомого майна створюється власна сторінка із багатьма функціями. 
                    </p>
                </div>
                <div class="col-lg-6 col-sm-12">
                    Технічні деталі додатку:<br>
                    <ul>
                        <li>Можливість створення власних типів постів</li>
                        <li>ExpertAgent API</li>
                        <li>Користувальницький запит за характеристиками</li>
                    </ul>
                    Використані технології: PHP 5.6, MySQL 5.6, HTML5, CSS3, Bootstrap, jQuery 1.x 
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-sm-6 col-xs-12 portfolio-sample">
            <a href="#" data-href="http://moticv.com/" data-images="motibu.png" rel="nofollow">
                <img src="../images/btn-motibu-small.png" width="289" height="214" alt="motibu small"/>
                <div class="mask"></div>
                <h3 class="name">MotiBu - Професійні портфоліо</h3>
            </a>
            <div class="info-box-hidden row" >
                <div class="col-lg-12 txt-center">
                    <p><strong class="my-upper">категорія: </strong>Wordpress Plugin <strong class="padding-l-30 my-upper">клієнт: </strong>UOU ltd.</p>
                    <p><strong class="my-upper">опис</strong></p><br>
                </div>
                <div class="col-lg-6 col-sm-12">
                    <p>Сайт створено на Wordpress із використанням плагіна, що допомагає людям створювати професійні резюме. Користувачі можуть без зайвих зусиль встановити плагін на власний сайт або створити профіль у централізованій системі. Додаток створює CV у відповідності до всіх вимог Європейської комісії. 
                    </p>
                </div>
                <div class="col-lg-6 col-sm-12">
                    Технічні деталі додатку:<br>
                    <ul>
                        <li>Можливість створення власних типів постів</li>
                        <li>EAUC API (комуникативні/професійні навички)</li>
                        <li>Javascript CV Builder</li>
                        <li>Уніфікована сторінка профілю</li>
                    </ul>
                    Використані технології: PHP 5.6, MySQL 5.6, HTML5, CSS3, Bootstrap, jQuery 2.x 
                </div>
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
                                <h3>Потрібно оцінити вартість проекту або ідеї?</h3>
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


<!--****   Popup REQUEST a QUOTE modals   ****-->
<div id="request-quote-modals">
    <div class="masks-back"></div>
    <div class="popup">
        <div class="close"></div>
        <div class="header-popap">Receive the quote from our technical leader who knows the field the best.</div>


        <!-- <form action="site/request" class="container-fluid" method="post">-->
        <?php $form = ActiveForm::begin(['action' => "site/request", 'options' => ['enctype' => 'multipart/form-data', 'class' => "container-fluid", 'method' => "post"]]) ?>




        <div class="row body-popap">

                <div class = "col-lg-12 step step1">
                    <div class="question">What is your website/application state?</div>
                    <div class="option-group">
                        <input type="radio" value="Active site application" name="website_state" id="active" required>
                        <label for="active">Active site/application</label>
                    </div>

                    <div class="option-group right-elem">
                        <input type="radio" value="Only technical specification" name="website_state" id="technical"  required>
                        <label for="technical">Only technical specification</label>




                    </div>

                    <div class="option-group">
                        <input type="radio" value="Only concept" name="website_state" id="concept"  required>
                        <label for="concept">Only concept</label>
                    </div>

                    <div class="option-group right-elem">
                        <input type="radio" value="In development" name="website_state" id="development"  required>
                        <label for="development">In development</label>
                    </div>
                </div>

                <div class = "col-lg-12 step step2">
                    <div class="question">What is your platform?</div>
                    <div class="input-group-btn select">

                        <select class="dropdown-toggle form-control" name="platform" required>
                            <option value="">Select ...</option>
                            <option value="Magento 1.x">Magento 1.x</option>
                            <option value="Magento 2.x">Magento 2.x</option>
                            <option value="Wordpress">Wordpress</option>
                            <option value="Yii 1, Yii 2">Yii 1, Yii 2</option>
                            <option value="ZF 1, ZF2">ZF 1, ZF2</option>
                            <option value="HTML/CSS/Javascript">HTML/CSS/Javascript</option>
                            <option value="Other">Other</option>
                        </select>

                    </div>
                    <div class="question margin-text">What kind of services do you need?</div>
                    <div class="option-group">
                        <input type="checkbox" value="New module, plugin, extension" name="services[]" id="module_plugin" required>
                        <label for="module_plugin"><span class="hidden-xs">New module,<br> plugin, extension</span><span class="visible-xs">New module, plugin, extension</span></label>
                    </div>
                    <div class="option-group right-elem">
                        <input type="checkbox" value="Existing code adjustments" name="services[]" id="code_adjustments" required>
                        <label for="code_adjustments"><span class="hidden-xs">Existing code<br> adjustments</span><span class="visible-xs">Existing code adjustments</span></label>
                    </div>
                    <div class="option-group">
                        <input type="checkbox" value="New graphic design" name="services[]" id="graphic_design" required>
                        <label for="graphic_design"><span class="hidden-xs">New<br> graphic design</span><span class="visible-xs">New graphic design</span></label>
                    </div>
                    <div class="option-group right-elem">
                        <input type="checkbox" value="Optimization" name="services[]" id="optimization" required>
                        <label for="optimization">Optimization</label>
                    </div>
                    <div class="option-group">
                        <input type="checkbox" value="Redesign" name="services[]" id="redesign" required>
                        <label for="redesign">Redesign</label>
                    </div>
                    <div class="option-group right-elem">
                        <input type="checkbox" value="Server Administration" name="services[]" id="server_administration" required>
                        <label for="server_administration"><span class="hidden-xs">Server<br> Administration</span><span class="visible-xs">Server Administration</span></label>
                    </div>
                </div>

                <div class = "col-lg-12 step step3">
                    <div class="question">What is your prefered backend platform?</div>
                    <div class="input-group-btn select">

                        <select class="dropdown-toggle form-control" name="backend_platform" required>
                            <option value="">Select ...</option>
                            <option value="Magento 1.x">Magento 1.x</option>
                            <option value="Magento 2.x">Magento 2.x</option>
                            <option value="Wordpress">Wordpress</option>
                            <option value="Yii 2">Yii 2</option>
                            <option value="Zend Framework 2">Zend Framework 2</option>
                            <option value="HTML/CSS/Javascript">HTML/CSS/Javascript</option>
                            <option value="No need for a backend">No need for a backend</option>
                        </select>
                    </div>
                    <div class="question margin-text">What is your prefered frontend platform?</div>
                    <div class="input-group-btn select">

                        <select class="dropdown-toggle form-control" name="frontend_platform" required>
                            <option value="">Select ...</option>
                            <option value="Twitter Bootstrap template">Twitter Bootstrap template</option>
                            <option value="HTML5, CSS3 template">HTML5, CSS3 template</option>
                            <option value="jQuery application">jQuery application</option>
                            <option value="AngularJS application">AngularJS application</option>
                            <option value="No need for a frontend">No need for a frontend</option>
                        </select>
                    </div>
                </div>

                <div class = "col-lg-12 step step4">
                    <div class="question"> When are you looking to start?</div>
                    <div class="input-group-btn select">

                        <select class="dropdown-toggle form-control" name="when_start" required>
                            <option value="">Select ...</option>
                            <option value="Immediately">Immediately</option>
                            <option value="1-2 weeks">1-2 weeks</option>
                            <option value="3-4 weeks">3-4 weeks</option>
                            <option value="in 1-2 months">in 1-2 months</option>
                        </select>


                    </div>
                    <div class="question margin-text">What is your budget?</div>
                    <div class="input-group-btn select">

                        <select class="dropdown-toggle form-control" name="budget" required>
                            <option value="">Select ...</option>
                            <option value="&lt; $300">&lt; $300</option>
                            <option value="$300 - $1000">$300 - $1000</option>
                            <option value="$1000 - $5000">$1000 - $5000</option>
                            <option value="&gt; $5000">&gt; $5000</option>
                        </select>
                    </div>
                </div>

                <div class = "col-lg-12 step step5">
                    <textarea rows="8" cols="45" name="description" placeholder="project description..." required></textarea>

                    <label class="file_upload">
                        <span class="button my-upper">upload file</span>
                       <input type="file" id="file" name="file">
                    </label>
                    <p class="message"></p>


                </div>

                <div class = "col-lg-12 step step6">
                    <input type="text" placeholder="Name" name="name" autocomplete="on" required >
                    <input type="email" placeholder="Email Address" name="email" autocomplete="on" pattern="[^ @]*@[^ @]*" required >
                    <input type="text" placeholder="Company" name="company" autocomplete="on" required>
                    <input type="text" placeholder="Country" name="country" autocomplete="on" required>
                </div>

            </div>

            <div class="row footer-popap">
                <div class = "col-lg-12">
                    <div class="progress">
                        <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100">
                            <span class="sr-only"></span>
                        </div>
                    </div>
                </div>
                <div class = "col-lg-12">
                    <p class="answer-ajax-error"></p>

                </div>
                <div class = "col-lg-2 col-sm-2 col-xs-4">
                    <button class="btn btn-link back"><strong class="my-upper">&lt; back</strong></button>
                </div>
                <div class = "col-lg-10 col-sm-10 col-xs-8">
                    <button class="btn btn-primary next my-upper">next</button>
                    <button class="btn btn-primary quotes my-upper">get my quotes</button>
                </div>
            </div>

            <!-- </form>-->
            <?php ActiveForm::end() ?>


        <div class="answer-ajax">
            <p>Thank You for your effort, Skynix team will process your request as soon as possible and get back to you with quotes</p>
            <button class="btn btn btn-primary close-popap close my-upper">close</button>

        </div>
    </div>
    <div class="front-mask"></div>


</div>
<!--****   End Popup REQUEST a QUOTE modals   ****-->


<!--****   Popup portfolio   ****-->
<div id="view_portfolio" >
    <div class="masks-back"></div>
    <div class="popup">
        <div class="close"></div>
        <div class="header-popap">Infinite Beginnings</div>
        <div class="container-fluid">
            <div class="row body-popap">
                <div class="slider_portfolio col-lg-12">
                    <div class="prev-box ua-box">
                        <div>
                            <a class="prev" href="javascript:void(0);">
                                <div class="hidden768 my-upper">
                                    Попередній<br>проект
                                </div>
                                <div class="visible768 my-upper">
                                    Попередній проект
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="viewport">
                    </div>
                    <div class="next-box ua-box">
                        <div>
                            <a class="next" href="javascript:void(0);">

                                <div class="hidden768 my-upper">
                                    Наступний<br>проект
                                </div>
                                <div class="visible768 my-upper">
                                    Наступний проект
                                </div>

                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="container-fluid info-box"></div>
                </div>
                <div class="col-lg-12 ua-visit">
                    <a href="#" class="btn read-more my-upper" target = "_blank" rel="nofollow">відвідати сайт</a>
                </div>
            </div>
        </div>
    </div>
    <div class="front-mask"></div>
</div>
<!--****   End Popup portfolio   ****-->

    
<?php $this->registerJsFile('/js/popup-request-quote-modals.js', ['depends' => [yii\web\JqueryAsset::className()]]); ?>
<?php $this->registerJsFile('/js/portfolio.js', ['depends' => [yii\web\JqueryAsset::className()]]); ?>
<?php $this->registerJsFile('/js/canvas.js', ['depends' => [yii\web\JqueryAsset::className()]]); ?>

