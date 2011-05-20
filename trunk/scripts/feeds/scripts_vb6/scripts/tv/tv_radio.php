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
		centerHeightPC=75
columnCount=6
	  rowCount=3
		menuBorderColor="55:55:55"
		sideColorBottom="0:0:0"
		sideColorTop="0:0:0"
	  backgroundColor="0:0:0"
		imageBorderColor="10:105:150"
		imageBorderPC="1.5"
		itemBackgroundColor="0:0:0"
		itemGapXPC=1
		itemGapYPC=4
		sideTopHeightPC=0
		bottomYPC=80
		sliding=yes
		showHeader=no
		showDefaultInfo=no
		idleImageWidthPC="10" idleImageHeightPC="10">
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
			    if(focus==idx) 50; else 37;
			   </script>
			 </heightPC>
			</image>

			<text align="center" lines="2" offsetXPC=0 offsetYPC=55 widthPC=100 heightPC=45 backgroundColor=-1:-1:-1>
				<script>
					idx = getQueryItemIndex();
					getItemInfo(idx, "title");
				</script>
				<fontSize>
  				<script>
  					idx = getQueryItemIndex();
  					focus = getFocusItemIndex();
  			    if(focus==idx) "16"; else "14";
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

    <title>TV, Radio şi emisiuni Inregistrate</title>

<item>
<title>TV Live</title>
<link><?php echo $host; ?>/scripts/tv/tv_live.php</link>
<media:thumbnail url="image/tv_radio.png" />
<image>/scripts/image/tv_radio.png</image>
<location></location>
<annotation>Posturi TV locale si internationale</annotation>
</item>

<item>
<title>Radio On Line</title>
<link>/scripts/tv/radio.rss</link>
<media:thumbnail url="../etc/translate/rss/image/radio_online.jpg" />
<image>../etc/translate/rss/image/radio_online.jpg</image>
<location></location>
<annotation>Posturi radio pe alese....</annotation>
<mediaDisplay name="photoView" />
</item>

<item>
<title>Antena 1</title>
<link><?php echo $host; ?>/scripts/tv/php/antena1_main.php</link>
<media:thumbnail url="/scripts/tv/image/antena1.jpg" />
<image>/scripts/tv/image/antena1.jpg</image>
<location>http://www.a1.ro/</location>
<annotation>Tot ce va intereseaza: stiri, vedete, program tv, evenimente, noutati auto, sport si nu numai. O colectie de informatii necesara oricarui roman. Antena 1 - Mereu Aproape</annotation>
<mediaDisplay name="photoView"/>
</item>

<item>
<title>Antena2</title>
<link><?php echo $host; ?>/scripts/tv/php/antena2_main.php</link>
<media:thumbnail url="/scripts/tv/image/antena2.jpg" />
<image>/scripts/tv/image/antena2.jpg</image>
<location>http://antena2.ro/</location>
<annotation>Programe LIVE,  reactii, replici, emotii, nervii, toate autentice si necenzurate</annotation>
</item>

<item>
<title>Antena3</title>
<link><?php echo $host; ?>/scripts/tv/php/ant3_main.php</link>
<media:thumbnail url="/scripts/tv/image/antena3.jpg" />
<image>/scripts/tv/image/antena3.jpg</image>
<location>http://www.antena3.ro/</location>
<annotation>Specialisti in stiri, prima optiune pentru stiri online in timp real din Romania si din lume</annotation>
</item>

<item>
<title>ProTV</title>
<link><?php echo $host; ?>/scripts/tv/php/protv_main.php</link>
<media:thumbnail url="/scripts/tv/image/protv.jpg" />
<image>/scripts/tv/image/protv.jpg</image>
<location>http://www.protv.ro/</location>
<annotation>Vezi aici emisiuni inregistrate ale postului TV ProTV</annotation>
</item>

<item>
<title>AcasaTV</title>
<link><?php echo $host; ?>/scripts/tv/acasatv.php</link>
<media:thumbnail url="/scripts/tv/image/acasatv.jpg" />
<image>/scripts/tv/image/acasatv.jpg</image>
<location>http://www.acasatv.ro/</location>
<annotation>Ultimele stiri despre telenovele, vedete, moda, frumusete, dieta si  familie</annotation>
</item>

<item>
<title>EuforiaTV</title>
<link><?php echo $host; ?>/scripts/tv/php/euforiatv.php</link>
<media:thumbnail url="/scripts/tv/image/euforiatv.gif" />
<image>/scripts/tv/image/euforiatv.gif</image>
<location>http://www.euforia.tv/</location>
<annotation>Euforia, lifestyle, hobby, fashion, retete culinare, sanatate, community</annotation>
</item>

