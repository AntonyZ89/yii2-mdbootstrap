<?php

namespace antonyz89\mdb\widgets\form;

use kartik\form\ActiveForm as ActiveFormBase;

/**
 * Class ActiveForm
 * @package antonyz89\mdb\widgets
 * 
 * Yii2 MDBootstrap
 * 
 * @author Antony Gabriel <antonyz.dev@gmail.com>
 * 
 * @since 1.0.0
 */
class ActiveForm extends ActiveFormBase
{
    public $fieldClass = ActiveField::class;

    public $tooltipStyleFeedback = true;
}
