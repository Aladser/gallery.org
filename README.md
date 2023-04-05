## Галерея изображений
### gallery.org

Изображения показываются как слайдер.

Доступна регистрация и авторизация пользователя.

Показаны комментарии к изображениям. Авторизованные пользователи могут оставлять и удалять свои комментарии, добавлять и удалять изображения.

Дамп базы в папке **rsc**

![схема](/rsc/dump-galleryDB-202304052101.sql)

Структура:

**index.php** - главная страница

**public_html** - верстка страниц

**config/config.php** - константы и модели таблиц изображений и комментариев

**data/image_index.data** - хранить индекс последнего открытого изображения

**data/img** - хранение изображений

**data/images.php** - получить список изображений, текущее изображение; смена текущего изображения слайдера (запись нового индекса в image_index.data)

**engine/table_models** - классы моделей таблиц изображений и комментариев

**engine/comments-queries.php** - перехватывает запросы к серверу, связанные с комментариями

**engine/users-queries.php** - перехватывает запросы к серверу, связанные с пользователями

**engine/delete_files.php** - удаление файлов

**engine/upload_files.php** - загрузка файлов

**views** - шаблоны страниц и отдельных частей, кроме главной страницы

**sql_functions.sql** - сохранил себе код создания таблиц в БД
