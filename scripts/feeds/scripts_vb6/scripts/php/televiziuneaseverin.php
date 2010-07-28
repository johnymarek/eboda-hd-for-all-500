<?php echo "<?phpxml version='1.0' ?>"; ?>
<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/">

<channel>
	<title>televiziuneaseverin</title>
	<menu>main menu</menu>


<?php
$query = $_GET["query"];
if($query) {
   $queryArr = explode(',', $query);
   $page = $queryArr[0];
   $search = $queryArr[1];
}

if($page) {
	$page1 = 14 * ($page-1);
        $html = file_get_contents("http://www.televiziuneaseverin.ro/rts2/index.php?option=com_content&task=blogsection&id=6&Itemid=9&limit=14&limitstart=".$page1."");
    }
else {
    $page = 1;
        $html = file_get_contents("http://www.televiziuneaseverin.ro/rts2/index.php?option=com_content&task=blogsection&id=6&Itemid=9");
    }


if($page > 1) { ?>

<item>
<?php
$sThisFile = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];
$url = $sThisFile."?query=".($page-1).",";
?>
<title>Previous Page</title>
<link><?php echo $url;?></link><media:thumbnail url="/scripts/image/left.jpg" />
</item>


<?php } ?>

<?php
function str_between($string, $start, $end){ 
	$string = " ".$string; $ini = strpos($string,$start); 
	if ($ini == 0) return ""; $ini += strlen($start); $len = strpos($string,$end,$ini) - $ini; 
	return substr($string,$ini,$len); 
}
$image = "/scripts/image/televiziuneaseverin.png";
$videos = explode('<td class="contentheading"', $html);

unset($videos[0]);
$videos = array_values($videos);

foreach($videos as $video) {
    $t1 = explode('<a href="', $video);
    $t2 = explode('"', $t1[1]);
    $link = $t2[0];

    $title = str_between($video,'class="contentpagetitle">','</a>');
    $title = trim($title);
    
    $data = trim(str_between($video,'class="createdate">','<'));
    $data = str_replace("</em>","",$data);
    $data = str_replace("<span>","",$data);
    $data = str_replace("&ndash;","",$data);
    //$link = "http://127.0.0.1:82/scripts/php/televiziuneaseverin_link.php?file=".$link;
    $link = str_replace("&amp;","&",$link);
		$html = file_get_contents($link);
		//echo $html;
		$link = str_between($html, 'file=', '&');
		$link = str_replace(" ","%20",$link);

    echo '<item>';
    echo '<title>'.$title.'</title>';
    echo '<link>'.$link.'</link>';
    echo '<pubDate>'.$data.'</pubDate>';
    echo '<media:thumbnail url="'.$image.'" />';	
    echo '<enclosure type="video/flv" url="'.$link.'"/>';
    echo '</item>';
    print "\n";
}


?>

<item>
<?php
$sThisFile = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];
$url = $sThisFile."?query=".($page+1).",";
?>
<title>Next Page</title>
<link><?php echo $url;?></link>
<media:thumbnail url="/scripts/image/right.jpg" />
</item>

</channel>
</rss>