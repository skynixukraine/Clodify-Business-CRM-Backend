<?php
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use app\models\Upload;

/* @var $this yii\web\View
 */

$this->title = 'Welcome to the Skynix - software development company';
?>
<canvas id="canvas1"></canvas>
<canvas id="canvas2"></canvas>
<canvas id="canvas3"></canvas>



<section class="container-fluid" id="about_skynix">
    <div class="row">
        <div class="col-lg-12 col-xs-12">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-xs-12">
                        <h1 class="en">ABOUT SKYNIX</h1>
                    </div>
                    <div class="col-lg-12 col-xs-12 about-txt1-en">
                        Skynix is a company that believes in making distinctive, lasting and substantial improvements
                        in IT World. We have only one goal in mind - to develop, excite and foster changes through our
                        solutions. Our professional team always takes into account the wishes and opinions of customers
                        and leverage on latest technology practices to deliver high quality and <span>cost-effective
                        solutions.</span>
                    </div>
                    <div class="col-lg-12 col-xs-12 about-txt2">
                        Our company develops innovative businesses software solutions that work.
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="container" id="working_fields">
    <div class="row">
        <div class="col-lg-12 col-xs-12">
            <h2>WE OPERATE IN THE FOLLOWING AREAS:</h2>
        </div>
        <div class="col-lg-4 col-sm-4 col-xs-6 web-network">
            <div>Corporate<br>Websites</div>
        </div>
        <div class="col-lg-4 col-sm-4 col-xs-6 hi">
            <div>Blogs, Forums, <br>Social networking</div>
        </div>
        <div class="col-lg-4 col-sm-4 col-xs-6 phonegap">
            <div>Mobile iOS & Android <br> Phonegap Applications</div>
        </div>
        <div class="col-lg-4 col-sm-4 col-xs-6 ecommerce">
            <div>eCommerce<br>Solutions</div>
        </div>
        <div class="col-lg-4 col-sm-4 col-xs-6 email">
            <div>Themes & Email<br>Templates</div>

        </div>
        <div class="col-lg-4 col-sm-4 col-xs-6 support">
            <div>Maintenance<br>and Support</div>

        </div>
    </div>
</section>

<section class="container" id="technology">
    <div class="row">
        <div class="col-lg-12 col-xs-12">
            <h3>
                <span class="brand-name">SKYNIX</span> strives to enrich and challenge your life with the
                <span class="brand-name">BEST</span> of <span class="brand-name">TECHNOLOGY</span>.<br>
            </h3>
        </div>
        <div class="col-lg-12 col-xs-12 technology-txt">
            We support a range of programming languages and some of our everyday programming languages  are:
        </div>
    </div>
    <div class="row scheme">
        <div class="col-lg-12 col-xs-12 ">
            <div class="backend">
                <strong>BACKEND DEVELOPMENT</strong><br>
                <ul>
                    <li>PHP5</li>
                    <li>Yii Framework 2</li>
                    <li>Zend Framework 2</li>
                    <li>Magento 1</li>
                    <li>Magento 2</li>
                    <li>Wordpress</li>
                    <li>Nodejs</li>
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
                <strong>FRONTEND DEVELOPMENT</strong><br>
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