<item>
<title>RealitateaTV</title>
<link><?php echo $host; ?>/scripts/tv/php/realitateatv_main.php</link>
<media:thumbnail url="/scripts/tv/image/realitateatv.gif" />
<image>/scripts/tv/image/realitateatv.gif</image>
<location>http://www.realitatea.net/tv</location>
<annotation>Site-ul de stiri nr. 1 in Romania iti ofera informatia proaspata corecta obiectiva si documentata despre stirile de ultima ora.</annotation>
</item>

<item>
<title>Money.ro WebTV</title>
<link><?php echo $host; ?>/scripts/tv/php/money.php</link>
<media:thumbnail url="/scripts/tv/image/money.gif" />
<image>/scripts/tv/image/money.gif</image>
<location>http://webtv.money.ro/</location>
<annotation>Site-ul de stiri nr. 1 in Romania iti ofera informatia proaspata corecta obiectiva si documentata despre stirile de ultima ora.</annotation>
</item>

<item>
<title>SensoTV</title>
<link><?php echo $host; ?>/scripts/tv/sensotv.php</link>
<media:thumbnail url="/scripts/tv/image/sensotv.png" />
<image>/scripts/tv/image/sensotv.png</image>
<location>http://www.sensotv.ro/</location>
<annotation>Senso TV este o televiziune online ce face parte dintr-un trust media, compus din 6 canale TV online: Arts Channel, Health Channel, Music Channel, Politic Channel, Extrem Sports Channel si Lifestyle Channel.</annotation>
</item>

<item>
<title>Publika.Md</title>
<link><?php echo $host; ?>/scripts/tv/php/publika.php</link>
<media:thumbnail url="/scripts/tv/image/publika.jpg" />
<image>/scripts/tv/image/publika.jpg</image>
<location>http://publika.md/</location>
<annotation>Site-ul de stiri care iti ofera informatia proaspata corecta obiectiva si documentata despre stirile de ultima ora.</annotation>
</item>

<item>
<title>JurnalTV</title>
<link><?php echo $host; ?>/scripts/tv/php/jurnaltv_main.php</link>
<media:thumbnail url="/scripts/tv/image/jurnaltv.jpg" />
<image>/scripts/tv/image/jurnaltv.jpg</image>
<location>http://jurnaltv.md/</location>
<annotation>JurnalTV - Prima televiziune de stiri din Republica Moldova</annotation>
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
<title>Emisiuni Sportive</title>
<link><?php echo $host; ?>/scripts/tv/tv_sport.php</link>
<media:thumbnail url="image/tv_radio.png" />
<image>/scripts/image/tv_radio.png</image>
<location></location>
<annotation>Inregistrari evenimente sportive.</annotation>
<mediaDisplay name="photoView"/>
</item>

<item>
<title>Posturi locale</title>
<link><?php echo $host; ?>/scripts/tv/locale.php</link>
<media:thumbnail url="image/tv_radio.png" />
<image>/scripts/image/tv_radio.png</image>
<location></location>
<annotation>Emisiuni posturi locale.</annotation>
<mediaDisplay name="photoView"/>
</item>

<item>
<title>Revision3</title>
<link><?php echo $host; ?>/scripts/tv/rev3.php</link>
<media:thumbnail url="/scripts/tv/image/revision3.gif" />
<image>/scripts/tv/image/revision3.gif</image>
<location>http://revision3.com/</location>
<annotation>Revision3 is the leading independent free online video service that offers hit TV shows including Diggnation with Kevin Rose, Scam School, Film Riot, etc.</annotation>
</item>
<!--
<item>
<title>Bing</title>
<link><?php echo $host; ?>/scripts/tv/bing.php</link>
<media:thumbnail url="/scripts/tv/image/bing.jpg"  />
<image>/scripts/tv/image/bing.jpg</image>
<location>http://www.bing.com/</location>
<annotation>Search through hundreds of millions of breaking news, hot viral, TV show & music videos from all over the Web. Browse categories to find just what you want.</annotation>
</item>
-->
<item>
<title>Cronica Carcotasilor</title>
<link>http://cronica.primatv.ro/podcast/podcast.xml</link>
<media:thumbnail url="image/tv_radio.png" />
<image>/scripts/image/tv_radio.png</image>
<location>http://cronica.primatv.ro/</location>
<annotation>Site dedicat emisiunii de divertisment Cronica Carcotasilor difuzata pe PrimaTV si prezentata de Serban Huidu si Mihai Gainusa.</annotation>
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
		<text  offsetXPC=20 offsetYPC=8 widthPC=70 heightPC=10 fontSize=20 backgroundColor=-1:-1:-1 foregroundColor=255:255:255>
           Cronica Carcotasilor KissFM
		</text>
</mediaDisplay>
</item>

</channel>
</rss>
