<?php
    try{
        $dbConnection = new PDO("mysql:dbname=".NAME_DB."; host=".HOST_DB, USER_DB, PASS_DB);
    }
    catch(PDOException $e){
        die($e->getMessage());
    }


    if (isset($_COOKIE['login']) && isset($_COOKIE['hash']))
    {
        $query = $dbConnection->prepare("SELECT * FROM users WHERE user_login = :login");
        $query->execute(['login' => $_COOKIE['login']]);
        $data = $query->fetchAll(PDO::FETCH_ASSOC)[0];
    
        if(($data['user_hash'] !== $_COOKIE['hash']) || ($data['user_login'] !== $_COOKIE['login']))
        {
            setcookie("id", "", time() - 3600*24*30*12, "/");
            setcookie("hash", "", time() - 3600*24*30*12, "/"); // httponly !!!
            $rslt = "cookies_set_again ";
        }
        else
        {
            $rslt = 'ok';
        }
    }
    else
    {
        $rslt = "cookies_off";
    }

    $dbConnection = null;
    return $rslt;
?>