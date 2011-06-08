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
	idleImageWidthPC="8" idleImageHeightPC="10"
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
		<mediaDisplay  name="threePartsView" idleImageWidthPC="8" idleImageHeightPC="10">
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
	<title>MediaDirect</title>
	<menu>main menu</menu>
<!-- http://www.mediadirect.ro/tv/ -->

    <item>
	<title>Antena1</title>
	<onClick>playItemURL("http://127.0.0.1:82/scripts/util/mediadirect.cgi?rtmpe://fms8.mediadirect.ro:1935/live3?id=6189013/antena1", 10);</onClick>
	<annotation>Antena1</annotation>
	</item>
	
	<item>
	<title>Antena2</title>
	<onClick>playItemURL("http://127.0.0.1:82/scripts/util/mediadirect.cgi?rtmpe://fms8.mediadirect.ro:1935/live3?id=6189013/antena2", 10);</onClick>
	<annotation>Antena2</annotation>
	</item>
	
	<item>
	<title>Antena3</title>
	<onClick>playItemURL("http://127.0.0.1:82/scripts/util/mediadirect.cgi?rtmpe://fms8.mediadirect.ro:1935/live3?id=6189013/antena_3", 10);</onClick>
	<annotation>Antena3</annotation>
	</item>

	<item>
	<title>Money Channel</title>
	<onClick>playItemURL("http://127.0.0.1:82/scripts/util/mediadirect.cgi?rtmpe://fms8.mediadirect.ro:1935/live3?id=6189013/money", 10);</onClick>
	<annotation>Money Channel</annotation>
	</item>

	<item>
	<title>Realitatea</title>
	<onClick>playItemURL("http://127.0.0.1:82/scripts/util/mediadirect.cgi?rtmpe://fms8.mediadirect.ro:1935/live3?id=6189013/realitatea", 10);</onClick>
	<annotation>Realitatea TV</annotation>
	</item>
	
	<item>
	<title>B1</title>
	<onClick>playItemURL("http://127.0.0.1:82/scripts/util/mediadirect.cgi?rtmpe://fms8.mediadirect.ro:1935/live3?id=6189013/b1", 10);</onClick>
	<annotation>B1 TV</annotation>
	</item>
	
	<item>
	<title>Somes</title>
	<onClick>playItemURL("http://127.0.0.1:82/scripts/util/mediadirect.cgi?rtmpe://fms8.mediadirect.ro:1935/live3?id=6189013/somes", 10);</onClick>
	<annotation>Somes</annotation>
	</item>
	
	<item>
	<title>TVR International</title>
	<onClick>playItemURL("http://127.0.0.1:82/scripts/util/mediadirect.cgi?rtmpe://fms8.mediadirect.ro:1935/live3?id=6189013/tvr", 10);</onClick>
	<annotation>TVR International</annotation>
	</item>
	
	<item>
	<title>TVR 1</title>
	<onClick>playItemURL("http://127.0.0.1:82/scripts/util/mediadirect.cgi?rtmpe://fms8.mediadirect.ro:1935/live3?id=6189013/tvr1", 10);</onClick>
	<annotation>TVR 1</annotation>
	</item>
	
	<item>
	<title>TVR 2</title>
	<onClick>playItemURL("http://127.0.0.1:82/scripts/util/mediadirect.cgi?rtmpe://fms8.mediadirect.ro:1935/live3?id=6189013/tvr2", 10);</onClick>
	<annotation>TVR 2</annotation>
	</item>
	
	<item>
	<title>TVR 3</title>
	<onClick>playItemURL("http://127.0.0.1:82/scripts/util/mediadirect.cgi?rtmpe://fms8.mediadirect.ro:1935/live3?id=6189013/tvr3", 10);</onClick>
	<annotation>TVR 3</annotation>
	</item>
	
	<item>
	<title>TVR Cultural</title>
	<onClick>playItemURL("http://127.0.0.1:82/scripts/util/mediadirect.cgi?rtmpe://fms8.mediadirect.ro:1935/live3?id=6189013/tvrcultural", 10);</onClick>
	<annotation>TVR Cultural</annotation>
	</item>
	
	<item>
	<title>TVR HD</title>
	<onClick>playItemURL("http://127.0.0.1:82/scripts/util/mediadirect.cgi?rtmpe://fms8.mediadirect.ro:1935/live3?id=6189013/tvrhd", 10);</onClick>
	<annotation>TVR HD</annotation>
	</item>
	
	<item>
	<title>TVR Info</title>
	<onClick>playItemURL("http://127.0.0.1:82/scripts/util/mediadirect.cgi?rtmpe://fms8.mediadirect.ro:1935/live3?id=6189013/tvrinfo", 10);</onClick>
	<annotation>TVR Info</annotation>
	</item>
	
	<item>
	<title>UTV</title>
	<onClick>playItemURL("http://127.0.0.1:82/scripts/util/mediadirect.cgi?rtmpe://fms8.mediadirect.ro:1935/live3?id=6189013/utv", 10);</onClick>
	<annotation>UTV</annotation>
	</item>
	
	<item>
	<title>Euronews</title>
	<onClick>playItemURL("http://127.0.0.1:82/scripts/util/mediadirect.cgi?rtmpe://fms8.mediadirect.ro:1935/live3?id=6189013/euronews", 10);</onClick>
	<annotation>Euronews</annotation>
	</item>
	
	<item>
	<title>DolceSport</title>
	<onClick>playItemURL("http://127.0.0.1:82/scripts/util/mediadirect.cgi?rtmpe://fms8.mediadirect.ro:1935/live3?id=6189013/dolcesport", 10);</onClick>
	<annotation>DolceSport</annotation>
	</item>
	
	<item>
	<title>DolceSport 2</title>
	<onClick>playItemURL("http://127.0.0.1:82/scripts/util/mediadirect.cgi?rtmpe://fms8.mediadirect.ro:1935/live3?id=6189013/dolcesport2", 10);</onClick>
	<annotation>DolceSport 2</annotation>
	</item>
	
	<item>
	<title>Mynele</title>
	<onClick>playItemURL("http://127.0.0.1:82/scripts/util/mediadirect.cgi?rtmpe://fms8.mediadirect.ro:1935/live3?id=6189013/mynele", 10);</onClick>
	<annotation>Mynele TV</annotation>
	</item>
	
	<item>
	<title>Party</title>
	<onClick>playItemURL("http://127.0.0.1:82/scripts/util/mediadirect.cgi?rtmpe://fms8.mediadirect.ro:1935/live3?id=6189013/party", 10);</onClick>
	<annotation>Party TV</annotation>
	</item>
	
	<item>
	<title>Etno</title>
	<onClick>playItemURL("http://127.0.0.1:82/scripts/util/mediadirect.cgi?rtmpe://fms8.mediadirect.ro:1935/live3?id=6189013/etno", 10);</onClick>
	<annotation>Etno</annotation>
	</item>


