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
  /scripts/tv/image/onehd.png
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
      majorContext = getPageInfo("majorContext");
      
      print("*** majorContext=",majorContext);
      print("*** userInput=",userInput);
      
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
	<title>OneHD</title>
	<menu>main menu</menu>

<item>
<title>OneHD - Live! Concert</title>
<onClick>playItemURL("http://127.0.0.1:83/cgi-bin/translate?stream,Content-type:video/mp4,rtmp://93.114.43.3:1935/live/onehd", 10);</onClick>
<media:thumbnail url="/scripts/tv/image/onehd.png" />
</item>

<item>
<title>OneHD - Live! Jazz</title>
<onClick>playItemURL("http://127.0.0.1:83/cgi-bin/translate?stream,Content-type:video/mp4,rtmp://93.114.43.3:1935/live/jazz", 10);</onClick>
</item>

<item>
<title>OneHD - Live! Classics</title>
<onClick>playItemURL("http://127.0.0.1:83/cgi-bin/translate?stream,Content-type:video/mp4,rtmp://93.114.43.3:1935/live/classics", 10);</onClick>
<media:thumbnail url="/scripts/tv/image/onehd.png" />
</item>

<item>
<title>OneHD - Live! Dance</title>
<onClick>playItemURL("http://127.0.0.1:83/cgi-bin/translate?stream,Content-type:video/mp4,rtmp://93.114.43.3:1935/live/dance", 10);</onClick>
<media:thumbnail url="/scripts/tv/image/onehd.png" />
</item>

<item>
<title>OneHD - Live! Rock</title>
<onClick>playItemURL("http://127.0.0.1:83/cgi-bin/translate?stream,Content-type:video/mp4,rtmp://93.114.43.3:1935/live/rock", 10);</onClick>
<media:thumbnail url="/scripts/tv/image/onehd.png" />
</item>

<item>
<title>OneHD - Live! Pop</title>
<onClick>playItemURL("http://127.0.0.1:83/cgi-bin/translate?stream,Content-type:video/mp4,rtmp://93.114.43.3:1935/live/pop", 10);</onClick>
<media:thumbnail url="/scripts/tv/image/onehd.png" />
</item>

<item>
<title>Divertisment</title>
<link><?php echo $host; ?>/scripts/tv/php/prahova.php?cat=Divertisment</link>
<media:thumbnail url="/scripts/tv/image/onehd.png" />
</item>

<item>
<title>Documentare</title>
<link><?php echo $host; ?>/scripts/tv/php/prahova.php?cat=Documentare</link>
<media:thumbnail url="/scripts/tv/image/onehd.png" />
</item>

<item>
<title>Emisiuni</title>
<link><?php echo $host; ?>/scripts/tv/php/prahova.php?cat=Emisiuni</link>
<media:thumbnail url="/scripts/tv/image/onehd.png" />
</item>

<item>
<title>Business</title>
<link><?php echo $host; ?>/scripts/tv/php/prahova.php?cat=Business</link>
<media:thumbnail url="/scripts/tv/image/onehd.png" />
</item>

</channel>
</rss>