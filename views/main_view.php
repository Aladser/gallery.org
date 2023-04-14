<!DOCTYPE html>
<html lang="en">
    
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Книги</title>
</head>

<body>
    <header class='header'>
        <p class='header__title'>Книги</p>
        <!-- кнопка войти-выйти -->
        <?php if(isset($_SESSION['auth'])): ?>
            <input type="button" class='gallery-btn header__login-btn' id='login-btn' value='Выйти'>
            <div class='header__username' id='header__username'><?=$user?></div>
        <?php else: ?>
            <input type="button" class='gallery-btn header__login-btn' id='login-btn' value='Войти'>
        <?php endif; ?>
    </header>
</body>

</html>