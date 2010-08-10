<?php

$country = '';
$IP = $_SERVER['REMOTE_ADDR'];
echo $IP;
if (!empty($IP)) {
$country = file_get_contents('http://api.hostip.info/country.php?ip='.$IP);
echo $country ;
}
?>