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

i18n
--

add in `common\config\main.php`

```php
return [
    ...
    'components' => [
       ...
       'i18n' => [
            'translations' => [
                'mdb' => [
                    'class' => PhpMessageSource::class,
                    'basePath' => '@antonyz89/mdb/messages',
                ],
            ],
        ], 
    ]
];
```

Modal
--

- Close modal after submit
- Callback after submit

**⚠️ IMPORTANT:**
- `modal=1` is added to URL when submit is triggered on modal to ignore ajax validation requests and save your model successfully.
- `data-callback` attribute is required even you don't wan't use a callback ( in this case use `callback=null`, `data-callback=false` or something else ). This is because when an `<a>` tag is clicked with `data-callback` attribute will add an `data-ajax=1` on your form to do submit via ajax and close modal when you return `{ success: true }`
 
```php
<?= Html::a(
    Html::icon('plus'),
    ['example/create'],
    [
        'id' => 'add_example',
        'class' => 'btn btn-success show-modal', // .show-modal is required
        'data' => [
            'target' => '#modal',
            'header' => 'Create Example',
            'callback' => 'modalCallback' // (required) your callback function who will be called after submit receiving response from server
        ]
    ]
) ?>

<?php 
$js = <<<JS
    function modalCallback(data) {
        if (data.success) {
            // do something
        }
    }
JS;
?>
```

```php
public function actionCreate()
{
    $model = new Example();

    // check if request is made via modal
    $isModal = $this->request->get('modal');

    if ($model->load(Yii::$app->request->post())) {
        // (opcional) ajax validation (disabled if modal ins't null)
        if (Yii::$app->request->isAjax && !$isModal) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->save()) {

            // if request is made via modal then return json object
            if ($isModal) {
                $this->response->format = Response::FORMAT_JSON;

                return [
                    // returning [[success => true]] closes modal
                    'success' => true,

                    // your data here
                    'model' => $model,
                    'message' => Yii::t('app', 'Created successfully'),
                ];
            }

            Yii::$app->session->setFlash('success', Yii::t('app', 'Created successfully'));
            return $this->redirect(['index']);
        }
    }

    return $this->render('create', [
        'model' => $model,
    ]);
}
```

# CREDITS

* UI components built with [Material Design Bootstrap 5](https://mdbootstrap.com).
* [Kartik](https://github.com/kartik-v) enhanced Yii2's components

# Support the project
* Star the repo
* Create issue report or feature request
