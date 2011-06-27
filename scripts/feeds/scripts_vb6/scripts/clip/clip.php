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
  middleItem = Integer(itemCount / 2);
  redrawDisplay();
</onRefresh>

	<mediaDisplay name=photoView 
	  centerXPC=7 
		centerYPC=25
		centerHeightPC=40
columnCount=5
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
		idleImageXPC="5" idleImageYPC="5" idleImageWidthPC="8" idleImageHeightPC="10">
		
  	<text align="center" offsetXPC="0" offsetYPC="0" widthPC="100" heightPC="20" fontSize="30" backgroundColor="10:105:150" foregroundColor="100:200:255">
		  <script>getPageInfo("pageTitle");</script>
		</text>

  	<text redraw="yes" offsetXPC="85" offsetYPC="12" widthPC="10" heightPC="6" fontSize="20" backgroundColor="10:105:150" foregroundColor="60:160:205">
		  <script>sprintf("%s / ", focus-(-1))+itemCount;</script>
		</text>

		<!--  lines="5" fontSize=15 -->
		<text align="center" redraw="yes" 
  lines=3 fontSize=17
		      offsetXPC=5 offsetYPC=65 widthPC=90 heightPC=20 
		      backgroundColor=0:0:0 foregroundColor=120:120:120>
			<script>print(annotation); annotation;</script>
		</text>
		
		<text align="center" redraw="yes" offsetXPC=10 offsetYPC=85 widthPC=80 heightPC=10 fontSize=15 backgroundColor=0:0:0 foregroundColor=75:75:75>
			<script>print(location); location;</script>
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
					  location = getItemInfo(idx, "location");
					  annotation = getItemInfo(idx, "annotation");
					}
					getItemInfo(idx, "image");
				</script>
			 <offsetXPC>
			   <script>
					idx = getQueryItemIndex();
					focus = getFocusItemIndex();
			    if(focus==idx) 0; else 12;
			   </script>
			 </offsetXPC>
			 <offsetYPC>
			   <script>
					idx = getQueryItemIndex();
					focus = getFocusItemIndex();
			    if(focus==idx) 0; else 6;
			   </script>
			 </offsetYPC>
			 <widthPC>
			   <script>
					idx = getQueryItemIndex();
					focus = getFocusItemIndex();
			    if(focus==idx) 100; else 75;
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
			
			<text align="center" lines="4" offsetXPC=0 offsetYPC=55 widthPC=100 heightPC=45 backgroundColor=-1:-1:-1>
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
<title>Videoclipuri</title>
<item>
<title>Vimeo</title>
	<link><?php echo $host; ?>/scripts/clip/php/vimeo_cat.php</link>
	<location>http://vimeo.com/</location>
	<image>/scripts/clip/image/vimeo.jpg</image>
	<media:thumbnail url="/scripts/clip/image/vimeo.jpg" />
	<annotation>Vimeo is a respectful community of creative people who are passionate about sharing the videos they make. We provide the best tools and highest quality video in the universe.</annotation>
</item>	

<item>
<title>Dailymotion</title>
	<link><?php echo $host; ?>/scripts/clip/dm.php</link>
	<location>http://www.dailymotion.com</location>
	<image>/scripts/clip/image/dailymotion.png</image>
	<media:thumbnail url="/scripts/clip/image/dailymotion.png" />
	<annotation>Dailymotion is about finding new ways to see, share and engage your world through the power of online video. You can find - or upload - videos about your interests and hobbies, eyewitness accounts of recent news and distant places, and everything else from the strange to the spectacular.</annotation>
</item>

<item>
<title>Youtube</title>
	<link>rss_file:///scripts/clip/youtube/yt_index.rss</link>
	<location>http://youtube.com</location>
	<image>/scripts/image/youtube.gif</image>
	<media:thumbnail url="image/youtube.gif" />
	<annotation>YouTube este un loc �n care puteti descoperi, urm�ri, �nc�rca si distribui videoclipuri.</annotation>
	<mediaDisplay name="onePartView" />
</item>
<!--
<item>
<title>Youtube user uploads</title>
	<link>rss_command://search</link>
	<location>http://youtube.com</location>
	<search url="<?php echo $host; ?>/scripts/php1/youtube_user.php?query=1,%s" />
	<image>/scripts/image/youtube.gif</image>
	<media:thumbnail url="image/youtube.gif" />
	<annotation>Căutare videoclipuri postate pe youtube de către....</annotation>
</item>
-->
<item>
<title>220.ro</title>
	<link><?php echo $host; ?>/scripts/clip/220.php</link>
	<location>http://www.220.ro/</location>
	<image>/scripts/clip/image/220.jpg</image>
	<media:thumbnail url="/scripts/clip/image/220.jpg" />
	<annotation>220.ro este una dintre cele mai interesante destinatii online pentru divertisment de calitate si noutati din toate domeniile, un site ce ofera materiale unice si nu numai. Totodata, 220.ro este si o comunitate de sharing video unde oricine poate uploada un material pentru a-l trimite mai apoi si prietenilor. In plus, Internetul naste din cand in cand si vedete. Tu poti fi una dintre ele.</annotation>
