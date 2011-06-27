<?php echo "<?xml version='1.0' encoding='UTF8' ?>";
$host = "http://127.0.0.1:82";
?>
<rss version="2.0">
<onEnter>
  startitem = "middle";
  setRefreshTime(1);
columnCount=3
</onEnter>

<onRefresh>
  setRefreshTime(-1);
  itemCount = getPageInfo("itemCount");
  redrawDisplay();
</onRefresh>

	<mediaDisplay name=photoView 
	    centerXPC=7
		centerYPC=25
		centerHeightPC=60
        columnCount=3
	    rowCount=1
		menuBorderColor="55:55:55"
		sideColorBottom="0:0:0"
		sideColorTop="0:0:0"
	    backgroundColor="0:0:0"
		imageBorderColor="0:0:0"
		itemBackgroundColor="0:0:0"
		itemGapXPC=0
		itemGapYPC=1
		sideTopHeightPC=22
		bottomYPC=85
		sliding=yes
		showHeader=no
		showDefaultInfo=no
		idleImageWidthPC="8" idleImageHeightPC="10" idleImageXPC="80" idleImageYPC="10">
<!--
  	<text align="center" offsetXPC="0" offsetYPC="0" widthPC="100" heightPC="20" fontSize="30" backgroundColor="10:105:150" foregroundColor="100:200:255">
		  <script>getPageInfo("pageTitle");</script>
		</text>

  	<text redraw="yes" offsetXPC="85" offsetYPC="12" widthPC="10" heightPC="6" fontSize="20" backgroundColor="10:105:150" foregroundColor="60:160:205">
		  <script>sprintf("%s / ", focus-(-1))+itemCount;</script>
		</text>
