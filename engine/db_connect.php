<?php

require_once(dirname(__DIR__, 1).'/config/config.php');

try{
    $dbConnection = new PDO("mysql:dbname=".NAME_DB."; host=".HOST_DB, USER_DB, PASS_DB);
    $sql = "select * from users";
    $rows = $dbConnection->query($sql);
    foreach ($rows as $row) {
        print_r($row);
        print_r('<br>');
    }
}
catch(PDOException $e){
    die($e->getMessage());
}