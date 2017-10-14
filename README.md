<p align="center">
    <a href="https://github.com/yiisoft" target="_blank">
        <img src="https://avatars0.githubusercontent.com/u/993323" height="100px">
    </a>
    <h1 align="center">Swagger Documentation Generator for Yii2 Framework</h1>
    <br>
</p>

Swagger/OpenAPI Documentation Generator for Yii2 Framework.

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist yii2mod/yii2-swagger "*"
```

or add

```
"yii2mod/yii2-swagger": "*"
```

to the require section of your composer.json.

Configuration
-------------
You need to configure two actions as follows:

```php
<?php

namespace app\controllers;

use Yii;
use yii\helpers\Url;
use yii\web\Controller;

/**
 * Class SiteController
 *
 * @package app\controllers
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function actions(): array
    {
        return [
            'docs' => [
                'class' => 'yii2mod\swagger\SwaggerAction',
                'restUrl' => Url::to(['site/json-schema']),
            ],
            'json-schema' => [
                'class' => 'yii2mod\swagger\SwaggerApiAction',
                // Тhe list of directories that contains the swagger annotations.
                'scanDir' => [
                    Yii::getAlias('@app/modules/api'),
                ],
            ],
        ];
    }
}
```
