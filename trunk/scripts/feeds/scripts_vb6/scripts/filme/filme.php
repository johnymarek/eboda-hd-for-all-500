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
		/scripts/image/movies.png
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
	<title>Filme Online</title>

<item>
<title>www.onlinemoca.com</title>
<link><?php echo $host; ?>/scripts/filme/php/onlinemoca_main.php</link>
<annotation>http://www.onlinemoca.com/</annotation>
<mediaDisplay name="threePartsView"/>
</item>

<item>
<title>cinemaxx.ro</title>
<link><?php echo $host; ?>/scripts/filme/php/cinemaxx_main.php</link>
<annotation>http://cinemaxx.ro/</annotation>
<mediaDisplay name="threePartsView"/>
</item>

<item>
<title>www.filmeonlinegratis.ro</title>
<link><?php echo $host; ?>/scripts/filme/php/filmeonlinegratis_main.php</link>
<annotation>http://www.filmeonlinegratis.ro</annotation>
<mediaDisplay name="threePartsView"/>
</item>

<item>
<title>filmehd.net</title>
<link><?php echo $host; ?>/scripts/filme/php/filmehd_main.php</link>
<annotation>http://filmehd.net/</annotation>
<mediaDisplay name="threePartsView"/>
</item>

<item>
<title>peteava.ro</title>
<link><?php echo $host; ?>/scripts/filme/peteava.php</link>
<annotation>http://www.peteava.ro/</annotation>
<mediaDisplay name="threePartsView"/>
</item>

<item>
<title>filmeonlinenoi.com</title>
<link><?php echo $host; ?>/scripts/filme/php/filmeonlinenoi_main.php</link>
<annotation>http://filmeonlinenoi.com/</annotation>
<mediaDisplay name="threePartsView"/>
</item>

<item>
<title>www.filmelive.net</title>
<link><?php echo $host; ?>/scripts/filme/php/filmelive_main.php</link>
<annotation>http://www.filmelive.net</annotation>
<mediaDisplay name="threePartsView"/>
</item>

<item>
<title>www.filmeonlinesubtitrate.ro</title>
<link><?php echo $host; ?>/scripts/filme/php/filmeonlinesubtitrate_main.php</link>
<annotation>http://www.filmeonlinesubtitrate.ro</annotation>
<mediaDisplay name="threePartsView"/>
</item>

<item>
<title>onlythefilm.com</title>
<link><?php echo $host; ?>/scripts/filme/php/onlythefilm.php</link>
<annotation>http://www.onlythefilm.com</annotation>
<mediaDisplay name="threePartsView"/>
</item>

<item>
<title>divxonline.biz</title>
<link><?php echo $host; ?>/scripts/filme/php/divxonline_main.php</link>
<annotation>http://divxonline.biz</annotation>
<mediaDisplay name="threePartsView"/>
</item>

<item>
<title>www.filme-online.ucoz.com</title>
<link><?php echo $host; ?>/scripts/filme/php/ucoz_main.php</link>
<annotation>http://www.filme-online.ucoz.com/</annotation>
<mediaDisplay name="threePartsView"/>
</item>

<item>
<title>Filme Romanesti - filmele-copilariei.blogspot.com</title>
<link><?php echo $host; ?>/scripts/filme/php/filmele-copilariei_main.php</link>
<annotation>http://filmele-copilariei.blogspot.com/</annotation>
<mediaDisplay name="threePartsView"/>
</item>

<item>
<title>Filme Romanesti - blip.tv</title>
<link>http://filmeromanesti.blip.tv/rss</link>
<annotation>http://filmeromanesti.blip.tv/rss</annotation>
<mediaDisplay name="threePartsView" 
	itemBackgroundColor="0:0:0" 
	backgroundColor="0:0:0" 
	sideLeftWidthPC="0" 
	itemImageXPC="5" 
	itemXPC="20" 
	itemYPC="20" 
	itemWidthPC="65" 
	capWidthPC="70" 
	unFocusFontColor="101:101:101" 
	focusFontColor="255:255:255" 
	idleImageWidthPC="10" 
	idleImageHeightPC="10">
        <idleImage>image/POPUP_LOADING_01.png</idleImage>
        <idleImage>image/POPUP_LOADING_02.png</idleImage>
        <idleImage>image/POPUP_LOADING_03.png</idleImage>
        <idleImage>image/POPUP_LOADING_04.png</idleImage>
        <idleImage>image/POPUP_LOADING_05.png</idleImage>
        <idleImage>image/POPUP_LOADING_06.png</idleImage>
        <idleImage>image/POPUP_LOADING_07.png</idleImage>
        <idleImage>image/POPUP_LOADING_08.png</idleImage>
		<backgroundDisplay>
			<image  offsetXPC=0 offsetYPC=0 widthPC=100 heightPC=100>
			image/mele/backgd.jpg
			</image>  
		</backgroundDisplay>
		<image  offsetXPC=0 offsetYPC=2.8 widthPC=100 heightPC=15.6>
		image/mele/rss_title.jpg
		</image>
		<text  offsetXPC=40 offsetYPC=8 widthPC=35 heightPC=10 fontSize=20 backgroundColor=-1:-1:-1 foregroundColor=255:255:255>
		Filme Romanesti - blip.tv
		</text>			
</mediaDisplay>
</item>

<item>
<title>vezifilme.ro</title>
<link><?php echo $host; ?>/scripts/filme/php/vezifilme_main.php</link>
<annotation>http://www.vezifilme.ro/</annotation>
<mediaDisplay name="threePartsView"/>
</item>

<item>
<title>www.filmeonline24.com</title>
<link><?php echo $host; ?>/scripts/filme/php/filmeonline24_main.php</link>
<annotation>http://www.filmeonline24.com/</annotation>
<mediaDisplay name="threePartsView"/>
</item>

<item>
<title>www.crutu-razvan.ro</title>
<link><?php echo $host; ?>/scripts/filme/php/crutu-razvan.php?query=1,</link>
<annotation>http://www.crutu-razvan.ro</annotation>
<mediaDisplay name="threePartsView"/>
</item>

<item>
<title>documentare.org - filme si seriale documentare</title>
<link><?php echo $host; ?>/scripts/filme/php/documentare_main.php</link>
<annotation>http://documentare.org</annotation>
<mediaDisplay name="threePartsView"/>
</item>

</channel>
</rss>
