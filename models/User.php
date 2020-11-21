<?php
namespace app\models;

use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

class User extends ActiveRecord implements IdentityInterface
{
    public static  function tableName()
    {
        return 'users';
    }
    
    public function validatePassword($password) // сравнение пароля пользователя с заданным паролем
    {
        return $this->password === sha1($password);
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
