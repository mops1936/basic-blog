<?php
use mihaildev\ckeditor\CKEditor;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

?>
<h1>Создание статьи в редакторе</h1>
<?php

$form = ActiveForm::begin();
echo $form->field($editor, 'title')->textInput(); // поле для ввода заголовка статьи

echo $form->field($editor, 'content')->widget(CKEditor::class,[
    'editorOptions' => [
        'preset' => 'basic',
        'inline' => false,
        'rows' => 5
    ]
]);     // поле для ввода текста статьи

echo $form->field($editor, 'context')->textInput(); // поле для ввода контекста статьи

echo '<b>Тэги статьи:</b>';
echo '<div id ="tags" >';
echo $form->field($editor, 'tags')->textInput(['id'=>'tag_input']); // поле для ввода тэгов статьи
echo Html::button('Добавить тэг', ['class' => 'btn btn-md', 'id'=>'tag_button']);
echo  '</div>';

// вывод автора как текущего пользователя
echo '<br>';
$editor->author = Yii::$app->user->identity->username;
echo '<b>Автор:</b> ' . $editor->author;

// вывод текущей даты
echo '<br><br>';
$editor->date = date('Y-m-d');
echo '<b>Дата:</b> ' . (string)$editor->date;

echo '<br><br>';

echo $form->field($editor, 'tags')->hiddenInput()->label(false);


echo Html::submitButton('Сохранить статью', ['class' => 'btn btn-success btn-lg', 'id'=>'submit_btn']); // кнопка "Сохранить статью"
ActiveForm::end();
?>

<?php
$js = <<<JS
$('#tag_button').on('click', addTag);       // ф-ция-обработчик нажатия на кнопку "Добавить тэг"
 
 function addTag(){
     var input = document.getElementById('tags').firstChild.cloneNode(true);    // копирование поля ввода тэга
     var button = document.getElementById('tags').lastChild.cloneNode(true);    // копирование кнопки добавления тэга
    
     document.getElementsByClassName('btn btn-md').item(0).remove();            // удаление предыдущей кнопки добавления тэга
    
     document.getElementById('tags').append(input);                             // добавление в DOM нового поля ввода
     document.getElementById('tags').append(button);                            //добавление в DOM новой кнопки
     $('#tag_button').on('click', addTag);                                      // назначение обработчика нажатия кнопки
 }
 
 $('#submit_btn').on('click', function (){      // ф-ция-обработчик нажатия на кнопку "Сохранить статью"
     var tags = '';
     var elementsArray = document.getElementsByName('Editor[tags]'); // получение массива полей для ввода тэгов
     elementsArray.forEach(function (item){
         tags = tags + ',' + item.value;
     })
     document.getElementById('editor-tags').value = tags;
     return true;
 });
 
JS;

$this->registerJs($js);
?>
