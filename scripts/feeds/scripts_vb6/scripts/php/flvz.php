<?php echo "<?phpxml version='1.0' ?>"; ?>
<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/">

<channel>
	<title>flvz.com</title>
	<menu>main menu</menu>
<?php
function str_between($string, $start, $end){ 
	$string = " ".$string; $ini = strpos($string,$start); 
	if ($ini == 0) return ""; $ini += strlen($start); $len = strpos($string,$end,$ini) - $ini; 
	return substr($string,$ini,$len); 
}
$image = "http://ims.hdplayers.net/scripts/image/movies.png";
$id = $_GET["id"];
$link = "http://upstream.flvz.com/convertite/".$id.".flv";
//http://upstream.flvz.com/convertite/173.flv
echo'
<item>
<title>'.$id.'</title>
<link>'.$link.'</link>
<media:thumbnail url="'.$image.'" />
<enclosure type="video/flv" url="'.$link.'" />	
</item>
';
?>
<item>
	<title>Nine (2009)</title>
	<link>http://upstream.flvz.com/convertite/173.flv</link>
	<media:thumbnail url="http://ims.hdplayers.net/scripts/image/movies.png" />
	<enclosure type="video/flv" url="http://upstream.flvz.com/convertite/173.flv" />
	</item>
</channel>
</rss>