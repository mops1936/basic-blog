<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

echo '<h1>Страница регистрации</h1>';
echo '<h2>Пожалуйста, введите логин и пароль для регистрации:</h2>';

$form = ActiveForm::begin();
echo $form->field($model, 'username')->textInput();     // поле для ввода логина
echo $form->field($model, 'password')->passwordInput(); // поле для ввода пароля
?>
<div class="form-group">
    <div>
        <?= Html::submitButton('Регистрация', ['class' => 'btn btn-success']) // кнопка "Регистрация" ?>
    </div>
</div>
<?php ActiveForm::end() ?>
