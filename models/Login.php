<?php
namespace app\models;

use yii\base\Model;

class Login extends Model // модель для заполнения формы авторизации
{
    public $username;
    public $password;
    
    public function rules() // правила для полей
    {
        return [
            [   ['username', 'password'], 'required', 'message' => 'Заполните поле'],
            ['username', 'string', 'min'=>3, 'max'=>30],
            ['password', 'string', 'min'=>3],
            ['password', 'validatePassword']
        ];
    }
    
    public function attributeLabels() // синонимы для отображения полей
    {
        return [
            'username' => 'Логин',
            'password' => 'Пароль',
        ];
    }
    
    public function validatePassword($attribute, $params)
    {
        if(!$this->hasErrors()) // если нет ошибок в валидации
        {
            $user = $this->getUser(); // поиск пользователя в БД
            if (!$user || !$user->validatePassword($this->password)) // если пользователь не найден или пароль неверный
            {
                $this->addError($attribute, 'Пароль или пользователь введены неверно');
            }
        }
    }
    
    public function  getUser()
    {
        return User::findOne(['username' => $this->username]); // поиск в таблице Users пользователя с заданным username
    }
}