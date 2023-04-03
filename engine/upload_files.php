<?php
 
require_once(dirname(__DIR__, 1).'/config/config.php');
require_once(dirname(__DIR__, 1).'/data/images.php');
 
if (!empty($_FILES)) {
    for ($i = 0; $i < count($_FILES['files']['name']); $i++) {
 
        $fileName = $_FILES['files']['name'][$i];
 
        if ($_FILES['files']['size'][$i] > UPLOAD_MAX_SIZE) {
            $_SESSION['error'] = "$fileName: Недопустимый размер файла";
            break;
        }
 
        if (!in_array($_FILES['files']['type'][$i], ALLOWED_TYPES)) {
            $_SESSION['error'] = "$fileName: Недопустимый формат файла";
            break;
        }
 
        $filePath = FILES . '\\' . basename($fileName);
 
        if (!move_uploaded_file($_FILES['files']['tmp_name'][$i], $filePath)) {
            $_SESSION['error'] = "$fileName: Ошибка загрузки файла";
            break;
        }
    }

    $files = getImages();
    $index = array_search($fileName, $files);
    file_put_contents(IMAGE_INDEX_FILE, "index = $index;");
    header('Location: ../index.php');
}
 
?>