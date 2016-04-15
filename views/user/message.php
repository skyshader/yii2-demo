<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Message */
/* @var $form ActiveForm */
?>
<div class="user-message">

    <?php
        $form = ActiveForm::begin([
            'id' => 'message-form',
            'options' => ['class' => 'form-horizontal'],
            'fieldConfig' => [
                'template' => "<div class=\"col-md-12\">{input}</div><div class=\"col-md-12\">{error}</div>",
                'labelOptions' => ['class' => 'col-lg-1 control-label'],
            ],
        ]);
    ?>

    
        <?=
            $form->field($model, 'message')->textarea([
                'id' => 'message-box',
                'data-for' => $forUser->id,
                'placeholder' => 'Message',
            ])
        ?>

    <?php ActiveForm::end(); ?>

</div><!-- user-message -->
