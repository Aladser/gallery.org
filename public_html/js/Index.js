function changeFrontImage(type){
    fetch('../../data/images.php?id').then(response => response.text()).then(data => {
        console.log(data);
        document.querySelector('.gallery__pane').src = '../../data/img/'+data;
    });
}
changeFrontImage();
changeFrontImage();
changeFrontImage();