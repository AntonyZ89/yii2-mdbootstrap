<?php

namespace antonyz89\mdb\widgets;

use antonyz89\mdb\helpers\Html;
use yii\bootstrap4\Modal as ModalBase;
use yii\helpers\ArrayHelper;

class Modal extends ModalBase
{

    public $options = [
        'tabindex' => false
    ];

    public $closeButton = [
        'type' => 'button',
        'class' => 'btn-close',
        'data-mdb-dismiss' => 'modal',
        'aria-label' => 'Close'
    ];

    /**
     * Renders the close button.
     * @return string the rendering result
     */
    protected function renderCloseButton()
    {
        if (($closeButton = $this->closeButton) !== false) {
            $tag = ArrayHelper::remove($closeButton, 'tag', 'button');
            $label = ArrayHelper::remove($closeButton, 'label', null);

            return Html::tag($tag, $label, $closeButton);
        } else {
            return null;
        }
    }
}
