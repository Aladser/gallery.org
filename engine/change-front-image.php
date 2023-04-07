<?php

require_once(dirname(__DIR__, 1).'/config/config.php');
// смена изображения слайдера
if(is_null($imageModel->getImages())) {
    echo null;
    exit;
}

$files = $imageModel->getImages();
$img_index = file_get_contents(IMAGE_INDEX_FILE);
$img_index = explode(' = ', $img_index)[1];
$img_index = mb_substr($img_index, 0, strlen($img_index)-1);
$img_index = intval($img_index); // индекс последнего изображения
$count = count($files);     // число файлов
$type = intval($_GET['type']);  // тип кнопки слайдера для переключения

if($type === 1){
    $new_index = $img_index===($count-1) ? 0 : $img_index+1;
    file_put_contents(IMAGE_INDEX_FILE, "index = $new_index;");
}
else if(($type === 0)){
    $new_index = $img_index===0 ? ($count-1) : $img_index-1;
    file_put_contents(IMAGE_INDEX_FILE, "index = $new_index;");
}
else {
    $new_index = $img_index;
}
echo  $files[$new_index];