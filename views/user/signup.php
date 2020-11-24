<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\alert;

echo '<h1>Страница регистрации</h1>';
echo '<h2>Пожалуйста, введите логин и пароль для регистрации:</h2>';

$form = ActiveForm::begin(['id' => 'reg_form']);
echo $form->field($model, 'username')->textInput();     // поле для ввода логина
echo $form->field($model, 'password')->passwordInput(); // поле для ввода пароля
?>

<div class="form-group">
    <?= Html::submitButton('Регистрация', ['class' => 'btn btn-success', 'id' => 'reg_btn']) // кнопка "Регистрация" ?>
</div>
<?php ActiveForm::end()?>


<?php if( Yii::$app->session->hasFlash('success') ):    // если валидация и регистрация прошла успешно
$js1 = <<<JS
    document.getElementsByTagName('h2').item(0).remove();   // удаление надписи "Пожалуйста, введите..."
    document.getElementById('reg_form').remove();           // удаление формы регистрации
JS;

    $this->registerJs($js1);
?>

<h3>
    <div class="alert alert-success alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
        <?php echo Yii::$app->session->getFlash('success'); ?>
    </div>
</h3>
<div id="countdown">
    <h4>Переход на главную страницу через <span class="display">5</span> секунд(ы)...</h4>
</div>
<?php endif;?>

<?php
$js2 = <<<JS
(function(d){
var display = d.querySelector('#countdown .display') // меняющаяся цифра
var timeLeft = parseInt(display.innerHTML) // оставшееся время

var timer = setInterval(function(){
    if (--timeLeft >= 0) { // если таймер всё еще больше нуля
        display.innerHTML = timeLeft // обновление цифры
    }
    else { document.location.href = 'index.php'; }     // перенаправление на главную страницу
}, 1000)  // таймер срабатывает каждые 1000 мс
})(document)
JS;

$this->registerJs($js2);
?>