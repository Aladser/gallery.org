/** установка смены изображения слайдера
 * type: 1 - кнопка вперед, 0 - кнопка назад, 2 - текущее изображение на сервере
 */ 
function setChangeFrontImage(type=2){
    function change(){
        fetch(`../../data/images.php?id=true&type=${type}`).then(response => response.text()).then(data => {
            if(data !== ''){
                document.querySelector('.gallery__pane').src = '../../uploads/'+data;
            }
            else{
                document.querySelector('.gallery__pane').src = '';
            }
        });
    }
    return change;
}

setChangeFrontImage()();
document.querySelector('.gallery__prev-btn').addEventListener('click', setChangeFrontImage(0));
document.querySelector('.gallery__next-btn').addEventListener('click', setChangeFrontImage(1));

// удаление изображения
const deleteBtn = document.querySelector('.gallery__delete-btn');
if(deleteBtn){
    deleteBtn.addEventListener('click', ()=>{
        let file = document.querySelector('.gallery__pane').src;
        fetch(`../../engine/delete_files.php?file=${file}`);
        location.href = '../../index.php';
    });
}

// сброс выбора изображения
const filenameLabel = document.querySelector('.custom-file__filename');
const fileNameInput = document.querySelector('.custom-file__label input');
const resetBtn = document.querySelector('#upload-container__reset-btn');
if(resetBtn){
    resetBtn.addEventListener('click', ()=>{
        filenameLabel.innerHTML = 'файл не выбран';
        fileNameInput.value = '';
    });
}

// выбор изображения
if(fileNameInput){
    fileNameInput.addEventListener('change', (e)=>{filenameLabel.innerHTML = e.target.files[0].name;});
}