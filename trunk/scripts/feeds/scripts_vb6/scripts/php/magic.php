﻿<?php
$link = $_GET["id"];
?>
<?php echo "<?xml version='1.0' ?>"; ?>
<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/">

<script>
      storagePath = getStoragePath("tmp");
      storagePath = storagePath + "VideoPlay.dat";
      showLoading = 0;
</script>

<onEnter>
    setRefreshTime(200);
    startVideo = 1;

    xmlurl = "http://127.0.0.1/cgi-bin/translate.vb6?status,,<?php echo $link; ?>";
    dlok = loadXMLFile(xmlurl);
    if (dlok != null)
    {
    serv_status = getXMLText("info", "status", "server-status");
    serv_str_status = getXMLText("info", "status", "stream-status");
    serv_peak = getXMLText("info", "status", "listener-peak");
    serv_peak_max = getXMLText("info", "status", "listeners");
    serv_curr_song = getXMLText("info", "status", "current-song");
    serv_str_title = getXMLText("info", "status", "stream-title");
    serv_str_genre = getXMLText("info", "status", "stream-genre");
    serv_str_bitrt = getXMLText("info", "status", "stream-bitrate");
    print("Status = ", serv_str_status);
    }
</onEnter>

<onRefresh>
      vidProgress = getPlaybackStatus();
      bufProgress = getCachedStreamDataSize(0, 262144);
      playElapsed = getStringArrayAt(vidProgress, 0);
      playStatus = getStringArrayAt(vidProgress, 3);
      print("Video status !!!!", vidProgress);

      if (startVideo == 1) {
          print("I am moviePlayback onEnter !! startVideo: ", startVideo);
	  content = "http://127.0.0.1/cgi-bin/wmv?<?php echo $link; ?>";
          playItemURL(content, 0, "mediaDisplay", "previewWindow");
          setRefreshTime(1000);
          showLoading = 1;
          startVideo = 0;
          updatePlaybackProgress(bufProgress, "mediaDisplay", "progressBar");
      } else {
          if (playElapsed != 0) {
              if (startVideo == 0) {
                  updatePlaybackProgress(bufProgress, "mediaDisplay", "progressBar");
		  print ("Wanted to delete progress bar, but didn't");
                  startVideo = 2;
              }
          } else if (playStatus == 0) {
              print("Video quit, return!");
              postMessage("return");
          }
          else {
              print("no playing yet, update buffer progress ", bufProgress);
              updatePlaybackProgress(bufProgress, "mediaDisplay", "progressBar");
          }
       }
       if (startVideo == 2) {
       setRefreshTime(30000);
       print ("Updating song title and listeners");
       showLoading = 0;
       xmlurl = "http://127.0.0.1/cgi-bin/translate.vb6?status,,<?php echo $link; ?>";
       dlok = loadXMLFile(xmlurl);
       if (dlok != null)
        {
        serv_curr_song = getXMLText("info", "status", "current-song");
	serv_peak_max = getXMLText("info", "status", "listeners");
	serv_str_status = getXMLText("info", "status", "stream-status");
	}
        updatePlaybackProgress(bufProgress, "mediaDisplay", "progressBar");
       }
</onRefresh>

<onExit>
      playItemURL(-1, 1);
      setRefreshTime(-1);
</onExit>

<mediaDisplay name=threePartsView 
idleImageXPC=80
idleImageYPC=80
idleImageWidthPC=10
idleImageHeightPC=10>
<!-- X -- Y || -->
    <previewWindow windowColor=8:8:15 offsetXPC=45 offsetYPC=25 widthPC=1 heightPC=1>
    </previewWindow>

    <progressBar backgroundColor=-1:-1:-1, offsetXPC=0, offsetYPC=30, widthPC=100, heightPC=55>
