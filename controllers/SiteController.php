<?php

namespace app\controllers; // пространство имён файла

use app\models\Article; //подключение пространств имён
use app\models\Editor;
use Yii;
use yii\web\Controller;
use yii\data\ArrayDataProvider;

// класс контроллера, наследующий Controller из Yii
class SiteController extends Controller
{
    public function actionIndex() // функция-действие для загрузки сайта
    {
        $offset = 0;
        if(Yii::$app->request->isAjax) {    // обработка ajax-запроса на подгрузку порции статей
            $offset = Yii::$app->request->get('offset');
            $articles = Article::getAll(5, $offset);
            if($articles != null) // если из БД прочитана хотя бы одна статья
            {
                foreach ($articles as $article) // получение автора, контекста и тэгов для каждой статьи
                {
                    $article->getAuthor();
                    $article->getContext();
                    $article->convertTagsToString();
                    $article->fillPublicFields();
                }
                
                return json_encode($articles);
            }
            else // если прочитаны все записи из БД
            {
                return json_encode('x');
            }
        }
        
        $articles = Article::getAll(5, $offset); // получение $limit статей со смещением $offset из БД
        
        if($articles != null) // если из БД прочитана хотя бы одна статья
        {
            
            foreach ($articles as $article) // получение автора, контекста и тэгов для каждой статьи
            {
                $article->getAuthor();
                $article->getContext();
                $article->convertTagsToString();
                $article->fillPublicFields();
            }
            
            $dataProvider = new ArrayDataProvider([    // DataProvider для отображения статей в GridView
                'allModels' => $articles,              // данные для отображения
                'pagination' => ['pageSize' => 5,],    // количество статей на одной странице
            ]);
    
            return $this->render('index', ['dataProvider' => $dataProvider]);
        }
        else
        {
            return '<h2>Сейчас статей нет :(</h2>';
        }
    }
    
    public function actionEditor() // функция-действие для создания статьи
    {
        $editorModel = new Editor();
        
        if(isset($_POST['Editor'])) // если данные из редактора были отправлены (в POST)
        {
            $editorModel->attributes = Yii::$app->request->post('Editor'); // заполнение модели данными из POST
            if($editorModel->validate() && $editorModel->save()) // если данные валидны и статья успешно сохранена в БД
            {
                Yii::$app->session->setFlash('success', 'Статья успешно сохранена!'); // вывод сообщения о сохранении статьи
                return $this->goHome(); // возврат на домашнюю страницу
            }
            else
            {
                echo 'Неудача полная!';
            }
        }
        
        return $this->render('editor', ['editor'=>$editorModel]); // отображение представления user\editor.php
    }
    
    public function actionArticle() // функция-действие для просмотра статьи
    {
        if(isset($_GET['id'])) // есть ли номер выбранной статьи в GET
        {
            $article = Article::findOne(Yii::$app->request->get('id')); // получение статьи с заданным id в БД
            $article->getAuthor();
            $article->getContext();
            $article->convertTagsToString();
            
            $formatDate = explode('-', $article->date);
            $article->date = $formatDate[2] . '.' . $formatDate[1] . '.' . $formatDate[0]; // формат даты дд.мм.гггг
            return $this->render('article', ['article'=>$article]); // отображение представления site\article.php
        }
    }
}
