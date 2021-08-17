<?php

namespace antonyz89\mdb;

use yii\web\AssetBundle;

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
