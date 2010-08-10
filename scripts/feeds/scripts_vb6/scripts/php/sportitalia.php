<?php echo "<?xml version='1.0' ?>"; ?>
<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/">
<mediaDisplay name="threePartsView" itemBackgroundColor="0:0:0" backgroundColor="0:0:0" sideLeftWidthPC="0" itemImageXPC="5" itemXPC="20" itemYPC="20" itemWidthPC="65" capWidthPC="70" unFocusFontColor="101:101:101" focusFontColor="255:255:255" idleImageXPC="45" idleImageYPC="42" idleImageWidthPC="20" idleImageHeightPC="26">
	<idleImage>image/busy1.png</idleImage>
	<idleImage>image/busy2.png</idleImage>
	<idleImage>image/busy3.png</idleImage>
	<idleImage>image/busy4.png</idleImage>
	<idleImage>image/busy5.png</idleImage>
	<idleImage>image/busy6.png</idleImage>
	<idleImage>image/busy7.png</idleImage>
	<idleImage>image/busy8.png</idleImage>
		<backgroundDisplay>
			<image  offsetXPC=0 offsetYPC=0 widthPC=100 heightPC=100>
			image/mele/backgd.jpg
			</image>  
		</backgroundDisplay>
		<image  offsetXPC=0 offsetYPC=2.8 widthPC=100 heightPC=15.6>
		image/mele/rss_title.jpg
		</image>
		<text  offsetXPC=40 offsetYPC=8 widthPC=35 heightPC=10 fontSize=20 backgroundColor=-1:-1:-1 foregroundColor=255:255:255>
		sportitalia
		</text>			
</mediaDisplay>
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
<link><?php echo $url;?></link><media:thumbnail url="http://ims.hdplayers.net/scripts/image/left.jpg" />
</item>


<?php } ?>

<?php
$image = "http://ims.hdplayers.net/scripts/image/sportitalia.jpg";
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
<media:thumbnail url="http://ims.hdplayers.net/scripts/image/right.jpg" />
</item>

</channel>
</rss>