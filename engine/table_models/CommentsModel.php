<?php
namespace table_models;
use \PDO;

require_once('TableDBModel.php');

class CommentsModel extends TableDBModel{
    function getComments($image){
        $query = $this->db->query("select image_id from images where image_path='$image'");
        $id = $query->fetch(PDO::FETCH_ASSOC)['image_id'];
        $query = $this->db->query("select cmt_text, cmt_author, cmt_date from comments where image_id='$id'");
        // формирование ответа-массива
        $rslt = array();
        foreach ($query as $row) {
            array_push( $rslt, array('text'=>$row['cmt_text'], 'author'=>$row['cmt_author'], 'date'=>$row['cmt_date']) );
        }
        return $rslt;
    }

    function addComment($image, $text, $author, $date){
        $query = $this->db->query("select image_id from images where image_path='$image'");
        $id = $query->fetch(PDO::FETCH_ASSOC)['image_id'];
        $sql = "insert into comments(image_id, cmt_author, cmt_text, cmt_date) values($id, '$author', '$text', '$date')";
        $rslt = $this->db->exec($sql);
        return $rslt;
    }

    function deleteComment($time){
        return $this->db->exec("delete from comments where cmt_date='$time'");
    }

    function deleteComments($image){
        $query = $this->db->query("select image_id from images where image_path='$image'");
        $id = $query->fetch(PDO::FETCH_ASSOC)['image_id'];
        return $this->db->exec("delete from comments where image_id=$id");
    }   
}