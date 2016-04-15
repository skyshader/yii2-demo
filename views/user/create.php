<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form ActiveForm */

$this->title = 'Create User';
?>
<div class="user-create col-md-4 col-md-offset-4 well well-lg">

    <h1><?= Html::encode($this->title) ?></h1>
    <p>Please fill out the following fields for user:</p>

    <hr>

    <?php
        $form = ActiveForm::begin([
            'id' => 'user-create-form',
            'options' => ['class' => 'form-horizontal'],
            'fieldConfig' => [
                'template' => "<div class=\"col-md-12\">{input}</div><div class=\"col-md-12\">{error}</div>",
                'labelOptions' => ['class' => 'col-lg-1 control-label'],
            ]
        ]);
    ?>

        <?=
            $form->field($model, 'name')->textInput([
                'autofocus' => true,
                'placeholder' => 'Name'
            ])
        ?>
        <?=
            $form->field($model, 'email')->input('email', [
                'placeholder' => 'Email address'
            ])
        ?>
        <?=
            $form->field($model, 'password')->passwordInput([
                'placeholder' => 'Password'
            ])
        ?>
        <?=
            $form->field($model, 'role')->dropDownList(
                ['1' => 'Admin', '2' => 'User'],
                ['options' => ['2' => ['Selected' => true]]]
            );
        ?>
        <?=
            $form->field($model, 'status')->dropDownList(
                ['0' => 'Disabled', '1' => 'Enabled'],
                ['options' => ['1' => ['Selected' => true]]]
            );
        ?>

        <div class="form-group">
            <div class="col-md-12">
                <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
            </div>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- user-create -->
