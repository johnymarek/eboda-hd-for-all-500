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
	idleImageXPC="5" idleImageYPC="5" idleImageWidthPC="8" idleImageHeightPC="10"
>

  	<text align="center" offsetXPC="0" offsetYPC="0" widthPC="100" heightPC="20" fontSize="30" backgroundColor="10:105:150" foregroundColor="100:200:255">
		  <script>getPageInfo("pageTitle");</script>
		</text>

  	<text redraw="yes" offsetXPC="85" offsetYPC="12" widthPC="10" heightPC="6" fontSize="20" backgroundColor="10:105:150" foregroundColor="60:160:205">
		  <script>sprintf("%s / ", focus-(-1))+itemCount;</script>
		</text>
		<image  redraw="yes" offsetXPC=60 offsetYPC=35 widthPC=30 heightPC=30>
  image/tv_radio.png
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
  <title>TV Live Romania</title>

   <item>
    <title>Showtime International</title>
    <onClick>playItemUrl("http://127.0.0.1/cgi-bin/translate?stream,,http://86.104.190.92:10/",10);</onClick>
  </item>
  
   <item>
    <title>Antena 2</title>
    <onClick>playItemUrl("http://127.0.0.1:83/cgi-bin/translate?stream,,mms://86.55.8.134/ant2",10);</onClick>
  </item>

   <item>
    <title>Tele M</title>
    <onClick>playItemUrl("http://127.0.0.1:83/cgi-bin/translate?stream,,http://telem.telem.ro:8780/telem_live.flv",10);</onClick>
  </item>

   <item>
    <title>Prahova TV</title>
    <onClick>playItemUrl("http://127.0.0.1:83/cgi-bin/translate?stream,,http://89.45.181.51:5000/test.flv",10);</onClick>
  </item>

   <item>
    <title>Publika TV</title>
    <onClick>playItemUrl("http://127.0.0.1:83/cgi-bin/translate?stream,,mmsh://77.36.61.36:8081/Publika%20TV",10);</onClick>
  </item>

   <item>
    <title>Jurnal TV - Rep. Moldova</title>
    <onClick>playItemUrl("http://127.0.0.1:83/cgi-bin/translate?stream,,http://ch0.jurnaltv.md/channel0.flv",10);</onClick>
  </item>

   <item>
    <title>Light Channel</title>
    <onClick>playItemUrl("http://127.0.0.1:83/cgi-bin/translate?stream,,rtmp://streamer1.adventhost.de/salive/romanian",10);</onClick>
  </item>

   <item>
    <title>MegaTV - Braila</title>
    <onClick>playItemUrl("http://127.0.0.1:83/cgi-bin/translate?stream,,http://89.36.72.7:8080/",10);</onClick>
  </item>

   <item>
    <title>Muscel TV</title>
    <onClick>playItemUrl("http://127.0.0.1:83/cgi-bin/translate?stream,,http://musceltvlive.muscel.ro:8080/",10);</onClick>
  </item>

   <item>
    <title>NCN - Cluj</title>
    <onClick>playItemUrl("http://127.0.0.1:83/cgi-bin/translate?stream,,http://ncn.simpliq.net:8090/ncn.flv",10);</onClick>
  </item>

   <item>
    <title>TV PLUS Suceava</title>
    <onClick>playItemUrl("http://127.0.0.1:83/cgi-bin/translate?stream,,http://85.186.146.34:8080",10);</onClick>
  </item>

   <item>
    <title>ACCES TV Targiu Jiu</title>
    <onClick>playItemUrl("http://127.0.0.1:83/cgi-bin/translate?stream,,http://82.77.72.47:8050/live.flv",10);</onClick>
  </item>

   <item>
    <title>TV eMARAMURES</title>
    <onClick>playItemUrl("http://127.0.0.1:83/cgi-bin/translate?stream,,http://195.28.2.42:8083/stream.flv",10);</onClick>
  </item>

   <item>
    <title>TTM - Televiziunea Tirgu Mures</title>
    <onClick>playItemUrl("http://127.0.0.1:83/cgi-bin/translate?stream,,http://89.121.214.123:8080/stream.flv",10);</onClick>
  </item>

   <item>
    <title>RTV Online - Televiziunea pentru toti gorjenii!</title>
    <onClick>playItemUrl("http://127.0.0.1:83/cgi-bin/translate?stream,,http://www.rtvonline.ro:8080/online.flv",10);</onClick>
  </item>

   <item>
    <title>Speranta Tv</title>
    <onClick>playItemUrl("http://127.0.0.1:83/cgi-bin/translate?stream,,rtmp://robuc140.crestin.tv:80/live/sperantatv_500",10);</onClick>
  </item>

</channel>
</rss>
