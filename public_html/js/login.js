const loginInputSection = document.querySelector('#loginInputSection');  // модальное окно входа/регистрации
const openLoginWindowBtn = document.querySelector('#login-btn');         // Кнопка Войти на главной странице 
const loginWindow = document.querySelector('.loginWindow');              // контейнер содержимого модального окна
const loginWindowError = document.querySelector('.loginWindow__error');  // поле ошибки входа

//Кнопка Открыть модальное окно/Выйти аутентификации кнопкой главной страницы
openLoginWindowBtn.onclick = () => {
    if(openLoginWindowBtn.value === 'Вход') loginInputSection.classList.add('modal_active');
    else location.href = '../index.php';
}
// кнопка закрытия модального окна
document.querySelector('.loginWindow__closeBtn').onclick = () => loginInputSection.classList.remove('modal_active');

//***** аутентификация *****//
const loginBtn = document.querySelector('#loginWindow__sendBtn');
const loginInput = document.querySelector('.loginWindow__loginInput');
const passInput = document.querySelector('.loginWindow__passwordInput');
loginBtn.onclick = ()=>{
    if(loginInput.value !== '' && passInput.value !== '') 
        location.href = `../php/users/auth.php?login=${loginInput.value}&password=${passInput.value}`;
}

//***** проверка аутентификации *****//
const [auth, login] = document.querySelector('#data-auth').getAttribute('data-json').split(':');
if(auth === 'ok'){
    let loginContainerName = document.querySelector('.login-container__name');
    loginContainerName.classList.remove('hidden');
    loginContainerName.innerHTML = login;
    openLoginWindowBtn.value = 'Выйти';
}
else if(auth === 'nouser' || auth === 'nopass'){
    loginInputSection.classList.add('modal_active');
    loginWindow .style.height = '15rem';
    loginWindowError.style.visibility = 'visible';
    loginWindowError.innerHTML = auth === 'nouser' ? 'Пользователь не существует' : 'Неверный пароль';
}

// кнопка регистрации
document.querySelector('#loginWindow__regBtn').onclick = () => location.href = '../pages/registration.php';