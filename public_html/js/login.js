const openLoginWindowBtn = document.querySelector('#login-btn');         // Кнопка Войти на главной странице 
const loginInputSection = document.querySelector('#loginInputSection');  // модальное окно входа/регистрации
const loginWindow = document.querySelector('.loginWindow');              // контейнер содержимого модального окна
const loginWindowError = document.querySelector('.loginWindow__error');  // поле ошибки входа
document.querySelector('#loginWindow__regBtn').onclick = () => location.href = '../views/registration_view.php'; // кнопка регистрации
document.querySelector('.loginWindow__closeBtn').onclick = () => loginInputSection.classList.remove('modal_active'); // кнопка закрытия модального окна

//Кнопка Открыть модальное окно/Выйти главной страницы
openLoginWindowBtn.onclick = () => {
    if(openLoginWindowBtn.value === 'Войти') loginInputSection.classList.add('modal_active');
    else location.href = '../../engine/logout.php';
}

//***** авторизация *****//
const loginInput = document.querySelector('.loginWindow__loginInput');
const passInput = document.querySelector('.loginWindow__passwordInput');
document.querySelector('#loginWindow__sendBtn').onclick = ()=>{
    if(loginInput.value !== '' && passInput.value !== '') {
        // POST-запрос
        const params = new URLSearchParams();
        params.set('auth', true);
        params.set('login', loginInput.value);
        params.set('password', passInput.value);
        fetch('../engine/db.php', {method: 'POST', body: params}).then(response => response.text()).then(data => {
            console.log(data);
            if(data !== 'auth') {
                loginWindowError.classList.remove('hidden');
                loginWindowError.innerHTML = data === 'wrongpass' ? 'Неверный пароль' : 'Пользователь не найден';
            }
            else{
                location.href = '/index.php';
            }
        });
    }
}
