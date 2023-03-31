<?php
    require_once('config/config.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="public_html/img/icon.png">
    <title>Галерея</title>
    <link rel="stylesheet" href="public_html/css/index.css">
</head>
<body>
    <h2>Галерея</h2>
    <div class='gallery'>
        <div class='gallery__prev-btn'>&#9001;</div>
        <img src="data/img/1.jpeg" class='gallery__pane' alt="место для изображения">
        <div class='gallery__next-btn'>&#9002;</div>
    </div>
</body>
</html>