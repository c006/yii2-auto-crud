Yii2 Auto CRUD
===================

Overview
---------

This extension queries all tables in a connection database (usually db) and creates all models, controllers and views (CRUD) automatically.

Create the database tables first then run this extension and it will create the majority for you.

Demo: [http://demo.c006.us/crud](http://demo.c006.us/crud)



Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist "c006/yii2-auto-crud" "*"
```

or add

```
"c006/yii2-auto-crud": "*"
```

to the require section of your `composer.json` file.


Required
--------

Basic ```config/web.php```

Advanced ```[backend|frontend|common]/config/main.php```

>
        'modules'    => [
            'crud' => [
                'class' => 'c006\crud\Module',
            ],
            ...
            ...
        ],



Install before using "yii2-auto-crud".

```php composer.phar require --prefer-dist "c006/yii2-submit-spinner" "*"```


Options
-------

No options for this extension



Usage
-----

Pretty Url's ```/crud```

No pretty Url's ```index.php?r=crud```


Errors
---------

If you see this error.

![Error Message](http://demo.c006.us/images/yii2-submit-spinner/invalid-configuration.jpg)

In this file ```vendor/c006/yii2-auto-crud/assets/AppAssets.php```

comment out these lines.

>
        public $depends = [
            // 'yii\web\YiiAsset',
            // 'yii\widgets\ActiveFormAsset',
            // 'yii\bootstrap\BootstrapAsset',
        ];


Comments / Suggestions
--------------------

Please provide any helpful feedback or requests.

Thanks.


































