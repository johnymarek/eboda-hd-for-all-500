<?php echo "<?phpxml version='1.0' ?>"; ?>
<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/">


<channel>
	<title>clickplay.tv</title>
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
        $html = file_get_contents("http://www.keezmovies.com/search.html?q=".$search."&page=".$page);
    } else {
        $html = file_get_contents("http://www.clickplay.tv/page,allMovies,show,".$page."");
    }
} else {
    $page = 1;
    if($search) {
        $html = file_get_contents("http://www.keezmovies.com/search.html?q=".$search);
    } else {
        $html = file_get_contents("http://www.clickplay.tv/page,allMovies,show,1");
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
$videos = explode('<a class="film_title"', $html);
unset($videos[0]);
$videos = array_values($videos);

foreach($videos as $video) {
    $t1 = explode(',', $video);
    $t2 = explode('">', $t1[1]);
    $link ='http://video.clickplay.tv/'.$t2[0].'.flv';
    
    $t1 = explode('">', $video);
    $t2 = explode('</a>', $t1[1]);
    $title = $t2[0];

$t1 = explode('<img style="border: 2px #000000 solid;" src="', $video);
$t2 = explode('.jpg', $t1[1]);
$image = 'image/arrow_right.png';

    echo '<item>';
    echo '<title>'.$title.'</title>';
    echo '<link>'.$link.'</link>';
    echo '<media:thumbnail url="'.$image.'" />';
    echo '<enclosure type="video/flv" url="'.$link.'"/>';	
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