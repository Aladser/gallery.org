<?php
require_once('TableDBModel.php');

class UsersModel extends TableDBModel{
    // проверить существование пользователя
    function existsUser($user){
        $query = $this->db->query("select count(*) as count from users where user_login = '$user'");
        $count = $query->fetch(PDO::FETCH_ASSOC)['count'];
        return intval($count) === 1;
    }

    // проверка авторизации
    function isAuthentication($user, $password){
        $password = md5(md5($password));
        $query = $this->db->query("select count(*) as count from users where user_login = '$user' and user_password='$password'");
        $count = $query->fetch(PDO::FETCH_ASSOC)['count'];
        return intval($count) === 1;
    }
    
    // добавить нового пользователя
    function addUser($login, $password){
        return $this->db->exec("insert into users(user_login, user_password) values('$login', '$password')");
    }

    // добавить хэш пользователю
    function addUserHash($login){
        $hash = self::generateCode();
        $this->db->query("UPDATE users SET user_hash='$hash' WHERE user_login='$login'");
    }

    // получить хэш пользователя
    function getUserHash($login){
        $query = $this->db->query("select user_hash from users where user_login = '$login'");
        $hash = $query->fetch(PDO::FETCH_ASSOC)['user_hash'];
        return $hash;
    }

    function checkUserHash($login, $hash){
        $query = $this->db->query("select count(*) as count from users where user_login = '$login' and user_hash='$hash'");
        $hash = $query->fetch(PDO::FETCH_ASSOC)['count'];
        return intval($hash) === 1;
    }

    // генерация случайной строки
    static function generateCode($length=6) {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPRQSTUVWXYZ0123456789";
        $code = "";
        $clen = strlen($chars) - 1;
        while (strlen($code) < $length) {
            $code .= $chars[mt_rand(0,$clen)];
        }
        return $code;
    }
}