<!--  Preluate de site-ul postului
	<item>
	<title>B1</title>
	<onClick>playItemURL("http://127.0.0.1:82/scripts/util/mediadirect.cgi?rtmpe://fms8.mediadirect.ro:80/live/b1?id=10668839/b1", 10);</onClick>
	<annotation>B1 TV</annotation>
	</item>

	<item>
	<title>Antena3</title>
	<onClick>playItemURL("http://127.0.0.1:82/scripts/util/mediadirect.cgi?rtmpe://fms8.mediadirect.ro:1935/live2/antena3?id=10668839/antena_3", 10);</onClick>
	<annotation>Antena3</annotation>
	</item>

	<item>
	<title>Money Channel</title>
	<onClick>playItemURL("http://127.0.0.1:82/scripts/util/mediadirect.cgi?rtmpe://fms8.mediadirect.ro:80/live/money?id=10668839/money", 10);</onClick>
	<annotation>Money Channel</annotation>
	</item>

	<item>
	<title>Realitatea</title>
	<onClick>playItemURL("http://127.0.0.1:82/scripts/util/mediadirect.cgi?rtmpe://fms8.mediadirect.ro:80/live2/realitatea?id=10668839/realitatea", 10);</onClick>
	<annotation>Realitatea TV</annotation>
	</item>

	<item>
	<title>TVR International</title>
	<onClick>playItemURL("http://127.0.0.1:82/scripts/util/mediadirect.cgi?rtmpe://fms8.mediadirect.ro:80/live/tvr?id=10668839/tvr", 10);</onClick>
	<annotation>TVR International</annotation>
	</item>

	<item>
	<title>TVR Info</title>
	<onClick>playItemURL("http://127.0.0.1:82/scripts/util/mediadirect.cgi?rtmpe://fms8.mediadirect.ro:1935/live/tvrinfo?id=10668839/tvrinfo", 10);</onClick>
	<annotation>TVR Info</annotation>
	</item>

-->
</channel>
</rss>
