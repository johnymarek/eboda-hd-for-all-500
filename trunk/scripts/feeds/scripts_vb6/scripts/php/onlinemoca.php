<?php echo "<?xml version='1.0' ?>"; ?>
<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/">

<channel>
	<title>onlinemoca.ro</title>
	<menu>main menu</menu>
<?php
if($_GET[page]!="") {
$search="http://www.onlinemoca.com/page/$_GET[page]/";
} else {
$search="http://www.onlinemoca.com/";
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

$pagina = explode('<span class="current">', $baza);
$pagina = explode('</span>', $pagina[1]);
$pagina = $pagina[0];
$next = $pagina + 1;
$prev = $pagina - 1;
$last = explode('<span class="pages">', $baza);
$last = explode('</span>', $last[1]);
$last = $last[0];
$pos = strpos($last, 'of');
$pos = $pos + 3;
$last = substr("$last", "$pos");
$page = "http://127.0.0.1:82/scripts/php/onlinemoca.php?page";

if($pagina!="1") {
echo'<item>
<title>Previous Page ('.$prev.' din '.$last.')</title>
<link>'.$page.'='.$prev.'/</link>
<media:thumbnail url="/tmp/hdd/volumes/HDD1/scripts/image/left.jpg" />
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
	$link = "http://127.0.0.1:82/scripts/php/onlinemoca_link.php?file=$link";
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

if($pagina!="$last") {
echo'
<item>
<title>Next Page ('.$next.' din '.$last.')</title>
<link>'.$page.'='.$next.'/</link>
<media:thumbnail url="/tmp/hdd/volumes/HDD1/scripts/image/right.jpg" />
</item>';
}

?>
</channel>
</rss>