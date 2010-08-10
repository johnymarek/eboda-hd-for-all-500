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
		onlinemoca.ro
		</text>			
</mediaDisplay>
<channel>
	<title>onlinemoca.ro</title>
	<menu>main menu</menu>
<?php
if($_GET[page]!="") {
$search="http://www.onlinemoca.com/page/$_GET[page]/";
$pagina = $_GET["page"];
} else {
$search="http://www.onlinemoca.com/";
$pagina = 1;
}
$baza = file_get_contents($search);
$b1 = explode('<div id="content">', $baza);
$b2 = explode('<div class="wp-pagenavi">', $b1[1]);
$continut = $b2[0];

$videos = explode('<h2>', $continut);
$videos = array_values($videos);

$data = explode('<div class="time">', $baza);
$data = explode('</div>', $data[1]);
$data = $data[0];
$next = $pagina + 1;
$prev = $pagina - 1;
$page = "http://ims.hdplayers.net/scripts/php/onlinemoca.php?page";

if($pagina!="1") {
echo'<item>
<title>Previous Page</title>
<link>'.$page.'='.$prev.'/</link>
<media:thumbnail url="http://ims.hdplayers.net/scripts/image/left.jpg" />
</item>
';
}

foreach($videos as $video) {
//  titlu  
    $v1 = explode('title="', $video);
    $v2 = explode('"', $v1[1]);
    $titlu = $v2[0];
    $titlu = str_replace("Permanent Link to ", "", "$titlu");	
    $titlu = htmlspecialchars_decode($titlu);
//  link  
    $v1 = explode('ink=', $video);
    $v2 = explode('"', $v1[1]);
    $link = $v2[0];  
//  imagine  
    $v1 = explode('src="', $video);
    $v2 = explode('"', $v1[1]);
    $image = $v2[0];  
//  descriere  
//  $v1 = explode('<p>', $video);
//  $v2 = explode('</p>', $v1[1]);
//  $descriere = $v2[0];  
//  $descriere = preg_replace("/(\r\n)+|(\n|\r)+|(<\/a>)+|(<strong>)+|(<\/strong>)+|(<br \/>)+|(<p>)+|(<\/p>)+|(<br>)+|(<\/br>)+|(<i>)+|(<\/i>)+|(<center>)+|(<\/center>)+|(<span>)+|(<\/span>)+|(<em>)+|(<\/em>)/", " ", $descriere);
//	$descriere = preg_replace("/(<b>)+|(<\/b>)/", ' - ', $descriere); 
//	$descriere = preg_replace("/(<)+|(>)/", '', $descriere);
//	$descriere = preg_replace("/'/", '`', $descriere); 
//	$descriere = preg_replace("/&amp;/", 'si', $descriere); 
//	$descriere = preg_replace("/(\s\s+)+|(  )/", ' ', $descriere); 

	if($link!="") {
//	$link2 = 'http://127.0.0.1:82/scripts/php/onlinemoca_link.php?file='.$link.'';
//	$link = "http://ims.hdplayers.net/scripts/php/onlinemoca_link.php?file=$link";
		$link = "http://127.0.0.1:8080/onlinemoca_link.php?file=$link";
	echo'
	<item>
	<title>'.$titlu.'</title>
	<link>'.$link.'</link>
	<pubDate>'.$data.'</pubDate> 
	<media:thumbnail url="'.$image.'" />
	</item>
	';
	}
}

echo'
<item>
<title>Next Page</title>
<link>'.$page.'='.$next.'/</link>
<media:thumbnail url="http://ims.hdplayers.net/scripts/image/right.jpg" />
</item>';

?>
</channel>
</rss>