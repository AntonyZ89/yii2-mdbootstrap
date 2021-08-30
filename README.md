Yii2 - Material Design Bootstrap 5
===========================

Material Design Bootstrap 5 for Yii2

# Installation

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```bash
php composer.phar require --prefer-dist antonyz89/yii2-mdb "*"
```

or add

```
"antonyz89/yii2-mdb": "*"
```

to the require section of your `composer.json` file.

Install sass to convert scss files, for now this is necessary.

```bash
npm install -g sass
```

# Usage

1. add `MDBootstrapPluginAsset::class` and `MDBootstrapAsset::class` to your `AppAsset::class`

```php
use antonyz89\mdb\MDBootstrapAsset;
use yii\web\YiiAsset;

class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $css = [];
    public $js = [];
    public $depends = [
        // ...
        MDBootstrapPluginAsset::class, // 1st
        MDBootstrapAsset::class,       // 2nd
    ];
}
```

# CREDITS

* UI components built with [Material Design Bootstrap 5](https://mdbootstrap.com).
* [Kartik](https://github.com/kartik-v) enhanced Yii2's components

# Support the project
* Star the repo
* Create issue report or feature request