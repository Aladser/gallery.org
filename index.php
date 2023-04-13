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
?>

