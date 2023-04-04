<?php

class UsersModel{
    private $dbConnection; // соединение с БД
    private $host;
    private $nameDB;
    private $userDB;
    private $passwordDB;

    function __construct($host, $nameDB, $userDB, $passwordDB){
        $this->host = $host;
        $this->nameDB = $nameDB;
        $this->userDB = $userDB;
        $this->passwordDB = $passwordDB;
    }

    private function connect(){
        try{
            $dbname = $this->nameDB;
            $host = $this->host;
            $this->dbConnection = new PDO("mysql:dbname=$dbname; host=$host", $this->userDB, $this->passwordDB, 
            array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
        }
        catch(PDOException $e){
            die($e->getMessage());
        }
    }

    private function disconnect(){
        $this->dbConnection = null;
    }

    // проверить существование пользователя
    public function existsUser($user){
        $this->connect();

        $query = $this->dbConnection->prepare("select count(*) as count from users where user_login = :user");
        $query->execute(['user' => $user]);
        $count = $query->fetch(PDO::FETCH_ASSOC)['count'];

        $this->disconnect();
        return intval($count) === 1;
    }

    // проверка авторизации
    public function isAuthorization($user, $password){
        $this->connect();

        $password = md5(md5($password));
        $query = $this->dbConnection->prepare("select count(*) as count from users where user_login = :user and user_password=:password");
        $query->execute(['user' => $user, 'password' => $password]);
        $count = $query->fetch(PDO::FETCH_ASSOC)['count'];

        $this->disconnect();
        return intval($count) === 1;
    }
    
    // добавить нового пользователя
    public function addUser($login, $password){
        $this->connect();
        $this->dbConnection->query("insert into users(user_login, user_password) values('$login', '$password')");
        $this->disconnect();
    }

    // добавить хэш пользователю
    public function addUserHash($login){
        $this->connect();
        $hash = UsersModel::generateCode();
        $this->dbConnection->query("UPDATE users SET user_hash='$hash' WHERE user_login='$login'");
        $this->disconnect();
    }

    // получить хэш пользователя
    public function getUserHash($login){
        $this->connect();
        $query = $this->dbConnection->query("select user_hash from users where user_login = '$login'");
        $hash = $query->fetch(PDO::FETCH_ASSOC)['user_hash'];
        $this->disconnect();
        return $hash;
    }

    // генерация случайной строки
    public static function generateCode($length=6) {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPRQSTUVWXYZ0123456789";
        $code = "";
        $clen = strlen($chars) - 1;
        while (strlen($code) < $length) {
            $code .= $chars[mt_rand(0,$clen)];
        }
        return $code;
    }
}