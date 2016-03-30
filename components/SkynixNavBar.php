<?php
/**
 * Created by PhpStorm.
 * User: olha
 * Date: 30.03.16
 * Time: 13:05
 */
namespace app\components;

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\bootstrap\BootstrapPluginAsset;

class SkynixNavBar extends \yii\bootstrap\NavBar
{
public $skynixLinks;
    /**
     * Renders the widget.
     */
    public function run()
    {
        $tag = ArrayHelper::remove($this->containerOptions, 'tag', 'div');
        echo Html::endTag($tag);
        if(isset($this->skynixLinks)){

            echo Html::beginTag('div', ['class' => 'skynix-links']);
            echo $this->skynixLinks;
            echo Html::endTag('div');

        }
        if ($this->renderInnerContainer) {
            echo Html::endTag('div');
        }
        $tag = ArrayHelper::remove($this->options, 'tag', 'nav');
        echo Html::endTag($tag, $this->options);
        BootstrapPluginAsset::register($this->getView());
    }
}