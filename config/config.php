<?php

define('FILES', dirname(__DIR__, 1).'\uploads');
define('IMAGE_INDEX_FILE', dirname(__DIR__, 1).'\data\image_index.data');
define('MAX_FILE_SIZE', 10000000);

define('HOST_DB', 'localhost');
define('NAME_DB','galleryDB');
define('USER_DB', 'admin');
define('PASS_DB','@admin@');

define('URL', '/'); // URL текущей страницы
define('UPLOAD_MAX_SIZE', 1000000); // 1mb
define('ALLOWED_TYPES', ['image/jpeg', 'image/png', 'image/gif']);
define('UPLOAD_DIR', 'uploads');