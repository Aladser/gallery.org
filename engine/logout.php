<?php
    session_start();
    unset($_SESSION['auth']);
    setcookie("login", "", time()-3600);
    setcookie("hash", "", time()-3600);
    header('Location: ../index.php');
?>