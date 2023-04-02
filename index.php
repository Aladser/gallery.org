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
</head>
<body>
    <h2 class='gallery-header'>Галерея</h2>
    <input type="button" class='gallery__login-btn' id='login-btn' value="Вход">
    <div class='gallery'>
        <div class='gallery__prev-btn'>&#9001;</div>
        <img class='gallery__pane' alt="место для изображения">
        <div class='gallery__next-btn'>&#9002;</div>
    </div>

    <?php 
        require_once('views/login_view.php');
        require_once('engine/db_connect.php');  
    ?>
    <script type='text/javascript' src='public_html/js/index.js'></script>
    <script type='text/javascript' src='public_html/js/login.js'></script>
</body>
</html>