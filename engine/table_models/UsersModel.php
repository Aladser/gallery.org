<?php
namespace table_models;
use \PDO;

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
        $query = $this->db->query("select user_password from users where user_login='$user'");
        $passhash = $query->fetch(PDO::FETCH_ASSOC)['user_password'];
        return password_verify($password, $passhash);
    }
    
    // добавить нового пользователя
    function addUser($login, $password){
        $password = password_hash($password, PASSWORD_DEFAULT);
        return $this->db->exec("insert into users(user_login, user_password, user_role_id) values('$login', '$password', 2)");
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

    function getUserRole($login){
        $query = $this->db->query("select name from user_roles where id = (select user_role_id from users where user_login='$login');");
        return $query->fetch(PDO::FETCH_ASSOC)['name'];
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