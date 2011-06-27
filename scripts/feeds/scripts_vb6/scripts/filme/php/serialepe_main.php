<?php echo "<?xml version='1.0' encoding='UTF8' ?>"; ?>
<rss version="2.0">
<onEnter>
  startitem = "middle";
  setRefreshTime(1);
</onEnter>

<onRefresh>
  setRefreshTime(-1);
  itemCount = getPageInfo("itemCount");
</onRefresh>

<mediaDisplay name="threePartsView"
	sideLeftWidthPC="0"
	sideRightWidthPC="0"

	headerImageWidthPC="0"
	selectMenuOnRight="no"
	autoSelectMenu="no"
	autoSelectItem="no"
	itemImageHeightPC="0"
	itemImageWidthPC="0"
	itemXPC="8"
	itemYPC="25"
	itemWidthPC="35"
	itemHeightPC="8"
	capXPC="8"
	capYPC="25"
	capWidthPC="35"
	capHeightPC="64"
	itemBackgroundColor="0:0:0"
	itemPerPage="8"
  itemGap="0"
	bottomYPC="90"
	backgroundColor="0:0:0"
	showHeader="no"
	showDefaultInfo="no"
	imageFocus=""
	sliding="no"
	idleImageXPC="5" idleImageYPC="5" idleImageWidthPC="8" idleImageHeightPC="10"
>

  	<text align="center" offsetXPC="0" offsetYPC="0" widthPC="100" heightPC="20" fontSize="30" backgroundColor="10:105:150" foregroundColor="100:200:255">
		  <script>getPageInfo("pageTitle");</script>
		</text>

  	<text redraw="yes" offsetXPC="85" offsetYPC="12" widthPC="10" heightPC="6" fontSize="20" backgroundColor="10:105:150" foregroundColor="60:160:205">
		  <script>sprintf("%s / ", focus-(-1))+itemCount;</script>
		</text>

		<text align="justify" redraw="yes"
          lines="18" fontSize=17
		      offsetXPC=45 offsetYPC=25 widthPC=50 heightPC=72
		      backgroundColor=0:0:0 foregroundColor=200:200:200>
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
			<text align="left" lines="1" offsetXPC=0 offsetYPC=0 widthPC=100 heightPC=100>
				<script>
					idx = getQueryItemIndex();
					focus = getFocusItemIndex();
					if(focus==idx)
					{
					  annotation = getItemInfo(idx, "annotation");
					}
					getItemInfo(idx, "title");
				</script>
				<fontSize>
  				<script>
  					idx = getQueryItemIndex();
  					focus = getFocusItemIndex();
  			    if(focus==idx) "14"; else "14";
  				</script>
				</fontSize>
			  <backgroundColor>
  				<script>
  					idx = getQueryItemIndex();
  					focus = getFocusItemIndex();
  			    if(focus==idx) "10:80:120"; else "-1:-1:-1";
  				</script>
			  </backgroundColor>
			  <foregroundColor>
  				<script>
  					idx = getQueryItemIndex();
  					focus = getFocusItemIndex();
  			    if(focus==idx) "255:255:255"; else "140:140:140";
  				</script>
			  </foregroundColor>
			</text>

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
    idx -= -8;
    if(idx &gt;= itemCount)
      idx = itemCount-1;
  }
  else
  {
    idx -= 8;
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

	<item_template>
		<mediaDisplay  name="threePartsView" idleImageXPC="5" idleImageYPC="5" idleImageWidthPC="8" idleImageHeightPC="10">
        <idleImage>image/POPUP_LOADING_01.png</idleImage>
        <idleImage>image/POPUP_LOADING_02.png</idleImage>
        <idleImage>image/POPUP_LOADING_03.png</idleImage>
        <idleImage>image/POPUP_LOADING_04.png</idleImage>
        <idleImage>image/POPUP_LOADING_05.png</idleImage>
        <idleImage>image/POPUP_LOADING_06.png</idleImage>
        <idleImage>image/POPUP_LOADING_07.png</idleImage>
        <idleImage>image/POPUP_LOADING_08.png</idleImage>
		</mediaDisplay>
	</item_template>
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
  if (strpos($description,"all posts filed") !== false) {
  $description=$title;
  }
  
	if ($link <> "") {
		$link = $host."/scripts/filme/php/serialepe.php?file=".$link.",".urlencode($title);
	  echo '
	  <item>
	  <title>'.$title.'</title>
	  <link>'.$link.'</link>
	  <annotation>'.$description.'</annotation>
	  <media:thumbnail url="'.$img.'" />
	  <mediaDisplay name="photoView"/>
	  </item>
	  ';
	  $n++;
	}
}
if ($n==0) {
$link = "/scripts/filme/php/serialepe.rss";
$description="Pentru a accesa acest site trebuie sa aveti un cont pe serialepe.net (e gratis). Completati user si pass in acest formular si apoi apasati return, return si apoi accesati din nou aceasta pagina. Daca user si pass sunt corecte veti vedea lista serialelor.";

	  echo '
	  <item>
	  <title>Logon</title>
	  <link>'.$link.'</link>
	  <annotation>'.$description.'</annotation>
	  <media:thumbnail url="'.$img.'" />
	  <mediaDisplay name="onePartView" />
	  </item>
	  ';
}
?>
</channel>
</rss>
