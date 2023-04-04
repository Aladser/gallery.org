<?php

// Класс модели таблицы БД
class TableDBModel{
    protected $dbConnection; // соединение с БД
    protected $host;
    protected $nameDB;
    protected $userDB;
    protected $passwordDB;

    function __construct($host, $nameDB, $userDB, $passwordDB){
        $this->host = $host;
        $this->nameDB = $nameDB;
        $this->userDB = $userDB;
        $this->passwordDB = $passwordDB;
    }

    protected function connect(){
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

    protected function disconnect(){
        $this->dbConnection = null;
    }
}