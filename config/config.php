<?php
require_once(dirname(__DIR__, 1).'/engine/table_models/UsersModel.php');
require_once(dirname(__DIR__, 1).'/engine/table_models/CommentsModel.php');
require_once(dirname(__DIR__, 1).'/engine/DB.php');

define('UPLOAD_FILES', dirname(__DIR__, 1).'\data\img');
define('IMAGE_INDEX_FILE', dirname(__DIR__, 1).'\data\image_index.data');

define('HOST_DB', 'localhost');
define('NAME_DB','galleryDB');
define('USER_DB', 'admin');
define('PASS_DB','@admin@');

define('UPLOAD_MAX_SIZE', 10000000); // 10mb
define('ALLOWED_TYPES', ['image/jpeg', 'image/png', 'image/gif']);

$db = new DB(HOST_DB, NAME_DB, USER_DB, PASS_DB);
$usersModel = new UsersModel(HOST_DB, NAME_DB, USER_DB, PASS_DB, $db);
$cmtModel = new CommentsModel(HOST_DB, NAME_DB, USER_DB, PASS_DB, $db);