<?php
$path_parts = pathinfo('/www/progetto/html/nocrawling/test.php');

echo $path_parts['dirname'], "\n";
echo $path_parts['basename'], "\n";
echo $path_parts['extension'], "\n";
echo $path_parts['filename'], "\n";
?>