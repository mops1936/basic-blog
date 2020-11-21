<?php
// представление для actionIndex() из SiteController.php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

?>
<h1>Прототип блога</h1>

<?php
echo GridView::widget([
        'id' => 'my_grid',
        'dataProvider' => $dataProvider,
        'columns' => [
            [
                'label' => 'Название статьи',
                'format' => 'raw',
                'value' => function($dataProvider){
                    return Html::a($dataProvider->publicTitle, Url::to(['site/article', 'id'=>(string)$dataProvider->id]));
                },
                'options' => ['width' => '200']
            ],
            [
                'attribute' => 'context',
                'format' => 'text',
                'label' => 'Контекст',
                'options' => ['width' => '200']
            ],
            [
                'attribute' => 'tagsStr',
                'format' => 'text',
                'label' => 'Тэги',
                'options' => ['width' => '200']
            ],
            [
                'attribute' => 'author',
                'format' => 'text',
                'label' => 'Автор',
                'options' => ['width' => '200']
            ],
            [
                'attribute' => 'date',
                'format' => ['date', 'dd.MM.Y'],
                'label' => 'Дата',
                'options' => ['width' => '200']
            ],
        ]
]);

?>
<div id="buttons">
<?= Html::submitButton('Загрузить следующие 5 статей', ['class' => 'btn btn-primary btn-lg', 'id'=>'my_button']) ?>
</div>

<?php
$js = <<<JS
document.getElementsByClassName('summary')[0].remove(); // удаление строки "Showing ..." над таблицей
var offset = 0;

 $('#my_button').on('click', function(){        // ф-ция-обработчик нажатия на кнопку "Загрузить следующие 5 статей"
     offset += 5;
     $.ajax({
         url: '/../../controllers/SiteController?offset=' + offset, // в GET помещается смещение для чтения из БД
          //'/site/index',
         type: 'GET',
         dataType: 'json',
         success: function(data){
                    console.log(data);  // принятые данные пишутся в консоль (для отладки)
                    if(data != 'x'){    // 'x' - признак того, что все записи из БД считаны
                        data.forEach(function (item, i, arr){       // цикл по записям из БД
                            var tbody = document.getElementsByTagName('tbody').item(0); // поиск тела таблицы
                            
                            var tr = document.createElement('tr');      // создание новой строки таблицы
                            tbody.append(tr)
                            
                            var td1 = document.createElement('td');     // создание элемента строки таблицы (название статьи)
                            //td1.innerHTML = '<a href="../site/article?id=' + item.publicId + '">'+ item.publicTitle +'</a>';
                            td1.innerHTML = '<a href="/index.php?r=site%2Farticle&id=' + item.publicId + '">'+ item.publicTitle +'</a>';
                            tr.append(td1);
                            
                            var td2 = document.createElement('td');     // создание элемента строки таблицы (контекст статьи)
                            td2.innerHTML = item.context;
                            tr.append(td2);
                            
                            var td3 = document.createElement('td');     // создание элемента строки таблицы (тэги статьи)
                            td3.innerHTML = item.tagsStr;
                            tr.append(td3);
                            
                            var td4 = document.createElement('td');     // создание элемента строки таблицы (автор статьи)
                            td4.innerHTML = item.author;
                            tr.append(td4);
                            
                            var td5 = document.createElement('td');     // создание элемента строки таблицы (дата статьи)
                            var date = item.publicDate.slice(8) + '.' + item.publicDate.slice(5,7) + '.' + item.publicDate.slice(0,4); // вывод даты в формате дд.мм.гггг
                            td5.innerHTML = date;
                            tr.append(td5);
                        })
                        if(data.length < 5){        // если из БД пришло менее 5 записей, то записей больше нет
                            document.getElementById('my_button').outerHTML = "<h3>Все статьи загружены</h3>";
                        }
                    }
                    else{                           // если из контроллера пришло 'x', то записей больше нет
                        document.getElementById('my_button').outerHTML = "<h3>Все статьи загружены</h3>";
                    }
                },
         error: function(){
                    alert('AJAX-запрос не сработал!');
                }
     })
 });
JS;

$this->registerJs($js);
?>
