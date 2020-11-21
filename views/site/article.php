<?php

echo '<h1>Название: ' . $article->title . '</h1>';
echo '<h2>Контекст: ' . $article->context . '</h2>';
echo '<h3>Тэги: ' . $article->tagsStr . '</h3>';
echo '<h4>Текст статьи: </h4>';
echo $article->content;
echo '<h4>Автор: ' . $article->author . '</h4>';
echo '<h4>Дата: ' . $article->date . '</h4>';

