﻿<?php echo "<?xml version='1.0' ?>"; ?>
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
		KeezMovies.com
		</text>			
</mediaDisplay>
<channel>
	<title>KeezMovies.com</title>
	<menu>main menu</menu>


<?php
$query = $_GET["query"];
if($query) {
   $queryArr = explode(',', $query);
   $page = $queryArr[0];
   $search = $queryArr[1];
}

if($page) {
    if($search) {
        $html = file_get_contents($search."/?page=".$page."");
    } else {
        $html = file_get_contents($search."/?page=".$page."");
    }
} else {
    $page = 1;
    if($search) {
        $html = file_get_contents("http://www.keezmovies.com/search.html?q=".$search);
    } else {
        $html = file_get_contents("http://www.keezmovies.com/");
    }
}

if($page > 1) { ?>

<item>
<?php
$sThisFile = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];
$url = $sThisFile."?query=".($page-1).",";
if($search) { 
  $url = $url.$search; 
}
?>
<title>Previous Page</title>
<link><?php echo $url;?></link><media:thumbnail url="http://ims.hdplayers.net/scripts/image/left.jpg" />
</item>
<?php } ?>

<?php
$pos = strpos($html, 'div class="videoblock  home-body-thumbs"');
if ($pos === false) { 
	$videos = explode('<div class="videoblock  video-thumbs">', $html);
//<div class="videoblock  video-thumbs">
}
else {
	$videos = explode('div class="videoblock  home-body-thumbs"', $html);
}
//$videos = explode('div class="videoblock  home-body-thumbs"', $html);
unset($videos[0]);
$videos = array_values($videos);
foreach($videos as $video) {
    $t1 = explode('<a href="', $video);
    $t2 = explode('"', $t1[1]);
    $link =$t2[0];
    $pos = strpos($link, 'http');
if ($pos === false) {
    		$link ='http://www.keezmovies.com'.$t2[0];
    	}
		$link = "http://ims.hdplayers.net/scripts/php/keezmovies_link.php?file=".$link;
    $t1 = explode(' src="', $video);
    $t2 = explode('"', $t1[1]);
    $image = $t2[0];

    $t1 = explode(' title="', $video);
    $t2 = explode('"', $t1[1]);
    $title = $t2[0];


    echo '<item>';
    echo '<title>'.$title.'</title>';
    echo '<link>'.$link.'</link>';
    echo '<media:thumbnail url="'.$image.'" />';
    echo '</item>';

}
?>
<item>
<?php
$sThisFile = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];
$url = $sThisFile."?query=".($page+1).",";
if($search) { 
  $url = $url.$search; 
}
?>
<title>Next Page</title>
<link><?php echo $url;?></link>
<media:thumbnail url="http://ims.hdplayers.net/scripts/image/right.jpg" />
</item>

</channel>
</rss>
