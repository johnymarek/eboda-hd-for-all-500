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
  <audioDispatcher>
    streamArray = null;
    streamArray = pushBackStringArray(streamArray, request_url);
    streamArray = pushBackStringArray(streamArray, request_options);
    streamArray = pushBackStringArray(streamArray, stream_url);
    streamArray = pushBackStringArray(streamArray, url);
    streamArray = pushBackStringArray(streamArray, stream_type);
    streamArray = pushBackStringArray(streamArray, stream_status_url);
    streamArray = pushBackStringArray(streamArray, stream_current_song);
    streamArray = pushBackStringArray(streamArray, stream_genre);
    streamArray = pushBackStringArray(streamArray, stream_bitrate);
    streamArray = pushBackStringArray(streamArray, stream_title);
    streamArray = pushBackStringArray(streamArray, "1");
    writeStringToFile(storagePath_stream, streamArray);
    doModalRss("rss_file://./rss/xspf/audioRenderer.rss");
  </audioDispatcher>
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
    doModalRss("rss_file:///scripts/rss/xspf/videoRenderer.rss");
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
	<title>TV Live - Muzica</title>
	<menu>main menu</menu>

<!-- fms.xxx.net -->	
	<item>
	<title>Virgin TV</title>
	<stream_url>rtmp://fms.105.net:1935/live/virgin1</stream_url>
	<annotation>Virgin TV</annotation>
	<stream_class>video</stream_class>
	</item>

	<item>
	<title>Top 40</title>
	<stream_url>rtmp://fms.105.net:1935/live/charts1</stream_url>
	<annotation>Top 40</annotation>
	<stream_class>video</stream_class>
	</item>
	
	<item>
	<title>Italy TV</title>
	<stream_url>rtmp://fms.105.net:1935/live/italytv1</stream_url>
	<annotation>Italy TV</annotation>
	<stream_class>video</stream_class>
	</item>
	
	<item>
	<title>Legend</title>
	<stream_url>rtmp://fms.105.net:1935/live/legend1</stream_url>
	<annotation>Legend</annotation>
	<stream_class>video</stream_class>
	</item>
	
	<item>
	<title>Radio 105 TV</title>
	<stream_url>rtmp://fms.105.net:1935/live/105Test1</stream_url>
	<annotation>Radio 105 TV</annotation>
	<stream_class>video</stream_class>
	</item>

	<item>
	<title>Radio Monte Carlo</title>
	<stream_url>rtmp://fms.105.net:1935/live/rmc1</stream_url>
	<annotation>Radio Monte Carlo</annotation>
	<stream_class>video</stream_class>
	</item>

<!-- end fms.xxx.net -->
<!--  -->
	<item>
	<title>VIVA</title>
	<stream_url>rtmp://80.94.85.180/live/stream22</stream_url>
	<annotation>VIVA</annotation>
	<stream_class>video</stream_class>
	</item>

	<item>
	<title>Music 1</title>
	<stream_url>rtmp://80.94.85.180/live/stream21</stream_url>
	<annotation>Music 1</annotation>
	<stream_class>video</stream_class>
	</item>
<!-- -->			
	<item>
	<title>DeeJay TV</title>
	<stream_url>http://wm.streaming.kataweb.it/reflector:40004</stream_url>
	<annotation>DeeJay TV</annotation>
	<stream_class>video</stream_class>
	</item>

	<item>
	<title>1 Music</title>
	<stream_url>rtmp://80.232.172.37/rtplive/vlc.sdp</stream_url>
	<annotation>1 Music</annotation>
	<stream_class>video</stream_class>
	</item>
	
	<item>
	<title>Rock One TV</title>
	<stream_url>http://mediatv2.topix.it/24RockOne66</stream_url>
	<annotation>Rock One TV</annotation>
	<stream_class>video</stream_class>
	</item>

	<item>
	<title>Clap Tv</title>
	<stream_url>mms://rr93.diffusepro.com/rr93</stream_url>
	<annotation>Clap TV</annotation>
	<stream_class>video</stream_class>
	</item>

	<item>
	<title>Soleil TV</title>
	<stream_url>mms://live240.impek.com/soleiltv?MSWMExt=.asf</stream_url>
	<annotation>Soleil TV</annotation>
	<stream_class>video</stream_class>
	</item>

	<item>
	<title>Music Box</title>
	<stream_url>mms://81.89.49.210/musicbox</stream_url>
	<annotation>MusicBox</annotation>
	<stream_class>video</stream_class>
	</item>

	<item>
	<title>Dance TV</title>
	<stream_url>mms://stream02.gtk.hu/dance_tvd</stream_url>
	<annotation>Dance TV</annotation>
	<stream_class>video</stream_class>
	</item>

	<item>
	<title>HIP HOP TV</title>
	<stream_url>mms://93.152.172.201/hiphoptv</stream_url>
	<annotation>HIP HOP TV</annotation>
	<stream_class>video</stream_class>
	</item>

	<item>
	<title>Spirit Television</title>
	<stream_url>mms://nyc04.egihosting.com/839181</stream_url>
	<annotation>Spirit Television</annotation>
	<stream_class>video</stream_class>
	</item>

	<item>
	<title>StreetClip TV</title>
	<stream_url>mms://85.214.55.57:1234</stream_url>
	<annotation>StreetClip TV</annotation>
	<stream_class>video</stream_class>
	</item>

	<item>
	<title>Labelle TV</title>
	<stream_url>rtsp://www.labelletv.com/labelletv</stream_url>
	<annotation>Labelle TV</annotation>
	<stream_class>video</stream_class>
	</item>

	<item>
	<title>Mad TV Live TV from Greece</title>
	<stream_url>rtsp://mediaserver.mad.tv/madtv</stream_url>
	<annotation>Mad TV Live TV from Greece</annotation>
	<stream_class>video</stream_class>
	</item>

	<item>
	<title>Ibiza on TV Live TV from Italy</title>
	<stream_url>rtsp://81.174.67.45/ibizaontv</stream_url>
	<annotation>Ibiza on TV Live TV from Italy</annotation>
	<stream_class>video</stream_class>
	</item>
	
	<item>
	<title>Jungle TV Live TV from Macedonia</title>
	<stream_url>rtsp://62.162.58.41/JUNGLE_TV</stream_url>
	<annotation>Jungle TV Live TV from Macedonia</annotation>
	<stream_class>video</stream_class>
	</item>

<!-- 08.05.2011 -->
	<item>
	<title>La Locale</title>
	<stream_url>rtsp://stream.lalocale.com/lalocale</stream_url>
	<annotation>La Locale</annotation>
	<stream_class>video</stream_class>
	</item>

	<item>
	<title>Bridge TV</title>
	<stream_url>http://89.232.125.188:3532/stream.flv</stream_url>
	<annotation>Bridge TV</annotation>
	<stream_class>video</stream_class>
	</item>

	<item>
	<title>Play TV</title>
	<stream_url>rtsp://93.103.4.16/playtv</stream_url>
	<annotation>Play TV</annotation>
	<stream_class>video</stream_class>
	</item>
			
</channel>
</rss>
