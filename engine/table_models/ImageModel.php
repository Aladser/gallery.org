<?php
namespace table_models;
use \PDO;

class ImageModel extends TableDBModel{
    private $upload_files;
    private $image_index_file;

    function __construct($db, $upload_files, $image_index_file){
        $this->db = $db;
        $this->upload_files = $upload_files;
        $this->image_index_file = $image_index_file;
    }

    // получить пути изображений
    function getImages(){
        $files = scandir( $this->upload_files);
        array_splice($files,0, 2);

        return count($files) !=0 ? $files : null;
    }

    function getCurrentImage(){
        $img_index = file_get_contents($this->image_index_file);
        $img_index = explode(' = ', $img_index)[1];
        $img_index = mb_substr($img_index, 0, strlen($img_index)-1);
        $img_index = intval($img_index);

        return is_null($this->getImages()) ? null : $this->getImages()[$img_index];
    }

    function addImage($fileName){
        $query = $this->db->query("select count(*) as count from images where image_path='$fileName'");
        $count = intval($query->fetch(PDO::FETCH_ASSOC)['count']);
        if($count === 0){
            $rslt = intval( $this->db->exec("insert into images(image_path) values('$fileName')") );
            if($rslt === 1){
                // установка изображения слайдера в конф.файле
                $index = array_search($fileName, $this->getImages());
                file_put_contents(IMAGE_INDEX_FILE, "index = $index;");
            }
            return $rslt;
        }
        return -1;
    }

    function deleteImage($filename){
        $img_index = intval(file_get_contents($this->image_index_file));
        $count = count($this->getImages());
        $rslt = $this->db->exec("delete from images where image_path='$filename'"); // удаляем изображение из бд
        
        $file =  $this->upload_files.'\\'.$filename; 
        unlink($file);// удаляем файл

        $count--;
        if($count != 0){
            $img_index = $img_index===0 ? $count-1 : $img_index-1;
            file_put_contents($this->image_index_file, "index = $img_index;");
            return $rslt;
        }
        else {
            file_put_contents($this->image_index_file, "index = -1;");
            return -1;
        }
    }
}