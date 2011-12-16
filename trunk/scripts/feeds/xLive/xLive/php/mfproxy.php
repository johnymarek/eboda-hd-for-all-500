<?php
$filelink=$_ENV["QUERY_STRING"];
#$filelink="http://127.0.0.1/xLive/php/mfproxy.php?http://www.metafeeds.com/channel/kids-channel/rss";

$html = file_get_contents($filelink);
                             

$patterns = array();
$patterns[0] = '/<link>(http:\/\/www.metafeeds.com.*)<\/link>/';
$patterns[1] = '/<link>([rtmp|mms].*)<\/link>/';
$patterns[2] = '/<enclosure type="video\/.*" url="(.*)"\/>/';

$replacements = array();
$replacements[0] = '<link>http://127.0.0.1:82/xLive/php/mfproxy.php?$1</link>';
$replacements[1] = '<onClick>playItemUrl("http://127.0.0.1:83/cgi-bin/translate?stream,,$1",10);</onClick>';
$replacements[2] = '<onClick>playItemUrl("http://127.0.0.1:83/cgi-bin/translate?stream,,$1",10);</onClick>';
echo preg_replace($patterns, $replacements, $html);


?>
