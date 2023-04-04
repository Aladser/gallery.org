<?php

define('UPLOAD_FILES', dirname(__DIR__, 1).'\data\img');
define('IMAGE_INDEX_FILE', dirname(__DIR__, 1).'\data\image_index.data');

define('HOST_DB', 'localhost');
define('NAME_DB','galleryDB');
define('USER_DB', 'admin');
define('PASS_DB','@admin@');

define('UPLOAD_MAX_SIZE', 10000000); // 10mb
define('ALLOWED_TYPES', ['image/jpeg', 'image/png', 'image/gif']);