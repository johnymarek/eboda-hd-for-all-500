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
		<image  redraw="yes" offsetXPC=60 offsetYPC=35 widthPC=30 heightPC=30>
  image/tv_radio.png
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
	<title>TV ESTERE</title>
	<menu>main menu</menu>


	<item>
	<title>ARD</title>
	<onClick>playItemURL("http://127.0.0.1:82/scripts/util/swiss.cgi?http://gartenhoflive2-f.akamaihd.net/ard_1_800@45494", 10);</onClick>
	<annotation>ARD</annotation>
	</item>

	<item>
	<title>ZDF</title>
	<onClick>playItemURL("http://127.0.0.1:82/scripts/util/swiss.cgi?http://gartenhoflive4-f.akamaihd.net/zdf_1_800@45509", 10);</onClick>
	<annotation>ZDF</annotation>
	</item>

	<item>
	<title>ZDF NEO</title>
	<onClick>playItemURL("http://127.0.0.1:82/scripts/util/swiss.cgi?http://gartenhoflive2-f.akamaihd.net/zdfneo_1_800@44504", 10);</onClick>
	<annotation>ZDFNEO</annotation>
	</item>

	<item>
	<title>SF 1</title>
	<onClick>playItemURL("http://127.0.0.1:82/scripts/util/swiss.cgi?http://gartenhof.live1-f.akamaihd.net/sf1_1_800@43046", 10);</onClick>
	<annotation>SF1</annotation>
	</item>

	<item>
	<title>SF 2</title>
	<onClick>playItemURL("http://127.0.0.1:82/scripts/util/swiss.cgi?http://gartenhof.live1-f.akamaihd.net/sf2_1_800@43048", 10);</onClick>
	<annotation>SF2</annotation>
	</item>

	<item>
	<title>SF INFO</title>
	<onClick>playItemURL("http://127.0.0.1:82/scripts/util/swiss.cgi?http://gartenhoflive4-f.akamaihd.net/sfinfo_1_800@45505", 10);</onClick>
	<annotation>SFINFO</annotation>
	</item>

	<item>
	<title>ORF 1</title>
	<onClick>playItemURL("http://127.0.0.1:82/scripts/util/swiss.cgi?http://gartenhof.live1-f.akamaihd.net/orf1_1_800@43059", 10);</onClick>
	<annotation>ORF1</annotation>
	</item>

	<item>
	<title>ORF 2</title>
	<onClick>playItemURL("http://127.0.0.1:82/scripts/util/swiss.cgi?http://gartenhoflive3-f.akamaihd.net/orf2_1_800@45502", 10);</onClick>
	<annotation>ORF2</annotation>
	</item>

	<item>
	<title>3 SAT</title>
	<onClick>playItemURL("http://127.0.0.1:82/scripts/util/swiss.cgi?http://gartenhoflive2-f.akamaihd.net/3sat_1_800@45493", 10);</onClick>
	<annotation>3SAT</annotation>
	</item>

	<item>
	<title>ARTE</title>
	<onClick>playItemURL("http://127.0.0.1:82/scripts/util/swiss.cgi?http://gartenhoflive3-f.akamaihd.net/arte_1_800@45495", 10);</onClick>
	<annotation>ARTE</annotation>
	</item>

	<item>
	<title>ARTE francais</title>
	<onClick>playItemURL("http://127.0.0.1:82/scripts/util/swiss.cgi?http://gartenhoflive5-f.akamaihd.net/arte_fr_1_800@45512", 10);</onClick>
	<annotation>ARTE</annotation>
	</item>

	<item>
	<title>KIKA</title>
	<onClick>playItemURL("http://127.0.0.1:82/scripts/util/swiss.cgi?http://gartenhoflive3-f.akamaihd.net/kika_1_800@45500", 10);</onClick>
	<annotation>KIKA</annotation>
	</item>

	<item>
	<title>PRO 7</title>
	<onClick>playItemURL("http://127.0.0.1:82/scripts/util/swiss.cgi?http://gartenhof.live1-f.akamaihd.net/pro7_1_800@43051", 10);</onClick>
	<annotation>PRO7</annotation>
	</item>

	<item>
	<title>RTL</title>
	<onClick>playItemURL("http://127.0.0.1:82/scripts/util/swiss.cgi?http://gartenhof.live1-f.akamaihd.net/rtl_1_800@43050", 10);</onClick>
	<annotation>RTL</annotation>
	</item>

	<item>
	<title>RTL 2</title>
	<onClick>playItemURL("http://127.0.0.1:82/scripts/util/swiss.cgi?http://gartenhof.live1-f.akamaihd.net/rtl2_1_800@43053", 10);</onClick>
	<annotation>RTL2</annotation>
	</item>

	<item>
	<title>RTL 9</title>
	<onClick>playItemURL("http://127.0.0.1:82/scripts/util/swiss.cgi?http://gartenhoflive4-f.akamaihd.net/rtl9_1_800@45503", 10);</onClick>
	<annotation>RTL9</annotation>
	</item>

	<item>
	<title>SUPER RTL</title>
	<onClick>playItemURL("http://127.0.0.1:82/scripts/util/swiss.cgi?http://gartenhoflive2-f.akamaihd.net/superrtl_1_800@44489", 10);</onClick>
	<annotation>SUPERRTL</annotation>
	</item>

	<item>
	<title>SAT 1</title>
	<onClick>playItemURL("http://127.0.0.1:82/scripts/util/swiss.cgi?http://gartenhoflive2-f.akamaihd.net/sat1_1_800@44490", 10);</onClick>
	<annotation>SAT1</annotation>
	</item>

	<item>
	<title>VOX</title>
	<onClick>playItemURL("http://127.0.0.1:82/scripts/util/swiss.cgi?http://gartenhof.live1-f.akamaihd.net/vox_1_800@43052", 10);</onClick>
	<annotation>VOX</annotation>
	</item>

	<item>
	<title>KABEL 1</title>
	<onClick>playItemURL("http://127.0.0.1:82/scripts/util/swiss.cgi?http://gartenhof.live1-f.akamaihd.net/kabel1_1_800@43055", 10);</onClick>
	<annotation>KABEL1</annotation>
	</item>

	<item>
	<title>DAS VIERTE</title>
	<onClick>playItemURL("http://127.0.0.1:82/scripts/util/swiss.cgi?http://gartenhoflive4-f.akamaihd.net/dasvierte_1_800@45510", 10);</onClick>
	<annotation>DASVIERTE</annotation>
	</item>

	<item>
	<title>SIXX</title>
	<onClick>playItemURL("http://127.0.0.1:82/scripts/util/swiss.cgi?http://gartenhoflive5-f.akamaihd.net/sixx_1_800@45516", 10);</onClick>
	<annotation>SIXX</annotation>
	</item>

	<item>
	<title>DMAX</title>
	<onClick>playItemURL("http://127.0.0.1:82/scripts/util/swiss.cgi?http://gartenhoflive3-f.akamaihd.net/dmax_1_800@45498", 10);</onClick>
	<annotation>DMAX</annotation>
	</item>

	<item>
	<title>NTV</title>
	<onClick>playItemURL("http://127.0.0.1:82/scripts/util/swiss.cgi?http://gartenhoflive6-f.akamaihd.net/ntv_1_800@45520", 10);</onClick>
	<annotation>NTV</annotation>
	</item>

	<item>
	<title>NICK / Comedy Central</title>
	<onClick>playItemURL("http://127.0.0.1:82/scripts/util/swiss.cgi?http://gartenhoflive5-f.akamaihd.net/nick_cc_1_800@45519", 10);</onClick>
	<annotation>NICK</annotation>
	</item>

	<item>
	<title>NICK / VIVA</title>
	<onClick>playItemURL("http://127.0.0.1:82/scripts/util/swiss.cgi?http://gartenhoflive4-f.akamaihd.net/nick_viva_1_800@45507", 10);</onClick>
	<annotation>NICK</annotation>
	</item>

	<item>
	<title>SPORT 1</title>
	<onClick>playItemURL("http://127.0.0.1:82/scripts/util/swiss.cgi?http://gartenhoflive5-f.akamaihd.net/sport1_1_800@45517", 10);</onClick>
	<annotation>SPORT1</annotation>
	</item>

	<item>
	<title>STAR TV</title>
	<onClick>playItemURL("http://127.0.0.1:82/scripts/util/swiss.cgi?http://gartenhoflive6-f.akamaihd.net/startv_1_800@45526", 10);</onClick>
	<annotation>STARTV</annotation>
	</item>

	<item>
	<title>TELE ZUERI</title>
	<onClick>playItemURL("http://127.0.0.1:82/scripts/util/swiss.cgi?http://gartenhoflive2-f.akamaihd.net/telezueri_1_800@44503", 10);</onClick>
	<annotation>TELEZUERI</annotation>
	</item>

	<item>
	<title>EUROSPORT</title>
	<onClick>playItemURL("http://127.0.0.1:82/scripts/util/swiss.cgi?http://gartenhoflive5-f.akamaihd.net/eurosport_1_800@45515", 10);</onClick>
	<annotation>EUROSPORT</annotation>
	</item>

	<item>
	<title>FRANCE 2</title>
	<onClick>playItemURL("http://127.0.0.1:82/scripts/util/swiss.cgi?http://gartenhoflive3-f.akamaihd.net/france2_1_800@45496", 10);</onClick>
	<annotation>FRANCE2</annotation>
	</item>

	<item>
	<title>FRANCE 3</title>
	<onClick>playItemURL("http://127.0.0.1:82/scripts/util/swiss.cgi?http://gartenhoflive3-f.akamaihd.net/france3_1_800@45499", 10);</onClick>
	<annotation>FRANCE3</annotation>
	</item>

	<item>
	<title>FRANCE 5</title>
	<onClick>playItemURL("http://127.0.0.1:82/scripts/util/swiss.cgi?http://gartenhoflive3-f.akamaihd.net/france5_1_800@45501", 10);</onClick>
	<annotation>FRANCE5</annotation>
	</item>

	<item>
	<title>TSR 1</title>
	<onClick>playItemURL("http://127.0.0.1:82/scripts/util/swiss.cgi?http://gartenhoflive6-f.akamaihd.net/tsr1_1_800@45522", 10);</onClick>
	<annotation>TSR1</annotation>
	</item>

	<item>
	<title>TSR 2</title>
	<onClick>playItemURL("http://127.0.0.1:82/scripts/util/swiss.cgi?http://gartenhoflive6-f.akamaihd.net/tsr2_1_800@45523", 10);</onClick>
	<annotation>TSR2</annotation>
	</item>

	<item>
	<title>TV5 MONDE</title>
	<onClick>playItemURL("http://127.0.0.1:82/scripts/util/swiss.cgi?http://gartenhoflive5-f.akamaihd.net/tv5monde_1_800@45511", 10);</onClick>
	<annotation>TV5MONDE</annotation>
	</item>

	<item>
	<title>TF1</title>
	<onClick>playItemURL("http://127.0.0.1:82/scripts/util/swiss.cgi?http://gartenhoflive4-f.akamaihd.net/tf1_1_800@45504", 10);</onClick>
	<annotation>TF1</annotation>
	</item>

	<item>
	<title>M6</title>
	<onClick>playItemURL("http://127.0.0.1:82/scripts/util/swiss.cgi?http://gartenhoflive4-f.akamaihd.net/m6_1_800@45506", 10);</onClick>
	<annotation>M6</annotation>
	</item>

	<item>
	<title>RSI LA 1</title>
	<onClick>playItemURL("http://127.0.0.1:82/scripts/util/swiss.cgi?http://gartenhoflive5-f.akamaihd.net/rsila1_1_800@45513", 10);</onClick>
	<annotation>RSILA1</annotation>
	</item>

	<item>
	<title>RSI LA 2</title>
	<onClick>playItemURL("http://127.0.0.1:82/scripts/util/swiss.cgi?http://gartenhoflive5-f.akamaihd.net/rsila2_1_800@45514", 10);</onClick>
	<annotation>RSILA2</annotation>
	</item>

	<item>
	<title>RAI 1</title>
	<onClick>playItemURL("http://127.0.0.1:82/scripts/util/swiss.cgi?http://gartenhoflive2-f.akamaihd.net/rai1_1_800@44470", 10);</onClick>
	<annotation>RAI1</annotation>
	</item>

	<item>
	<title>EURONEWS</title>
	<onClick>playItemURL("http://127.0.0.1:82/scripts/util/swiss.cgi?http://gartenhoflive6-f.akamaihd.net/euronews_1_800@45525", 10);</onClick>
	<annotation>EURONEWS</annotation>
	</item>

	<item>
	<title>BBC WORLD</title>
	<onClick>playItemURL("http://127.0.0.1:82/scripts/util/swiss.cgi?http://gartenhoflive4-f.akamaihd.net/bbcworld_1_800@45508", 10);</onClick>
	<annotation>BBCWORLD</annotation>
	</item>

	<item>
	<title>CNN</title>
	<onClick>playItemURL("http://127.0.0.1:82/scripts/util/swiss.cgi?http://gartenhoflive3-f.akamaihd.net/cnn_1_800@45497", 10);</onClick>
	<annotation>CNN</annotation>
	</item>

	<item>
	<title>RUSSIA TODAY</title>
	<onClick>playItemURL("http://127.0.0.1:82/scripts/util/swiss.cgi?http://gartenhoflive6-f.akamaihd.net/rusiya_1_800@45521", 10);</onClick>
	<annotation>RUSIYA</annotation>
	</item>

</channel>
</rss>
