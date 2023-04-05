<?php
// Отлавливает запросы, связанные с комментариеями

require_once(dirname(__DIR__, 1).'/config/config.php');
require_once(dirname(__DIR__, 1).'/data/images.php');

// список комментариев
if(isset($_GET['comments'])){
    $comments = $cmtModel->getComments(getCurrentImage());
    $rslt = array();
    foreach ($comments as $row) {
        array_push( $rslt, array($row['cmt_text'], $row['cmt_author'], $row['cmt_date']) );
    }
    echo json_encode($rslt);
}

// добавление комментария
// имя текущего изображения берется с сервера, т.к. у IMG русское название некорректно
if(isset($_POST['newcmt'])){
    $text  = $_POST['text'];
    $author = $_POST['author'];
    $date = $_POST['date'];
    echo $cmtModel->addComment(getCurrentImage(), $text, $author, $date); 
}

// удаление комментария
if(isset($_GET['deletecmt'])){
    echo $cmtModel->deleteComment($_GET['time']);
}
