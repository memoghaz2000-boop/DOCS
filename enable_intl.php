<?php
$iniPath = 'C:\xampp\php\php.ini';
$content = file_get_contents($iniPath);
$content = str_replace(';extension=intl', 'extension=intl', $content);
file_put_contents($iniPath, $content);
echo "intl enabled\n";
