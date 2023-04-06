<?php
// Отлавливает запросы, связанные с комментариями
require_once(dirname(__DIR__, 1).'/config/config.php');
require_once('images.php');

// список комментариев
if(isset($_GET['comments'])){
    $curImage = getCurrentImage();
    if(!is_null($curImage)){
        $comments = $cmtModel->getComments(getCurrentImage());
        echo json_encode($comments);
    }
    else {
        echo null;
    }
}

// добавление комментария
// имя текущего изображения берется с сервера, т.к. у IMG русское название некорректно
if(isset($_POST['newcmt'])){
    echo $cmtModel->addComment(getCurrentImage(), $_POST['text'],  $_POST['author'], $_POST['date']); 
}

// удаление комментария
if(isset($_GET['deletecmt'])){
    echo $cmtModel->deleteComment($_GET['time']);
}
