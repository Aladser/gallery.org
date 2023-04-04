<?php
    require_once(dirname(__DIR__, 1).'/config/config.php');

    // соединение с БД
    try{
        $dbConnection = new PDO("mysql:dbname=".NAME_DB."; host=".HOST_DB, USER_DB, PASS_DB);
    }
    catch(PDOException $e){
        die($e->getMessage());
    }

    $time = $_GET['time'];
    $rslt = $dbConnection->exec("delete from comments where cmt_date='$time'");
    
    $dbConnection = null;
    echo $rslt;
?>