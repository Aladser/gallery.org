<?php

require_once(dirname(__DIR__, 1).'/config/config.php');
session_start();

// авторизация
function logIn($usersModel, $login, $saveAuth=false){
    // добавить хэш пользователю
    $usersModel->addUserHash($login); 
    // Ставим куки
    if($saveAuth){
        setcookie('login', $login, time()+60*60*24, '/');
        setcookie('hash', $usersModel->getUserHash($login), time()+60*60*24, '/');
    }
    $_SESSION['auth'] = 1;
    $_SESSION['login'] = $login;
}

// аутентификация
if(isset($_POST['auth']))
{
    if($_POST['token'] === $_SESSION['CSRF']){
        $login = $_POST['login'];
        if($usersModel->existsUser($login))
        {
            if($usersModel->isAuthentication($login, $_POST['password'])){
                $saveAuth = isset($_POST['saveAuth']) ? true : false;
                logIn($usersModel, $login, $saveAuth);
                $rslt = 'auth';
            }
            else {
                $rslt = 'wrongpass';
            }
        }
        else {
            $rslt = 'nouser';
        }
    }
    else{
        $rslt = 'bootforce';
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
        $_SESSION['error'] = " $newLogin уже существует";
    }
    // добавление пользователя
    else{
        $rslt = $usersModel->addUser($newLogin, $newPass); 
        logIn($usersModel, $newLogin);
        if($rslt === 1) $rslt = 'auth';
        else $_SESSION['error'] = " $newLogin: ошибка добавления пользователя";
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
    setcookie("login", "", time()-3600, '/');
    setcookie("hash", "", time()-3600, '/');
    header('Location: ../index.php');
}