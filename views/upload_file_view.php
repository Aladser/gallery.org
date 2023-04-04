<container class='upload-container'>
    <h4 class='upload-container__header'>Загрузка изображений</h4>
    <form action="engine/upload_files.php" method="post" enctype="multipart/form-data">
        <div class="custom-file">     

            <label class="custom-file__label" for="customFile" data-browse="Выбрать">
                Выберите файлы
                <br>
                <input type="file" name="files[]" id="customFile">
            </label>

            <?php if(isset($_SESSION['error'])): ?>
                <p class='custom-file__filename'><?=$_SESSION['error']?></p>
                <?php unset($_SESSION['error']); ?>
            <?php else: ?>
                <p class='custom-file__filename'>Файл не выбран</p>
            <?php endif; ?>

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