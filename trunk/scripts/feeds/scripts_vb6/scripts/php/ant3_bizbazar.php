<?php echo "<?xml version='1.0' ?>"; ?>
<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/">

<channel>
	<title>Bizbazar cu Moise Guran</title>
	<menu>main menu</menu>


<?php
$d = $_GET["d"];
echo '<item>';
echo '<title>Bizbazar cu Moise Guran - '.$d.' (HQ)</title>';
echo '<link>http://127.0.0.1/cgi-bin/rtmp?rtmpe://fms8.mediadirect.ro:80/recantena3?id=1676684/mp4:Bizbazar_cu_Moise_Guran_L-J_'.$d.'_16-05-00.mp4</link>';
echo '<media:thumbnail url="/tmp/hdd/volumes/HDD1/scripts/php/antena3.jpg" />';
echo '<enclosure type="video/mp4" url="http://127.0.0.1/cgi-bin/rtmp?rtmpe://fms8.mediadirect.ro:80/recantena3?id=1676684/mp4:Bizbazar_cu_Moise_Guran_L-J_'.$d.'_16-05-00.mp4"/>';
echo '</item>';

echo '<item>';
echo '<title>Bizbazar cu Moise Guran - '.$d.' (LQ)</title>';
echo '<link>http://127.0.0.1/cgi-bin/rtmp?rtmpe://fms8.mediadirect.ro:80/recantena3?id=1676684/mp4:Bizbazar_cu_Moise_Guran_L-J_'.$d.'_16-05-00_low.mp4</link>';
echo '<media:thumbnail url="/tmp/hdd/volumes/HDD1/scripts/php/antena3.jpg" />';
echo '<enclosure type="video/mp4" url="http://127.0.0.1/cgi-bin/rtmp?rtmpe://fms8.mediadirect.ro:80/recantena3?id=1676684/mp4:Bizbazar_cu_Moise_Guran_L-J_'.$d.'_16-05-00_low.mp4"/>';
echo '</item>';


?>

</channel>
</rss>