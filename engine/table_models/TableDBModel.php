<?php

// Класс модели таблицы БД
class TableDBModel{
    protected $db;

    function __construct($db){
        $this->db = $db;
    }
}