<section class="container" id="portfolio">
    <div class="row">
        <div class="col-lg-3 col-sm-2 col-xs-1 portfolio-header">
            <div class="line"></div>
        </div>
        <div class="col-lg-6 col-sm-8 col-xs-10 portfolio-header"><h2>PROJECTS WE HAVE DONE</h2></div>
        <div class="col-lg-3 col-sm-2 col-xs-1 portfolio-header">
            <div class="line"></div>
        </div>

        <div class="col-lg-4 col-sm-6 col-xs-12 portfolio-sample">
            <a href="#" data-href="http://marketplace.skynix.solutions/" data-images="m2_marketplace_extension.jpg" rel="nofollow">
                <img src="../images/btn-marketplace-extension.jpg" width="289" height="214" alt="marketplace extension"/>
                <div class="mask"></div>
                <h3 class="name">Magento 2 Marketplace Extension</h3>
            </a>
            <div class="info-box-hidden row" >

                <div class="col-lg-12 txt-center">
                    <p><strong>CATEGORY: </strong>Magento 2.x Extension <strong class="padding-l-30">CLIENT: </strong>Skynix Solutions</p>
                    <p><strong>DESCRIPTION: </strong></p><br>
                </div>

                <div class="col-lg-6 col-sm-12">

                    <p>The Magento 2 Marketplace extension intended to create specific
                        markets based on Magento 2 ecommerce.
                        It shares Magento 2 functionality between different vendors and promotes their products under
                        one catalog (marketplace).
                        Every seller in the specific market can sign up and sell the products easily.
                        The platform easily converts any Magento 2.x instance to a rich featured marketplace like
                        Amazon or eBay
                    </p>
                </div>
                <div class="col-lg-6 col-sm-12">
                    Features:<br>
                    <ul>
                        <li>All Magento 2.x features</li>
                        <li>Mobile Responsive</li>
                        <li>Seller profile with reviews and ratings</li>
                        <li>Seller sign up page</li>
                        <li>Payment systems like PayPal and Braintree</li>
                    </ul>
                    Technologies: Magento 2.x, PHP 5.6, MySQL 5.6, HTML5, CSS3, Bootstrap, jQuery 2.x

                </div>
            </div>
        </div>
        <div class="col-lg-4 col-sm-6 col-xs-12 portfolio-sample">
            <a href="#" data-href="https://handmade.works/" data-images="handmadeworks.jpg" rel="nofollow">
                <img src="../images/btn-handmade-works.jpg" width="289" height="214" alt="handmade works"/>
                <div class="mask"></div>
                <h3 class="name">Magento 2 Marketplace - Handmade Theme</h3>
            </a>
            <div class="info-box-hidden row" >

                <div class="col-lg-12 txt-center">
                    <p><strong>CATEGORY: </strong>Magento 2.x Marketplace Theme <strong class="padding-l-30">CLIENT: </strong>Skynix Solutions</p>
                    <p><strong>DESCRIPTION: </strong></p><br>
                </div>
                <div class="col-lg-6 col-sm-12">
                    <p>The Handmade theme is designed for a Magento 2 Marketplace extension.
                        This theme completely covers functionality of the M2 Marketplace Extension
                        that shares Magento 2 functionality between different vendors and promotes their products under
                        one catalog (marketplace).
                    </p>
                </div>
                <div class="col-lg-6 col-sm-12">
                    Features:<br>
                    <ul>
                        <li>
                            All Magento 2.x features
                        </li>
                        <li>
                            Mobile Responsive
                        </li>
                        <li>
                            Seller profile with reviews and ratings
                        </li>
                        <li>Seller sign up page</li>
                        <li>Shopping cart</li>
                        <li>Customer Account</li>
                    </ul>
                    Technologies: Magento 2.x, PHP 5.6, MySQL 5.6, HTML5, CSS3, Bootstrap, jQuery 2.x
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-sm-6 col-xs-12 portfolio-sample">
            <a href="#" data-href="http://www.aftereden.nl/" data-images="after_eden_table_extension.png" rel="nofollow">
                <img src="../images/btn-after_eden.png" width="289" height="214" alt="after eden"/>
                <div class="mask"></div>
                <h3 class="name">After Eden - Sizes Table Magento 1.x Extension</h3>
            </a>
            <div class="info-box-hidden row">
                <div class="col-lg-12 txt-center">
                    <p><strong>CATEGORY: </strong>Magento 1.x Extension <strong class="padding-l-30">CLIENT: </strong>After Eden</p>
                    <p><strong>DESCRIPTION: </strong></p><br>
                </div>
                <div class="col-lg-6 col-sm-12">
                    <p>The Sizes Table Magento 1.9 extension lets customers easily select a
                        necessary size of the product based on available stock.
                        The extension is universal and can be easily installed on any version of Magento 1.x
                    </p>
                </div>
                <div class="col-lg-6 col-sm-12">
                    Features:<br>
                    <ul>
                        <li>Product page improvement</li>
                        <li>Mobile Responsive</li>
                    </ul>
                    Technologies: Magento 1.x, HTML5, CSS3, Bootstrap, jQuery 1.x
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-sm-6 col-xs-12 portfolio-sample">
            <a href="#" data-href="https://skynix.solutions/" data-images="skynix_solutions_theme.png" rel="nofollow">
                <img src="../images/btn-skynix_theme.png" width="289" height="214" alt="skynix theme"/>
                <div class="mask"></div>
                <h3 class="name">Magento 2 Skynix Solutions Theme</h3>
            </a>
            <div class="info-box-hidden row">
                <div class="col-lg-12 txt-center">
                    <p><strong>CATEGORY: </strong>Magento 2.x Theme <strong class="padding-l-30">CLIENT: </strong>Skynix Solutions</p>
                    <p><strong>DESCRIPTION: </strong></p><br>
                </div>
                <div class="col-lg-6 col-sm-12">
                    <p>The Skynix Solutions theme is designed for a Magento 2 platform.
                        This theme completely covers functionality of the Magento and meets a corporate style.
                    </p>
                </div>
                <div class="col-lg-6 col-sm-12">
                    Features:<br>
                    <ul>
                        <li>All Magento 2.x features</li>
                        <li>Mobile Responsive</li>
                        <li>Shoping cart</li>
                        <li>Customer Account</li>
                    </ul>
                    Technologies: Magento 2.x, PHP 5.6, MySQL 5.6, HTML5, CSS3, Bootstrap, jQuery 2.x
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
                    <p><strong>CATEGORY: </strong> Wordpress Theme <strong class="padding-l-30">CLIENT: </strong> Web Mission Control Inc.</p>
                    <p><strong>DESCRIPTION: </strong></p><br>
                </div>
                <div class="col-lg-6 col-sm-12">
                    <p>The Infinite Beginnings Wordpress theme is compatible with all
                        recent versions of Wordpress and is based on Bootstrap (mobile responsive project) and is a
                        child theme of the premium Enfold theme.<br>

                        This means that the theme has all features of Wordpress Enfold theme and the set of additional
                        custom features formed under the child theme. This theme is good for business, church,
                        construction, corporate, ecommerce, fashion, hotel, multi purpose, one page, parallax,
                        photography, portfolio, restaurant, retina, travel web sites.
                    </p>
                </div>
                <div class="col-lg-6 col-sm-12">
                    Custom features of the Infinite Beginnings Theme:
                    <ul>
                        <li>
                            Created custom post types and appropriate backend features for managing: events, services,
                            resources and people
                        </li>
                        <li>
                            Created custom registration form and implemented custom registration workflow
                        </li>
                        <li>
                            Created smart Javascript application, that supplies users with the most suitable content
                            according to their behavior.
                        </li>
                    </ul>
                    Technologies: PHP 5.6, MySQL 5.6, HTML5, CSS3, Bootstrap, jQuery 2.x
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
                    <p><strong>CATEGORY: </strong>Mobile App: iOS & Android <strong class="padding-l-30">CLIENT: </strong>Fisherman UK ltd.</p>
                    <p><strong>DESCRIPTION: </strong></p><br>
                </div>
                <div class="col-lg-6 col-sm-12">
                    <p>The mobile application is intended to help for specific groups of
                        people to get their aims.
                        Fishermen can plan the trips and share the results.
                        Local equipment shops can advertise their products based on fishermen trips.
                        Basically this application consists from three parts, it is a social network, a reporting system
                        and an advertisement system.
                    </p>
                </div>
                <div class="col-lg-6 col-sm-12">
                    The App has been developed using the most modern technologies.<br>
                    Application solution:<br>
                    <ul>
                        <li>HTML5, CSS3, Javascript</li>
                        <li>AngularJS</li>
                        <li>Twitter Bootstrap</li>
                        <li>Phonegap (iOS + Android)</li>
                    </ul>
                    Server-side solution:<br>
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
                    <p><strong>CATEGORY: </strong>CMS & Web <strong class="padding-l-30">CLIENT: </strong>Citrix Systems</p>
                    <p><strong>DESCRIPTION: </strong></p><br>
                </div>
                <div class="col-lg-6 col-sm-12">
                    <p>This informational announcement site for events at Citrix is
                        developed using flexible CMS Adobe CQ.
                        CMS allows administrators of the site to manage content by multiple admins with different
                        privilege levels.
                    </p>
                </div>
                <div class="col-lg-6 col-sm-12">
                    The CMS has been developed using the following technologies:<br>
                    <ul>
                        <li>Adobe CQ 5.6  - the most modern content management system on Java</li>
                        <li>Foundation - responsive framework for creating mobile friendly web sites</li>
                        <li>HTML5, CSS3, Javascript</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-sm-6 col-xs-12 portfolio-sample">
            <a href="#" data-href="http://www.castles.uk.com/" data-images="castles.jpg" rel="nofollow">
                <img src="../images/btn-сastles_estate_agents.jpg" width="289" height="214" alt="сastles estate agents"/>
                <div class="mask"></div>
                <h3 class="name">Castles - Estate agents</h3>
            </a>
            <div class="info-box-hidden row" >
                <div class="col-lg-12 txt-center">
                    <p><strong>CATEGORY: </strong>Wordpress Plugin <strong class="padding-l-30">CLIENT: </strong>Castles Estate Agents ltd.</p>
                    <p><strong>DESCRIPTION: </strong></p><br>
                </div>
                <div class="col-lg-6 col-sm-12">
                    <p>The website is a wordpress + custom plugin that provide a catalog
                        of available properties.
                        The list of properties is fetched from external feed through ExpertAgent API.
                        Every property has own rich featured details pages.
                    </p>
                </div>
                <div class="col-lg-6 col-sm-12">
                    Technical details of the Wordpress Plugin:<br>
                    <ul>
                        <li>Custom post type</li>
                        <li>ExpertAgent API</li>
                        <li>Custom Request an Agent Feature</li>
                    </ul>
                    Technologies: PHP 5.6, MySQL 5.6, HTML5, CSS3, Bootstrap, jQuery 1.x
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-sm-6 col-xs-12 portfolio-sample">
            <a href="#" data-href="http://moticv.com/" data-images="motibu.png" rel="nofollow">
                <img src="../images/btn-motibu-small.png" width="289" height="214" alt="motibu small"/>
                <div class="mask"></div>
                <h3 class="name">MotiBu - Professional Profiles</h3>
            </a>
            <div class="info-box-hidden row" >
                <div class="col-lg-12 txt-center">
                    <p><strong>CATEGORY: </strong>Wordpress Plugin <strong class="padding-l-30">CLIENT: </strong>UOU ltd.</p>
                    <p><strong>DESCRIPTION: </strong></p><br>
                </div>
                <div class="col-lg-6 col-sm-12">
                    <p>The website is a wordpress + custom plugin that helps people to
                        create professional profiles.
                        People can easily install the plugin on own web site or create a profile on the centralized
                        moticv system.
                        The plugin creates CVs according to all requirements of European Commission.
                    </p>
                </div>
                <div class="col-lg-6 col-sm-12">
                    Technical details of the Wordpress Plugin:<br>
                    <ul>
                        <li>Custom Post Type</li>
                        <li>EAUC API (soft/hard skills)</li>
                        <li>Javascript CV Builder</li>
                        <li>Standardized profile page</li>
                    </ul>
                    Technologies: PHP 5.6, MySQL 5.6, HTML5, CSS3, Bootstrap, jQuery 2.x
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
                        <div class="col-lg-8 col-md-12 evaluation-txt">
                            <h3>Do you need to get a quote of your project or idea?</h3>
                        </div>
                        <div class="col-lg-4 col-md-12">
                            <a href="<?=Url::to(["site/contact"])?>" class="en-btn">REQUEST A QUOTE</a>
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
                        <span class="button">UPLOAD FILE</span>
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
                    <button class="btn btn-link back"><strong>&lt; BACK</strong></button>
                </div>
                <div class = "col-lg-10 col-sm-10 col-xs-8">
                    <button class="btn btn-primary next">NEXT</button>
                    <button class="btn btn-primary quotes">GET MY QUOTES</button>
                </div>
            </div>

            <!-- </form>-->
            <?php ActiveForm::end() ?>


        <div class="answer-ajax">
            <p>Thank You for your effort, Skynix team will process your request as soon as possible and get back to you with quotes</p>
            <button class="btn btn btn-primary close-popap close">CLOSE</button>

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

                    <div class="prev-box">

                        <div>
                            <a class="prev" href="javascript:void(0);">

                                <div class="hidden768">
                                    PREV<br>PROJECT
                                </div>
                                <div class="visible768">
                                    PREV PROJECT
                                </div>

                            </a>
                        </div>

                    </div>
                    <div class="viewport">

                    </div>
                    <div class="next-box">

                        <div>
                            <a class="next" href="javascript:void(0);">

                                <div class="hidden768">
                                    NEXT<br>PROJECT
                                </div>
                                <div class="visible768">
                                    NEXT PROJECT
                                </div>

                            </a>
                        </div>

                    </div>
                </div>

                <div class="col-lg-12">

                    <div class="container-fluid info-box"></div>

                </div>
                <div class="col-lg-12">
                    <a href="#" class="btn read-more" target = "_blank" rel="nofollow">VISIT WEBSITE</a>
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




 
  

