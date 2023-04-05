<?php 
    require_once('config/config.php'); 
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="public_html/img/icon.png">
    <title>Галерея</title>
    <link rel="stylesheet" href="public_html/css/reset_cs.css">
    <link rel="stylesheet" href="public_html/css/index.css">
    <link rel="stylesheet" href="public_html/css/login.css">
    <link rel="stylesheet" href="public_html/css/modal.css">
    <link rel="stylesheet" href="public_html/css/upload_files.css">
    <link rel="stylesheet" href="public_html/css/comments.css">
</head>
<body>
    <h2 class='gallery-header'>Галерея</h2>
    <!-- кнопка войти-выйти -->
    <?php if(isset($_SESSION['auth'])): ?>
        <input type="button" class='gallery-btn gallery__login-btn' id='login-btn' value='Выйти'>
        <div class='gallery-login-name'><?=$_SESSION['login']?></div>
    <?php else: ?>
        <input type="button" class='gallery-btn gallery__login-btn' id='login-btn' value='Войти'>
    <?php endif; ?>

    <container class='gallery'>
        <div class='gallery__prev-btn'>&#9001;</div>
        <img class='gallery__pane'>
        <div class='gallery__next-btn'>&#9002;</div>
    </container>
    
    <?php if(isset($_SESSION['auth'])): ?>
        <?php include 'views/upload_file_view.php'; ?>
        <input type="button" class='gallery-btn gallery__delete-btn' value="Удалить">
    <?php endif; ?>

    <container class='cmt-container'>
        <h4>Комментарии</h4>
        <div class='cmt-container__list'>

        </div>
        <?php if(isset($_SESSION['auth'])): ?>
            <form method="post" id='cmt-container__form'>
                <textarea  class='cmt-container__text' id='cmt-container__new-cmt'></textarea>
                <input type="submit" class='gallery-btn cmt-container__btn' id='cmt-container__submit-btn' value='Отправить'>
            </form>
        <?php endif; ?>
    </container>

    <?php require_once('views/login_view.php'); ?>
    <script type='text/javascript' src='public_html/js/login.js'></script>
    <script type='text/javascript' src='public_html/js/images.js'></script>
    <script type='text/javascript' src='public_html/js/comments.js'></script>
</body>
</html>