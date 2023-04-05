<?php
require_once('TableDBModel.php');

class CommentsModel extends TableDBModel{
    function getComments($image){
        $this->connect();

        $query = $this->dbConnection->query("select image_id from images where image_path='$image'");
        $id = $query->fetch(PDO::FETCH_ASSOC)['image_id'];
        $sql = "select cmt_text, cmt_author, cmt_date from comments where image_id='$id'";
        $query = $this->dbConnection->query($sql);

        $this->disconnect();
        return $query;
    }

    function addComment($image, $text, $author, $date){
        $this->connect();

        $sql = "select image_id from images where image_path='$image'";
        $query = $this->dbConnection->query($sql);
        $id = $query->fetch(PDO::FETCH_ASSOC)['image_id'];
        $sql = "insert into comments(image_id, cmt_author, cmt_text, cmt_date) values($id, '$author', '$text', '$date')";
        $rslt = $this->dbConnection->exec($sql);

        $this->disconnect();
        return $rslt;
    }

    function deleteComments($image){
        $this->connect();

        $query = $this->dbConnection->query("select image_id from images where image_path='$image'");
        $id = $query->fetch(PDO::FETCH_ASSOC)['image_id'];
        $sql = "delete from comments where image_id=$id";
        $rslt = $this->dbConnection->exec("delete from comments where image_id=$id");
        
        $this->disconnect();
        return $rslt;
    }   
}