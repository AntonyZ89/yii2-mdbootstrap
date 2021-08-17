<?php

namespace antonyz89\mdb\widgets\form;

use kartik\form\ActiveForm as ActiveFormBase;

class ActiveForm extends ActiveFormBase
{
    public $fieldClass = ActiveField::class;

    public $tooltipStyleFeedback = true;
}
