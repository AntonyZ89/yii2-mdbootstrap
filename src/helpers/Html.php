<?php

namespace antonyz89\mdb\helpers;

use antonyz89\templates\helpers\Html as HtmlBase;

/**
 * Class Html
 * @package antonyz89\mdb\widgets
 * 
 * Yii2 MDBootstrap
 * 
 * @author Antony Gabriel <antonyz.dev@gmail.com>
 * 
 * @since 1.0.0
 */
class Html extends HtmlBase
{
    public const DEFAULT_ROW = 'gx-2 align-items-end';
    public const DEFAULT_CHECKBOX = 'form-check-input';

    /**
     * @inheritDoc
     */
    public static function checkbox($name, $checked = false, $options = self::DEFAULT_CHECKBOX)
    {
        if (is_string($options)) {
            $options = ['class' => $options];
        } else if (!isset($options['class'])) {
            $options['class'] = self::DEFAULT_CHECKBOX;
        }

        return parent::checkbox($name, $checked, $options);
    }
}
