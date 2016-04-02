<?php
use yii\helpers\Url;
/* @var $this yii\web\View
 */

$this->title = 'My Yii Application';
?>
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
                        in IT World. We have only one goal in mind-to develop, excite and foster changes through our
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
                <strong>FRONTEND DEVELOPMENT</strong><br>
                <ul>
                    <li>HTML5</li>
                    <li>CSS3</li>
                    <li>jQuery</li>
                    <li>Sencha ExtJS</li>
                    <li>AngularJS</li>
                    <li>Twitter Bootstrap</li>
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
                        <div class="col-lg-8 col-md-12 evaluation-txt">
                            <p>Do you need to get a quote of your project or idea?</p>
                        </div>
                        <div class="col-lg-4 col-md-12">
                            <a href="#" class="en-btn">REQUEST A QUOTE</a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<!--****   Popup REQUEST a QUOTE modals   ****-->

<div id="request-quote-modals">

    <div class="box-popup">
        <div class="close"></div>
        <div class="header-popap">Receive the quote from our technical leader who knows the field the best.</div>


        <form action="api.php" class="container-fluid" method="post">


            <div class="row body-popap">
                <div class = "col-lg-12 step1">
                    <div class="question">What is your website/application state?</div>

                    <div class="option-group">
                        <input type="radio" value="Active site/application" name="active_site_application" id="active">
                        <label for="active">Active site/application</label>
                    </div>

                    <div class="option-group">
                        <input type="radio" value="Only technical specification" name="prog_lang" id="technical">
                        <label for="technical">Only technical specification</label>
                    </div>

                    <div class="option-group">
                        <input type="radio" value="Only concept" name="prog_lang" id="concept">
                        <label for="concept">Only concept</label>
                    </div>

                    <div class="option-group">
                        <input type="radio" value="In development" name="prog_lang" id="development">
                        <label for="development">In development</label>
                    </div>

                </div>
                <div class = "col-lg-12 step2">
                    <div class="question">What is your platform?</div>
                </div>
                <div class = "col-lg-12 step3">
                    <div class="question">What is your prefered frontend platform?</div>
                </div>
                <div class = "col-lg-12 step4">
                    <div class="question"> When are you looking to start?</div>
                </div>
                <div class = "col-lg-12 step5">

                </div>
                <div class = "col-lg-12 step6">

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
                <div class = "col-lg-2 col-xs-2">
                    <button class="btn btn-link back">&lt; BACK</button>
                </div>
                <div class = "col-lg-10 col-xs-10">
                    <button class="btn btn btn-primary next">NEXT</button>
                    <button class="btn btn btn-primary quotes">GET MY QUOTES</button>
                </div>
            </div>
        </form>
    </div>


</div>



<!--****   End Popup REQUEST a QUOTE modals   ****-->
<?php $this->registerJsFile('/js/popup-request-quote-modals.js'); ?>