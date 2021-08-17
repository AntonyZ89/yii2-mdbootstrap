<?php

namespace antonyz89\mdb;

use yii\web\AssetBundle;

class MDBootstrapPluginAsset extends AssetBundle
{
    public $sourcePath = '@npm/mdb-ui-kit';
    public $css = [
        'css/mdb.min.css',
    ];
    public $js = [
        'js/mdb.min.js'
    ];
    public $depends = [];
}
