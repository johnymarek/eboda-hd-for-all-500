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
	<title>Seeon TV</title>
	<menu>main menu</menu>


	<item>
	<title>Fox Soccer Channel</title>
	<onClick>playItemURL("http://127.0.0.1:82/scripts/util/seeon.cgi?rtmp://live4.seeon.tv/edge/rltmx3oeb3t9d0c", 10);</onClick>
	<annotation>http://www.seeon.tv</annotation>
	</item>

	<item>
	<title>Gol TV</title>
	<onClick>playItemURL("http://127.0.0.1:82/scripts/util/seeon.cgi?rtmp://live6.seeon.tv/edge/k1c73soqsm3ok74", 10);</onClick>
	<annotation>http://www.seeon.tv</annotation>
	</item>
	
	<item>
	<title>SportZone</title>
	<onClick>playItemURL("http://127.0.0.1:82/scripts/util/seeon.cgi?rtmp://live8.seeon.tv/edge/ozfqf0q6hn0c2dh", 10);</onClick>
	<annotation>http://www.seeon.tv</annotation>
	</item>

	<item>
	<title>ESPN</title>
	<onClick>playItemURL("http://127.0.0.1:82/scripts/util/seeon.cgi?rtmp://live4.seeon.tv/edge/bzhw62kbfg0lsqe", 10);</onClick>
	<annotation>http://www.seeon.tv</annotation>
	</item>

	<item>
	<title>Calcio Streaming Live</title>
	<onClick>playItemURL("http://127.0.0.1:82/scripts/util/seeon.cgi?rtmp://live2.seeon.tv/edge/yelqnl3le1a2l67", 10);</onClick>
	<annotation>http://www.seeon.tv</annotation>
	</item>

	<item>
	<title>Marco1</title>
	<onClick>playItemURL("http://127.0.0.1:82/scripts/util/seeon.cgi?rtmp://live4.seeon.tv/edge/lfxsgeil7xbcren", 10);</onClick>
	<annotation>http://www.seeon.tv</annotation>
	</item>

	<item>
	<title>ABC Family</title>
	<onClick>playItemURL("http://127.0.0.1:82/scripts/util/seeon.cgi?rtmp://live8.seeon.tv/edge/75a9xzy4ar89ur0", 10);</onClick>
	<annotation>http://www.seeon.tv</annotation>
	</item>

	<item>
	<title>NBC</title>
	<onClick>playItemURL("http://127.0.0.1:82/scripts/util/seeon.cgi?rtmp://live2.seeon.tv/edge/uijs8reafi8i2ay", 10);</onClick>
	<annotation>http://www.seeon.tv</annotation>
	</item>

	<item>
	<title>Sein</title>
	<onClick>playItemURL("http://127.0.0.1:82/scripts/util/seeon.cgi?rtmp://live4.seeon.tv/edge/h520obcmt5uoopn", 10);</onClick>
	<annotation>http://www.seeon.tv</annotation>
	</item>

	<item>
	<title>HBO</title>
	<onClick>playItemURL("http://127.0.0.1:82/scripts/util/seeon.cgi?rtmp://live1.seeon.tv/edge/jzup1bm4f63q4j1", 10);</onClick>
	<annotation>http://www.seeon.tv</annotation>
	</item>
	
	<item>
	<title>Disney</title>
	<onClick>playItemURL("http://127.0.0.1:82/scripts/util/seeon.cgi?rtmp://live4.seeon.tv/edge/rrw4s3plh42gohw", 10);</onClick>
	<annotation>http://www.seeon.tv</annotation>
	</item>

	<item>
	<title>Two and a half men</title>
	<onClick>playItemURL("http://127.0.0.1:82/scripts/util/seeon.cgi?rtmp://live8.seeon.tv/edge/f4tmvj4qmh9czzz", 10);</onClick>
	<annotation>http://www.seeon.tv</annotation>
	</item>

	<item>
	<title>King Of The Hill</title>
	<onClick>playItemURL("http://127.0.0.1:82/scripts/util/seeon.cgi?rtmp://live6.seeon.tv/edge/1xoq5bcyeb8higr", 10);</onClick>
	<annotation>http://www.seeon.tv</annotation>
	</item>

	<item>
	<title>Super Movies</title>
	<onClick>playItemURL("http://127.0.0.1:82/scripts/util/seeon.cgi?rtmp://live2.seeon.tv/edge/sj3i8ctowne2lej", 10);</onClick>
	<annotation>http://www.seeon.tv</annotation>
	</item>

	<item>
	<title>Best Movies</title>
	<onClick>playItemURL("http://127.0.0.1:82/scripts/util/seeon.cgi?rtmp://live2.seeon.tv/edge/jjylzf6jmbqfahn", 10);</onClick>
	<annotation>http://www.seeon.tv</annotation>
	</item>

	<item>
	<title>Newest Movies</title>
	<onClick>playItemURL("http://127.0.0.1:82/scripts/util/seeon.cgi?rtmp://live4.seeon.tv/edge/sr6axrt2ent25k7", 10);</onClick>
	<annotation>http://www.seeon.tv</annotation>
	</item>

	<item>
	<title>Friends show</title>
	<onClick>playItemURL("http://127.0.0.1:82/scripts/util/seeon.cgi?rtmp://live2.seeon.tv/edge/ktc6f73bm5w2ny8", 10);</onClick>
	<annotation>http://www.seeon.tv</annotation>
	</item>
	
</channel>
</rss>
