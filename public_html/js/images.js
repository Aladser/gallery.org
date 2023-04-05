/** установка изображения слайдера и комментариев к нему
 * type: 1 - кнопка вперед, 0 - кнопка назад, 2 - текущее изображение
 */ 
function setChangeFrontImage(type=2){
    return () => fetch(`../../data/images.php?id=true&type=${type}`).then(response => response.text()).then(data => {
        document.querySelector('.gallery__pane').src = data !== '' ? '../../data/img/'+data : '';
        document.querySelector('.cmt-container__list').querySelectorAll('.cmt-container__cmt').forEach(elem => elem.remove());
        showComments();
    });
}
setChangeFrontImage()();
document.querySelector('.gallery__prev-btn').addEventListener('click', setChangeFrontImage(0));
document.querySelector('.gallery__next-btn').addEventListener('click', setChangeFrontImage(1));

// добавление изображения
const addBtn = document.querySelector('.gallery__add-btn');
if(addBtn){
    addBtn.addEventListener('click', ()=>{
        location.href = '../../views/upload_file_view.php';
    });
}

// удаление изображения
const deleteBtn = document.querySelector('.gallery__delete-btn');
if(deleteBtn){
    deleteBtn.addEventListener('click', ()=>{
        let file = document.querySelector('.gallery__pane').src;
        fetch(`../../engine/delete_files.php?file=${file}`).then(r=>r.text()).then(d=>console.log(d));
        location.href = '../../index.php';
    });
}

window.addEventListener('resize', function(event) {
    console.log(this.window.outerWidth);
}, true);