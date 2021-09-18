# YII2-UTILITY

This is Yii2 utilities.

Requirements
---------

* PHP >= 5.6
* Curl extension for PHP5 must be enabled.

Download
---------

#### Using Composer

From your project directory, run:
```
composer require algol-team/library-yii2
```
or
```
php composer.phar require algol-team/library-yii2
```
Note: If you don't have Composer you can download it [HERE](https://getcomposer.org/download/).

#### Using release archives

https://github.com/algol-team/yii2-utility/releases

#### Using Git

From a project directory, run:
```
git clone https://github.com/algol-team/yii2-utility.git
```

Installation
---------

#### Via Composer's autoloader

After downloading by using Composer, you can include Composer's autoloader:
```php

<?php
use ExpandColumn;
?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        [
            'class' => ExpandColumn::class,
            'attribute' => 'name',
            'url' => Url::to(['your-show-page']),
        ],
    ],
]) ?>
```
License
------------

This open-source software is distributed under the BSD-3-Clause License. See LICENSE.md

Contributing
------------

All kinds of contributions are welcome - code, tests, documentation, bug reports, new features, etc...

* Send feedbacks.
* Submit bug reports.
* Write/Edit the documents.
* Fix bugs or add new features.

Contact me
------------

You can contact me [via Telegram](https://telegram.me/algol-team) but if you have an issue please [open](https://github.com/algol-team) one.

Support me
------------

You can support me using via LiberaPay [![Donate using Liberapay](https://liberapay.com/assets/widgets/donate.svg)](https://liberapay.com/algol-team/donate)

or buy me a beer or two using [Paypal](https://paypal.me/algol-team).