<?php

namespace antonyz89\mdb;

use yii\web\AssetBundle;

/**
 * Class MDBootstrapPluginAsset
 * @package antonyz89\mdb\widgets
 * 
 * Yii2 MDBootstrap
 * 
 * @author Antony Gabriel <antonyz.dev@gmail.com>
 * 
 * @since 1.0.0
 */
class MDBootstrapPluginAsset extends AssetBundle
{
    public $sourcePath = '@npm/mdb-ui-kit';
    public $css = [
        'https://fonts.googleapis.com/icon?family=Material+Icons',
        'css/mdb.min.css',
    ];
    public $js = [
        'js/mdb.min.js'
    ];
    public $depends = [];
}
