<?php echo "<?xml version='1.0' encoding='UTF8' ?>"; ?>
<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/">
<onEnter>
  setRefreshTime(1);
</onEnter>

<onRefresh>
  setRefreshTime(-1);
  itemCount = getPageInfo("itemCount");
</onRefresh>
<mediaDisplay name="photoView"
	fontSize="16"
	rowCount="7"
	columnCount="3"
	sideColorBottom="10:105:150"
	sideColorTop="10:105:150"
	itemYPC="25"
	itemXPC="5"
	itemGapXPC="1"
	itemGapYPC="1"
	rollItems="yes"
	drawItemText="yes"
	itemOffsetXPC="5"
	itemImageWidthPC="0.1"
	itemImageHeightPC="0.1"
	imageBorderPC="1.5"
	forceFocusOnItem="yes"
	itemCornerRounding="yes"
	idleImageWidthPC="10"
	idleImageHeightPC="10"
	sideTopHeightPC=20
	bottomYPC=80
	sliding=yes
	showHeader=no
	showDefaultInfo=no
	>
  	<text align="center" offsetXPC="0" offsetYPC="0" widthPC="100" heightPC="20" fontSize="30" backgroundColor="10:105:150" foregroundColor="100:200:255">
		  <script>getPageInfo("pageTitle");</script>
		</text>

  	<text redraw="yes" offsetXPC="85" offsetYPC="12" widthPC="10" heightPC="6" fontSize="20" backgroundColor="10:105:150" foregroundColor="60:160:205">
		  <script>sprintf("%s / ", focus-(-1))+itemCount;</script>
		</text>
  	<text  redraw="yes" align="center" offsetXPC="0" offsetYPC="85" widthPC="100" heightPC="10" fontSize="17" backgroundColor="10:105:150" foregroundColor="100:200:255">
		  <script>print(annotation); annotation;</script>
		</text>
        <idleImage>image/POPUP_LOADING_01.png</idleImage>
        <idleImage>image/POPUP_LOADING_02.png</idleImage>
        <idleImage>image/POPUP_LOADING_03.png</idleImage>
        <idleImage>image/POPUP_LOADING_04.png</idleImage>
        <idleImage>image/POPUP_LOADING_05.png</idleImage>
        <idleImage>image/POPUP_LOADING_06.png</idleImage>
        <idleImage>image/POPUP_LOADING_07.png</idleImage>
        <idleImage>image/POPUP_LOADING_08.png</idleImage>
		<itemDisplay>
				<script>
					idx = getQueryItemIndex();
					focus = getFocusItemIndex();
					if(focus==idx) 
					{
					  annotation = getItemInfo(idx, "title");
					}
				</script>
		</itemDisplay>
<onUserInput>
<script>
ret = "false";
userInput = currentUserInput();

if (userInput == "pagedown" || userInput == "pageup")
{
  idx = Integer(getFocusItemIndex());
  if (userInput == "pagedown")
  {
    idx -= -21;
    if(idx &gt;= itemSize)
      idx = itemSize-1;
  }
  else
  {
    idx -= 21;
    if(idx &lt; 0)
      idx = 0;
  }
  
  print("new idx: "+idx);
  setFocusItemIndex(idx);
	setItemFocus(0);
  redrawDisplay();
  "true";
}
ret;
</script>
</onUserInput>
      		
</mediaDisplay>
<channel>
	<title>SerialePe.Net</title>
	<menu>main menu</menu>

<?php
function str_between($string, $start, $end){ 
	$string = " ".$string; $ini = strpos($string,$start); 
	if ($ini == 0) return ""; $ini += strlen($start); $len = strpos($string,$end,$ini) - $ini; 
	return substr($string,$ini,$len); 
}
$host = "http://127.0.0.1:82";
//necesita inregistrare pe site
//serialepe.txt are o singura linie de forma
//username@pass
$filename = "/scripts/filme/php/serialepe.txt";
$handle = fopen($filename, "r");
$c = fread($handle, filesize($filename));
fclose($handle);
$a=explode("@",$c);
$user=$a[0];
$pass=trim($a[1]);
$post="log=".$user."&pwd=".$pass."&rememberme=forever&wp-submit=Log+In&redirect_to=http%3A%2F%2Fwww.serialepe.net%2Fwp-admin%2F&testcookie=1";
if (function_exists('curl_init')) {
 $ch = curl_init("http://www.serialepe.net/wp-login.php");
 curl_setopt($ch, CURLOPT_POST      ,1);
 curl_setopt($ch, CURLOPT_POSTFIELDS    ,$post);
 curl_setopt($ch, CURLOPT_FOLLOWLOCATION  ,1);
 curl_setopt($ch, CURLOPT_HEADER      ,1);  // DO NOT RETURN HTTP HEADERS
 curl_setopt($ch, CURLINFO_HEADER_OUT ,1);
 curl_setopt($ch, CURLOPT_RETURNTRANSFER  ,1);  // RETURN THE CONTENTS OF THE CALL
 $html = curl_exec($ch);
 $a=explode("Set-Cookie: ",$html);
 $b=explode("httponly", $a[5]);
 $c=trim($b[0])." httponly";
 $handle = fopen("/tmp/serialepe.txt", "w");
 fwrite($handle,$c);
 fclose($handle);
} else {
  //wget solution
  exec ("date -s '112012002003'");
  $string = "http://www.serialepe.net/wp-login.php";
  exec("rm -f /tmp/vix");
  exec("rm -f /tmp/serialepe.txt");
  $c="/sbin/wget -q --save-cookies /tmp/serialepe.txt --post-data '".$post."' ".$string." -O /tmp/vix";
  exec($c);
  $html=file_get_contents("/tmp/vix");
}
//$html = file_get_contents("http://www.serialepe.net/");
//$html = str_between($html,"<h2 class='title'>Seriale Online</h2>","</ul>");
$videos = explode('<li class="cat-item cat-item', $html);
unset($videos[0]);
$videos = array_values($videos);
$img = "image/movies.png";
$n=0;
foreach($videos as $video) {
  $t1 = explode('href="', $video);
  $t2 = explode('"', $t1[1]);
  $link = $t2[0];

  $t3 = explode('">', $t1[1]);
  $t4 = explode('<', $t3[1]);
  $title = trim($t4[0]);
  
  $t1 = explode('title="',$video);
  $t2= explode('"',$t1[1]);
  $description = $t2[0];
  
	if (($link <> "") && (strpos($description,"all posts filed") === false)) {
		$link = $host."/scripts/filme/php/serialepe.php?file=".$link.",".urlencode($title);
	  echo '
	  <item>
	  <title>'.$title.'</title>
	  <link>'.$link.'</link>
	  <media:thumbnail url="'.$img.'" />
	  </item>
	  ';
	  $n++;
	}
}
if ($n==0) {
$link = "/scripts/filme/php/serialepe.rss";
	  echo '
	  <item>
	  <title>Logon</title>
	  <link>'.$link.'</link>
	  <media:thumbnail url="'.$img.'" />
	  <mediaDisplay name="onePartView" />
	  </item>
	  ';
}
?>
</channel>
</rss>
