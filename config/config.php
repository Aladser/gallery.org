<?php
define('FILES', 'data/img');

// файлы
$files = scandir(FILES);
array_splice($files,0, 2);
echo 'Файлы: ';
print_r($files);
