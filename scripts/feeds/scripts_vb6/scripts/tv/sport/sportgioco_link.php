<?php
function str_between($string, $start, $end){ 
	$string = " ".$string; $ini = strpos($string,$start); 
	if ($ini == 0) return ""; $ini += strlen($start); $len = strpos($string,$end,$ini) - $ini; 
	return substr($string,$ini,$len); 
}
$link = $_GET["file"];
$html = file_get_contents($link);
if (strpos($link, "youtube") !== false) {
   if (strpos($link, "&") === false) {
			$v_id = substr(strrchr($link, "="), 1);
			$link = "http://127.0.0.1:83/cgi-bin/translate?stream,HD:1,http://www.youtube.com/watch?v=".$v_id;
   } else {
			$v_id = str_between($link,'v=','&');
			$link = "http://127.0.0.1:83/cgi-bin/translate?stream,HD:1,http://www.youtube.com/watch?v=".$v_id;
   }
print $link;
}
if (strpos($link, "sapo.pt") !== false) {
			$v_id = substr(strrchr($link, "/"), 1);
			$link = "http://rd3.videos.sapo.pt/".$v_id."/mov/1" ;
print $link;
}
if ((strpos($link, "dailymotion") !== false) || (strpos($link, "dai.ly") !== false)){
    $html = file_get_contents($link);
    $t1 = explode('sdURL', $html);
    $sd=urldecode($t1[1]);
    $t1=explode('"',$sd);
    $sd=$t1[2];
    $sd=str_replace("\\","",$sd);
    $n=explode("?",$sd);
    $nameSD=$n[0];
    $nameSD=substr(strrchr($nameSD,"/"),1);
    $t1 = explode('hqURL', $html);
    $hd=urldecode($t1[1]);
    $t1=explode('"',$hd);
    $hd=$t1[2];
    $hd=str_replace("\\","",$hd);
    $n=explode("?",$hd);
    $nameHD=$n[0];
    $nameHD=substr(strrchr($nameHD,"/"),1);
    if ($hd <> "") {
print $hd;
    }
    if (($sd <> "") && ($hd=="")) {
print $sd;
    }
}
if (strpos($link, "vids.myspace.com") !== false) {
			$suf1 = "/vid.mp4";
			$suf2 = "/vid.flv";
			$h1 = file_get_contents($link);
			$link = str_between($h1,'<link rel="image_src" href="','"');
			$link = str_replace('thumb1_','',$link);
			$link = str_replace('thumb2_','',$link);
			$link = str_replace('.jpg','',$link);
			$part = substr($link,34);
			$link = "http://l3-hl1.videos02.myspacecdn.com".$part.$suf1; //mp4
			$AgetHeaders = @get_headers($link);
			if (!preg_match("|200|", $AgetHeaders[0])) {
				$link = "http://l3-hl1.videos02.myspacecdn.com".$part.$suf2; //flv
				$AgetHeaders = @get_headers($link);
				if (!preg_match("|200|", $AgetHeaders[0])) {
					$link = "http://l3-hl1xl.myspacecdn.cust.footprint.net".$part.$suf1; //mp4
					$AgetHeaders = @get_headers($link);
					if (!preg_match("|200|", $AgetHeaders[0])) {
						$link = "http://l3-hl1xl.myspacecdn.cust.footprint.net".$part.$suf2; //flv
						$AgetHeaders = @get_headers($link);
						if (!preg_match("|200|", $AgetHeaders[0])) {
							$link = "";
						}
					}
				}
			}
print $link;
}
if (strpos($link, "svtplay.se") !== false) {
   $html = file_get_contents($link);
   $link = str_between($html,'pathflv=','&');
print $link;
}
?>
