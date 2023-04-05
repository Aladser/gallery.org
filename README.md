## Галерея изображений
#### gallery.org

Изображения показываются как слайдер.

Доступна регистрация и авторизация пользователя.

Показаны комментарии к изображениям. Авторизованные пользователи могут оставлять и удалять свои комментарии, добавлять и удалять изображения.

Структура:

**index.php** - главная страница

**public_html** - верстка страниц

**config/config.php** - константы и классы моделей таблицы изображений и комментариев

**data/image_index.data** - хранить индекс последнего открытого изображения

**data/img** - хранение изображений

**data/images.php** - получить список изображений, текущее изображение; смена текущего изображения слайдера (запись нового индекса в image_index.data)

**engine/table_models** - модели таблица изображений и комментариев

**enginecomments-queries.php** - перехватывает запросы к серверу, связанные с комментариями

**engineusers-queries.php** - перехватывает запросы к серверу, связанные с пользователями

**delete_files.php** - удаление файлов

**upload_files.php** - загрузка файлов

**views** - шаблоны страниц и отдельных частей, кроме главной страницы
