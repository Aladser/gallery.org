/** установка смены изображения слайдера
 * type: 1 - кнопка вперед, 0 - кнопка назад, 2 - последнее изображение 
 */ 
function setChangeFrontImage(type=2){
    function change(){
        fetch(`../../data/images.php?id=true&type=${type}`).then(response => response.text()).then(data => {
            document.querySelector('.gallery__pane').src = '../../data/img/'+data;
        });
    }
    return change;
}

setChangeFrontImage()();
document.querySelector('.gallery__prev-btn').addEventListener('click', setChangeFrontImage(0));
document.querySelector('.gallery__next-btn').addEventListener('click', setChangeFrontImage(1));