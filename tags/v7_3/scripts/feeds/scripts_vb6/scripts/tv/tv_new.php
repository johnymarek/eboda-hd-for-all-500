<?php echo "<?xml version='1.0' encoding='UTF8' ?>";
$host = "http://127.0.0.1:82";
?>
<rss version="2.0">
<script>
  translate_base_url  = "http://127.0.0.1:83/cgi-bin/translate?";

  storagePath             = getStoragePath("tmp");
  storagePath_stream      = storagePath + "stream.dat";
  
  error_info          = "";
</script>
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
if(userInput == "enter")
{
  showIdle();
  focus = getFocusItemIndex();

  request_title = getItemInfo(focus, "title");
  request_url = getItemInfo(focus, "location");
  request_options = getItemInfo(focus, "options");

  stream_url = getItemInfo(focus, "stream_url");
  stream_title = getItemInfo(focus, "stream_title");
  stream_type = getItemInfo(focus, "stream_type");
  stream_protocol = getItemInfo(focus, "stream_protocol");
  stream_soft = getItemInfo(focus, "stream_soft");
  stream_class = getItemInfo(focus, "stream_class");
  stream_server = getItemInfo(focus, "stream_server");
  stream_status_url = "";
  stream_current_song = "";
  stream_genre = getItemInfo(focus, "stream_genre");
  stream_bitrate = getItemInfo(focus, "stream_bitrate");
  
  if(stream_class == "" || stream_class == null)
    stream_class = "unknown";

  if(stream_url == "" || stream_url == null)
    stream_url = request_url;

  if(stream_server != "" &amp;&amp; stream_server != null)
    stream_status_url = translate_base_url + "status," + urlEncode(stream_server) + "," + urlEncode(stream_url);

  if(stream_title == "" || stream_title == null)
    stream_title = request_title;

  if(stream_url != "" &amp;&amp; stream_url != null)
  {
    if(stream_protocol == "file" || (stream_protocol == "http" &amp;&amp; stream_soft != "shoutcast"))
    {
      url = stream_url;
    }
    else
    {
      if(stream_type != null &amp;&amp; stream_type != "")
      {
        request_options = "Content-type:"+stream_type+";"+request_options;
      }
      url = translate_base_url + "stream," + request_options + "," + urlEncode(stream_url);
    }
  
    executeScript(stream_class+"Dispatcher");
  }
  
  cancelIdle();
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
	<item_template>
		<mediaDisplay  name="threePartsView">
			<idleImage idleImageWidthPC=10 idleImageHeightPC=10> image/POPUP_LOADING_01.png </idleImage>
			<idleImage idleImageWidthPC=10 idleImageHeightPC=10> image/POPUP_LOADING_02.png </idleImage>
			<idleImage idleImageWidthPC=10 idleImageHeightPC=10> image/POPUP_LOADING_03.png </idleImage>
			<idleImage idleImageWidthPC=10 idleImageHeightPC=10> image/POPUP_LOADING_04.png </idleImage>
			<idleImage idleImageWidthPC=10 idleImageHeightPC=10> image/POPUP_LOADING_05.png </idleImage>
			<idleImage idleImageWidthPC=10 idleImageHeightPC=10> image/POPUP_LOADING_06.png </idleImage>
			<idleImage idleImageWidthPC=10 idleImageHeightPC=10> image/POPUP_LOADING_07.png </idleImage>
			<idleImage idleImageWidthPC=10 idleImageHeightPC=10> image/POPUP_LOADING_08.png </idleImage>
		</mediaDisplay>
	</item_template>

  <videoDispatcher>
    streamArray = null;
    streamArray = pushBackStringArray(streamArray, request_url);
    streamArray = pushBackStringArray(streamArray, request_options);
    streamArray = pushBackStringArray(streamArray, stream_url);
    streamArray = pushBackStringArray(streamArray, url);
    streamArray = pushBackStringArray(streamArray, stream_type);
    streamArray = pushBackStringArray(streamArray, stream_title);
    streamArray = pushBackStringArray(streamArray, "1");
    writeStringToFile(storagePath_stream, streamArray);
    doModalRss("rss_file://../etc/translate/rss/xspf/videoRenderer.rss");
  </videoDispatcher>
  <unknownDispatcher>
    info_url    = translate_base_url + "info," + request_options + "," + urlEncode(request_url);
    error_info  = "";

    res = loadXMLFile(info_url);
    
    if (res != null)
    {
      error = getXMLElementCount("info","error");
      
      if(error != 0)
      {
  	    value = getXMLText("info","error");
  	    if(value != null)
  	    {
  	     error_info = value;
  	    }
      }
      else
      {
  	    value = getXMLAttribute("info","stream","url");
  	    if(value != null)
  	     stream_url = value;
  
  	    value = getXMLAttribute("info","stream","type");
  	    if(value != null)
  	     stream_type = value;
  	    
  	    value = getXMLAttribute("info","stream","class");
  	    if(value != null)
  	     stream_class = value;
  
  	    value = getXMLAttribute("info","stream","protocol");
  	    if(value != null)
  	     stream_protocol = value;
  
  	    value = getXMLAttribute("info","stream","server");
  	    if(value != null)
  	     stream_soft = value;
  
        stream_status_url = "";
        
  	    value = getXMLAttribute("info","stream","server_url");
  	    if(value != null)
  	    {
  	     stream_server_url = value;
  	     if((stream_soft == "icecast" || stream_soft == "shoutcast") &amp;&amp; stream_server_url!="")
  	     {
    	      stream_status_url = translate_base_url+"status,"+urlEncode(stream_server_url)+","+urlEncode(stream_url);
    	   }
  	    }
  	     
        value = getXMLText("info","status","stream-title");
  	    if(value != null)
  	     stream_title = value;
  
        stream_current_song = "";
  	    value = getXMLText("info","status","current-song");
  	    if(value != null)
    		  stream_current_song = value;
    		  
  	    value = getXMLText("info","status","stream-genre");
  	    if(value != null)
  	      stream_genre = value;
        
  	    value = getXMLText("info","status","stream-bitrate");
  	    if(value != null)
  	      stream_bitrate = value;
  
        options = "";
        
        if(stream_type != "")
          options = "Content-type:"+stream_type;
        
        if(options == "")
          options = stream_options;
        else
          options = options + ";" + stream_options;
  
  	    stream_translate_url = translate_base_url + "stream," + options + "," + urlEncode(stream_url);
  	    
  	    url = null;
  	    
  	    if(stream_class == "video" || stream_class == "audio")
    	  {
          if(stream_protocol == "file" || (stream_protocol == "http" &amp;&amp; stream_soft != "shoutcast"))
    	      url = stream_url;
    	    else
    	      url = stream_translate_url;
    	  }
    	  else
    	  {
  	      url = stream_url;
    	  }
    	     
    	  if(url != null)
    	  {
          if(stream_class == "audio" || stream_class == "video" || stream_class == "playlist" || stream_class == "rss")
          {
            executeScript(stream_class+"Dispatcher");
          }
          else
          {
            error_info = "Unsupported media type: " + stream_type;
          }
  	    }
  	    else
  	    {
          error_info = "Empty stream url!";
  	    }
      }
    }
    else
    {
      error_info = "CGI translate module failed!";
    }
    print("error_info=",error_info);
  </unknownDispatcher>
<channel>
	<title>TV Live - Canale noi</title>
	<menu>main menu</menu>


	<item>
	<title>BBC1</title>
	<stream_url>mms://195.90.118.88/BBC1_1?MSWMExt=.asf</stream_url>
	<annotation>BBC1</annotation>
	<stream_class>video</stream_class>
	</item>

	<item>
	<title>BBC2</title>
	<stream_url>mms://195.90.118.88/BBC2_1?MSWMExt=.asf</stream_url>
	<annotation>BBC2</annotation>
	<stream_class>video</stream_class>
	</item>

	<item>
	<title>Cielo</title>
	<stream_url>rtmp://cp86825.live.edgefcs.net/live/cielo_std@17630</stream_url>
	<annotation>Cielo</annotation>
	<stream_class>video</stream_class>
	</item>

	<item>
	<title>Sky Tg 24</title>
	<stream_url>rtmp://cp49989.live.edgefcs.net:1935/live?videoId=53404915001&lineUpId=&pubId=1445083406&playerId=760707277001&affiliateId=/streamRM1@2564</stream_url>
	<annotation>Sky Tg 24</annotation>
	<stream_class>video</stream_class>
	</item>

	<item>
	<title>Canale 7</title>
	<stream_url>http://canale7.superstreaming.it/</stream_url>
	<annotation>Canale 7</annotation>
	<stream_class>video</stream_class>
	</item>

	<item>
	<title>QVC</title>
	<stream_url>rtmp://cp107861.live.edgefcs.net/live/QVC_Italy_Stream1200@34577</stream_url>
	<annotation>QVC</annotation>
	<stream_class>video</stream_class>
	</item>
	
	<item>
	<title>Videolina</title>
	<stream_url>rtmp://91.121.222.160/videolinalive/videolinalive.sdp</stream_url>
	<annotation>Videolina</annotation>
	<stream_class>video</stream_class>
	</item>

	<item>
	<title>Quararete TV</title>
	<stream_url>rtmp://wowza1.top-ix.org/quartaretetv/quartareteweb</stream_url>
	<annotation>Quararete TV</annotation>
	<stream_class>video</stream_class>
	</item>

	<item>
	<title>RAI SPORT 2</title>
	<stream_url>mms://wms.3BA6.edgecastcdn.net/203BA6/RAI?e=1300996339&h=97c1e4a8ae7329df1b92814a02a62e02&startTime=1300996329&userId=13057&portalId=5&portal=5&channelId=2892&ppvId=24260&mark=9517&source=box&tvRandom=47686498&epgType=live</stream_url>
	<annotation>RAI SPORT 2</annotation>
	<stream_class>video</stream_class>
	</item>

	<item>
	<title>NDR</title>
	<stream_url>mms://ndr-fs-hh-hi-wmv.wm.llnwd.net/ndr_fs_hh_hi_wmv</stream_url>
	<annotation>NDR</annotation>
	<stream_class>video</stream_class>
	</item>

	<item>
	<title>Antena3 Spania</title>
	<stream_url>rtmp://antena3fms35livefs.fplive.net/antena3fms35live-live/stream-antena3.flv</stream_url>
	<annotation>Antena3 Spania</annotation>
	<stream_class>video</stream_class>
	</item>

	<item>
	<title>NASA Space Shuttle Launch</title>
	<stream_url>http://playlist.yahoo.com/makeplaylist.dll?id=1368163</stream_url>
	<annotation>NASA Space Shuttle Launch</annotation>
	<stream_class>video</stream_class>
	</item>
<!-- start edgefcs.net -->
	<item>
	<title>ARD</title>
	<stream_url>rtmp://cp108475.live.edgefcs.net/live/ard_1_800@45494</stream_url>
	<annotation>ARD</annotation>
	<stream_class>video</stream_class>
	</item>

	<item>
	<title>ZDF Neo</title>
	<stream_url>rtmp://cp108475.live.edgefcs.net/live/zdfneo_1_800@44504</stream_url>
	<annotation>ZDF Neo</annotation>
	<stream_class>video</stream_class>
	</item>
	
	<item>
	<title>KiKa</title>
	<stream_url>rtmp://cp108476.live.edgefcs.net/live/kika_1_800@45500</stream_url>
	<annotation>KiKa</annotation>
	<stream_class>video</stream_class>
	</item>
	
	<item>
	<title>SAT 1</title>
	<stream_url>rtmp://cp108475.live.edgefcs.net/live/sat1_1_800@44490</stream_url>
	<annotation>SAT 1</annotation>
	<stream_class>video</stream_class>
	</item>
	
	<item>
	<title>RTL</title>
	<stream_url>rtmp://cp108341.live.edgefcs.net/live/rtl_1_800@43050</stream_url>
	<annotation>RTL</annotation>
	<stream_class>video</stream_class>
	</item>
	
	<item>
	<title>RTL 2</title>
	<stream_url>rtmp://cp108341.live.edgefcs.net/live/rtl2_1_800@43053</stream_url>
	<annotation>RTL 2</annotation>
	<stream_class>video</stream_class>
	</item>
	
	<item>
	<title>PRO 7</title>
	<stream_url>rtmp://cp108341.live.edgefcs.net/live/pro7_1_800@43051</stream_url>
	<annotation>PRO 7</annotation>
	<stream_class>video</stream_class>
	</item>
	
	<item>
	<title>Vox</title>
	<stream_url>rtmp://cp108341.live.edgefcs.net/live/vox_1_800@43052</stream_url>
	<annotation>Vox</annotation>
	<stream_class>video</stream_class>
	</item>
	
	<item>
	<title>Kabel1</title>
	<stream_url>rtmp://cp108341.live.edgefcs.net/live/kabel1_1_800@43055</stream_url>
	<annotation>Kabel1</annotation>
	<stream_class>video</stream_class>
	</item>
	
	<item>
	<title>SuperRTL</title>
	<stream_url>rtmp://cp108475.live.edgefcs.net/live/superrtl_1_800@44489</stream_url>
	<annotation>SuperRTL</annotation>
	<stream_class>video</stream_class>
	</item>
	
	<item>
	<title>ORF1</title>
	<stream_url>rtmp://cp108341.live.edgefcs.net/live/orf1_1_800@43059</stream_url>
	<annotation>ORF1</annotation>
	<stream_class>video</stream_class>
	</item>
	
	<item>
	<title>ORF2</title>
	<stream_url>rtmp://cp108476.live.edgefcs.net/live/orf2_1_800@45502</stream_url>
	<annotation>ORF2</annotation>
	<stream_class>video</stream_class>
	</item>
	
	<item>
	<title>SF1</title>
	<stream_url>rtmp://cp108341.live.edgefcs.net/live/sf1_1_800@43046</stream_url>
	<annotation>SF1</annotation>
	<stream_class>video</stream_class>
	</item>
	
	<item>
	<title>SF2</title>
	<stream_url>rtmp://cp108341.live.edgefcs.net/live/sf2_1_800@43048</stream_url>
	<annotation>SF2</annotation>
	<stream_class>video</stream_class>
	</item>

	<item>
	<title>Tele Zuri</title>
	<stream_url>rtmp://cp108475.live.edgefcs.net/live/telezueri_1_800@44503</stream_url>
	<annotation>Tele Zuri</annotation>
	<stream_class>video</stream_class>
	</item>

	<item>
	<title>DMAX</title>
	<stream_url>rtmp://cp108476.live.edgefcs.net/live/dmax_1_800@45498</stream_url>
	<annotation>DMAX</annotation>
	<stream_class>video</stream_class>
	</item>

	<item>
	<title>3Sat</title>
	<stream_url>rtmp://cp108475.live.edgefcs.net/live/3sat_1_800@45493</stream_url>
	<annotation>3Sat</annotation>
	<stream_class>video</stream_class>
	</item>

	<item>
	<title>Arte</title>
	<stream_url>rtmp://cp108476.live.edgefcs.net/live/arte_1_800@45495</stream_url>
	<annotation>Arte</annotation>
	<stream_class>video</stream_class>
	</item>

	<item>
	<title>Arte francais</title>
	<stream_url>rtmp://cp108478.live.edgefcs.net/live/arte_fr_1_800@45512</stream_url>
	<annotation>Arte francais</annotation>
	<stream_class>video</stream_class>
	</item>
	
	<item>
	<title>Sixx</title>
	<stream_url>rtmp://cp108478.live.edgefcs.net/live/sixx_1_800@45516</stream_url>
	<annotation>Sixx</annotation>
	<stream_class>video</stream_class>
	</item>
	
	<item>
	<title>Nickelodeon</title>
	<stream_url>rtmp://cp108478.live.edgefcs.net/live/nick_cc_1_800@45519</stream_url>
	<annotation>Nickelodeon</annotation>
	<stream_class>video</stream_class>
	</item>
	
	<item>
	<title>Sport1</title>
	<stream_url>rtmp://cp108478.live.edgefcs.net/live/sport1_1_800@45517</stream_url>
	<annotation>Sport1</annotation>
	<stream_class>video</stream_class>
	</item>
	
	<item>
	<title>Eurosport 1</title>
	<stream_url>rtmp://cp108478.live.edgefcs.net/live/eurosport_1_800@45515</stream_url>
	<annotation>Eurosport 1</annotation>
	<stream_class>video</stream_class>
	</item>
	
	<item>
	<title>tv5 monde</title>
	<stream_url>rtmp://cp108478.live.edgefcs.net/live/tv5monde_1_800@45511</stream_url>
	<annotation>tv5 monde</annotation>
	<stream_class>video</stream_class>
	</item>
	
	<item>
	<title>France 2</title>
	<stream_url>rtmp://cp108476.live.edgefcs.net/live/france2_1_800@45496</stream_url>
	<annotation>France 2</annotation>
	<stream_class>video</stream_class>
	</item>
	
	<item>
	<title>France 3</title>
	<stream_url>rtmp://cp108476.live.edgefcs.net/live/france3_1_800@45499</stream_url>
	<annotation>France 3</annotation>
	<stream_class>video</stream_class>
	</item>
	
	<item>
	<title>France 5</title>
	<stream_url>rtmp://cp108476.live.edgefcs.net/live/france5_1_800@45501</stream_url>
	<annotation>France 5</annotation>
	<stream_class>video</stream_class>
	</item>

	<item>
	<title>CNN</title>
	<stream_url>rtmp://cp108476.live.edgefcs.net/live/cnn_1_800@45497</stream_url>
	<annotation>CNN</annotation>
	<stream_class>video</stream_class>
	</item>
	
	<item>
	<title>RSI LA1</title>
	<stream_url>rtmp://cp108478.live.edgefcs.net/live/rsila1_1_800@45513</stream_url>
	<annotation>RSI LA1</annotation>
	<stream_class>video</stream_class>
	</item>
	
	<item>
	<title>RSI LA2</title>
	<stream_url>rtmp://cp108478.live.edgefcs.net/live/rsila2_1_800@45514</stream_url>
	<annotation>RSI LA2</annotation>
	<stream_class>video</stream_class>
	</item>

	<item>
	<title>RAI UNO</title>
	<stream_url>rtmp://cp108475.live.edgefcs.net/live/rai1_1_800@44470</stream_url>
	<annotation>RAI UNO</annotation>
	<stream_class>video</stream_class>
	</item>
<!-- end edgefcs.net -->
	<item>
	<title>hr fernsehen</title>
	<stream_url>rtmp://gffstream.fc.llnwd.net/gffstream/005/hr-fernsehen-1</stream_url>
	<annotation>hr fernsehen</annotation>
	<stream_class>video</stream_class>
	</item>
	
	<item>
	<title>Video  BR-Mediathek</title>
	<stream_url>rtmp://cp121359.live.edgefcs.net:1935/live/b7_bfssued_m@49987</stream_url>
	<annotation>Video  BR-Mediathek</annotation>
	<stream_class>video</stream_class>
	</item>
<!-- new UK -->
	<item>
	<title>BBC1</title>
	<stream_url>http://93.184.223.134:80/203BA6/BBC1</stream_url>
	<annotation>BBC1</annotation>
	<stream_class>video</stream_class>
	</item>
	<item>
	<title>BBC2</title>
	<stream_url>http://wms.3BA6.edgecastcdn.net/203BA6/BBC2?e=1302604063&h=e6d2bef3b7ae51cca5c96362b4a291f4&startTime=1302604053&userId=13194&portalId=5&portal=5&channelId=2628&ppvId=19839&mark=4006&source=box&epgType=live</stream_url>
	<annotation>BBC2</annotation>
	<stream_class>video</stream_class>
	</item>
	<item>
	<title>BBC3</title>
	<stream_url>http://93.184.223.134:80/203BA6/BBC3</stream_url>
	<annotation>BBC3</annotation>
	<stream_class>video</stream_class>
	</item>
	<item>
	<title>ITV1</title>
	<stream_url>http://93.184.223.134:80/203BA6/ITV1?e=1302562262&h=5838b10b68653ee968cafcba15c05391&startTime=1302562252&userId=13194&portalId=5&portal=5&channelId=2629&ppvId=19840&mark=3763&source=box&epgType=live&MSWMExt=.asf</stream_url>
	<annotation>ITV1</annotation>
	<stream_class>video</stream_class>
	</item>
	<item>
	<title>ITV2</title>
	<stream_url>http://93.184.223.134:80/203BA6/ITV2?e=1302563922&h=82dfff068946a457d0fa0259c09fea6c&startTime=1302563912&userId=13194&portalId=5&portal=5&channelId=2632&ppvId=19850&mark=6649&source=box&epgType=live&MSWMExt=.asf</stream_url>
	<annotation>ITV2</annotation>
	<stream_class>video</stream_class>
	</item>
	<item>
	<title>ITV3</title>
	<stream_url>http://93.184.223.134:80/203BA6/ITV3?e=1302602282&h=3d2ba17c6b4e7c109b200356fcd26a1f&startTime=1302602272&userId=13194&portalId=5&portal=5&channelId=2633&ppvId=19851&mark=2671&source=box&epgType=live&MSWMExt=.asf</stream_url>
	<annotation>ITV3</annotation>
	<stream_class>video</stream_class>
	</item>
	<item>
	<title>E4</title>
	<stream_url>http://93.184.223.134:80/203BA6/E4</stream_url>
	<annotation>E4</annotation>
	<stream_class>video</stream_class>
	</item>
	<item>
	<title>FILM 4</title>
	<stream_url>http://wms.3ba6.edgecastcdn.net/203BA6/FILM4?e=1302562882&h=5c179fc2fc31f42272e16f7d7ebc224c&startTime=1302562872&userId=13194&portalId=5&portal=5&channelId=2637&ppvId=19855&mark=6932&source=box&epgType=live</stream_url>
	<annotation>FILM 4</annotation>
	<stream_class>video</stream_class>
	</item>
	<item>
	<title>Channel 4</title>
	<stream_url>mms://wms.3BA6.edgecastcdn.net/203BA6/CH4?e=1302532635&h=eba04ddbf1f069a085d7a026e69e6932&startTime=1302532625&userId=13194&portalId=5&portal=5&channelId=2627&ppvId=19841&mark=3326&source=box&epgType=live/Channel%204</stream_url>
	<annotation>Channel 4</annotation>
	<stream_class>video</stream_class>
	</item>
	<item>
	<title>Channel 5</title>
	<stream_url>http://93.184.223.134:80/203BA6/CH5?e=1302563233&h=c80b8a2fc2f406a447f622746823edb4&startTime=1302563223&userId=13194&portalId=5&portal=5&channelId=2631&ppvId=19842&mark=2170&source=box&epgType=live&MSWMExt=.asf</stream_url>
	<annotation>Channel 5</annotation>
	<stream_class>video</stream_class>
	</item>
	<item>
	<title>BBC News</title>
	<stream_url>rtsp://wms.3BA6.edgecastcdn.net/203BA6/bbcnews</stream_url>
	<annotation>BBC News</annotation>
	<stream_class>video</stream_class>
	</item>
<!-- end new uk -->
	<item>
	<title>LCP</title>
	<stream_url>rtmp://stream2.lcp.yacast.net/lcp_live/lcptnt</stream_url>
	<annotation>LCP</annotation>
	<stream_class>video</stream_class>
	</item>
<!--
    <item>
	<title>BBC1</title>
	<stream_url>mms://verytangy-653-400102.wm.llnwd.net/verytangy_653-400102?e=1297124432&h=f3dadefd07f4765b93e74298c277d29b&startTime=1297124422&userId=13194&portalId=5&portal=5&channelId=2627&ppvId=19838&mark=4024&source=box&epgType=live</stream_url>
	<annotation>BBC1</annotation>
	<stream_class>video</stream_class>
	</item>
	<item>
	<title>BBC2</title>
	<stream_url>mms://verytangy-654-400103.wm.llnwd.net/verytangy_654-400103?e=1297124569&h=55bed855bacf48ce2a90e08a520ae00c&startTime=1297124559&userId=13194&portalId=5&portal=5&channelId=2627&ppvId=19839&mark=8585&source=box&epgType=live</stream_url>
	<annotation>BBC2</annotation>
	<stream_class>video</stream_class>
	</item>
	<item>
	<title>BBC3</title>
	<stream_url>mms://verytangy-671-403113.wm.llnwd.net/verytangy_671-403113</stream_url>
	<annotation>BBC3</annotation>
	<stream_class>video</stream_class>
	</item>
	
	<item>
	<title>Film 4</title>
	<stream_url>mms://verytangy-664-404364.wm.llnwd.net/verytangy_664-404364?e=1297330200&h=e6ea29a1dceba38dc84abce185d938d6&startTime=1297330190&userId=13194&portalId=5&portal=5&channelId=2627&ppvId=19855&mark=8181&source=box&epgType=live</stream_url>
	<annotation>Film 4</annotation>
	<stream_class>video</stream_class>
	</item>

	<item>
	<title>Channel 4</title>
	<stream_url>mms://verytangy-656-400105.wm.llnwd.net/verytangy_656-400105?e=1296946762&h=31a2395e03e96cf62c940c79edda93a6&startTime=1296946752&userId=13194&portalId=5&portal=5&channelId=2627&ppvId=19841&mark=7458&source=box&epgType=live</stream_url>
	<annotation>Channel 4</annotation>
	<stream_class>video</stream_class>
	</item>
	
	<item>
	<title>ITV1</title>
	<stream_url>mms://verytangy-655-400104.wm.llnwd.net/verytangy_655-400104?e=1297330397&h=1ca240e9e36aa7248098b3f9428880e6&startTime=1297330387&userId=13194&portalId=5&portal=5&channelId=2627&ppvId=19840&mark=6834&source=box&epgType=live</stream_url>
	<annotation>ITV1</annotation>
	<stream_class>video</stream_class>
	</item>

	<item>
	<title>ITV2</title>
	<stream_url>mms://verytangy-659-404326.wm.llnwd.net/verytangy_659-404326?e=1297125524&h=823cdd5a345eeee67e20eae1ba211d15&startTime=1297125514&userId=13194&portalId=5&portal=5&channelId=2627&ppvId=19850&mark=7930&source=box&epgType=live</stream_url>
	<annotation>ITV2</annotation>
	<stream_class>video</stream_class>
	</item>

	<item>
	<title>CBBC</title>
	<stream_url>mms://verytangy-668-404404.wm.llnwd.net/verytangy_668-404404</stream_url>
	<annotation>CBBC</annotation>
	<stream_class>video</stream_class>
	</item>

	<item>
	<title>5</title>
	<stream_url>mms://verytangy-657-400685.wm.llnwd.net/verytangy_657-400685/rtx</stream_url>
	<annotation>5</annotation>
	<stream_class>video</stream_class>
	</item>

	<item>
	<title>E4</title>
	<stream_url>mms://verytangy-663-404346.wm.llnwd.net/verytangy_663-404346</stream_url>
	<annotation>E4</annotation>
	<stream_class>video</stream_class>
	</item>
	-->
</channel>
</rss>
