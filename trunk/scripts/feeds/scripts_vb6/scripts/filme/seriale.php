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
        /scripts/filme/image/series.png
		</image>
		<idleImage idleImageWidthPC=10 idleImageHeightPC=10> image/POPUP_LOADING_01.png </idleImage>
		<idleImage idleImageWidthPC=10 idleImageHeightPC=10> image/POPUP_LOADING_02.png </idleImage>
		<idleImage idleImageWidthPC=10 idleImageHeightPC=10> image/POPUP_LOADING_03.png </idleImage>
		<idleImage idleImageWidthPC=10 idleImageHeightPC=10> image/POPUP_LOADING_04.png </idleImage>
		<idleImage idleImageWidthPC=10 idleImageHeightPC=10> image/POPUP_LOADING_05.png </idleImage>
		<idleImage idleImageWidthPC=10 idleImageHeightPC=10> image/POPUP_LOADING_06.png </idleImage>
		<idleImage idleImageWidthPC=10 idleImageHeightPC=10> image/POPUP_LOADING_07.png </idleImage>
		<idleImage idleImageWidthPC=10 idleImageHeightPC=10> image/POPUP_LOADING_08.png </idleImage>

		<itemDisplay>
			<text align="left" lines="1" offsetXPC=0 offsetYPC=0 widthPC=100 heightPC=100>
				<script>
					idx = getQueryItemIndex();
					focus = getFocusItemIndex();
					if(focus==idx) 
					{
					  location = getItemInfo(idx, "location");
					  annotation = getItemInfo(idx, "annotation");
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
	
	<item_template>
		<mediaDisplay  name="threePartsView" idleImageWidthPC="10" idleImageHeightPC="10">
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
	<title>Seriale TV</title>

<item>
<title>www.serialepe.net</title>
<link><?php echo $host; ?>/scripts/filme/php/serialepe_main.php</link>
<annotation>http://www.serialepe.net/p/seriale-online-gratis-subtitrate.html</annotation>
<mediaDisplay name="threePartsView"/>
</item>

<item>
<title>filmesubtitrate.info</title>
<link><?php echo $host; ?>/scripts/filme/php/filmesubtitrate_info_main.php</link>
<annotation>http://www.seriale.filmesubtitrate.info/p/seriale-online-subtitrate-in-romana.html</annotation>
<mediaDisplay name="photoView"/>
</item>

<item>
<title>serialeonline.tv</title>
<link><?php echo $host; ?>/scripts/filme/php/serialeonline_main.php</link>
<annotation>http://www.serialeonline.tv/</annotation>
<mediaDisplay name="threePartsView"/>
</item>

<item>
<title>www.veziserialeonline.info</title>
<link><?php echo $host; ?>/scripts/filme/php/veziserialeonline_main.php</link>
<annotation>http://www.veziserialeonline.info/tv-shows</annotation>
<mediaDisplay name="threePartsView"/>
</item>

<item>
<title>www.serialulmeu.ro</title>
<link><?php echo $host; ?>/scripts/filme/php/serialulmeu_main.php</link>
<annotation>http://www.serialulmeu.ro/</annotation>
<mediaDisplay name="threePartsView"/>
</item>

<item>
<title>seriale.subtitrate.info</title>
<link><?php echo $host; ?>/scripts/filme/php/seriale_subtitrate_info_l.php</link>
<annotation>http://seriale.subtitrate.info/tv-shows</annotation>
<mediaDisplay name="threePartsView"/>
</item>

<item>
<title>www.cinemaro.ro</title>
<link><?php echo $host; ?>/scripts/filme/php/cinemaro_main.php</link>
<annotation>http://www.cinemaro.ro</annotation>
<mediaDisplay name="threePartsView"/>
</item>

<item>
<title>www.seriale-filme.info</title>
<link><?php echo $host; ?>/scripts/filme/php/seriale-filme_info_main.php</link>
<annotation>http://www.seriale-filme.info/tv-shows</annotation>
<mediaDisplay name="threePartsView"/>
</item>

<item>
<title>www.990.ro</title>
<link><?php echo $host; ?>/scripts/filme/990.php</link>
<annotation>http://www.990.ro</annotation>
<mediaDisplay name="threePartsView"/>
</item>
<!--
<item>
<title>serialeonline.biz</title>
<link><?php echo $host; ?>/scripts/filme/php/serialeonline_biz.php?query=1,</link>
<annotation>http://serialeonline.biz/seriale-online</annotation>
<mediaDisplay name="threePartsView"/>
</item>
-->
<item>
<title>seriale.doi10.com</title>
<link><?php echo $host; ?>/scripts/filme/php/seriale_doi10_main.php</link>
<annotation>http://seriale.doi10.com/seriale</annotation>
<mediaDisplay name="threePartsView"/>
</item>

<item>
<title>www.serialetvonline.info</title>
<link><?php echo $host; ?>/scripts/filme/php/serialetvonline_info_main.php</link>
<annotation>http://www.serialetvonline.info/tv-shows</annotation>
<mediaDisplay name="threePartsView"/>
</item>

<item>
<title>www.starmaxmovie.com - seriale (fara subtitrare)</title>
<link><?php echo $host; ?>/scripts/filme/php/starmaxmovie_main.php</link>
<annotation>http://www.starmaxmovie.com</annotation>
<mediaDisplay name="threePartsView"/>
</item>
<!--
<item>
<title>tvcinema.info (fara subtitrare)</title>
<link><?php echo $host; ?>/scripts/filme/php/tvcinema_main.php</link>
<annotation>http://tvcinema.info/tv-shows</annotation>
<mediaDisplay name="threePartsView"/>
</item>

<item>
<title>10starmovies.com - (fara subtitrare)</title>
<link><?php echo $host; ?>/scripts/filme/php/10starmovies_main.php</link>
<annotation>http://10starmovies.com/Tv-Shows/</annotation>
<mediaDisplay name="threePartsView"/>
</item>
-->
</channel>
</rss>
