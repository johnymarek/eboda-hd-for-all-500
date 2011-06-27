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
  redrawDisplay();
</onRefresh>

	<mediaDisplay name=photoView
	  centerXPC=5
		centerYPC=5
		centerHeightPC=70
      columnCount=3
	  rowCount=2
		menuBorderColor="55:55:55"
		sideColorBottom="0:0:0"
		sideColorTop="0:0:0"
	  backgroundColor="0:0:0"
		imageBorderColor="10:105:150"
		imageBorderPC="0"
		itemBackgroundColor="0:0:0"
		itemGapXPC=5
		itemGapYPC=0
		sideTopHeightPC=0
		bottomYPC=100
		sliding=yes
		showHeader=no
		showDefaultInfo=no
		idleImageWidthPC="8" idleImageHeightPC="10" idleImageXPC="5" idleImageYPC="5">
<!--
  	<text align="center" offsetXPC="0" offsetYPC="0" widthPC="100" heightPC="20" fontSize="30" backgroundColor="10:105:150" foregroundColor="100:200:255">
		  <script>getPageInfo("pageTitle");</script>
		</text>

  	<text redraw="yes" offsetXPC="85" offsetYPC="12" widthPC="10" heightPC="6" fontSize="20" backgroundColor="10:105:150" foregroundColor="60:160:205">
		  <script>sprintf("%s / ", focus-(-1))+itemCount;</script>
		</text>
-->
		<!--  lines="5" fontSize=15 -->
		<text align="center" redraw="yes"
  lines=3 fontSize=17
		      offsetXPC=5 offsetYPC=80 widthPC=90 heightPC=15
		      backgroundColor=0:0:0 foregroundColor=120:120:120>
			<script>print(annotation); annotation;</script>
		</text>
<!--
		<text align="center" redraw="yes" offsetXPC=10 offsetYPC=85 widthPC=80 heightPC=10 fontSize=15 backgroundColor=0:0:0 foregroundColor=75:75:75>
			<script>print(location); location;</script>
		</text>
