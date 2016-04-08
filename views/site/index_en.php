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
<div class="masks-back"></div>
    <div class="popup">
        <div class="close"></div>
        <div class="header-popap">Receive the quote from our technical leader who knows the field the best.</div>


        <form action="site/request" class="container-fluid" method="post">


            <div class="row body-popap">

                <div class = "col-lg-12 step step1">
                    <div class="question">What is your website/application state?</div>
                    <div class="option-group">
                        <input type="radio" value="Active site application" name="website_state" id="active" checked="checked" >
                        <label for="active">Active site/application</label>
                    </div>

                    <div class="option-group right-elem">
                        <input type="radio" value="Only technical specification" name="website_state" id="technical"  >
                        <label for="technical">Only technical specification</label>
                    </div>

                    <div class="option-group">
                        <input type="radio" value="Only concept" name="website_state" id="concept"  >
                        <label for="concept">Only concept</label>
                    </div>

                    <div class="option-group right-elem">
                        <input type="radio" value="In development" name="website_state" id="development"  >
                        <label for="development">In development</label>
                    </div>
                </div>

                <div class = "col-lg-12 step step2">
                    <div class="question">What is your platform?</div>
                    <div class="input-group-btn select">

                        <!--<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" value="Magento 1.x" name="platform" id="platform">
                            Magento 1.x <span class="caret1">&or;</span>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="platform">
                            <li><a href="#">Magento 1.x</a></li>
                            <li><a href="#">Magento 2.x</a></li>
                            <li><a href="#">Wordpress</a></li>
                            <li><a href="#">Yii 1, Yii 2</a></li>
                            <li><a href="#">ZF 1, ZF2</a></li>
                            <li><a href="#">HTML/CSS/Javascript</a></li>
                            <li><a href="#">Other</a></li>
                        </ul>-->
                        <select class="dropdown-toggle form-control">
                            <option>Magento 1.x</option>
                            <option>Magento 2.x</option>
                            <option>Wordpress</option>
                            <option>Yii 1, Yii 2</option>
                            <option>ZF 1, ZF2</option>
                            <option>HTML/CSS/Javascript</option>
                            <option>Other</option>
                        </select>



                    </div>
                    <div class="question margin-text">What kind of services do you need?</div>
                    <div class="option-group">
                        <input type="checkbox" value="New module, plugin, extension" name="services[]" id="module_plugin">
                        <label for="module_plugin"><span class="hidden-xs">New module,<br> plugin, extension</span><span class="visible-xs">New module, plugin, extension</span></label>
                    </div>
                    <div class="option-group right-elem">
                        <input type="checkbox" value="Existing code adjustments" name="services[]" id="code_adjustments">
                        <label for="code_adjustments"><span class="hidden-xs">Existing code<br> adjustments</span><span class="visible-xs">Existing code adjustments</span></label>
                    </div>
                    <div class="option-group">
                        <input type="checkbox" value="New graphic design" name="services[]" id="graphic_design">
                        <label for="graphic_design"><span class="hidden-xs">New<br> graphic design</span><span class="visible-xs">New graphic design</span></label>
                    </div>
                    <div class="option-group right-elem">
                        <input type="checkbox" value="Optimization" name="services[]" id="optimization">
                        <label for="optimization">Optimization</label>
                    </div>
                    <div class="option-group">
                        <input type="checkbox" value="Redesign" name="services[]" id="redesign">
                        <label for="redesign">Redesign</label>
                    </div>
                    <div class="option-group right-elem">
                        <input type="checkbox" value="Server Administration" name="services[]" id="server_administration">
                        <label for="server_administration"><span class="hidden-xs">Server<br> Administration</span><span class="visible-xs">Server Administration</span></label>
                    </div>
                </div>

                <div class = "col-lg-12 step step3">
                    <div class="question">What is your prefered backend platform?</div>
                    <div class="input-group-btn select">
                        <!--<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" value="Magento 1.x" name="backend_platform" id="backend_platform">
                            Magento 1.x <span class="caret1">&or;</span>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="backend_platform">
                            <li><a href="#">Magento 1.x</a></li>
                            <li><a href="#">Magento 2.x</a></li>
                            <li><a href="#">Wordpress</a></li>
                            <li><a href="#">Yii 2</a></li>
                            <li><a href="#">Zend Framework 2</a></li>
                            <li><a href="#">HTML/CSS/Javascript</a></li>
                            <li><a href="#">No need for a backend</a></li>
                        </ul>-->

                        <select class="dropdown-toggle form-control">
                            <option>Magento 1.x</option>
                            <option>Magento 2.x</option>
                            <option>Wordpress</option>
                            <option>Yii 2</option>
                            <option>Zend Framework 2</option>
                            <option>HTML/CSS/Javascript</option>
                            <option>No need for a backend</option>
                        </select>
                    </div>
                    <div class="question margin-text">What is your prefered frontend platform?</div>
                    <div class="input-group-btn select">
                        <!--<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" value="Twitter Bootstrap template" name="frontend_platform" id="frontend_platform">
                            Twitter Bootstrap template<span class="caret1">&or;</span>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="frontend_platform">
                            <li><a href="#">Twitter Bootstrap template</a></li>
                            <li><a href="#">HTML5, CSS3 template</a></li>
                            <li><a href="#">jQuery application</a></li>
                            <li><a href="#">AngularJS application</a></li>
                            <li><a href="#">No need for a frontend</a></li>
                        </ul>-->

                        <select class="dropdown-toggle form-control">
                            <option>Twitter Bootstrap template</option>
                            <option>HTML5, CSS3 template</option>
                            <option>jQuery application</option>
                            <option>AngularJS application</option>
                            <option>No need for a frontend</option>
                        </select>
                    </div>
                </div>

                <div class = "col-lg-12 step step4">
                    <div class="question"> When are you looking to start?</div>
                    <div class="input-group-btn select">
                        <!--<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" value="Immediately" name="when_start" id="when_start">
                            Immediately<span class="caret1">&or;</span>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="when_start">
                            <li><a href="#">Immediately</a></li>
                            <li><a href="#">1-2 weeks</a></li>
                            <li><a href="#">3-4 weeks</a></li>
                            <li><a href="#">in 1-2 months</a></li>
                        </ul>-->

                        <select class="dropdown-toggle form-control">
                            <option>Immediately</option>
                            <option>1-2 weeks</option>
                            <option>3-4 weeks</option>
                            <option>in 1-2 months</option>
                        </select>


                    </div>
                    <div class="question margin-text">What is your budget?</div>
                    <div class="input-group-btn select">
                        <!--<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" value="$1000 - $5000" name="budget" id="budget">
                            $1000 - $5000<span class="caret1">&or;</span>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="budget">
                            <li><a href="#">&lt; $300</a></li>
                            <li><a href="#">$300 - $1000</a></li>
                            <li><a href="#">$1000 - $5000</a></li>
                            <li><a href="#">&gt; $5000</a></li>
                        </ul>-->

                        <select class="dropdown-toggle form-control">
                            <option>&lt; $300</option>
                            <option>$300 - $1000</option>
                            <option>$1000 - $5000</option>
                            <option>&gt; $5000</option>
                        </select>
                    </div>



                </div>
                <div class = "col-lg-12 step step5">
                    <textarea rows="8" cols="45" name="description" placeholder="project description..."></textarea>

                    <label class="file_upload">
                        <span class="button">UPLOAD FILE</span>
                        <input type="file" id="file" name="file" multiple>
                    </label>


                </div>
                <div class = "col-lg-12 step step6">
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
                <div class = "col-lg-12">
                    <p class="answer-ajax-error"></p>
                </div>
                <div class = "col-lg-2 col-sm-2 col-xs-4">
                    <button class="btn btn-link back"><strong>&lt; BACK</strong></button>
                </div>
                <div class = "col-lg-10 col-sm-10 col-xs-8">
                    <button class="btn btn btn-primary next">NEXT</button>
                    <button class="btn btn btn-primary quotes">GET MY QUOTES</button>
                </div>
            </div>
        </form>
        <div class="answer-ajax">
            <p>Thank You for your effort, Skynix team will process your request as soon as possible and get back to you with quotes</p>
            <button class="btn btn btn-primary close-popap close">CLOSE</button>

        </div>
    </div>
    <div class="front-mask"></div>


</div>



<!--****   End Popup REQUEST a QUOTE modals   ****-->
<?php $this->registerJsFile('/js/popup-request-quote-modals.js'); ?>