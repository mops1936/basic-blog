<?php
namespace app\models;

use yii\base\Model;

class Signup extends Model // модель для заполнения формы регистрации
{
    public $username;
    public $password;
    
    public function rules() // правила для полей
    {
        return [
            [   ['username', 'password'], 'required', 'message' => 'Заполните поле'],
            ['username', 'unique', 'targetClass' => 'app\models\User',  'message' => 'Этот логин уже занят'],
            ['username', 'string', 'min'=>3, 'max'=>30],
            ['password', 'string', 'min'=>3]
        ];
    }
    
    public function attributeLabels() // синонимы для отображени полей
    {
        return [
            'username' => 'Логин',
            'password' => 'Пароль',
        ];
    }
    
    public function signup() // метод регистрации пользователя в БД
    {
        $user = new User();
        $user->username = $this->username;
        $user->password = sha1($this->password);
        return $user->save();
    }
}
