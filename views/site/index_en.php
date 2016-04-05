<?php
use yii\helpers\Url;
/* @var $this yii\web\View
 */

$this->title = 'Welcome to the Skynix - software development company';
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

    <div class="popup">
        <div class="close"></div>
        <div class="header-popap">Receive the quote from our technical leader who knows the field the best.</div>


        <form action="api.php" class="container-fluid" method="post">


            <div class="row body-popap">

                <div class = "col-lg-12 step1">
                    <div class="question">What is your website/application state?</div>
                    <div class="option-group">
                        <input type="radio" value="Active site/application" name="your_website" id="active" checked="checked" >
                        <label for="active">Active site/application</label>
                    </div>

                    <div class="option-group right-elem">
                        <input type="radio" value="Only technical specification" name="your_website" id="technical"  >
                        <label for="technical">Only technical specification</label>
                    </div>

                    <div class="option-group">
                        <input type="radio" value="Only concept" name="your_website" id="concept"  >
                        <label for="concept">Only concept</label>
                    </div>

                    <div class="option-group right-elem">
                        <input type="radio" value="In development" name="your_website" id="development"  >
                        <label for="development">In development</label>
                    </div>
                </div>

                <div class = "col-lg-12 step2">
                    <div class="question">What is your platform?</div>
                    <div class="input-group-btn select">
                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" value="Magento 1.x" name="your_platform">
                            Magento 1.x <span class="caret1">&or;</span>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a href="#">Magento 1.x</a></li>
                            <li><a href="#">Magento 2.x</a></li>
                            <li><a href="#">Wordpress</a></li>
                            <li><a href="#">Yii 1, Yii 2</a></li>
                            <li><a href="#">ZF 1, ZF2</a></li>
                            <li><a href="#">HTML/CSS/Javascript</a></li>
                            <li><a href="#">Other</a></li>
                        </ul>
                    </div>
                    <div class="question margin-text">What kind of services do you need?</div>
                    <div class="option-group">
                        <input type="checkbox" value="New module, plugin, extension" name="module_plugin" id="module_plugin" checked="checked">
                        <label for="module_plugin">New module,<br> plugin, extension</label>
                    </div>
                    <div class="option-group right-elem">
                        <input type="checkbox" value="Existing code adjustments" name="code_adjustments" id="code_adjustments">
                        <label for="code_adjustments">Existing code<br> adjustments</label>
                    </div>
                    <div class="option-group">
                        <input type="checkbox" value="New graphic design" name="graphic_design" id="graphic_design">
                        <label for="graphic_design">New<br> graphic design</label>
                    </div>
                    <div class="option-group right-elem">
                        <input type="checkbox" value="Optimization" name="optimization" id="optimization">
                        <label for="optimization">Optimization</label>
                    </div>
                    <div class="option-group">
                        <input type="checkbox" value="Redesign" name="redesign" id="redesign">
                        <label for="redesign">Redesign</label>
                    </div>
                    <div class="option-group right-elem">
                        <input type="checkbox" value="Server Administration" name="server_administration" id="server_administration" checked="checked">
                        <label for="server_administration">Server<br> Administration</label>
                    </div>
                </div>

                <div class = "col-lg-12 step3">
                    <div class="question">What is your prefered backend platform?</div>
                    <div class="input-group-btn select">
                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" value="Magento 1.x" name="prefered_backend_platform">
                            Magento 1.x <span class="caret1">&or;</span>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a href="#">Magento 1.x</a></li>
                            <li><a href="#">Magento 2.x</a></li>
                            <li><a href="#">Wordpress</a></li>
                            <li><a href="#">Yii 2</a></li>
                            <li><a href="#">Zend Framework 2</a></li>
                            <li><a href="#">HTML/CSS/Javascript</a></li>
                            <li><a href="#">No need for a backend</a></li>
                        </ul>
                    </div>
                    <div class="question margin-text">What is your prefered frontend platform?</div>
                    <div class="input-group-btn select">
                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" value="Twitter Bootstrap template" name="prefered_frontend_platform">
                            Twitter Bootstrap template<span class="caret1">&or;</span>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a href="#">Twitter Bootstrap template</a></li>
                            <li><a href="#">HTML5, CSS3 template</a></li>
                            <li><a href="#">jQuery application</a></li>
                            <li><a href="#">AngularJS application</a></li>
                            <li><a href="#">No need for a frontend</a></li>
                        </ul>
                    </div>
                </div>

                <div class = "col-lg-12 step4">
                    <div class="question"> When are you looking to start?</div>
                    <div class="input-group-btn select">
                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" value="Immediately" name="looking_start">
                            Immediately<span class="caret1">&or;</span>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a href="#">Immediately</a></li>
                            <li><a href="#">1-2 weeks</a></li>
                            <li><a href="#">3-4 weeks</a></li>
                            <li><a href="#">in 1-2 months</a></li>
                        </ul>



                    </div>
                    <div class="question margin-text">What is your budget?</div>
                    <div class="input-group-btn select">
                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" value="$1000 - $5000" name="your_budget">
                            $1000 - $5000<span class="caret1">&or;</span>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a href="#">&lt; $300</a></li>
                            <li><a href="#">$300 - $1000</a></li>
                            <li><a href="#">$1000 - $5000</a></li>
                            <li><a href="#">&gt; $5000</a></li>

                        </ul>
                    </div>



                </div>
                <div class = "col-lg-12 step5">
                    <textarea rows="8" cols="45" name="project_description" placeholder="project description..."></textarea>

                    <label class="file_upload">
                        <span class="button">UPLOAD FILE</span>
                        <input type="file" id="file" name="file" multiple>
                    </label>


                </div>
                <div class = "col-lg-12 step6">
                    <input type="text" placeholder="Name" name="name" autocomplete="on" required >
                    <input type="email" placeholder="Email Address" name="email" autocomplete="on" required >
                    <input type="text" placeholder="Company" name="company" autocomplete="on">
                    <input type="text" placeholder="Country" name="country" autocomplete="on">
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
                    <button class="btn btn-link back"><strong>&lt; BACK</strong></button>
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