-->
		<text align="left" offsetXPC=5 offsetYPC=5 widthPC=75 heightPC=5 fontSize=15 backgroundColor=0:0:0 foregroundColor=120:120:120>
   Tips: Folositi tastele 1-9, Prev si Next pentru o navigare mai usoara! Apasati 0 pentru help.
		</text>
		<text align="center" redraw="yes" lines="4" offsetXPC=10 offsetYPC=85 widthPC=75 heightPC=15 fontSize=15 backgroundColor=0:0:0 foregroundColor=120:120:120>
			<script>print(annotation); annotation;</script>
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
			<image>
				<script>
					idx = getQueryItemIndex();
					focus = getFocusItemIndex();
					if(focus==idx) 
					{
					  annotation = getItemInfo(idx, "annotation");
					}
					getItemInfo(idx, "image");
				</script>
			 <offsetXPC>
			   <script>
					idx = getQueryItemIndex();
					focus = getFocusItemIndex();
			    if(focus==idx) 0; else 15;
			   </script>
			 </offsetXPC>
			 <offsetYPC>
			   <script>
					idx = getQueryItemIndex();
					focus = getFocusItemIndex();
			    if(focus==idx) 0; else 8;
			   </script>
			 </offsetYPC>
			 <widthPC>
			   <script>
					idx = getQueryItemIndex();
					focus = getFocusItemIndex();
			    if(focus==idx) 100; else 70;
			   </script>
			 </widthPC>
			 <heightPC>
			   <script>
					idx = getQueryItemIndex();
					focus = getFocusItemIndex();
			    if(focus==idx) 60; else 42;
			   </script>
			 </heightPC>
			</image>
			
			<text align="center" lines="3" offsetXPC=0 offsetYPC=65 widthPC=100 heightPC=35 backgroundColor=-1:-1:-1>
				<script>
					idx = getQueryItemIndex();
					getItemInfo(idx, "title");
				</script>
				<fontSize>
  				<script>
  					idx = getQueryItemIndex();
  					focus = getFocusItemIndex();
  			    if(focus==idx) "22"; else "18";
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
      doModalRss("/scripts/util/help.rss");
      ret="true";
      }
      else if (userInput == "pagedown" || userInput == "pageup" || userInput == "PD" || userInput == "PG")
      {
        itemSize = getPageInfo("itemCount");
        idx = Integer(getFocusItemIndex());
        if (userInput == "pagedown")
        {
          idx -= -10;
          if(idx &gt;= itemSize)
            idx = itemSize-1;
        }
        else
        {
          idx -= 10;
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
		<link>
		  <script>getItemInfo(getQueryItemIndex(), "location");</script>
		</link>
	</item_template>
	
  <channel>
    <title>HDD Links</title>
  <item>
    <link><?php echo $host; ?>/scripts/trailer/trailer.php</link>
    <title>Trailere filme şi jocuri</title>
    <annotation>Vedeţi aici ultimele trailere pentru filme sau jocuri...</annotation>
    <image>/scripts/image/trailerb.png</image>
    <mediaDisplay name="photoView"/>
  </item>
  <item>
    <link><?php echo $host; ?>/scripts/filme/filme.php</link>
    <title>Filme online subtitrate</title>
    <annotation>Vedeţi aici filme online cu subtitrare...</annotation>
    <image>/scripts/filme/image/movies.png</image>
    <mediaDisplay name="threePartsView"/>
  </item>
  <item>
    <link><?php echo $host; ?>/scripts/filme/seriale.php</link>
    <title>Seriale TV subtitrate</title>
    <annotation>Vedeţi aici seriale TV cu subtitrare...</annotation>
    <image>/scripts/filme/image/series.png</image>
    <mediaDisplay name="threePartsView"/>
  </item>
  <item>
    <link><?php echo $host; ?>/scripts/filme/desene.php</link>
    <title>Pentru copii...</title>
    <annotation>Pentru copii avem desene animate, povesti...</annotation>
    <image>/scripts/filme/image/desene.png</image>
    <mediaDisplay name="threePartsView"/>
  </item>
  <item>
    <link><?php echo $host; ?>/scripts/clip/clip.php</link>
    <title>Videoclipuri şi altele</title>
    <annotation>Filmuleţe nostime, clipuri video şi altele</annotation>
    <image>/scripts/image/videoclip.png</image>
    <mediaDisplay name="photoView"/>
  </item>
  <item>
    <link><?php echo $host; ?>/scripts/news/news.php</link>
    <title>Ştiri şi alte informaţii</title>
    <annotation>Vezi orarul serialelor, cursul valutar sau alte informaţii utile</annotation>
    <image>/scripts/news/image/news.png</image>
    <mediaDisplay name="photoView"/>
  </item>
  <item>
    <link><?php echo $host; ?>/scripts/tv/tv_radio.php</link>
    <title>TV, Radio şi emisiuni Inregistrate</title>
    <annotation>Ascultă sau vezi postul tău de radio sau TV favorit. Ai ratat o emisiune? Aici poţi s-o găseşti!</annotation>
    <image>/scripts/image/tv_radio.png</image>
    <mediaDisplay name="photoView"/>
  </item>
  <item>
    <link><?php echo $host; ?>/scripts/user/users.php</link>
    <title>Conturi personale metafeeds</title>
    <annotation>Ai un cont pe metafeeds? Aici putem să-l adăugăm!</annotation>
    <image>/scripts/image/users.png</image>
    <mediaDisplay name="threePartsView"/>
  </item>
  <item>
		<link>rss_command://search</link>
		<search url="<?php echo $host; ?>/scripts/adult/adult%s.php" />
    <title>Canal adulţi</title>
    <annotation>Numai pentru 18++! Necesită parolă. Intră pe http://forum.softpedia.com/index.php?showforum=14 pentru mai multe informaţii</annotation>
    <image>/scripts/image/adult.png</image>
    <mediaDisplay name="photoView"/>
  </item>
<!--
  <item>
    <link><?php echo $host; ?>/scripts/util/system.php</link>
    <title>Utilitare player</title>
    <annotation>Pornire-Oprire sever FTP, redenumire fişiere si alte unelte utile.</annotation>
    <image>/scripts/image/system.png</image>
    <mediaDisplay name="threePartsView"/>
  </item>
-->
</channel>

</rss>
