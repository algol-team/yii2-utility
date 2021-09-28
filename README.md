# YII2-UTILITY

This is Yii2 utilities.

Requirements
---------

* PHP >= 7.4
* Curl extension for PHP7 must be enabled.

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

Usage
---------
<main.php>
```php
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        [
                'class' => ALGOL_YII::GridColumnExpandOf(),
                'attribute' => 'fTitle',
                'label' => 'Title',
                'onclick' => function ($data) {
                    $FResult = [];
                    if (isset($data['fUrl']) and !empty($data['fUrl'])) {
                        $FResult['value'] = '<i class="fa fa-youtube-play"></i> ' . $data['fTitle'];
                        $FResult['url'] = \yii\helpers\Url::toRoute('info');
                    } else {
                        $FResult['value'] = '<i class="fas fa-folder"></i> ' . $data['fTitle'];
                        $FResult['url'] = yii\helpers\Url::home();
                        $FResult['expand'] = false;
                    }
                    $FResult['data'] = ['id' => $data['ID'], 'hi' => [1, 2, 3]];
                    return $FResult;
                },
        ],
    ],
]) 
?>
```
<controller.php>
```php
<?php
    public function actionInfo($id = null) {
        if (isset($id)) {
            $model = Tlink::findOne($id);
            if (isset($model)) return $this->renderAjax('info', ['model' => $model]);
        }
        return 'not found data...';
    }
?>
```
<view.info.php>
```php
<?php
use yii\widgets\Pjax;
?>

<?php Pjax::begin([]);

$info = ALGOL::EmbedOf()->get($model->fUrl);

?>

    <div class="container-fluid">
        <div class="row">
            <div class="col-3">
                <img class="img-fluid img-responsive rounded shadow" src="<?= $info->image ?>">
            </div>
            <div class="col p-3">
                <div class="list-group list-group-horizontal pb-3 text-center">
                    <a href="<?= $info->authorUrl ?>" class="list-group-item list-group-item-action bg-opacity-75 bg-dark text-white">
                        <h5 class="mb-1"><i class="bi bi-play-btn"></i> Play</h5>
                    </a>
                    <a href="<?= $info->authorUrl ?>" class="list-group-item list-group-item-action bg-opacity-75 bg-dark text-white">
                        <h5 class="mb-1"><i class="bi bi-youtube"></i> YouTube</h5>
                    </a>
                    <a href="<?= $info->authorUrl ?>" class="list-group-item list-group-item-action bg-opacity-75 bg-dark text-white">
                        <h5 class="mb-1"><i class="bi bi-heart"></i> Favorite</h5>
                    </a>
                    <a href="<?= $info->authorUrl ?>" class="list-group-item list-group-item-action bg-opacity-75 bg-dark text-white">
                        <h5 class="mb-1"><i class="bi bi-stars"></i> List</h5>
                    </a>
                </div>
                <h5><?= $info->title ?></h5>
                <p class="text-justify"><?= ALGOL::StrOf()->Replace($info->description, [CH_NEW_LINE, CH_TRIM], [CH_FREE]) ?></p>
            </div>
        </div>
    </div>

<?php Pjax::end(); ?>
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