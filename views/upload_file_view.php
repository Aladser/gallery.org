<section id='uploadFilesSection' class='modal'>
<container class='modalWindow upload-container'>
    <input type='button' class='modal__closeBtn' id='uploadWdw__closeBtn' value='x'> 
    <h4 class='upload-container__header'>Загрузка изображения</h4>

    <form method="submit" action="../engine/upload_files.php" id='uploadWdw__form' enctype="multipart/form-data">
        <div class="custom-file">     

            <label class="custom-file__label" for="customFile" data-browse="Выбрать">
                Выберите файлы
                <br>
                <input type="file" name="files[]" id="customFile">
            </label>
            <p class='custom-file__filename'>файл не выбран</p>
            <hr>
            <small>
                Максимальный размер файла: <?php echo UPLOAD_MAX_SIZE / 1000000; ?>Мб.
                Допустимые форматы: <?php echo implode(', ', ALLOWED_TYPES) ?>.
            </small>

        </div>
        <hr>
        <button type="submit" class="upload-container__btn">Загрузить</button>
        <button type="button" class="upload-container__btn" id='upload-container__reset-btn'>Сбросить</button>
    </form>

</container>
</section>