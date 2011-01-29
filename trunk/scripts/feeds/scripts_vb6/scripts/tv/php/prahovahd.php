<?php echo '<?xml version="1.0" encoding="UTF8" ?>';
$host = "http://127.0.0.1:82";
?>
<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/">
	<script>
  translate_base_url  = "http://127.0.0.1:83/cgi-bin/translate?";

  storagePath             = getStoragePath("tmp");
  storagePath_stream      = storagePath + "stream.dat";
  
  error_info          = "";
</script>
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
	popupXPC = "40"
  popupYPC = "55"
  popupWidthPC = "22.3"
  popupHeightPC = "5.5"
  popupFontSize = "13"
	popupBorderColor="28:35:51" 
	popupForegroundColor="255:255:255"
 	popupBackgroundColor="28:35:51"
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
		<text  offsetXPC=40 offsetYPC=8 widthPC=35 heightPC=10 fontSize=20 backgroundColor=-1:-1:-1 foregroundColor=255:255:255>
  OneHD - playlist
		</text>
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
<channel>
	<title>OneHD</title>
	<menu>main menu</menu>

<?php
function str_between($string, $start, $end){ 
	$string = " ".$string; $ini = strpos($string,$start); 
	if ($ini == 0) return ""; $ini += strlen($start); $len = strpos($string,$end,$ini) - $ini; 
	return substr($string,$ini,$len); 
}
//http://live.1hd.ro/playlist.php
$url="http://live.1hd.ro";
$file = get_headers($url);
foreach ($file as $key => $value)
   {
    if (strstr($value,"Set-Cookie"))
     {
      $cookie = ltrim($value,"Set-Cookie: ");
     } // end if
   } // end foreach
$url = "http://live.1hd.ro/playlist.php";
// Create a stream
$opts = array(
  'http'=>array(
    'method'=>"GET",
    'header'=>"Accept-language: en\r\n" .
              "Cookie: ".$cookie."\r\n"
  )
);

$context = stream_context_create($opts);
$html = file_get_contents($url, false, $context);
$videos = explode('<track>', $html);
unset($videos[0]);
$videos = array_values($videos);
foreach($videos as $video) {
    $server = str_between($video,'<meta rel="streamer">','</meta>');
    $link = $server.str_between($video,"<location>","</location>");
    //$link = str_replace(' ','%20',$link);
    $title = str_between($video,"<title>","</title>");
    
    echo '<item>';
    echo '<title>'.$title.'</title>';
    echo '<ext>mp4</ext>';
    echo '<protocol>rtmp</protocol>';
    echo '<location>'.$link.'</location>';
    echo '<stream_url>'.$link.'</stream_url>';
    echo '<stream_class>video</stream_class>
    <stream_soft/>
    <stream_server/>
    <stream_type>video/mp4</stream_type>
    <stream_protocol>rtmp</stream_protocol>
  </item>';	
  print "\n";
}
?>
</channel>
</rss>
