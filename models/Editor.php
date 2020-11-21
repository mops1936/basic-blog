<?php
namespace app\models;

use Yii;
use yii\base\Model;

class Editor extends Model // модель для заполнения формы редактора статьи
{
    public $title;
    public $content;
    public $context;
    public $tags;
    public $author;
    public $date;
    
    public function rules() // правила для полей
    {
        return [
            [   ['title', 'content', 'context', 'tags'], 'required', 'message' => 'Заполните поле'],
            ['title', 'unique', 'targetClass' => 'app\models\Article',  'message' => 'Статья с таким названием уже существует'],
            ['title', 'string', 'min'=>1, 'max'=>255],
            ['content', 'string', 'min'=>3, 'max'=>65000],
            ['context', 'string', 'min'=>1, 'max'=>255],
            ['tags', 'string', 'max'=>30],
        ];
    }
    
    public function attributeLabels() // синонимы для отображения полей
    {
        return [
            'title' => 'Название',
            'content' => 'Содержание',
            'context' => 'Контекст',
            'tags' => 'Тэг'
        ];
    }
    
    public function save() // метод для сохранения статьи в БД
    {
        $article = new Article();                           // создание объекта Article для сохранения в БД
        $article->title = $this->title;                     // название и текст статьи
        $article->content = $this->content;                 // сохраняются из редактора
        $article->user_id = Yii::$app->user->identity->id;  // автор - текущий пользователь
        $article->date = date('Y-m-d');              // дата - текущая дата
    
        $context = new Context();                            // создание объекта Context
        $contextFlag = Context::findOne(['title' => $this->context]); // поиск в БД введённого в редакторе контекста
        if(!$contextFlag)  // если контекст с таким названием не существует в БД
        {
            $context->title = $this->context;
            
            if(!$context->save())                        // запись нового контекста в БД
            {
                return false;
            }
        }
        $article->context_id = Context::findOne(['title' => $this->context])->id;   // запись id контекста в статью
    
        if(!$article->save())                            // сохранение статьи в БД
        {
            return false;
        }
        
        $tag = new Tag();                                                           // создание объекта Tag
        $tagFlag = Tag::findOne(['title' => $this->tags]);                           // поиск в БД введённого в редакторе тэга
        
        if(!$tagFlag)                                                               // если тэг с таким названием не существует в БД
        {
            $tag->title = $this->tags;
            if(!$tag->save())                                                      // запись нового тэга в БД
            {
                return false;
            }
        }
        
        $articleTag = new ArticlesTags();                                           // создание объекта ArticlesTags
        $articleTag->tag_id = Tag::findOne(['title' => $this->tags])->id;            // заполнение строки для новой статьи
        $articleTag->article_id = Article::findOne(['title' => $this->title])->id;  // в таблице articles_tags
        
        if(!$articleTag->save())                         // запись новой строки таблцы articles_tags в БД
        {
            return false;
        }
        
        return true;
    }
}
