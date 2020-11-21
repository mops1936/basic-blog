<?php
namespace app\models;

use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

class Article extends ActiveRecord implements IdentityInterface
{
    public $author = '';
    public $context = '';
    public $tagsStr = '';
    public $publicId;
    public $publicTitle;
    public $publicContent;
    public $publicDate;
    
    public static  function tableName()
    {
        return 'articles';
    }
    
    public static function getAll($limit, $offset) // метод для получения $limit статей с $offset позиции из БД
    {
        return Article::find()->limit($limit)->offset($offset)->all();
    }
    
    public function getAuthor() // метод для получения имени (username) автора статьи
    {
        $this->author = User::findOne(['id' => $this->user_id])->username;
    }
    
    public function  getContext() // метод для получения контекста (темы) статьи
    {
        $this->context = Context::findOne(['id' => $this->context_id])->title;
    }
    
    public function fillPublicFields() // заполнение public полей объекта значениями из private полей
    {
        $this->publicId = $this->id;
        $this->publicTitle = $this->title;
        $this->publicContent = $this->content;
        $this->publicDate = $this->date;
    }
    
    public function getTags() // метод для получения всех тэгов статьи в виде строки
    {
        return $this->hasMany(Tag::class, ['id' => 'tag_id']) // получение массива объектов Tag
            ->viaTable('articles_tags', ['article_id' => 'id']);
    }
    
    public function convertTagsToString() // метод для преобразования массива объектов Tag в строку тэгов
    {
        foreach($this->tags as $tagObj)    // цикл по массиву объектов Tag для формирования строки тэгов
            {
                $this->tagsStr .= $tagObj['title'] . ', ';
            }
            $this->tagsStr = chop($this->tagsStr, ', '); // удаление последней запятой
    }
    
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }
    
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }
    
    public function getId()
    {
        return $this->id;
    }
    
    public function getAuthKey()
    {
        return $this->authKey;
    }
    
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }
}
