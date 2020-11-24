<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <title>Прототип блога</title>
    <?php $this->head(); ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([             // начало меню
        'options' => [
            'class' => 'navbar navbar-inverse navbar-fixed-top' // шапка: стандарт. стиль, фикс. вверху страницы
        ],
        'brandLabel' => 'БЛОГ', // наименование блога (шапка сайта)
        'brandUrl' => Yii::$app->homeUrl // ссылка в наименовании блога
    ]);
    $items = [                // массив пунктов меню
        ['label' => 'Регистрация', 'url' => ['/user/signup'],
            'visible' => (Yii::$app->user->isGuest && (Yii::$app->controller->action->id)!='signup')],
        ['label' => 'Вход', 'url' => ['/user/login'],
            'visible' => (Yii::$app->user->isGuest && (Yii::$app->controller->action->id)!='login')],
        ['label' => 'Добавить статью', 'url' => ['/site/editor'],
            'visible' => (!(Yii::$app->user->isGuest) && (Yii::$app->controller->action->id)!='editor')],
        ['label' => 'Выход  [ ' . Yii::$app->user->identity->username .' ]', 'url' => ['/user/logout'],
            'visible' => (!(Yii::$app->user->isGuest))]
    ];
    echo Nav::widget([
        'items' => $items,
        'options' => [ 'class' => 'navbar-nav navbar-right']
    ]);

    NavBar::end();
    ?>

    <div class="container" id="content" style="margin-top: 30px">
        <?= $content ?>
    </div>
    <?php $this->endBody(); ?>
</body>
</html>
<?php $this->endPage() ?>
