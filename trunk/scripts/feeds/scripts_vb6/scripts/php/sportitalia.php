<?php echo "<?xml version='1.0' ?>"; ?>
<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/">
<channel>
	<title>sportitalia</title>
	<menu>main menu</menu>

<?php
function str_between($string, $start, $end){ 
	$string = " ".$string; $ini = strpos($string,$start); 
	if ($ini == 0) return ""; $ini += strlen($start); $len = strpos($string,$end,$ini) - $ini; 
	return substr($string,$ini,$len); 
}
$page = $_GET["query"];


if($page) {
    //$html = file_get_contents("http://www.sportitalia.com/showvideo.aspx?id=".$page);
} else {
    $html = file_get_contents("http://www.sportitalia.com/video.aspx");
    $page = str_between($html,'showvideo.aspx?id=','"');  
		//$html = file_get_contents("http://www.sportitalia.com/showvideo.aspx?id=".$page);
}


if($page > 1 ) { ?>

<item>
<?php
$sThisFile = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];
$url = $sThisFile."?query=".($page+10);
?>
<title>Previous Page</title>
<link><?php echo $url;?></link><media:thumbnail url="/scripts/image/left.jpg" />
</item>


<?php } ?>

<?php
$image = "/scripts/image/sportitalia.jpg";
for ($i = 1; $i <= 10; $i++) {		
    $html = file_get_contents("http://www.sportitalia.com/showvideo.aspx?id=".$page);
    $html = str_between($html,'<div id="ctl00_bodyContent_UPvideo">','</embed>');
    $link = "http://www.sportitalia.com".str_between($html,"value='.","'");
    $link = str_replace(' ','%20',$link);
    $title= str_between($html,"<a title='","'");
    $data = str_between($html,"<span>","</span>");
    $page = $page -1;

    echo '<item>';
    echo '<title>'.$title.'</title>';
    echo '<link>'.$link.'</link>';
    echo '<pubDate>'.$data.'</pubDate>';
    echo '<media:thumbnail url="'.$image.'" />';
    echo '<enclosure type="video/x-ms-wmv" url="'.$link.'"/>';	
    echo '</item>';
    print "\n";

}


?>

<item>
<?php
$sThisFile = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];
$url = $sThisFile."?query=".($page);
?>
<title>Next Page</title>
<link><?php echo $url;?></link>
<media:thumbnail url="/scripts/image/right.jpg" />
</item>

</channel>
</rss>