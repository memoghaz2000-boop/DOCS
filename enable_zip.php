<?php
$iniPath = 'C:\xampp\php\php.ini';
$content = file_get_contents($iniPath);
$content = str_replace(';extension=zip', 'extension=zip', $content);
file_put_contents($iniPath, $content);
echo "zip enabled\n";
