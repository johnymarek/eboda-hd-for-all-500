<?php echo "<?xml version='1.0' ?>"; ?>
<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/">

<channel>
	<title>videonews.ro - tv</title>
	<menu>main menu</menu>


<?php
$link = $_GET["file"];
    $html = file_get_contents($link);
    $t1 = explode('file=', $html);
    $t2 = explode('&', $t1[1]);
    $link = $t2[0];
$pos = strpos($link, '.flv');
if ($pos !== false) {
    echo '<item>';
    echo '<title>Link</title>';
    echo '<link>'.$link.'</link>';
    echo '<media:thumbnail url="/scripts/image/videonews.jpg" />';
    echo '<enclosure type="video/flv" url="'.$link.'"/>';	
    echo '</item>';
}
else {
    $t1 = explode("file:'", $html);
    $t2 = explode("'", $t1[1]);
    $link = $t2[0];
    echo '<item>';
    echo '<title>Link</title>';
    echo '<link>'.$link.'</link>';
    echo '<media:thumbnail url="/scripts/image/videonews.jpg" />';
    echo '<enclosure type="video/flv" url="'.$link.'"/>';	
    echo '</item>';
  }
?>
</channel>
</rss>