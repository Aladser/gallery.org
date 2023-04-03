<?php
    require_once(dirname(__DIR__, 1).'/config/config.php');
    require_once(dirname(__DIR__, 1).'/data/images.php');
    $img_index = intval(file_get_contents(IMAGE_INDEX_FILE)); // индекс показываемого изображения

    $files = getImages();
    if(!is_null($files)){
        $count = count($files);
        $file =  FILES.'\\'.basename($_GET['file']); // удаляемый файл
        unlink($file);
        $count--;
        if($count != 0){
            $img_index = $img_index===0 ? $count-1 : $img_index-1;
            file_put_contents(IMAGE_INDEX_FILE, "index = $img_index;"); 
            echo $img_index;
        }
        else {
            echo null;
        }
    }
    else {
        echo null;
    }
?>