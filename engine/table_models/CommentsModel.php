<?php
require_once('TableDBModel.php');

class CommentsModel extends TableDBModel{
    function getComments($image){
        $this->connect();

        $query = $this->dbConnection->query("select image_id from images where image_path='$image'");
        $id = $query->fetch(PDO::FETCH_ASSOC)['image_id'];
        $sql = "select cmt_text, cmt_author, cmt_date from comments where image_id='$id'";
        $query = $this->dbConnection->query($sql);
        return $query;

        $this->disconnect();
    }

    function addComment($image, $text, $author, $date){
        $this->connect();

        $query = $this->dbConnection->query("select image_id from images where image_path='$image'");
        $id = $query->fetch(PDO::FETCH_ASSOC)['image_id'];
        $sql = "insert into comments(image_id, cmt_author, cmt_text, cmt_date) values($id, '$author', '$text', '$date')";
        return $this->dbConnection->exec($sql);

        $this->disconnect();
    }

    function deleteComments($image){
        $this->connect();

        $query = $this->dbConnection->query("select image_id from images where image_path='$image'");
        $id = $query->fetch(PDO::FETCH_ASSOC)['image_id'];
        $sql = "delete from comments where image_id=$id";
        return $this->dbConnection->exec("delete from comments where image_id=$id");
        
        $this->disconnect();
    }   
}