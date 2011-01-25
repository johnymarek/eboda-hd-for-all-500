#!/usr/local/bin/Resource/www/cgi-bin/php
<?php echo "<?xml version='1.0' ?>"; ?>
<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/">
<mediaDisplay name="threePartsView" 
	showDefaultInfo="no" 
	bottomYPC="0" 
	itemGap="0" 
	itemPerPage="10" 
	showHeader="no" 
	sideLeftWidthPC="0" 
	itemImageXPC="0" 
	itemImageHeightPC="0" 
	itemImageWidthPC="0" 
	itemXPC="10" 
	itemYPC="10" 
	itemWidthPC="50" 
	itemHeightPC="8" 
	capWidthPC="55" 
	unFocusFontColor="101:101:101" 
	focusFontColor="255:255:255" 
	idleImageXPC="40" idleImageYPC="40" idleImageWidthPC="20" idleImageHeightPC="26">
        <idleImage>image/busy1.png</idleImage>
        <idleImage>image/busy2.png</idleImage>
        <idleImage>image/busy3.png</idleImage>
        <idleImage>image/busy4.png</idleImage>
        <idleImage>image/busy5.png</idleImage>
        <idleImage>image/busy6.png</idleImage>
        <idleImage>image/busy7.png</idleImage>
        <idleImage>image/busy8.png</idleImage>
</mediaDisplay>
<channel>
	<title>Curs Valutar</title>
	<menu>main menu</menu>
<?php
//m.cursbnr.ro
function str_between($string, $start, $end){ 
	$string = " ".$string; $ini = strpos($string,$start); 
	if ($ini == 0) return ""; $ini += strlen($start); $len = strpos($string,$end,$ini) - $ini; 
	return substr($string,$ini,$len); 
}
$html = file_get_contents("http://m.cursbnr.ro/");
$title = str_between($html,"<p>","</p>");
    echo '<item>';
    echo '<title>'.$title.'</title>';
    echo '</item>';
$videos = explode('<p style="background-color:', $html);
unset($videos[0]);
$videos = array_values($videos);

foreach($videos as $video) {
    $t1 = explode('<b>', $video);
    $t2 = explode('</b>', $t1[1]);
    $title = $t2[0].'RON';
    echo '<item>';
    echo '<title>'.$title.'</title>';
    echo '</item>';
  }
  ?>
  </channel>
  </rss>