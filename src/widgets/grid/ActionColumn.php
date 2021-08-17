<?php


namespace antonyz89\mdb\widgets\grid;

use kartik\grid\ActionColumn as ActionColumnBase;

/**
 * Class ActionColumn
 * @package antonyz89\mdb\widgets
 * 
 * Yii2 MDBootstrap
 * 
 * @author Antony Gabriel <antonyz.dev@gmail.com>
 * 
 * @since 1.0.0
 */
class ActionColumn extends ActionColumnBase
{
    public $buttonOptions = ['class' => 'btn btn-floating btn-sm btn-light'];
    public $viewOptions = ['class' => 'btn btn-floating btn-sm btn-light'];
    public $updateOptions = ['class' => 'btn btn-floating btn-sm btn-primary'];
    public $deleteOptions = ['class' => 'btn btn-floating btn-sm btn-danger'];
}
