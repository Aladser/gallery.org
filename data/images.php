<?php

require_once(dirname(__DIR__, 1).'/config/config.php');

// получить пути изображений
function getImages(){
    $files = scandir(FILES);
    array_splice($files,0, 2);
    return $files;
}

// изображение по id 
if(isset($_GET['id'])){
    $img_index = file_get_contents(IMAGE_INDEX);
    $img_index = explode(' = ', $img_index)[1];
    $img_index = mb_substr($img_index, 0, strlen($img_index)-1);
    echo getImages()[$img_index];
}