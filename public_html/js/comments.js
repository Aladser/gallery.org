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

    // кнопка удаления комментария
    let loginNameLabel = document.querySelector('#header__username'); // поле отображения имени пользователя
    if(loginNameLabel){
        if(loginNameLabel.innerHTML === author){
            let btn = document.createElement('button');
            btn.innerHTML= '&#128465;';
            btn.className = 'cmt-container__delete-btn';
            btn.title = 'удалить комментарий';
            btn.onclick = setDeleteParentComment(dateElem);
            comment.appendChild(btn);
        }
    }

    comment.appendChild(textArea);
    comment.appendChild(authorElem);
    comment.appendChild(dateElem);
    document.querySelector('.cmt-container__list').appendChild(comment);
}

/** показать комментарии для текущего изображения */
function showComments(){
    fetch('../engine/comments-queries.php?comments=1').then(response => response.text()).then(data => {
        if(data !== ''){
            data = JSON.parse(data);      
            for(i=0; i<data.length; i++) addComment(data[i]['text'], data[i]['author'], data[i]['date']);
        }
    });
}

// функция удаления выбранного комментария пользователя
function setDeleteParentComment(elem){
    return () =>{
        fetch(`../engine/comments-queries.php?deletecmt=true&time=${elem.innerHTML}`).then(response => response.text()).then(data => {
            if(data === '1'){
                elem.parentNode.remove();
            }
        });
    }
}

// добавление нового комментария в БД
const sendNewCmtForm =  document.querySelector('#cmt-container__form');
if(sendNewCmtForm){
    let newCmt = document.querySelector('#cmt-container__new-cmt');
    let author =  document.querySelector('#header__username');
    sendNewCmtForm.addEventListener('submit', e => {
        if(newCmt.value !== ''){
            e.preventDefault();
            // POST-запрос
            let params = new URLSearchParams();
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
            date = `${date.getFullYear()}-${month}-${day} ${hours}:${minutes}:${seconds}`;
            params.set('date', date);
    
            fetch('../engine/comments-queries.php', {method: 'POST', body: params}).then(response => response.text()).then(data => {
                if(data === '1'){
                    addComment(newCmt.value, author.innerHTML, date);
                    newCmt.value = '';
                }
            });
        }
    });
}