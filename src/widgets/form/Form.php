<?php

namespace antonyz89\mdb\widgets\form;

use antonyz89\mdb\helpers\Html;
use antonyz89\mdb\widgets\Card;
use yii\base\Widget;
use yii\db\ActiveRecord;

/**
 * Class Form
 * @package antonyz89\mdb\widgets
 * 
 * Yii2 MDBootstrap
 * 
 * @author Antony Gabriel <antonyz.dev@gmail.com>
 * 
 * @since 1.0.0
 */
class Form extends Widget
{
    /** @var ActiveRecord */
    public $model;

    public function init()
    {
        Card::begin([
            'footer' => Html::submitButton($this->model->isNewRecord ? 'Cadastrar' : 'Atualizar', ['class' => 'btn-' . ($this->model->isNewRecord ? 'success' : 'primary')]),
            'footerOptions' => ['class' => 'card-footer text-end']
        ]);

        parent::init();
    }

    public function run()
    {
        Card::end();
    }
}
