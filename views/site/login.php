<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Login';
?>
<div class="site-login col-md-4 col-md-offset-4 well well-lg">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>Please fill out the following fields to login:</p>

    <hr>

    <?php
        $form = ActiveForm::begin([
            'id' => 'login-form',
            'options' => ['class' => 'form-horizontal'],
            'fieldConfig' => [
                'template' => "<div class=\"col-md-12\">{input}</div><div class=\"col-md-12\">{error}</div>",
                'labelOptions' => ['class' => 'col-lg-1 control-label'],
            ],
        ]);
    ?>

        <?=
            $form->field($model, 'email')->input('email', [
                'autofocus' => true,
                'placeholder' => 'Email address'
            ])
        ?>

        <?=
            $form->field($model, 'password')->passwordInput([
                'placeholder' => 'Password'
            ])
        ?>

        <?= $form->field($model, 'rememberMe')->checkbox([
            'template' => "<div class=\"col-md-12\">{input} {label}</div>\n<div class=\"col-md-12\">{error}</div>",
        ]) ?>

        <div class="form-group">
            <div class="col-md-12">
                <?= Html::submitButton('Login', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
            </div>
        </div>

    <?php ActiveForm::end(); ?>
</div>
