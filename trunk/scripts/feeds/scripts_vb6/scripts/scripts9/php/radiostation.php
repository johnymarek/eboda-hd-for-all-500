<?php
header("Content-type: text/xml");
echo"<?xml version='1.0' ?>";
echo '<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/">';



/* MAIN */
$filecontent = file_get_contents( "http://radio.akado.ru/" ) ;
$filecontent = str_replace("<div", "\n<div", $filecontent );
$afilecontent = explode("\n", $filecontent );

echo "\n<channel>\n\n";
getItems( $afilecontent );
echo "\n</channel>\n\n";





function getItems( $afilecontent ){
$flag = 0;
foreach ($afilecontent as $line ){
$line = trim($line);
if ( 20 < strlen($line) ) { 
if ( 0 < substr_count($line, '<div class="r">' ) ){
$title = between($line, 'title="', '">'); 
$image = "http://radio.akado.ru".between($line, '<img src="', '" class="logo"');
$flag = 1;
}

if ( $flag && 0 < substr_count($line, '<div class="play">') ){
$file = between($line, '<div class="play"><a href="', '"><img src="');

if ( "http" == substr( $file, 0, 4 ) ){
$stations = explode("\n", file_get_contents( $file ) );
//print_r( $stations );
$station = array_pop($stations);
$station = array_pop($stations);
printitem( $title, $image, $station );
$flag = 0; 
} 
}
}
}
}


function printitem( $title, $image, $file )
{
echo "<item>\n";
echo "<title>$title</title>\n";
echo '<media:thumbnail url="'.$image.'" width="80" height="120" />'."\n";
echo "<enclosure type=\"video/mp4\" url=\"$file\"/>\n";
echo "</item>\n\n";
}



function between($s,$l,$r, $optional = false) { 
$ret = "";
$il = strpos($s,$l,0)+strlen($l); 

if (true == $optional){

if ( strlen($l) == $il && $il < strlen($s) ){
$ir = strpos($s,$r,$il); 
if ( 0 < $ir) { $ret = substr($s,$il,($ir-$il)); }
}
}
else
{
$ir = strpos($s,$r,$il); 
$ret = substr($s,$il,($ir-$il)); 
}
return $ret; 
}


?>
</rss>