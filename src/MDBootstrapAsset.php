<?php

namespace antonyz89\mdb;

use yii\web\AssetBundle;

/**
 * Class MDBootstrapAsset
 * @package antonyz89\mdb\widgets
 * 
 * Yii2 MDBootstrap
 * 
 * @author Antony Gabriel <antonyz.dev@gmail.com>
 * 
 * @since 1.0.0
 */
class MDBootstrapAsset extends AssetBundle
{
    public $sourcePath = '@antonyz89/mdb/assets';
    public $css = [
        'css/main.scss',
        'css/sidebar.scss',
        'css/form.scss',
    ];
    public $js = [
        'js/modal.js',
        'js/init.js',
        'js/sidebar.js',
    ];
    public $depends = [];
}
