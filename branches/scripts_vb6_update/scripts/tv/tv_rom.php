<?php echo "<?xml version='1.0' encoding='UTF8' ?>";
$host = "http://127.0.0.1:82";
?>
<rss version="2.0">

<!--
#
#   http://code.google.com/media-translate/
#   Copyright (C) 2010  Serge A. Timchenko
#
#   This program is free software: you can redistribute it and/or modify
#   it under the terms of the GNU General Public License as published by
#   the Free Software Foundation, either version 3 of the License, or
#   (at your option) any later version.
#
#   This program is distributed in the hope that it will be useful,
#   but WITHOUT ANY WARRANTY; without even the implied warranty of
#   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
#   GNU General Public License for more details.
#
#   You should have received a copy of the GNU General Public License
#   along with this program. If not, see <http://www.gnu.org/licenses/>.
#
-->

<script>
  translate_base_url  = "http://127.0.0.1:82/scripts/cgi-bin/translate?";

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
	itemWidthPC="48"
	itemHeightPC="8"
	capXPC="8"
	capYPC="25"
	capWidthPC="48"
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

		<text align="justify" redraw="yes" 
          lines="14" fontSize=14
		      offsetXPC=55 offsetYPC=25 widthPC=40 heightPC=60 
		      backgroundColor=10:80:120 foregroundColor=200:200:200>
			<script>print(annotation); annotation;</script>
		</text>
		
		<text align="center" redraw="yes" offsetXPC=55 offsetYPC=85 widthPC=40 heightPC=5 fontSize=13 backgroundColor=10:80:120 foregroundColor=0:0:0>
			<script>print(location); location;</script>
		</text>

		<text align="center" redraw="yes" offsetXPC=55 offsetYPC=90 widthPC=40 heightPC=5 fontSize=13 backgroundColor=0:0:0 foregroundColor=200:80:80>
			<script>if(streamurl==""||streamurl==null) "WARNING! No stream url."; else "";</script>
		</text>

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
					  if(annotation == "" || annotation == null)
					    annotation = getItemInfo(idx, "stream_genre");
					  streamurl = getItemInfo(idx, "stream_url");
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
  
  <playlistDispatcher>
    streamArray = null;
    streamArray = pushBackStringArray(streamArray, stream_url);
    streamArray = pushBackStringArray(streamArray, stream_url);
    streamArray = pushBackStringArray(streamArray, "");
    streamArray = pushBackStringArray(streamArray, "");
    streamArray = pushBackStringArray(streamArray, "playlist");
    streamArray = pushBackStringArray(streamArray, "1");
    writeStringToFile(storagePath_playlist, streamArray);
    doModalRss("rss_file://./rss/xspf/xspfBrowser.rss");
  </playlistDispatcher>
  
  <rssDispatcher>
    streamArray = null;
    streamArray = pushBackStringArray(streamArray, stream_url);
    streamArray = pushBackStringArray(streamArray, stream_url);
    streamArray = pushBackStringArray(streamArray, "");
    streamArray = pushBackStringArray(streamArray, "");
    writeStringToFile(storagePath_stream, streamArray);
    doModalRss("rss_file://./rss/xspf/rss_mediaFeed.rss");
  </rssDispatcher>

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
  <title>TV Romania</title>
  <item>
    <title>Neptun TV</title>
    <ext>ro</ext>
    <protocol>mms</protocol>
    <location>mms://77.36.61.4:8081/Neptun%20TV</location>
    <stream_url>mms://77.36.61.4:8081/Neptun%20TV</stream_url>
    <stream_class>video</stream_class>
    <stream_soft/>
    <stream_server/>
    <stream_type>video/x-msvideo</stream_type>
    <stream_protocol>mms</stream_protocol>
  </item>
  <item>
    <title>Kiss TV</title>
    <ext>ro</ext>
    <protocol>mms</protocol>
    <location>mms://77.36.61.133:8071/Kiss%20TV</location>
    <stream_url>mms://77.36.61.133:8071/Kiss%20TV</stream_url>
    <stream_class>video</stream_class>
    <stream_soft/>
    <stream_server/>
    <stream_type>video/x-msvideo</stream_type>
    <stream_protocol>mms</stream_protocol>
  </item>
  <item>
    <title>Alpha Media</title>
    <ext>ro</ext>
    <protocol>mms</protocol>
    <location>mms://77.36.61.158:7061/Alpha%20Media</location>
    <stream_url>mms://77.36.61.158:7061/Alpha%20Media</stream_url>
    <stream_class>video</stream_class>
    <stream_soft/>
    <stream_server/>
    <stream_type>video/x-msvideo</stream_type>
    <stream_protocol>mms</stream_protocol>
  </item>
  <item>
    <title>ELTH TV</title>
    <ext>ro</ext>
    <protocol>mms</protocol>
    <location>mms://89.33.60.137:8081/ELTH%20TV</location>
    <stream_url>mms://89.33.60.137:8081/ELTH%20TV</stream_url>
    <stream_class>video</stream_class>
    <stream_soft/>
    <stream_server/>
    <stream_type>video/x-msvideo</stream_type>
    <stream_protocol>mms</stream_protocol>
  </item>
  <item>
    <title>Fresh Art TV</title>
    <ext>ro</ext>
    <protocol>mms</protocol>
    <location>mms://77.36.61.144:8081/Fresh%20Art%20TV</location>
    <stream_url>mms://77.36.61.144:8081/Fresh%20Art%20TV</stream_url>
    <stream_class>video</stream_class>
    <stream_soft/>
    <stream_server/>
    <stream_type>video/x-msvideo</stream_type>
    <stream_protocol>mms</stream_protocol>
  </item>
   <item>
    <title>TV NGOs</title>
    <ext>ro</ext>
    <protocol>mms</protocol>
    <location>mms://77.36.61.6:8081/TV%20NGOs</location>
    <stream_url>mms://77.36.61.6:8081/TV%20NGOs</stream_url>
    <stream_class>video</stream_class>
    <stream_soft/>
    <stream_server/>
    <stream_type>video/x-msvideo</stream_type>
    <stream_protocol>mms</stream_protocol>
  </item>
  <item>
    <title>TV Natura</title>
    <ext>ro</ext>
    <protocol>mms</protocol>
    <location>mms://77.36.61.4:8091/TV%20Natura</location>
    <stream_url>mms://77.36.61.4:8091/TV%20Natura</stream_url>
    <stream_class>video</stream_class>
    <stream_soft/>
    <stream_server/>
    <stream_type>video/x-msvideo</stream_type>
    <stream_protocol>mms</stream_protocol>
  </item>
  <item>
    <title>TVR Info</title>
    <ext>ro</ext>
    <protocol>rtmpe</protocol>
    <location>rtmpe://fms8.mediadirect.ro:1935/live/tvrinfo?id=1676684/tvrinfo</location>
    <stream_url>rtmpe://fms8.mediadirect.ro:1935/live/tvrinfo?id=1676684/tvrinfo</stream_url>
    <stream_class>video</stream_class>
    <stream_soft/>
    <stream_server/>
    <stream_type>video/x-msvideo</stream_type>
    <stream_protocol>rtmpe</stream_protocol>
  </item>
  <item>
    <title>Tele Sport</title>
    <ext>ro</ext>
    <protocol>mms</protocol>
    <location>mms://194.169.235.98/384x</location>
    <stream_url>mms://194.169.235.98/384x</stream_url>
    <stream_class>video</stream_class>
    <stream_soft/>
    <stream_server/>
    <stream_type>video/x-msvideo</stream_type>
    <stream_protocol>mms</stream_protocol>
  </item>
  <item>
    <title>Antena 2</title>
    <ext>ro</ext>
    <protocol>mms</protocol>
    <location>mms://86.55.8.134/ant2</location>
    <stream_url>mms://86.55.8.134/ant2</stream_url>
    <stream_class>video</stream_class>
    <stream_soft/>
    <stream_server/>
    <stream_type>video/x-msvideo</stream_type>
    <stream_protocol>mms</stream_protocol>
  </item>
   <item>
    <title>1 TV Neamt</title>
    <ext>ro</ext>
    <protocol>http</protocol>
    <location>http://1tv.ambra.ro</location>
    <stream_url>http://1tv.ambra.ro</stream_url>
    <stream_class>video</stream_class>
    <stream_soft/>
    <stream_server/>
    <stream_type>video/x-msvideo</stream_type>
    <stream_protocol>http</stream_protocol>
  </item>
  <item>
    <title>Alfa Omega Tv</title>
    <ext>ro</ext>
    <protocol>mms</protocol>
    <location>mms://ns.alfanet.ro/live</location>
    <stream_url>mms://ns.alfanet.ro/live</stream_url>
    <stream_class>video</stream_class>
    <stream_soft/>
    <stream_server/>
    <stream_type>video/x-msvideo</stream_type>
    <stream_protocol>mms</stream_protocol>
  </item>
  <item>
    <title>Alfa Omega Crestin Tv</title>
    <ext>ro</ext>
    <protocol>mms</protocol>
    <location>mms://ns.alfanet.ro/CrestinTv</location>
    <stream_url>mms://ns.alfanet.ro/CrestinTv</stream_url>
    <stream_class>video</stream_class>
    <stream_soft/>
    <stream_server/>
    <stream_type>video/x-msvideo</stream_type>
    <stream_protocol>mms</stream_protocol>
  </item>
  <item>
    <title>Alfa Omega Movies</title>
    <ext>ro</ext>
    <protocol>mms</protocol>
    <location>mms://ns.alfanet.ro/AlfaOmegaMovies</location>
    <stream_url>mms://ns.alfanet.ro/AlfaOmegaMovies</stream_url>
    <stream_class>video</stream_class>
    <stream_soft/>
    <stream_server/>
    <stream_type>video/x-msvideo</stream_type>
    <stream_protocol>mms</stream_protocol>
  </item>
  <item>
    <title>Alfa Omega Youth Tv</title>
    <ext>ro</ext>
    <protocol>mms</protocol>
    <location>mms://ns.alfanet.ro/YouthTv</location>
    <stream_url>mms://ns.alfanet.ro/YouthTv</stream_url>
    <stream_class>video</stream_class>
    <stream_soft/>
    <stream_server/>
    <stream_type>video/x-msvideo</stream_type>
    <stream_protocol>mms</stream_protocol>
  </item>
  <item>
    <title>TV M</title>
    <ext>ro</ext>
    <protocol>http</protocol>
    <location>http://tvm.ambra.ro</location>
    <stream_url>http://tvm.ambra.ro</stream_url>
    <stream_class>video</stream_class>
    <stream_soft/>
    <stream_server/>
    <stream_type>video/x-msvideo</stream_type>
    <stream_protocol>http</stream_protocol>
  </item>
  <item>
    <title>TV Samtel</title>
    <ext>ro</ext>
    <protocol>http</protocol>
    <location>http://www.tv1samtel.ro:8080/stream.flv</location>
    <stream_url>http://www.tv1samtel.ro:8080/stream.flv</stream_url>
    <stream_class>video</stream_class>
    <stream_soft/>
    <stream_server/>
    <stream_type>video/x-flv</stream_type>
    <stream_protocol>http</stream_protocol>
  </item>
  <item>
    <title>Tele M</title>
    <ext>ro</ext>
    <protocol>http</protocol>
    <location>http://telem.telem.ro:8780/telem_live.flv</location>
    <stream_url>http://telem.telem.ro:8780/telem_live.flv</stream_url>
    <stream_class>video</stream_class>
    <stream_soft/>
    <stream_server/>
    <stream_type>video/x-flv</stream_type>
    <stream_protocol>http</stream_protocol>
  </item>
   <item>
    <title>Prahova TV</title>
    <ext>ro</ext>
    <protocol>http</protocol>
    <location>http://89.45.181.51:5000/test.flv</location>
    <stream_url>http://89.45.181.51:5000/test.flv</stream_url>
    <stream_class>video</stream_class>
    <stream_soft/>
    <stream_server/>
    <stream_type>video/x-flv</stream_type>
    <stream_protocol>http</stream_protocol>
  </item>
  <item>
    <title>Tele'M Botosani</title>
    <ext>ro</ext>
    <protocol>mms</protocol>
    <location>mms://195.64.178.23/telem</location>
    <stream_url>mms://195.64.178.23/telem</stream_url>
    <stream_class>video</stream_class>
    <stream_soft/>
    <stream_server/>
    <stream_type>video/x-msvideo</stream_type>
    <stream_protocol>mms</stream_protocol>
  </item>
   <item>
    <title>TV6 Bucuresti</title>
    <ext>ro</ext>
    <protocol>http</protocol>
    <location>http://83.166.193.50:8800/flv-audio-video/</location>
    <stream_url>http://83.166.193.50:8800/flv-audio-video/</stream_url>
    <stream_class>video</stream_class>
    <stream_soft/>
    <stream_server/>
    <stream_type>video/x-msvideo</stream_type>
    <stream_protocol>http</stream_protocol>
  </item>
   <item>
    <title>Baricada TV</title>
    <ext>ro</ext>
    <protocol>http</protocol>
    <location>http://77.36.61.158:7231/Baricada%20TV</location>
    <stream_url>http://77.36.61.158:7231/Baricada%20TV</stream_url>
    <stream_class>video</stream_class>
  </item>
   <item>
    <title>AU_Channel 7</title>
    <ext>ro</ext>
    <protocol>http</protocol>
    <location>http://77.36.61.158:7131/AU_Channel%207</location>
    <stream_url>http://77.36.61.158:7131/AU_Channel%207</stream_url>
    <stream_class>video</stream_class>
  </item>
   <item>
    <title>Publika TV</title>
    <ext>ro</ext>
    <protocol>http</protocol>
    <location>http://77.36.61.36:8081/Publika%20TV</location>
    <stream_url>http://77.36.61.36:8081/Publika%20TV</stream_url>
    <stream_class>video</stream_class>
  </item>
   <item>
    <title>DDTV</title>
    <ext>ro</ext>
    <protocol>http</protocol>
    <location>http://77.36.61.132:8091/DDTV</location>
    <stream_url>http://77.36.61.132:8091/DDTV</stream_url>
    <stream_class>video</stream_class>
  </item>
   <item>
    <title>Jurnal TV - Rep. Moldova</title>
    <ext>ro</ext>
    <protocol>http</protocol>
    <location>http://ch0.jurnaltv.md/channel0.flv</location>
    <stream_url>http://ch0.jurnaltv.md/channel0.flv</stream_url>
    <stream_class>video</stream_class>
  </item>  
</channel>
</rss>
