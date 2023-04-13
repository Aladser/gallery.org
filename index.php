<?php 
    require_once('config/config.php');
    session_start();
    // проверка куки
    $auth = $_SESSION['auth'] ?? null;
    $userRole = null;
    if(is_null($auth)){
        $cookieLogin = $_COOKIE["login"] ?? null;
        $cookieHash = $_COOKIE["hash"] ?? null;
        if(!is_null($cookieLogin) && !is_null($cookieHash)){
            if($usersModel->checkUserHash($cookieLogin, $cookieHash)){
                $user = $cookieLogin;
                $_SESSION['login'] = $cookieLogin;
                $_SESSION['hash'] = $cookieHash;
                $userRole = $usersModel->getUserRole($cookieLogin);
                $_SESSION['auth'] = 1;
            }
        }
    }
    else if(isset($_SESSION['login'])){
        $user = $_SESSION['login'];
        $userRole = $usersModel->getUserRole($user);
    }
    
    include 'views/login_view.php'; 
    include 'views/upload_file_view.php';
    include 'views/main_view.php';

    // лог запуска
    $today = date("Y-m-d H:i:s");
    if(!file_exists(LOGS)){
        file_put_contents(LOGS, "файл логов создан $today;\n");
    }
    else{
        file_put_contents(LOGS, "запуск программы $today;\n", FILE_APPEND);
    }
    // ограничение размера файла логов
    $arr = file(LOGS);
    if(count($arr)> 100) unset($arr[0]);
    file_put_contents(LOGS, $arr);
?>

