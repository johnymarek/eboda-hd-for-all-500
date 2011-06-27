<?php echo "<?xml version='1.0' encoding='UTF8' ?>";
$host = "http://127.0.0.1:82";
?>
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
	itemWidthPC="20"
	itemHeightPC="8"
	capXPC="8"
	capYPC="25"
	capWidthPC="20"
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
		<text align="left" redraw="yes"
          lines="12" fontSize=15
		      offsetXPC=30 offsetYPC=40 widthPC=65 heightPC=48
		      backgroundColor=0:0:0 foregroundColor=200:200:200>
			<script>print(annotation); annotation;</script>
		</text>
		<image  redraw="yes" offsetXPC=52 offsetYPC=25 widthPC=25 heightPC=10>
  /scripts/tv/image/dolce.jpg
		</image>
		
		<image  redraw="yes" offsetXPC=10 offsetYPC=7 widthPC=10 heightPC=10>
		<script>print(img); img;</script>
		</image>
  	<text  redraw="yes" align="center" offsetXPC="0" offsetYPC="90" widthPC="100" heightPC="8" fontSize="17" backgroundColor="10:105:150" foregroundColor="100:200:255">
    Apasati 2 pentru program
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
                      img = getItemInfo(idx,"image");
					}
					getItemInfo(idx, "title");
				</script>
				<fontSize>
  				<script>
  					idx = getQueryItemIndex();
  					focus = getFocusItemIndex();
  			    if(focus==idx) "16"; else "14";
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
  annotation = " ";
  setFocusItemIndex(idx);
	setItemFocus(0);
  redrawDisplay();
  "true";
}
else if(userInput == "two")
{
showIdle();
idx = Integer(getFocusItemIndex());
url_canal = "http://127.0.0.1:82/scripts/tv/php/dolce_prog.php?file=" + getItemInfo(idx,"canal");
annotation = getURL(url_canal);
cancelIdle();
"true";
}
else
{
annotation = " ";
"true";
}
      redrawDisplay();
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
  <title>Dolce TV</title>
<!-- Dolce TV -->
<?php
function str_between($string, $start, $end){
	$string = " ".$string; $ini = strpos($string,$start);
	if ($ini == 0) return ""; $ini += strlen($start); $len = strpos($string,$end,$ini) - $ini;
	return substr($string,$ini,$len);
}
$link="http://www.dolcetv.ro/tv-live";
$html = file_get_contents($link);
$l=array (
"Dolce Sport" => "10212,rtmpe://fms1.mediadirect.ro:80/live3?id=10668839&publisher=2/dolcesport",
"Dolce Sport 2" => "10225,rtmpe://fms1.mediadirect.ro:80/live3?id=10668839&publisher=2/dolcesport2",
"Antena 3" => "10055,rtmpe://fms1.mediadirect.ro:80/live3?id=10668839&publisher=2/antena_3",
"Antena 2" => "10119,rtmpe://fms1.mediadirect.ro:80/live3?id=10668839&publisher=2/antena2",
"Realitatea TV" => "10019,rtmpe://fms1.mediadirect.ro:80/live3?id=10668839&publisher=2/realitatea",
"B1 TV" => "10022,rtmpe://fms1.mediadirect.ro:80/live3?id=10668839&publisher=2/b1",
"TVR 1" => "10001,rtmpe://fms1.mediadirect.ro:80/live3?id=10668839&publisher=2/tvr1",
"TVR 2" => "10002,rtmpe://fms1.mediadirect.ro:80/live3?id=10668839&publisher=2/tvr2",
"TVR 3" => "10208,rtmpe://fms1.mediadirect.ro:80/live3?id=10668839&publisher=2/tvr3",
"TVR Cultural" => "10025,rtmpe://fms1.mediadirect.ro:80/live3?id=10668839&publisher=2/tvrcultural",
"TVR International" => "10015,rtmpe://fms1.mediadirect.ro:80/live3?id=10668839&publisher=2/tvr",
"TVR Info" => "10174,rtmpe://fms1.mediadirect.ro:80/live3?id=10668839&publisher=2/tvrinfo",
"TVR HD" => "10190,rtmpe://fms1.mediadirect.ro:80/live3?id=10668839&publisher=2/tvrhd",
"OTV" => "10046,rtmpe://fms1.mediadirect.ro:80/live3?id=10668839&publisher=2/otv",
"UTV" => "10096,rtmpe://fms1.mediadirect.ro:80/live3?id=10668839&publisher=2/utv",
"Mynele TV" => "10206,rtmpe://fms1.mediadirect.ro:80/live3?id=10668839&publisher=2/mynele",
"Etno TV" => "10037,rtmpe://fms1.mediadirect.ro:80/live3?id=10668839&publisher=2/etno",
"The Money Channel" => "10076,rtmpe://fms1.mediadirect.ro:80/live3?id=10668839&publisher=2/money",
"Euronews" => "10113,rtmpe://fms1.mediadirect.ro:80/live3?id=10668839&publisher=2/euronews",
"Kiss TV" => "10008,rtmpe://fms1.mediadirect.ro:80/live3?id=10668839&publisher=2/kiss",
"Transilvania Channel" => "0,rtmpe://fms1.mediadirect.ro:80/live3?id=10668839&publisher=2/somes",
"Taraf TV" => "10101,rtmpe://fms1.mediadirect.ro:80/live3?id=10668839&publisher=2/taraf",
"TV5 Monde" => "10041,rtmpe://fms1.mediadirect.ro:80/live3?id=10668839&publisher=2/tv5",
"Party TV" => "10164,rtmpe://fms1.mediadirect.ro:80/live3?id=10668839&publisher=2/party",
"Baby TV" => "0,rtmpe://fms1.mediadirect.ro:80/live3?id=10668839&publisher=2/babytv",
"Deutsche Welle" => "10131,rtmpe://fms1.mediadirect.ro:80/live3?id=10668839&publisher=2/dw",
"Dolce Sport HD" => "0,rtmpe://fms1.mediadirect.ro:80/live3?id=10668839&publisher=2/dolcesporthd",
"Mooz HD" => "0,rtmpe://fms1.mediadirect.ro:80/live3?id=10668839&publisher=2/moozhd",
"Mooz hits" => "0,rtmpe://fms1.mediadirect.ro:80/live3?id=10668839&publisher=2/moozhits",
"Mooz RO" => "0,rtmpe://fms1.mediadirect.ro:80/live3?id=10668839&publisher=2/moozro"
);

$videos = explode('<div class="station_program_cell', $html);
unset($videos[0]);
$videos = array_values($videos);
$n=0;
foreach($videos as $video) {
  $title=str_between($video,'class="post">','<');
  $acum=str_between($video,'class="acum">','<');
  $next=str_between($video,'class="next">','<');
  $image="http://www.dolcetv.ro/".str_between($video,'background-image:url(',')');
  $t=explode(",",$l[$title]);
  $link=$t[1];
  $link="http://127.0.0.1:83/cgi-bin/translate?stream,,".$link;
  $canal=$t[0];
  if ($link=="") {
  $title=$title." ***";
  }
  print '
  <item>
  <title>'.$title.'</title>
  <onClick>playItemURL("'.$link.'",10);</onClick>
  <image>'.$image.'</image>
  <canal>'.$canal.'</canal>
  </item>
  ';
}

?>
<!-- end Dolce TV -->
</channel>
</rss>
