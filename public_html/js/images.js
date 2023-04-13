/** установка изображения слайдера и комментариев к нему
 * type: 1 - кнопка вперед, 0 - кнопка назад, 2 - текущее изображение
 */ 
function setChangeFrontImage(type=2){
    return () => fetch(`../../engine/change-front-image.php?type=${type}`).then(response => response.text()).then(data => {
        document.querySelector('.gallery__pane').src = data !== '' ? '../../data/img/'+data : '';
        document.querySelector('.cmt-container__list').querySelectorAll('.cmt-container__cmt').forEach(elem => elem.remove());
        showComments();
    });
}
setChangeFrontImage()();
document.querySelector('.gallery__prev-btn').addEventListener('click', setChangeFrontImage(0));
document.querySelector('.gallery__next-btn').addEventListener('click', setChangeFrontImage(1));

// удаление изображения
const deleteBtn = document.querySelector('.gallery__delete-btn');
if(deleteBtn){
    let user = document.querySelector('#header__username').innerHTML;
    deleteBtn.addEventListener('click', ()=>{
        let file = document.querySelector('.gallery__pane').src;
        if(file !== 'http://gallery.org/index.php'){
            fetch(`../../engine/delete_files.php?delete=1&file=${file}&user=${user}`).then(r=>r.text()).then(data=>{
                if(data === '1' || data === '-1') location.href = '../../index.php';
                else alert(`ошибка удаления ${data}`);
            });
        }
    });
}