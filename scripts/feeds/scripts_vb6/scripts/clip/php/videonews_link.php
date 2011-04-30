#!/usr/local/bin/Resource/www/cgi-bin/php
<?php
$link = $_GET["file"];
    $html = file_get_contents($link);
    $t1 = explode('file=', $html);
    $t2 = explode('&', $t1[1]);
    $link = $t2[0];
$pos = strpos($link, '.flv');
if ($pos !== false) {
print $link;
}
else {
    $t1 = explode("file:'", $html);
    $t2 = explode("'", $t1[1]);
    $link = $t2[0];
print $link;
  }
?>
