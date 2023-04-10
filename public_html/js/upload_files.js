const uploadSection = document.querySelector('#uploadFilesSection');
const fileNameInput = document.querySelector('.custom-file__label input');
const filenameLabel = document.querySelector('.custom-file__filename');
let filename;

// сброс выбора изображения
const resetBtn = document.querySelector('#upload-container__reset-btn');
if(resetBtn){
    resetBtn.addEventListener('click', ()=>{
        filenameLabel.innerHTML = 'файл не выбран';
        fileNameInput.value = '';
        filenameLabel.classList.remove('custom-file__filename_error');
    });
}

// показ имени выбранного изображения
if(fileNameInput){fileNameInput.addEventListener('change', e => {
    filenameLabel.innerHTML = e.target.files[0].name;
    filenameLabel.classList.remove('custom-file__filename_error');
});}

// закрыть окно добавления изображения
const closeUploadWdwBtn = document.querySelector('#uploadWdw__closeBtn');
closeUploadWdwBtn.addEventListener('click', ()=>{
    uploadSection.classList.remove('modal_active');
    filenameLabel.innerHTML = '';
    filenameLabel.classList.remove('custom-file__filename_error');
});

// открыть окно добавления изображения
const addImgBtn = document.querySelector('#gallery__addImgBtn');
if(addImgBtn){
    addImgBtn.addEventListener('click', ()=>{
        uploadSection.classList.add('modal_active');
    });
}

// отправка формы
let formElem = document.querySelector('#uploadWdw__form');
formElem.addEventListener('submit', function(e){
    e.preventDefault();
    if(filenameLabel.innerHTML !== 'Файл не выбран'){
        let data= new FormData(formElem);
        fetch('../../engine/upload_files.php', {method: 'POST', body: data}).then(r=>r.text()).then(data=>{
            if(data === 'OK'){
                setChangeFrontImage()();
                filenameLabel.innerHTML = 'Файл не выбран';
                uploadSection.classList.remove('modal_active');
            }
            else{ 
                filenameLabel.innerHTML = data;
                filenameLabel.classList.add('custom-file__filename_error');
            }
        });
    }
});