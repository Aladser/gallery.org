<?php

class ImageModel{
    private $upload_files;
    private $image_index_file;

    function __construct($upload_files, $image_index_file){
        $this->upload_files = $upload_files;
        $this->image_index_file = $image_index_file;
    }

    // получить пути изображений
    function getImages(){
        $files = scandir( $this->upload_files);
        array_splice($files,0, 2);
        return count($files) !=0 ? $files : null;
    }

    // получить текущее изображение
    function getCurrentImage(){
        $img_index = file_get_contents($this->image_index_file);
        $img_index = explode(' = ', $img_index)[1];
        $img_index = mb_substr($img_index, 0, strlen($img_index)-1);
        $img_index = intval($img_index);

        return is_null($this->getImages()) ? null : $this->getImages()[$img_index];
    }
}