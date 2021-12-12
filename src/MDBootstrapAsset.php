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
    public $sourcePath = '@antonyz89/mdb/assets/dist';
    public $css = [
        'css/main.min.css',
        'css/sidebar.min.css',
        'css/form.min.css',
    ];
    public $js = [
        'js/modal.min.js',
        'js/init.min.js',
        'js/sidebar.min.js',
    ];
    public $depends = [];
}
