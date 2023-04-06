<?php
    require_once(dirname(__DIR__, 1).'/config/config.php');
    require_once('images.php');
    $img_index = intval(file_get_contents(IMAGE_INDEX_FILE)); // индекс показываемого изображения

    $files = getImages();
    if(!is_null($files)){
        // соединение с БД
        try{
            $dbConnection = new PDO("mysql:dbname=".NAME_DB."; host=".HOST_DB, USER_DB, PASS_DB);
        }
        catch(PDOException $e){
            die($e->getMessage());
        }

        $count = count($files);
        $filename = basename($_GET['file']);
        $file =  UPLOAD_FILES.'\\'.$filename; 
        $cmtModel->deleteComments($filename); // удаляем комментарии под изображением
        $rslt = $dbConnection->exec("delete from images where image_path='$filename'"); // удаляем изображение из бд
        unlink($file);// удаляем файл
        $count--;
        
        $dbConnection = null;
        if($count != 0){
            $img_index = $img_index===0 ? $count-1 : $img_index-1;
            file_put_contents(IMAGE_INDEX_FILE, "index = $img_index;");
            echo $rslt;
        }
        else {
            file_put_contents(IMAGE_INDEX_FILE, "index = -1;");
            echo null;
        }
    }
    else {
        file_put_contents(IMAGE_INDEX_FILE, "index = -1;");
        echo null;
    }
?>