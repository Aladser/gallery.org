// кнопка Назад
document.querySelector('#newPassword__backBtn').onclick = () => window.open('../index.php', '_self');

// Проверка на пустоту
const newLoginRegBtn = document.querySelector('.newUserForm__regBtn');
const newLoginInput = document.querySelector('#newUserForm__loginInput');
const newPasswordInput = document.querySelector('#newUserForm__passwordInput');
const checkNewDataFields = () => newLoginRegBtn.disabled = newLoginInput.value!=='' && newPasswordInput.value!=='' ? false : true;
checkNewDataFields();
newLoginInput.oninput = checkNewDataFields;
newPasswordInput.oninput =  checkNewDataFields;