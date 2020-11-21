<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

echo '<h1>Страница авторизации</h1>';
echo '<h2>Пожалуйста, введите логин и пароль для авторизации:</h2>';

$form = ActiveForm::begin(['id' => 'form']);
echo $form->field($model, 'username')->textInput();     // поле для ввода логина
echo $form->field($model, 'password')->passwordInput(); // поле для ввода пароля
//echo '<button class = "btn btn-success" id="btn">Войти</button>';
echo Html::submitButton('Войти', ['class' => 'btn btn-success']); // кнопка "Войти"
ActiveForm::end();
?>
