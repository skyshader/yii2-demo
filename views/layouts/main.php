<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => '<i class="glyphicon glyphicon-send logo"></i>Messenger',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => [

            Yii::$app->user->isGuest ? ['label'=>''] : (
                [
                    'label' => '<i class="glyphicon glyphicon-home"></i> Home',
                    'url' => ['/user/home'],
                    'encode' => false
                ]
            ),

            !Yii::$app->user->isGuest && Yii::$app->user->identity->role === 1 ? (
                [
                    'label' => '<i class="glyphicon glyphicon-plus"></i> Create User',
                    'url' => ['/user/create'],
                    'encode' => false
                ]
            ) : ['label'=>''],

            Yii::$app->user->isGuest ? (
                [
                    'label' => '<i class="glyphicon glyphicon-log-in"></i> Login',
                    'url' => ['/site/login'],
                    'encode' => false
                ]
            ) : (
                '<li>'
                . Html::beginForm(['/site/logout'], 'post')
                . Html::submitButton(
                    '<i class="glyphicon glyphicon-log-out"></i> Logout (' . Yii::$app->user->identity->name . ')',
                    ['class' => 'btn btn-link logout']
                )
                . Html::endForm()
                . '</li>'
            ),
        ],
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; Messenger <?= date('Y') ?></p>

        <p class="pull-right">Built with Yii</p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
