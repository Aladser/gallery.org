<?php session_start();?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public_html/css/reset_cs.css">
    <link rel="stylesheet" href="../public_html/css/registration.css">
    <title>Регистрация нового пользователя</title>
</head>

<body>
    <br>
    <div class='registration-container'>
    <h3 class='registration-container__header'>Регистрация нового пользователя</h3>
        <form class='newUserForm' method="POST" action='../engine/users-queries.php'>
            <input type="text" id='newUserForm__loginInput' class='newUserForm__input' name='newLogin' placeholder="Логин">
            <br>
            <input type="password" id='newUserForm__passwordInput' class='newUserForm__input' name='newPassword' placeholder="Пароль">

            <div class='newUserForm__row newUserForm__btnrow'>
                <input type="submit" class='newUserForm__btn newUserForm__regBtn' value="Регистрация" disabled>
                <input type="button" class='newUserForm__btn newUserForm__backBtn' id='newPassword__backBtn' value="Назад">
            </div>
            <?php if(isset($_SESSION['error'])): ?>
                <p class='newUserForm__error'><?=$_SESSION['error']?></p>
                <?php unset($_SESSION['error']); ?>
            <?php endif; ?>
        </form>
    </div>
    <script type='text/javascript' src='../public_html/js/registration.js'></script>
</body>
</html>