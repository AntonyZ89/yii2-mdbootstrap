<?php

namespace antonyz89\mdb\widgets\form;

use kartik\datecontrol\DateControl;
use kartik\form\ActiveField as ActiveFieldBase;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use antonyz89\templates\helpers\Html;

class ActiveField extends ActiveFieldBase
{
    /**
     * @inheritdoc
     */
    public $options = ['class' => 'form-outline mb-4'];

    /**
     * @inheritdoc
     */
    public $labelOptions = ['class' => 'form-label'];

    /**
     * @inheritdoc
     */
    public $template = "{input}\n{label}\n{hint}\n{error}";

    public function init()
    {
        if (count($this->addon)) {
            $this->template = "{label}\n{input}\n{hint}\n{error}";
            if ($this->form->tooltipStyleFeedback) {
                $this->template = "{label}\n{input}\n{hint}";
            }
            $this->options['class'] = str_replace('form-outline', '', $this->options['class']);
        }

        parent::init();
    }

    public function widget($class, $config = [])
    {
        switch ($class) {
            case Select2::class:
            case DateControl::class:
                $this->template = "{label}\n{input}\n{hint}\n{error}";
                $this->options['class'] = str_replace('form-outline', 'form-group', $this->options['class']);
                $this->labelOptions = [];
                break;
        }

        return parent::widget($class, $config);
    }

    /**
     * @inheritDoc
     */
    protected function generateAddon()
    {
        if (empty($this->addon)) {
            return '{input}';
        }
        $addon = $this->addon;
        $isBs4 = $this->form->isBs4();
        $prepend = $this->getAddonContent('prepend', $isBs4);
        $append = $this->getAddonContent('append', $isBs4);
        $content = $prepend . '{input}' . ($this->form->tooltipStyleFeedback ? '{error}' : '') . $append;
        $group = ArrayHelper::getValue($addon, 'groupOptions', []);
        Html::addCssClass($group, 'input-group');
        $contentBefore = ArrayHelper::getValue($addon, 'contentBefore', '');
        $contentAfter = ArrayHelper::getValue($addon, 'contentAfter', '');
        $content = Html::tag('div', $contentBefore . $content . $contentAfter, $group);
        return $content;
    }

    /**
     * @inheritdoc
     */
    protected function getAddonContent($type, $isBs4)
    {
        $addon = ArrayHelper::getValue($this->addon, $type, '');
        if (!is_array($addon)) {
            return $addon;
        }
        if (isset($addon['content'])) {
            $out = static::renderAddonItem($addon, $isBs4);
        } else {
            $out = '';
            foreach ($addon as $item) {
                if (is_array($item) && isset($item['content'])) {
                    $out .= static::renderAddonItem($item, $isBs4);
                }
            }
        }
        return $out;
    }
}
