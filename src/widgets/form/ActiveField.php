<?php

namespace antonyz89\mdb\widgets\form;

use kartik\datecontrol\DateControl;
use kartik\form\ActiveField as ActiveFieldBase;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use antonyz89\mdb\helpers\Html;
use kartik\file\FileInput;

/**
 * Class ActiveField
 * @package antonyz89\mdb\widgets
 *
 * Yii2 MDBootstrap
 *
 * @author Antony Gabriel <antonyz.dev@gmail.com>
 *
 * @since 1.0.0
 */
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

    /**
     * temp override
     *
     * @inheritDoc
     */
    protected function createLayoutConfig($instanceConfig = [])
    {
        $form = $instanceConfig['form'];
        $layout = $form->type;
        $bsVer = $form->getBsVer();
        $config = [
            'hintOptions' => ['tag' => 'div', 'class' => ['form-text', 'text-muted', 'small']],
            'errorOptions' => ['tag' => 'div', 'class' => 'invalid-feedback'],
            'inputOptions' => ['class' => 'form-control'],
            'labelOptions' => ['class' => 'form-label'],
            'options' => ['class' => 'form-outline mb-4'],
        ];

        if ($layout === ActiveForm::TYPE_HORIZONTAL) {
            $config['template'] = "{label}\n{beginWrapper}\n{input}\n{error}\n{hint}\n{endWrapper}";
            $config['wrapperOptions'] = $config['labelOptions'] = [];
            $cssClasses = [
                'offset' => $bsVer === 3 ? 'col-sm-offset-3' : ['col-sm-10', 'offset-sm-2'],
                'field' => $bsVer > 3 ? 'row' : 'form-group',
            ];
            if (isset($instanceConfig['horizontalCssClasses'])) {
                $cssClasses = ArrayHelper::merge($cssClasses, $instanceConfig['horizontalCssClasses']);
            }
            $config['horizontalCssClasses'] = $cssClasses;
            foreach (array_keys($cssClasses) as $cfg) {
                $key = $cfg === 'field' ? 'options' : "{$cfg}Options";
                if ($cfg !== 'offset' && !empty($cssClasses[$cfg])) {
                    Html::addCssClass($config[$key], $cssClasses[$cfg]);
                }
            }
        } elseif ($layout === ActiveForm::TYPE_INLINE) {
            $config['inputOptions']['placeholder'] = true;
            Html::addCssClass($config['options'], 'col-12');
            Html::addCssClass($config['labelOptions'], ['screenreader' => $form->getSrOnlyCss()]);
        } elseif ($bsVer === 5 && $layout === ActiveForm::TYPE_FLOATING) {
            $config['inputOptions']['placeholder'] = true;
            $config['template'] = "{input}\n{label}\n{error}\n{hint}";
            Html::addCssClass($config['options'], ['layout' => 'form-floating mt-3']);
        }

        return $config;
    }

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

    /**
     * @inheritdoc
     */
    public function checkboxList($items, $options = [])
    {
        $this->template = "{label}\n{input}\n{hint}";
        return parent::checkboxList($items, $options);
    }

    public function widget($class, $config = [])
    {
        $original_template = $this->template;

        $this->template = "{label}\n{input}\n{hint}\n{error}";

        switch ($class) {
            case $this->compare($class, 'kartik\select2\Select2'):
                $this->addErrorClassBS4($this->inputOptions);
            case $this->compare($class, 'kartik\datecontrol\DateControl'):
            case $this->compare($class, 'kartik\time\TimePicker'):
            case $this->compare($class, 'kartik\daterange\DateRangePicker'):
            case $this->compare($class, 'kartik\file\FileInput'):
            case $this->compare($class, 'kartik\switchinput\SwitchInput'):
            case $this->compare($class, 'kartik\color\ColorInput'):
                $this->options['class'] = str_replace('form-outline', 'form-group', $this->options['class']);
                $this->labelOptions = [];
                break;
            case $this->compare($class, 'yii\widgets\MaskedInput'):
            case $this->compare($class, 'kartik\number\NumberControl'):
            case $this->compare($class, 'yii\widgets\InputWidget'):
                $this->template = $original_template;
                break;
        }

        return parent::widget($class, $config);
    }

    protected function compare($class, string $targetClass) {
        return $class === $targetClass || is_subclass_of($class, $targetClass);
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
    protected function getAddonContent($type, $isBs4 = null)
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

    /**
     * @inheritDoc
     */
    public function hiddenInput($options = [])
    {
        $this->options['class'] = str_replace(['form-outline', 'mb-4'], '', $this->options['class']);
        $options = array_merge($this->inputOptions, $options);
        $this->adjustLabelFor($options);
        $this->parts['{input}'] = Html::activeHiddenInput($this->model, $this->attribute, $options);

        return $this;
    }
}
