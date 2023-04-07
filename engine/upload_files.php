<?php
require_once(dirname(__DIR__, 1).'/config/config.php');
session_start();
 
if (!empty($_FILES)) {
    $fileName = $_FILES['files']['name'][0];

    if ($_FILES['files']['size'][$i] > UPLOAD_MAX_SIZE) {
        $_SESSION['error'] = "$fileName: Недопустимый размер файла";
    }
    elseif (!in_array($_FILES['files']['type'][0], ALLOWED_TYPES)) {
        $_SESSION['error'] = "$fileName: Недопустимый формат файла";
    }
    else{
        $filePath = UPLOAD_FILES . '\\' . basename($fileName);

        if (!move_uploaded_file($_FILES['files']['tmp_name'][0], $filePath)) {
            $_SESSION['error'] = "$fileName: Ошибка загрузки файла";
        }
        else{ 
            $query = $db->query("select count(*) as count from images where image_path='$fileName'");
            $count = intval($query->fetch(PDO::FETCH_ASSOC)['count']);
            if($count === 0){
                $query = $db->query("insert into images(image_path) values('$fileName')");
                // установка изображения слайдера загруженным изображением
                $index = array_search($fileName, $imageModel->getImages());
                file_put_contents(IMAGE_INDEX_FILE, "index = $index;");
            }
            else{
                $_SESSION['error'] = "$fileName: файл уже существует";
            }
        }
    }
    
    // редирект
    if(isset($_SESSION['error'])) 
        header('Location: ../views/upload_file_view.php');
    else
        header('Location: ../index.php');
}
 
?>