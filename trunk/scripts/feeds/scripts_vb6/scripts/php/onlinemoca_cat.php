<?php echo "<?xml version='1.0' ?>"; ?>
<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/">

<channel>
	<title>onlinemoca.ro</title>
	<menu>main menu</menu>
<?php
function str_between($string, $start, $end){ 
	$string = " ".$string; $ini = strpos($string,$start); 
	if ($ini == 0) return ""; $ini += strlen($start); $len = strpos($string,$end,$ini) - $ini; 
	return substr($string,$ini,$len); 
}
$cat=$_GET["cat"];
if($_GET["page"]!="") {
	$pagina = $_GET["page"];
$search='http://www.onlinemoca.com/category/filme-online/'.$cat.'/page/'.$_GET["page"].'/';
} else {
$search='http://www.onlinemoca.com/category/filme-online/'.$cat.'/';
$pagina = 1;
}
$baza = file_get_contents($search);
$b1 = explode('<div id="content">', $baza);
$b2 = explode('<div class="wp-pagenavi">', $b1[1]);
$continut = $b2[0];

$videos = explode('<h1>', $continut);
$videos = array_values($videos);

$data = explode('<div class="time">', $baza);
$data = explode('</div>', $data[1]);
$data = $data[0];
//<span class="pages">Page 1 of 18</span><span class="current">1</span>
//$t1 = explode('<span class="current">', $baza);
//$t2 = explode('</span>', $t1[1]);
//$pagina = str_between($baza,'<span class="current">','</span>');
//echo $$t1[1];
$next = $pagina + 1;
$prev = $pagina - 1;
$page = 'http://127.0.0.1:82/scripts/php/onlinemoca_cat.php?cat='.$cat.'&amp;page';

if($pagina!="1") {
echo'<item>
<title>Previous Page</title>
<link>'.$page.'='.$prev.'</link>
<media:thumbnail url="/scripts/image/left.jpg" />
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

echo'
<item>
<title>Next Page</title>
<link>'.$page.'='.$next.'/</link>
<media:thumbnail url="/scripts/image/right.jpg" />
</item>';


?>
</channel>
</rss>