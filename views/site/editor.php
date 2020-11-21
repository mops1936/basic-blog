<?php
use mihaildev\ckeditor\CKEditor;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

?>
<h1>Создание статьи в редакторе</h1>
<?php

$form = ActiveForm::begin();
echo $form->field($editor, 'title')->widget(CKEditor::class,[
        'editorOptions' => [
            'preset' => 'basic',
            'inline' => false,
            'rows' => 1
        ]
    ]);     // поле для ввода названия статьи

echo $form->field($editor, 'content')->widget(CKEditor::class,[
    'editorOptions' => [
        'preset' => 'basic',
        'inline' => false,
        'rows' => 5
    ]
]);     // поле для ввода текста статьи

echo $form->field($editor, 'context')->textInput(); // поле для ввода контекста статьи

echo '<div id ="tags" >';
echo $form->field($editor, 'tags')->textInput(['id'=>'tag_input']); // поле для ввода тэгов статьи
echo Html::submitButton('Добавить тэг', ['class' => 'btn btn-md', 'id'=>'tag_button']);
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

echo Html::submitButton('Сохранить статью', ['class' => 'btn btn-success btn-lg']); // кнопка "Сохранить статью"

ActiveForm::end();
?>

<?php
//$js = <<<JS
//var input_id = '#tag_input';
//var btn_id = '#tag_button';
//var count = 1;
//
// $(btn_id).on('click', function(){
//
// var input = document.getElementById(input_id).cloneNode(true);
// var button = document.getElementById(btn_id).cloneNode(true);
//
// document.getElementById(btn_id).remove();
//
// input_id = input_id + count;
// btn_id = btn_id + count
//
// input.setAttribute('id', input_id);
// button.setAttribute('id', btn_id);
//
// document.getElementById('tags').appendChild(input);
// document.getElementById('tags').appendChild(button);
// count++;
//
// return false;
//
// });
//JS;
//
//$this->registerJs($js);
//?>

