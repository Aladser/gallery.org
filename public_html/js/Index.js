const imagePane = document.querySelector('.gallery__pane');
const commentsList = document.querySelector('.cmt-container__list');

// создание комментария
function addComment(text, author, date){
    let textArea = document.createElement('textarea');
    textArea.className = 'cmt-container__cmt';
    textArea.innerHTML = text;

    let authorElem = document.createElement('div');
    let dateElem = document.createElement('div');
    authorElem.innerHTML = author;
    dateElem.innerHTML = date;

    commentsList.appendChild(authorElem);
    commentsList.appendChild(dateElem);
    commentsList.appendChild(textArea);
}

/** установка изображения слайдера и вывод комментариев
 * type: 1 - кнопка вперед, 0 - кнопка назад, 2 - текущее изображение на сервере
 */ 
function setChangeFrontImage(type=2){
    return () => fetch(`../../data/images.php?id=true&type=${type}`).then(response => response.text()).then(data => {
        imagePane.src = data !== '' ? '../../data/img/'+data : '';
    });
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

// показ имени выбранного изображения
if(fileNameInput){
    fileNameInput.addEventListener('change', e => filenameLabel.innerHTML = e.target.files[0].name);
}

// отправка нового комментария
const sendNewCmtBtn =  document.querySelector('.cmt-container__btn');
if(sendNewCmtBtn){
    let newCmt = document.querySelector('#cmt-container__new-cmt');
    let author =  document.querySelector('.gallery-login-name');
    document.querySelector('.cmt-container__btn').addEventListener('click', () => {
        if(newCmt.value !== ''){
            // POST-запрос
            const params = new URLSearchParams();
            params.set('image', imagePane.src);
            params.set('newcmt', true);
            params.set('text', newCmt.value);
            params.set('author', author.innerHTML);
    
            // текущее время
            let date = new Date();
            let addZeroToNumber = number => number<10 ? `0${number}` : number; // добавление 0 к числу
            let month = addZeroToNumber(date.getMonth()+1);
            let day = addZeroToNumber(date.getDate());
            let hours = addZeroToNumber(date.getHours());
            let minutes = addZeroToNumber(date.getMinutes());
            let seconds = addZeroToNumber(date.getSeconds());
            let tableDate = `${date.getFullYear()}-${month}-${day} ${hours}:${minutes}:${seconds}`;
            params.set('date', tableDate);
    
            fetch('../engine/db.php', {method: 'POST', body: params}).then(response => response.text()).then(data => {
                if(data === '1'){
                    addComment(newCmt.value, author.innerHTML, tableDate);
                    newCmt.value = '';
                }
                else
                    location.href = 'Location: ../../index.php';
            });
        }
    });
}
