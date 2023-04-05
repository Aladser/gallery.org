const fileNameInput = document.querySelector('.custom-file__label input');
const filenameLabel = document.querySelector('.custom-file__filename');

// сброс выбора изображения
const resetBtn = document.querySelector('#upload-container__reset-btn');
if(resetBtn){
    resetBtn.addEventListener('click', ()=>{
        filenameLabel.innerHTML = 'файл не выбран';
        fileNameInput.value = '';
    });
}

// показ имени выбранного изображения
if(fileNameInput){fileNameInput.addEventListener('change', e => filenameLabel.innerHTML = e.target.files[0].name);}

// кнопка Назад
document.querySelector('#upload-container__back-btn').onclick = () => window.open('../index.php', '_self');