<?php echo "<?xml version='1.0' encoding='UTF8' ?>";
$host = "http://127.0.0.1:82";
$img = "/scripts/clip/image/220.jpg";
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
	itemWidthPC="50"
	itemHeightPC="8"
	capXPC="8"
	capYPC="25"
	capWidthPC="50"
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
  	<text  redraw="yes" align="center" offsetXPC="0" offsetYPC="90" widthPC="100" heightPC="8" fontSize="17" backgroundColor="10:105:150" foregroundColor="100:200:255">
		  <script>print(annotation); annotation;</script>
		</text>
		<image  redraw="yes" offsetXPC=60 offsetYPC=35 widthPC=30 heightPC=30>
  <?php echo $img; ?>
		</image>
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
					  location = getItemInfo(idx, "location");
					  annotation = getItemInfo(idx, "title");
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
  setFocusItemIndex(idx);
	setItemFocus(0);
  redrawDisplay();
  "true";
}
ret;
</script>
</onUserInput>

	</mediaDisplay>
	<searchLink>
	  <link>
	    <script>"<?php echo $host; ?>/scripts/clip/php/220_search.php?query=1," + urlEncode(keyword) + "," + urlEncode(keyword);</script>
	  </link>
	</searchLink>
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
<title>220.ro</title>

<item>
<title>Search</title>
<onClick>
  keyword = getInput();
  if (keyword != null)
  {
    jumpToLink("searchLink");
  }
</onClick>
</item>


<item>
<title>200.ro - Shows</title>
<link><?php echo $host; ?>/scripts/clip/php/220_show_main.php</link>
</item>

<item>
<title>200.ro - selectii</title>
<link><?php echo $host; ?>/scripts/clip/php/220.php?query=,http://www.220.ro/,Selectii</link>
</item>

<item>
<title>200.ro - filmele zilei</title>
<link><?php echo $host; ?>/scripts/clip/php/220.php?query=,http://www.220.ro/filmele-zilei/,Filmele+zilei</link>
</item>

<item>
<title>200.ro - Cele mai recente</title>
<link><?php echo $host; ?>/scripts/clip/php/220.php?query=,http://www.220.ro/cele-mai-noi/,Cele+mai+recente</link>
</item>

<item>
<title>200.ro - Cele mai vizionate</title>
<link><?php echo $host; ?>/scripts/clip/php/220.php?query=,http://www.220.ro/cele-mai-vazute/,Cele+mai+vizionate</link>
</item>

<item>
<title>200.ro - Cele mai comentate</title>
<link><?php echo $host; ?>/scripts/clip/php/220.php?query=,http://www.220.ro/cele-mai-comentate/,Cele+mai+comentate</link>
</item>

<item>
<title>Toate filmele</title>
<link><?php echo $host; ?>/scripts/clip/php/220.php?query=,http://www.220.ro/video/,Toate+filmele</link>
</item>

<item>
<title>Animale</title>
<link><?php echo $host; ?>/scripts/clip/php/220.php?query=,http://www.220.ro/animale/,Animale</link>
</item>

<item>
<title>Auto, moto</title>
<link><?php echo $host; ?>/scripts/clip/php/220.php?query=,http://www.220.ro/auto/,Auto</link>
</item>

<item>
<title>Cinema, movie trailers</title>
<link><?php echo $host; ?>/scripts/clip/php/220.php?query=,http://www.220.ro/trailer/,Cinema</link>
</item>

<item>
<title>Comedie, Umor romanesc</title>
<link><?php echo $host; ?>/scripts/clip/php/220.php?query=,http://www.220.ro/umor-romanesc/,Comedie</link>
</item>

<item>
<title>Desene animate</title>
<link><?php echo $host; ?>/scripts/clip/php/220.php?query=,http://www.220.ro/desene-animate/,Desene+animate</link>
</item>

<item>
<title>Emisiuni TV</title>
<link><?php echo $host; ?>/scripts/clip/php/220.php?query=,http://www.220.ro/emisiuni-tv/,Emisiuni+TV</link>
</item>

<item>
<title>Farse</title>
<link><?php echo $host; ?>/scripts/clip/php/220.php?query=,http://www.220.ro/farse/,Farse</link>
</item>

<item>
<title>Faze tari</title>
<link><?php echo $host; ?>/scripts/clip/php/220.php?query=,http://www.220.ro/faze-tari/,Faze+tari</link>
</item>

<item>
<title>Funny</title>
<link><?php echo $host; ?>/scripts/clip/php/220.php?query=,http://www.220.ro/funny/,Funny</link>
</item>

<item>
<title>Interzis la birou</title>
<link><?php echo $host; ?>/scripts/clip/php/220.php?query=,http://www.220.ro/sexy/,Interzis+la+birou</link>
</item>

<item>
<title>Jocuri, Gameplay</title>
<link><?php echo $host; ?>/scripts/clip/php/220.php?query=,http://www.220.ro/gaming/,Jocuri</link>
</item>

<item>
<title>Muzica, Videoclipuri</title>
<link><?php echo $host; ?>/scripts/clip/php/220.php?query=,http://www.220.ro/videoclipuri/,Muzica</link>
</item>

<item>
<title>Prieteni, petreceri, clubbing</title>
<link><?php echo $host; ?>/scripts/clip/php/220.php?query=,http://www.220.ro/party/,Prieteni</link>
</item>

<item>
<title>Reclame</title>
<link><?php echo $host; ?>/scripts/clip/php/220.php?query=,http://www.220.ro/reclame/,Reclame</link>
</item>

<item>
<title>Sport</title>
<link><?php echo $host; ?>/scripts/clip/php/220.php?query=,http://www.220.ro/sport/,Sport</link>
</item>

<item>
<title>Vedete</title>
<link><?php echo $host; ?>/scripts/clip/php/220.php?query=,http://www.220.ro/vedete/,Vedete</link>
</item>


</channel>
</rss>
