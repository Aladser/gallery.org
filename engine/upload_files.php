<?php

require_once(dirname(__DIR__, 1).'/config/config.php');
session_start();
 
// загрузка изображения
if (!empty($_FILES)) {
    $fileName = $_FILES['files']['name'][0];

    if ($_FILES['files']['size'][0] > UPLOAD_MAX_SIZE) {
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
            $imageModel->addImage($fileName);
        }
    }
    
    // редирект
    if(isset($_SESSION['error'])) 
        header('Location: ../views/upload_file_view.php');
    else
        header('Location: ../index.php');
}
 
?>