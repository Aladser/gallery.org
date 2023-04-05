<?php

require_once(dirname(__DIR__, 1).'/config/config.php');
require_once('images.php');
session_start();

// авторизация
function logIn($usersModel, $login){
    // добавить хэш пользователю
    $usersModel->addUserHash($login); 
    // Ставим куки
    setcookie('login', $login, time()+60*60*24);
    setcookie('hash', $usersModel->getUserHash($login), time()+60*60*24);
    // защита выключена для простоты проекта
    //$rslt = require_once('check.php');
    $_SESSION['auth'] = 1;
    $_SESSION['login'] = $login;
}

// аутентификация
if(isset($_POST['auth']))
{
    $login = $_POST['login'];
    if($usersModel->existsUser($login))
    {
        $password = $_POST['password'];
        if($usersModel->isAuthorization($login, $password)){
            logIn($usersModel, $login);
            $rslt = 'auth';
        }
        else {
            $rslt = 'wrongpass';
        }
    }
    else {
        $rslt = 'nouser';
    }
    echo $rslt;
}

// регистрация 
if(isset($_POST['newLogin'])){
    $newLogin = $_POST['newLogin'];
    $newPass = $_POST['newPassword'];
    // проверяем логин
    if(!preg_match("/^[a-zA-Z0-9]+$/",$newLogin))
    {
        $_SESSION['error'] = "Логин может состоять только из букв английского алфавита и цифр";
    }
    elseif(strlen($newLogin) < 3 || strlen($newLogin) > 30)
    {
        $_SESSION['error'] = "Логин должен быть не меньше 3-х символов и не больше 30";
    }
    elseif($usersModel->existsUser($newLogin)){
        $_SESSION['error'] = "Пользователь с таким логином уже существует в базе данных";
    }
    // добавление пользователя
    else{
        $password = md5(md5(trim($newPass)));
        $usersModel->addUser($newLogin, $password); 
        logIn($usersModel, $newLogin);
        $rslt = 'auth';
    }
    // редирект
    if(isset($_SESSION['error'])) 
        header('Location: ../views/registration_view.php');
    else {
        header('Location: ../index.php');
    }
}

// Выход
if(isset($_GET['logout'])){
    unset($_SESSION['auth']);
    setcookie("login", "", time()-3600);
    setcookie("hash", "", time()-3600);
    header('Location: ../index.php');
}