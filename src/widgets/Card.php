<?php

namespace antonyz89\mdb\widgets;

use antonyz89\mdb\helpers\Html;
use yii\base\Widget;
use yii\helpers\ArrayHelper;

/**
 * Class Card
 * @package antonyz89\mdb\widgets
 * 
 * Yii2 MDBootstrap
 * 
 * @author Antony Gabriel <antonyz.dev@gmail.com>
 * 
 * @since 1.0.0
 */
class Card extends Widget
{
    /** @var string|null */
    public $header;

    /** @var array */
    public $headerOptions  = [];

    /** @var string|null */
    public $title;

    /** @var array */
    public $titleOptions = [];

    /** @var string|null */
    public $content;

    /** @var string|null */
    public $footer;

    /** @var array */
    public $footerOptions = ['class' => 'card-footer'];

    /** @var array */
    public $options = [];

    public function init()
    {
        parent::init();

        $this->options['class'] = 'card ' . ArrayHelper::getValue($this->options, 'class');

        $id = ArrayHelper::getValue($this->options, 'id');

        if ($id) {
            $this->setId($id);
        }

        echo Html::beginTag('div', $this->options) . "\n";
        $this->renderHeader();
        echo Html::beginTag('div', 'card-body') . "\n";
        $this->renderTitle();
        $this->renderContent();
    }

    public function run()
    {
        echo "\n" . Html::endTag('div');
        $this->renderFooter();
        echo "\n" . Html::endTag('div');
    }

    public function renderHeader(): void
    {
        if ($this->header) {
            $this->headerOptions['class'] = 'card-header font-weight-bold ' . ArrayHelper::getValue($this->headerOptions, 'class');

            $tag = ArrayHelper::remove($this->headerOptions, 'tag', 'h5');

            echo Html::tag($tag, $this->header, $this->headerOptions);
        }
    }

    public function renderTitle(): void
    {
        if ($this->title) {
            $this->titleOptions['class'] = 'card-title ' . ArrayHelper::getValue($this->titleOptions, 'class');

            $tag = ArrayHelper::remove($this->titleOptions, 'tag', 'h5');

            echo Html::tag($tag, $this->title, $this->titleOptions) . "\n";
        }
    }

    public function renderContent(): void
    {
        if (is_array($this->content)) {
            echo implode("\n", $this->content);
        } else {
            echo $this->content;
        }
    }

    public function renderFooter()
    {
        if (is_callable($this->footer)) {
            $footer = call_user_func($this->footer);
        } else {
            $footer = $this->footer;
        }

        if ($this->footer) {
            echo Html::tag('div', $footer, $this->footerOptions);
        }
    }
}
