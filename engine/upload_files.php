<?php
 
require_once(dirname(__DIR__, 1).'/config/config.php');
$errors = [];
 
if (!empty($_FILES)) {
    for ($i = 0; $i < count($_FILES['files']['name']); $i++) {
 
        $fileName = $_FILES['files']['name'][$i];
 
        if ($_FILES['files']['size'][$i] > UPLOAD_MAX_SIZE) {
            echo 'Недопустимый размер файла ' . $fileName;
            continue;
        }
 
        if (!in_array($_FILES['files']['type'][$i], ALLOWED_TYPES)) {
            echo 'Недопустимый формат файла ' . $fileName;
            continue;
        }
 
        $filePath = FILES . '\\' . basename($fileName);
 
        if (!move_uploaded_file($_FILES['files']['tmp_name'][$i], $filePath)) {
            echo 'Ошибка загрузки файла ' . $fileName;
            continue;
        }
        else
            echo 'ok';
    }
}
 
?>