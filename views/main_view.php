<!DOCTYPE html>
<html lang="en">
    
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Галерея</title>
</head>

<body>
    <header class='header'>
        <p class='header__title'>Галерея</p>
        <!-- кнопка войти-выйти -->
        <?php if(isset($_SESSION['auth'])): ?>
            <input type="button" class='gallery-btn header__login-btn' id='login-btn' value='Выйти'>
            <div class='header__username' id='header__username'><?=$user?></div>
        <?php else: ?>
            <input type="button" class='gallery-btn header__login-btn' id='login-btn' value='Войти'>
        <?php endif; ?>

        <?php if($userRole === 'admin'): ?>
            <input type="button" class='gallery-btn header__users-btn' value='Пользователи'>
        <?php endif; ?>
    </header>

    <container class='gallery-container'>
        <?php if(isset($_SESSION['auth'])): ?>
            <div class='gallery__img-btns'>
                <input type="button" class='gallery-btn gallery__img-btn gallery__add-btn' id='gallery__addImgBtn' value="+" title='добавить изображение'>
                <input type="button" class='gallery-btn gallery__img-btn gallery__delete-btn' value="-" title='удалить текущее изображение'>
            </div>
        <?php endif; ?>
        <div class='gallery'>
            <div class='gallery__prev-btn' title='предыдущее изображение'>&#9001;</div>
            <img class='gallery__pane'>
            <div class='gallery__next-btn' title='следующее изображение'>&#9002;</div>
        </div>
    </container>

    <container class='cmt-container'>
        <h4 class='cmt-container__header'>Комментарии</h4>
        <div class='cmt-container__list'>

        </div>
        <?php if(isset($_SESSION['auth'])): ?>
            <form method="post" id='cmt-container__form'>
                <textarea  class='cmt-container__text' id='cmt-container__new-cmt'></textarea>
                <input type="submit" class='gallery-btn cmt-container__btn' id='cmt-container__submit-btn' value='Отправить' title='Добавить комментарий'>
            </form>
        <?php endif; ?>
    </container>

    <script type='text/javascript' src='public_html/js/login.js'></script>
    <script type='text/javascript' src='public_html/js/images.js'></script>
    <script type='text/javascript' src='public_html/js/comments.js'></script>
    <script type='text/javascript' src='public_html/js/upload_files.js'></script>
</body>

</html>