<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap4\ActiveForm $form */
/** @var app\models\LoginForm $model */

use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="site-login">
    <h1 class="text-center"><?= Html::encode($this->title) ?></h1>

    <p class="text-center text-muted">Enter your credentials to access your account.</p>

    <div class="row justify-content-center">
        <div class="col-lg-6">
            <?php $form = ActiveForm::begin([
                'id' => 'login-form',
                'options' => ['class' => 'card p-4 shadow-sm'],
                'fieldConfig' => [
                    'template' => "{label}\n{input}\n{error}",
                    'labelOptions' => ['class' => 'font-weight-bold'],
                    'inputOptions' => ['class' => 'form-control'],
                    'errorOptions' => ['class' => 'text-danger small'],
                ],
            ]); ?>

            <?= $form->field($model, 'username')->textInput([
                'autofocus' => true,
                'placeholder' => 'Enter your username',
            ]) ?>

            <div class="position-relative">
                <?= $form->field($model, 'password')->passwordInput([
                    'id' => 'password-input',
                    'placeholder' => 'Enter your password',
                ]) ?>
                <span class="position-absolute" style="top: 38px; right: 10px; cursor: pointer;" onclick="togglePassword()">
                    <i id="toggle-icon" class="fas fa-eye"></i>
                </span>
            </div>

            <?= $form->field($model, 'rememberMe')->checkbox([
                'template' => "<div class=\"form-check\">{input} {label}</div>\n<div>{error}</div>",
            ]) ?>

            <div class="form-group text-center">
                <?= Html::submitButton('Login', ['class' => 'btn btn-primary btn-block', 'name' => 'login-button']) ?>
            </div>

            <?php ActiveForm::end(); ?>

            <p class="text-center text-muted mt-3">
                <p>Don't have an account? <?= Html::a('Sign up', ['site/signup']) ?></p>
                <p>Forgot your password? <?= Html::a('Reset it', ['site/request-password-reset']) ?></p>


            </p>
        </div>
    </div>
</div>

<script>
    function togglePassword() {
        let input = document.getElementById("password-input");
        let icon = document.getElementById("toggle-icon");
        if (input.type === "password") {
            input.type = "text";
            icon.classList.remove("fa-eye");
            icon.classList.add("fa-eye-slash");
        } else {
            input.type = "password";
            icon.classList.remove("fa-eye-slash");
            icon.classList.add("fa-eye");
        }
    }
</script>
