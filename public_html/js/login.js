const openLoginWindowBtn = document.querySelector('#login-btn');         // Кнопка Войти на главной странице 
const loginInputSection = document.querySelector('#loginInputSection');  // модальное окно входа/регистрации
const loginWindowError = document.querySelector('.loginWindow__error');  // поле ошибки входа
document.querySelector('#loginWindow__regBtn').onclick = () => location.href = '../views/registration_view.php'; // кнопка регистрации
document.querySelector('.loginWindow__closeBtn').onclick = () => loginInputSection.classList.remove('modal_active'); // кнопка закрытия модального окна

//Кнопка Открыть модальное окно/Выйти главной страницы
openLoginWindowBtn.onclick = () => {
    if(openLoginWindowBtn.value === 'Войти') 
        loginInputSection.classList.add('modal_active');
    else
        location.href = '/engine/users-queries.php?logout=1';
}

//***** авторизация *****//
document.querySelector('#loginWindow__form').addEventListener('submit', function(e){
    e.preventDefault();
    let form = new FormData(this);
    fetch('../engine/users-queries.php', {method: 'POST', body: form}).then(response => response.text()).then(data => {
        console.log(data);
        if(data !== 'auth') {
            loginWindowError.classList.remove('hidden');
            if(data === 'wrongpass') loginWindowError.innerHTML = 'Неверный пароль';
            else if(data === 'nouser') loginWindowError.innerHTML = 'Пользователь не найден';
            else loginWindowError.innerHTML = 'Двойная аутентификация';
        }
        else{
            location.href = '/index.php';
        }
    });
});