</item>

<item>
<title>videonews</title>
	<link><?php echo $host; ?>/scripts/clip/php/videonews_tv.php</link>
	<location>http://videonews.antena3.ro/action/videolist/tv/</location>
	<image>/scripts/clip/image/videonews.jpg</image>
	<media:thumbnail url="/scripts/clip/image/videonews.jpg" />
	<annotation>Dacă aţi surprins un eveniment, ceva important sau neobişnuit, uploadaţi imaginile pe Videonews. Materialele voastre pot deveni ştiri pe Antena3.ro sau în jurnalele Antenei 3, iar cele mai bune materiale primite vor fi premiate.</annotation>
</item>

<item>
<title>peteava.ro</title>
	<link><?php echo $host; ?>/scripts/clip/peteava_main.php</link>
	<location>http://www.peteava.ro/</location>
	<image>/scripts/clip/image/peteava.png</image>
	<media:thumbnail url="/scripts/clip/image/peteava.png" />
	<annotation>Poti incarca 50 de clipuri video si / sau imagini simultan, iar clipurile video pot avea 1 GB sau 50 min.</annotation>
</item>

<item>
<title>ViataLaServiciu</title>
	<link><?php echo $host; ?>/scripts/clip/php/viatalaserviciu.php</link>
	<location>http://www.viatalaserviciu.ro/</location>
	<image>/scripts/clip/image/viatalaserviciu.gif</image>
	<media:thumbnail url="/scripts/clip/image/viatalaserviciu.gif" />
	<annotation>Ne petrecem la job mai mult de jumatate din timpul nostru activ. Mincam, facem febra, avem aventuri, fumam o tigara, citim ziare online, muncim, ne certam, ne simpatizam, flirtam, ne uitam pe geam, fugim sa luam o piine de la supermarket – facem toate aceste lucruri la serviciu. Avem o viata la serviciu.</annotation>
</item>

<item>
<title>VideoAlegeNet</title>
	<link><?php echo $host; ?>/scripts/clip/php/video_alege_net.php?query=0,http://video.alege.net/c-filme-noi-ro-</link>
	<location>http://video.alege.net</location>
	<image>/scripts/image/videoclip.png</image>
	<media:thumbnail url="image/videoclip.png" />
	<annotation>Azi va recomandam urmatoarele filme...</annotation>
</item>

<item>
<title>CancanTV</title>
	<link><?php echo $host; ?>/scripts/clip/php/cancan.php</link>
	<location>http://www.cancan.ro/</location>
	<image>/scripts/clip/image/cancan.jpg</image>
	<media:thumbnail url="/scripts/clip/image/cancan.jpg" />
	<annotation>Ai un pont? Trimite acum un e-mail la pont@cancan.ro</annotation>
</item>

<item>
<title>youclubvideo</title>
	<link><?php echo $host; ?>/scripts/clip/php/youclubvideo.php</link>
	<location>http://www.youclubvideo.com</location>
	<image>/scripts/clip/image/youclubvideo.png</image>
	<media:thumbnail url="/scripts/clip/image/youclubvideo.png" />
	<annotation>YouClubVideo was started as an idea to bring together a wide variety of clubbing experiences and people from all the countries of the world that have in common the same feelings, sounds and sences of club music.</annotation>
</item>

<item>
<title>almanahe.ro</title>
	<link><?php echo $host; ?>/scripts/clip/php/almanahe.php</link>
	<location>http://www.almanahe.ro/</location>
	<image>/scripts/clip/image/almanahe.png</image>
	<media:thumbnail url="/scripts/clip/image/almanahe.png" />
	<annotation>Ideea proiectului almanahe.ro dateaza din anul de gratie 2007 ( luna noiembrie cred ) cand domnul Vanghelie a dat duma': " Sa se duca dracu' la munca, sa puna mana sa citeasca niste almanahe, almanahe! " si asta a fost DECLICK-UL.</annotation>
</item>

<item>
<title>Tare.ro</title>
	<link><?php echo $host; ?>/scripts/clip/php/tare.php</link>
	<location>http://www.tare.ro/</location>
	<image>/scripts/clip/image/tare.png</image>
	<media:thumbnail url="/scripts/clip/image/tare.png" />
	<annotation>Cele mai tari clipuri ale zilei</annotation>
</item>

