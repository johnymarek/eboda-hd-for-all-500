<?php echo "<?xml version='1.0' ?>"; ?>
<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/">

<channel>
	<title>divxonline</title>
	<menu>main menu</menu>


<?php
$query = $_GET["query"];
if($query) {
   $queryArr = explode(',', $query);
   $page = $queryArr[0];
   $search = $queryArr[1];
}
//http://divxonline.biz/comedie/page/2/
//http://divxonline.biz/comedie/page/1/
if($page) {
    if($search) {
        $html = file_get_contents($search."page/".$page."/");
    } else {
        $html = file_get_contents($search."page/".$page."/");
    }
} else {
    $page = 1;
    if($search) {
        $html = file_get_contents($search."page/".$page."/");
    } else {
        $html = file_get_contents($search."page/".$page."/");
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
<link><?php echo $url;?></link><media:thumbnail url="/tmp/hdd/volumes/HDD1/scripts/image/left.jpg" />
</item>


<?php } ?>
<?php

$videos = explode('<td class="post" colspan="2">', $html);
unset($videos[0]);
$videos = array_values($videos);

foreach($videos as $video) {
    $t1 = explode('<a href="', $video);
    $t2 = explode('"', $t1[1]);
    $link = $t2[0];
    $t3 = explode(">",$t1[1]);
    $t4 = explode("<",$t3[1]);
    $title = trim($t4[0]);
		$link = str_replace(' ','%20',$link);
		$link = str_replace('[','%5B',$link);
		$link = str_replace(']','%5D',$link); 
		  
    $t1 = explode(' src="', $video);
    $t2 = explode('"', $t1[2]);
    $image = $t2[0];

    $link = 'http://127.0.0.1:82/scripts/php/filme_link.php?file='.$link;
    echo '<item>';
    echo '<title>'.$title.'</title>';
    echo '<link>'.$link.'</link>';	
    echo '<media:thumbnail url="'.$image.'" />';
    echo '</item>';
    print "\n";
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
<media:thumbnail url="/tmp/hdd/volumes/HDD1/scripts/image/right.jpg" />
</item>

</channel>
</rss>