-->
        <idleImage>image/POPUP_LOADING_01.png</idleImage>
        <idleImage>image/POPUP_LOADING_02.png</idleImage>
        <idleImage>image/POPUP_LOADING_03.png</idleImage>
        <idleImage>image/POPUP_LOADING_04.png</idleImage>
        <idleImage>image/POPUP_LOADING_05.png</idleImage>
        <idleImage>image/POPUP_LOADING_06.png</idleImage>
        <idleImage>image/POPUP_LOADING_07.png</idleImage>
        <idleImage>image/POPUP_LOADING_08.png</idleImage>
		<itemDisplay>
			<image>
				<script>
					idx = getQueryItemIndex();
					focus = getFocusItemIndex();
					if(focus==idx)
					{
					  location = getItemInfo(idx, "location");
					  annotation = getItemInfo(idx, "annotation");
					}
					getItemInfo(idx, "image");
				</script>
			 <offsetXPC>
			   <script>
					idx = getQueryItemIndex();
					focus = getFocusItemIndex();
			    if(focus==idx) 5; else 12;
			   </script>
			 </offsetXPC>
			 <offsetYPC>
			   <script>
					idx = getQueryItemIndex();
					focus = getFocusItemIndex();
			    if(focus==idx) 4; else 6;
			   </script>
			 </offsetYPC>
			 <widthPC>
			   <script>
					idx = getQueryItemIndex();
					focus = getFocusItemIndex();
			    if(focus==idx) 90; else 75;
			   </script>
			 </widthPC>
			 <heightPC>
			   <script>
					idx = getQueryItemIndex();
					focus = getFocusItemIndex();
			    if(focus==idx) 70; else 60;
			   </script>
			 </heightPC>
			</image>

			<text align="center" lines="1" offsetXPC=0 offsetYPC=82 widthPC=100 heightPC=12 useBackgroundSurface=yes>
				<script>
					idx = getQueryItemIndex();
					getItemInfo(idx, "title");
				</script>
				<fontSize>
  				<script>
  					idx = getQueryItemIndex();
  					focus = getFocusItemIndex();
  			    if(focus==idx) "18"; else "14";
  				</script>
				</fontSize>
			  <foregroundColor>
  				<script>
  					idx = getQueryItemIndex();
  					focus = getFocusItemIndex();
  			    if(focus==idx) "255:255:255"; else "75:75:75";
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

      if(userInput == "one" || userInput == "1")
      {
        if(itemCount &gt;= 1)
        {
          setFocusItemIndex(0);
          redrawDisplay();
        }
      }
      else if(userInput == "two" || userInput == "2")
      {
        if(itemCount &gt;= 2)
        {
          setFocusItemIndex(1);
          redrawDisplay();
        }
      }
      else if(userInput == "three" || userInput == "3")
      {
        if(itemCount &gt;= 3)
        {
          setFocusItemIndex(2);
          redrawDisplay();
        }
      }
      else if(userInput == "four" || userInput == "4")
      {
        if(itemCount &gt;= 4)
        {
          setFocusItemIndex(3);
          redrawDisplay();
        }
      }
      else if(userInput == "five" || userInput == "5")
      {
        if(itemCount &gt;= 5)
        {
          setFocusItemIndex(4);
          redrawDisplay();
        }
      }
      else if(userInput == "six" || userInput == "6")
      {
        if(itemCount &gt;= 6)
        {
          setFocusItemIndex(5);
          redrawDisplay();
        }
      }
      else if(userInput == "seven" || userInput == "7")
      {
        if(itemCount &gt;= 7)
        {
          setFocusItemIndex(6);
          redrawDisplay();
        }
      }
      else if(userInput == "eight" || userInput == "8")
      {
        if(itemCount &gt;= 8)
        {
          setFocusItemIndex(7);
          redrawDisplay();
        }
      }
      else if(userInput == "nine" || userInput == "9")
      {
        if(itemCount &gt;= 9)
        {
          setFocusItemIndex(8);
          redrawDisplay();
        }
      }
      if(userInput == "zero" || userInput == "0")
      {
        if(itemCount &gt;= 10)
        {
          setFocusItemIndex(9);
          redrawDisplay();
        }
      }
      else if (userInput == "pagedown" || userInput == "pageup" || userInput == "PD" || userInput == "PG")
      {
        itemSize = getPageInfo("itemCount");
        idx = Integer(getFocusItemIndex());
        if (userInput == "pagedown")
        {
          idx -= -5;
          if(idx &gt;= itemSize)
            idx = itemSize-1;
        }
        else
        {
          idx -= 5;
          if(idx &lt; 0)
            idx = 0;
        }
        setFocusItemIndex(idx);
        setItemFocus(idx);
        redrawDisplay();
        ret = "true";
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

    <title>TV, Radio şi emisiuni Inregistrate</title>

<item>
<title>TV Live</title>
<link><?php echo $host; ?>/scripts/tv/tv_live.php</link>
<media:thumbnail url="/scripts/tv/image/tvlive.png" />
<image>/scripts/tv/image/tvlive.png</image>
<location></location>
<annotation>Posturi TV din Romania sau din alte tari. Canale de stiri, muzica sau sport.</annotation>
</item>

<item>
<title>Radio On Line</title>
<link>/scripts/tv/radio.rss</link>
<media:thumbnail url="/scripts/image/radio_online.png" />
<image>/scripts/image/radio_online.png</image>
<location></location>
<annotation>Posturi de radio pe alese....</annotation>
<mediaDisplay name="photoView" />
</item>

<item>
<title>OneHD</title>
<link><?php echo $host; ?>/scripts/tv/prahovahd.php</link>
<media:thumbnail url="/scripts/tv/image/onehd.png" />
<image>/scripts/tv/image/onehd.png</image>
<location>http://live.1hd.ro/</location>
<annotation>One HD - prima televiziune online HD - o alternativa la televiziunea clasica, promoveaza emisiuni culturale, de divertisment, business, turism, experimentale, disponibile atat live cat si on-demand (VOD).</annotation>
</item>

<item>
<title>Posturi nationale</title>
<link><?php echo $host; ?>/scripts/tv/nationale.php</link>
<media:thumbnail url="image/tv_radio.png" />
<image>/scripts/image/tv_radio.png</image>
<location></location>
<annotation>Inregistrari emisiuni TV ale posturilor nationale.</annotation>
<mediaDisplay name="photoView"/>
</item>

<item>
<title>Posturi locale</title>
<link><?php echo $host; ?>/scripts/tv/locale.php</link>
<media:thumbnail url="image/tv_radio.png" />
<image>/scripts/image/tv_radio.png</image>
<location></location>
<annotation>Stiri si emisiuni inregistrate, difuzate de posturile TV locale.</annotation>
<mediaDisplay name="photoView"/>
</item>

<item>
<title>Emisiuni Sportive</title>
<link><?php echo $host; ?>/scripts/tv/tv_sport.php</link>
<media:thumbnail url="/scripts/tv/image/sport.jpg" />
<image>/scripts/tv/image/sport.jpg</image>
<location></location>
<annotation>Inregistrari evenimente sportive. Fotbal si nu numai...</annotation>
<mediaDisplay name="photoView"/>
</item>



</channel>
</rss>
