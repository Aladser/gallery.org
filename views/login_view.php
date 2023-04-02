<!-- модальное окно входа -->
<section id='loginInputSection' class='modal'>
    <div class='modalWindow loginWindow'>
        <h3 class='modal__header'> Авторизация</h3>
        <form method="POST">
        <input type='button' class='modal__closeBtn loginWindow__closeBtn' value='x'> 
        <div class='loginWindow__formRow'>
            <label for="loginInput" class='loginWindow__label'>Логин:</label>
            <input type='text' class='loginWindow__input loginWindow__loginInput' name='login' id='loginInput' autocomplete='on' value ='user' >
        </div> 
        <div class='loginWindow__formRow'>
            <label for="passwordInput" class='loginWindow__label'>Пароль:</label>
            <input type="password" class='loginWindow__input loginWindow__passwordInput' name='password' id='passwordInput' autocomplete='off' value= 'user'>
        </div>
        
        <div class='loginWindow__formRow loginWindow__btnRow'> 
            <input type='button' class='loginWindow__btn' id='loginWindow__sendBtn' value='Войти'>
            <input type='button' class='loginWindow__btn' id='loginWindow__regBtn' value='Регистрация'>            
        </div>
        <p class='loginWindow__error'>Ошибка</p>
    </form></div>
</section>