<item>
<title>www.sanchi.ro</title>
	<link><?php echo $host; ?>/scripts/clip/php/sanchi.php</link>
	<location>http://www.sanchi.ro/</location>
	<image>/scripts/clip/image/sanchi.jpg</image>
	<media:thumbnail url="/scripts/clip/image/sanchi.jpg" />
	<annotation>sanchi.ro Pastila ta de buna dispozitie!</annotation>
</item>

<item>
<title>myvideo.ro</title>
	<link><?php echo $host; ?>/scripts/clip/php/myvideo.php</link>
	<location>http://www.myvideo.ro/</location>
	<image>/scripts/clip/image/myvideo.gif</image>
	<media:thumbnail url="/scripts/clip/image/myvideo.gif" />
	<annotation>Noi de la MyVideo iubim filmuletele haioase! Şi tu? Atunci ajută-ne să facem ca marea comunitate MyVideo să crească şi mai mare! Mii de filmulete aşteaptă deja să fie găsite, vizionate, votate, comentate şi trimise. Şi pe zi ce trece devin mai multe.</annotation>
</item>

<item>
<title>dump.ro</title>
	<link><?php echo $host; ?>/scripts/clip/php/dump.php</link>
	<location>http://dump.ro/</location>
	<image>/scripts/clip/image/dump.jpg</image>
	<media:thumbnail url="/scripts/clip/image/dump.jpg" />
	<annotation>Uploadeaza-ti si tu clipurile sau amintirile preferate, pentru a le arata prietenilor sau efectiv pentru a le avea la indemana, cu noua facilitate pe care ti-o ofera Dump.ro vei putea vedea fisierele video intr-o fereastra mult mai mare .</annotation>
</item>

<item>
<title>BlipTV</title>
	<link><?php echo $host; ?>/scripts/clip/bliptv.php</link>
	<location>http://blip.tv/</location>
	<image>/scripts/clip/image/blip_tv.jpg</image>
	<media:thumbnail url="/scripts/clip/image/blip_tv.jpg" />
	<annotation>Our mission is to make independent Web shows sustainable. We provide services to more than 50,000 independently produced Web shows. More than 44,000 show creators use blip.tv every day to manage their online and offline presence.</annotation>
</item>

<item>
<title>Best of YouTube (iPod video)</title>
	<link>http://feeds.feedburner.com/boyt</link>
	<location>http://feeds.feedburner.com/boyt</location>
	<image>/scripts/clip/image/bestofyoutube.jpg</image>
	<media:thumbnail url="/scripts/clip/image/bestofyoutube.jpg" />
	<annotation>The best video clips from YouTube delivered directly to your iPod</annotation>
    <mediaDisplay name="threePartsView" itemBackgroundColor="0:0:0" backgroundColor="0:0:0" sideLeftWidthPC="0" itemImageXPC="5" itemXPC="20" itemYPC="20" itemWidthPC="65" capWidthPC="70" unFocusFontColor="101:101:101" focusFontColor="255:255:255" idleImageWidthPC="10" idleImageHeightPC="10">
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
               Best of YouTube
		</text>
    </mediaDisplay>
</item>
<item>
<title>Revision3</title>
<link><?php echo $host; ?>/scripts/tv/rev3.php</link>
<media:thumbnail url="/scripts/tv/image/revision3.gif" />
<image>/scripts/tv/image/revision3.gif</image>
<location>http://revision3.com/</location>
<annotation>Revision3 is the leading independent free online video service that offers hit TV shows including Diggnation with Kevin Rose, Scam School, Film Riot, etc.</annotation>
</item>

<item>
<title>Video Podcast from SDK4</title>
	<link>/scripts/clip/videopodcast.rss</link>
	<location></location>
	<image>/scripts/user/image/metafeeds.jpg</image>
	<media:thumbnail url="/scripts/user/image/metafeeds.jpg" />
	<annotation>Video Podcast from SDK4</annotation>
</item>

<item>
<title>Video Podcast Directory</title>
	<link><?php echo $host; ?>/scripts/clip/php/videopodcasts_main.php</link>
	<location>http://www.videopodcasts.tv/</location>
	<image>/scripts/clip/image/videopodcasts.gif</image>
	<media:thumbnail url="/scripts/clip/image/videopodcasts.gif" />
	<annotation>The best video podcast directory. Search the biggest collection of video podcasts, video podcast feeds and video podcast software in the universe. Play, share, and enjoy!</annotation>
</item>

<item>
<title>podcastalley</title>
	<link><?php echo $host; ?>/scripts/clip/php/podcastalley_main.php</link>
	<location>http://www.podcastalley.com/index.php</location>
	<image>/scripts/clip/image/podcastalley.gif</image>
	<media:thumbnail url="/scripts/clip/image/podcastalley.gif" />
	<annotation>Podcast Alley is the podcast lovers portal. Featuring the best Podcast Directory and the Top 10 podcasts, as voted on by the listeners.</annotation>
</item>

</channel>
</rss>
