<?php
//use yii\widgets\DetailView;
//
//echo DetailView::widget([
//    'model' => $article,
//    'attributes' => [
//        'title', 'context', 'tagsStr', 'content', 'author', 'date'
//    ]
//]);

echo '<h1 align="center">' . $article->title.'</h1>';
echo '<br>';
echo '<h4>Контекст: ' . $article->context . '</h4>';
echo '<h4>Тэги: ' . $article->tagsStr . '</h4>';
echo '<br>';
echo '<h4>';
echo '<p align="justify">' . $article->content . '</p>';
echo '</h4>';
echo '<br>';
echo '<div align="right">';
echo '<h4>Автор: ' . $article->author . '</4>';
echo '<h4>Дата: ' . $article->date . '</h4>';
echo '</div>';

?>
