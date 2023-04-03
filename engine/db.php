<?php
    require_once(dirname(__DIR__, 1).'/config/config.php');
    session_start();

    // генерация случайной строки
    function generateCode($length=6) {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPRQSTUVWXYZ0123456789";
        $code = "";
        $clen = strlen($chars) - 1;
        while (strlen($code) < $length) {
            $code .= $chars[mt_rand(0,$clen)];
        }
        return $code;
    }

    // проверить существование пользователя
    function existsUser($user){
        global $dbConnection;
        $query = $dbConnection->prepare("select count(*) as count from users where user_login = :user");
        $query->execute(['user' => $user]);
        $count = $query->fetch(PDO::FETCH_ASSOC)['count'];
        return intval($count) === 1;
    }

    // проверить пароль
    function isAuthorization($user, $password){
        global $dbConnection;
        $password = md5(md5($password));
        $query = $dbConnection->prepare("select count(*) as count from users where user_login = :user and user_password=:password");
        $query->execute(['user' => $user, 'password' => $password]);
        $count = $query->fetch(PDO::FETCH_ASSOC)['count'];
        return intval($count) === 1;
    }
 
    // авторизация
    if(isset($_POST['login']))
    {
        // соединение с БД
        try{
            $dbConnection = new PDO("mysql:dbname=".NAME_DB."; host=".HOST_DB, USER_DB, PASS_DB);
        }
        catch(PDOException $e){
            die($e->getMessage());
        }

        $login = $_POST['login'];
        if(existsUser($login))
        {
            $password = $_POST['password'];
            if(isAuthorization($login, $password)){
                // Генерируем случайное число и шифруем его
                $hash = md5(generateCode(10));
                $query = $dbConnection->prepare("UPDATE users SET user_hash=:user_hash WHERE user_login=:user_login");
                $query->execute(['user_hash'=>$hash, 'user_login' => $login]);
                // Ставим куки
                setcookie('login', $login, time()+60*60*24);
                setcookie('hash', $hash, time()+60*60*24);
                //$rslt = require_once('check.php');
                $rslt = 'auth';
                $_SESSION['auth'] = 1;
                $_SESSION['login'] = $login;
            }
            else {
                $rslt = 'wrongpass';
            }
        }
        else {
            $rslt = 'nouser';
        }

        echo $rslt;
        $dbConnection = null;
    }
?>