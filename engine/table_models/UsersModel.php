<?php
require_once('TableDBModel.php');

class UsersModel extends TableDBModel{
    // проверить существование пользователя
    function existsUser($user){
        $this->connect();

        $query = $this->dbConnection->prepare("select count(*) as count from users where user_login = :user");
        $query->execute(['user' => $user]);
        $count = $query->fetch(PDO::FETCH_ASSOC)['count'];

        $this->disconnect();
        return intval($count) === 1;
    }

    // проверка авторизации
    function isAuthorization($user, $password){
        $this->connect();

        $password = md5(md5($password));
        $query = $this->dbConnection->prepare("select count(*) as count from users where user_login = :user and user_password=:password");
        $query->execute(['user' => $user, 'password' => $password]);
        $count = $query->fetch(PDO::FETCH_ASSOC)['count'];

        $this->disconnect();
        return intval($count) === 1;
    }
    
    // добавить нового пользователя
    function addUser($login, $password){
        $this->connect();
        $this->dbConnection->query("insert into users(user_login, user_password) values('$login', '$password')");
        $this->disconnect();
    }

    // добавить хэш пользователю
    function addUserHash($login){
        $this->connect();
        $hash = UsersModel::generateCode();
        $this->dbConnection->query("UPDATE users SET user_hash='$hash' WHERE user_login='$login'");
        $this->disconnect();
    }

    // получить хэш пользователя
    function getUserHash($login){
        $this->connect();
        $query = $this->dbConnection->query("select user_hash from users where user_login = '$login'");
        $hash = $query->fetch(PDO::FETCH_ASSOC)['user_hash'];
        $this->disconnect();
        return $hash;
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