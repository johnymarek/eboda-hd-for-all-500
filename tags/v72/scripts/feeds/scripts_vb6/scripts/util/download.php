#!/usr/local/bin/Resource/www/cgi-bin/php
<?php
$file = $_GET["file"];
$log_file = file($file);
$t1 = explode('/log/', $file);
$t1 = explode('.log', $t1[1]);
$log = $log_file[count($log_file) -4];
$t3 = explode("K", $log);
$t4 = substr($log, -25);
$t5 = explode("%", $log);
$end = substr($t5[0], -3);
$title = $t1[0].' -  '.$t3[0].'KB'.$t4;
echo $title;
?>