<!--	<bar offsetXPC=10, offsetYPC=75, widthPC=60, heightPC=4, barColor=200:200:200, progressColor=26:129:211, bufferColor=-1:-1:-1/> -->
	<text offsetXPC=5 offsetYPC=10 widthPC=90 heightPC=8 fontSize=13 backgroundColor=-1:-1:-1 foregroundColor=200:200:200>
	 Server Status:
	</text>
	 <text offsetXPC=20 offsetYPC=10 widthPC=90 heightPC=8 fontSize=13 backgroundColor=-1:-1:-1 foregroundColor=200:200:200>
	  <script>
	  serv_status;
	  </script>
	 </text>
	<text offsetXPC=5 offsetYPC=16 widthPC=90 heightPC=8 fontSize=13 backgroundColor=-1:-1:-1 foregroundColor=200:200:200>
	 Stream Status:
	</text>
	 <text offsetXPC=20 offsetYPC=16 widthPC=90 heightPC=8 fontSize=13 backgroundColor=-1:-1:-1 foregroundColor=200:200:200>
	<script>
	 serv_str_status;
	 </script>
	 </text>
	 <text offsetXPC=5 offsetYPC=22 widthPC=90 heightPC=8 fontSize=13 backgroundColor=-1:-1:-1 foregroundColor=200:200:200>
	 Listener-peak:
	</text>
	 <text offsetXPC=20 offsetYPC=22 widthPC=90 heightPC=8 fontSize=13 backgroundColor=-1:-1:-1 foregroundColor=200:200:200>
	<script>
	 serv_peak;
	 </script>
	 </text>
	 <text offsetXPC=5 offsetYPC=28 widthPC=90 heightPC=8 fontSize=13 backgroundColor=-1:-1:-1 foregroundColor=200:200:200>
	 Current song:
	</text>
	 <text offsetXPC=20 offsetYPC=28 widthPC=90 heightPC=8 fontSize=13 backgroundColor=-1:-1:-1 foregroundColor=200:200:200>
	<script>
	 serv_curr_song;
	 </script>
	 </text>
	 <text offsetXPC=5 offsetYPC=34 widthPC=90 heightPC=8 fontSize=13 backgroundColor=-1:-1:-1 foregroundColor=200:200:200>
	 Stream Title:
	</text>
	 <text offsetXPC=20 offsetYPC=34 widthPC=90 heightPC=8 fontSize=13 backgroundColor=-1:-1:-1 foregroundColor=200:200:200>
	<script>
	 serv_str_title;
	 </script>
	 </text>
	 <text offsetXPC=5 offsetYPC=40 widthPC=90 heightPC=8 fontSize=13 backgroundColor=-1:-1:-1 foregroundColor=200:200:200>
	 Genre:
	</text>
	 <text offsetXPC=20 offsetYPC=40 widthPC=90 heightPC=8 fontSize=13 backgroundColor=-1:-1:-1 foregroundColor=200:200:200>
	<script>
	 serv_str_genre;
	 </script>
	 </text>
	 <text offsetXPC=5 offsetYPC=46 widthPC=90 heightPC=8 fontSize=13 backgroundColor=-1:-1:-1 foregroundColor=200:200:200>
	 Bitrate:
	</text>
	 <text offsetXPC=20 offsetYPC=46 widthPC=90 heightPC=8 fontSize=13 backgroundColor=-1:-1:-1 foregroundColor=200:200:200>
	<script>
	 serv_str_bitrt;
	 </script>
	 </text>
	 <text offsetXPC=5 offsetYPC=52 widthPC=90 heightPC=8 fontSize=13 backgroundColor=-1:-1:-1 foregroundColor=200:200:200>
	 Buffer status:
	</text>
	<text offsetXPC=22 offsetYPC=52 widthPC=20 heightPC=8 fontSize=13 backgroundColor=-1:-1:-1 foregroundColor=200:200:200>
	<script>
	        if (playStatus == 2) {
                        showstr = "Playing..";
		} else if (vidProgress != 0) {
			showstr = "Playing..";
		} else {
		        showstr = "Buffering..";
		}
		showstr;
	  </script>
	</text>
	<text  offsetXPC=5 offsetYPC=-1 widthPC=90 heightPC=10 fontSize=20 backgroundColor=0:0:0 foregroundColor=255:255:255>
	Playing:
        </text>
	<text  offsetXPC=20 offsetYPC=-1 widthPC=90 heightPC=10 fontSize=20 backgroundColor=0:0:0 foregroundColor=255:255:255>
	    <script>
	    serv_curr_song;
	    </script>
        </text>
	<bar offsetXPC=34, offsetYPC=55, widthPC=40, heightPC=2, barColor=200:200:200, progressColor=26:129:211, bufferColor=-1:-1:-1/>

	
	<destructor offsetXPC=0 offsetYPC=0 widthPC=100 heightPC=100 Color=-1:-1:-1>
	</destructor>

    </progressBar>

    <progressBar backgroundColor=-1:-1:-1, offsetXPC=25, offsetYPC=70, widthPC=60, heightPC=20>
	<bar offsetXPC=20, offsetYPC=48, widthPC=60, heightPC=6, barColor=200:200:200, progressColor=26:129:211, bufferColor=-1:-1:-1/> 


	<destructor offsetXPC=0 offsetYPC=0 widthPC=100 heightPC=100 Color=-1:-1:-1>
	</destructor>

    </progressBar>

<onUserInput>
input = currentUserInput();
ret = "false";
if (input == "stop" || input == "setup" || input == "guide")
{
    playItemURL(-1, 1);
    setRefreshTime(-1);
	postMessage("return");
	if (input == "setup")
		postMessage("setup");
	else
		postMessage("guide");
	ret = "true";
}
ret;
</onUserInput>
<backgroundDisplay>
<image  offsetXPC=0 offsetYPC=0 widthPC=100 heightPC=100>
    image/mele/backgd.jpg
                </image>
        </backgroundDisplay>
            <image  offsetXPC=0 offsetYPC=2.8 widthPC=100 heightPC=15.6>
            /scripts/image/sc_title.jpg
            </image>


<idleImage> image/POPUP_LOADING_01.png </idleImage>
<idleImage> image/POPUP_LOADING_02.png </idleImage>
<idleImage> image/POPUP_LOADING_03.png </idleImage>
<idleImage> image/POPUP_LOADING_04.png </idleImage>
<idleImage> image/POPUP_LOADING_05.png </idleImage>
<idleImage> image/POPUP_LOADING_06.png </idleImage>
<idleImage> image/POPUP_LOADING_07.png </idleImage>
<idleImage> image/POPUP_LOADING_08.png </idleImage>
</mediaDisplay>

<channel>
	<title>Shoutcast</title>
	<link></link>
    <media:thumbnail url="/scripts/image/rss1.png" width="120" height="90" />	

</channel>

</rss>
