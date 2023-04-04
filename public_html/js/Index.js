const imagePane = document.querySelector('.gallery__pane');
const commentsList = document.querySelector('.cmt-container__list');

/** установка изображения слайдера и комментариев к нему
 * type: 1 - кнопка вперед, 0 - кнопка назад, 2 - текущее изображение
 */ 
function setChangeFrontImage(type=2){
    return () => fetch(`../../data/images.php?id=true&type=${type}`).then(response => response.text()).then(data => {
        imagePane.src = data !== '' ? '../../data/img/'+data : '';
        commentsList.querySelectorAll('.cmt-container__cmt').forEach(elem => elem.remove());
        showComments();
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
if(fileNameInput){fileNameInput.addEventListener('change', e => filenameLabel.innerHTML = e.target.files[0].name);}

/** создание комментария на html-странице */
function addComment(text, author, date){
    let comment = document.createElement('div');
    comment.className = 'cmt-container__cmt';

    let textArea = document.createElement('p');
    textArea.innerHTML = text;
    textArea.className = 'cmt-container__text';

    let authorElem = document.createElement('div');
    authorElem.className = 'cmt-container__author';
    authorElem.innerHTML = author;

    let dateElem = document.createElement('div');
    dateElem .className = 'cmt-container__date';
    dateElem.innerHTML = date;

    comment.appendChild(textArea);
    comment.appendChild(authorElem);
    comment.appendChild(dateElem);
    commentsList.appendChild(comment);
}

/** показать комментарии для текущего изображения */
function showComments(){
    const params = new URLSearchParams();
    params.set('comments', true);
    fetch('../engine/db.php', {method: 'POST', body: params}).then(response => response.text()).then(data => {
        data = JSON.parse(data);
        for(i=0; i<data.length; i++) addComment(data[i][0], data[i][1], data[i][2]);
    });
}

// отправка нового комментария
const sendNewCmtBtn =  document.querySelector('.cmt-container__btn');
if(sendNewCmtBtn){
    let newCmt = document.querySelector('#cmt-container__new-cmt');
    let author =  document.querySelector('.gallery-login-name');
    sendNewCmtBtn.addEventListener('click', () => {
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
                console.log(data);
                if(data === '1'){
                    addComment(newCmt.value, author.innerHTML, tableDate);
                    newCmt.value = '';
                }
            });
        }
    });
}