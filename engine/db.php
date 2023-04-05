<?php
    require_once(dirname(__DIR__, 1).'/config/config.php');
    require_once(dirname(__DIR__, 1).'/data/images.php');
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

    // добавление комментария
    // имя текущего изображения берется с сервера, т.к. у IMG русское название некорректно
    if(isset($_POST['newcmt'])){
        $text  = $_POST['text'];
        $author = $_POST['author'];
        $date = $_POST['date'];
        echo $cmtModel->addComment(getCurrentImage(), $text, $author, $date); 
    }
    
    // список комментариев
    if(isset($_POST['comments'])){
        // поиск текущего изображения
        $files = getImages();
        $img_index = file_get_contents(IMAGE_INDEX_FILE);
        $img_index = explode(' = ', $img_index)[1];
        $img_index = mb_substr($img_index, 0, strlen($img_index)-1);
        $img_index = intval($img_index);
        $currentFile = getImages($img_index)[$img_index];
        // комментарии
        $comments = $cmtModel->getComments($currentFile);
        $rslt = array();
        foreach ($comments as $row) {
            array_push( $rslt, array($row['cmt_text'], $row['cmt_author'], $row['cmt_date']) );
        }
        echo json_encode($rslt);
    }