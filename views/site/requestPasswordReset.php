<?php

use yii\bootstrap4\Html;
use yii\bootstrap4\ActiveForm;

$this->title = 'Request Password Reset';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="site-request-password-reset">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Enter your email to receive a password reset link:</p>

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'email')->input('email') ?>

        <div class="form-group">
            <?= Html::submitButton('Send Email', ['class' => 'btn btn-primary']) ?>
        </div>

    <?php ActiveForm::end(); ?>
</div>
