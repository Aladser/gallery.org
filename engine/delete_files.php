<?php
    require_once(dirname(__DIR__, 1).'/config/config.php');
    session_start();
    $img_index = intval(file_get_contents(IMAGE_INDEX_FILE)); // индекс показываемого изображения

    if($_GET['delete']){
        if(!is_null($imageModel->getImages())){
            $filename = basename($_GET['file']);
            $cmtModel->deleteComments($filename);
            echo $imageModel->deleteImage($filename);
            $_SESSION['login'] = $_GET['user'];
        }
        else {
            file_put_contents(IMAGE_INDEX_FILE, "index = -1;");
            echo null;
        }
    }
?>