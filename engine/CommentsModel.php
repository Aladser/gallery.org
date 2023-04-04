<?php

class CommentsModel{
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

    public function getComments($image_id){
        $this->connect();
        $sql = "select cmt_text, cmt_author, cmt_date from comments where image_id='$image_id'";
        $query = $this->dbConnection->query($sql);
        return $sql;
        $this->disconnect();
    }

    public function addComment($image, $text, $author, $date){
        $this->connect();

        $query = $this->dbConnection->query("select image_id from images where image_path='$image'");
        $id = $query->fetch(PDO::FETCH_ASSOC)['image_id'];
        return $this->dbConnection->exec("insert into comments(image_id, cmt_author, cmt_text, cmt_date) values($id, '$author', '$text', '$date')");

        $this->disconnect();
    }

    public function deleteComment($text, $author, $date){
        $this->connect();
        $this->dbConnection->query("insert into users(user_login, user_password) values('$login', '$password')");
        $this->disconnect();
    }   
}