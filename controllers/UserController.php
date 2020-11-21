<?php
namespace app\controllers; // пространство имён файла

use Yii;
use yii\web\Controller;
use app\models\Signup;
use app\models\Login;

class UserController extends Controller
{
    public function actionLogin() // функция-действие для авторизации
    {
        $loginModel = new Login();
        
        if(isset($_POST['Login'])) // если данные из формы авторизации были отправлены (в POST)
        {
            $loginModel->attributes = Yii::$app->request->post('Login'); // заполнение модели данными из POST
            if($loginModel->validate()) // если данные валидны
            {
                Yii::$app->user->login($loginModel->getUser()); // вход заданного пользователя
                return $this->goHome(); // возврат на домашнюю страницу
            }
        }
        
        return $this->render("login", ['model' => $loginModel]); // отображение представления user\login.php
    }
    
    public  function  actionLogout() // функция-действие для выхода текущего пользователя
    {
        if(!Yii::$app->user->isGuest)
        {
            Yii::$app->user->logout(); // выход текущего пользователя
            return $this->goHome(); // возврат на домашнюю страницу
        }
    }
    
    public function actionSignup() // функция-действие для регистрации
    {
        if(!Yii::$app->user->isGuest)
        {
            return $this->goHome();
        }
        $signupModel = new Signup(); // создание экзмепляра формы (модели) для регистрации
        
        if(isset($_POST['Signup'])) // если данные из формы регистрации были отправлены (в POST)
        {
            $signupModel->attributes = Yii::$app->request->post('Signup'); // заполнение модели данными из POST
            if($signupModel->validate() && $signupModel->signup()) // если данные валидны и пользователь успешно осхранен в БД
            {
                return $this->goHome(); // возврат на домашнюю страницу
            }
        }
        
        return $this->render("signup", ['model' => $signupModel]); // отображение представления user\signup.php
    }
}