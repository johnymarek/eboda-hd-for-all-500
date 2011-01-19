#!/bin/sh

cat <<EOF
Content-type: application/xhtml+xml

<?xml version="1.0" ?>
<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/">
<script>
  systemItemMaxIndex = 6
</script>
<mediaDisplay name=meleNewsPartView
	itemBackgroundColor=0:0:0
   backgroundColor=0:0:0
   sideLeftWidthPC=0
   sideRightWidthPC=100
   showHeader="yes"  
   imageParentFocus="image/mele/focus.bmp"
   imageFocus="image/mele/focus.bmp"
   imageUnFocus="image/mele/unfocus.bmp"
   unFocusFontColor=101:101:101
   focusFontColor=255:255:255
   
   suffixXPC=86.5
   suffixYPC=12.2
   suffixBgColor=-1:-1:-1
   suffixTextColor=101:101:101
   suffixClearImage="IMS_Modules/News/image/news_title.jpg"
   suffixClearImageXPC=0
   suffixClearImageYPC=2.8
   suffixClearImageWPC=100
   suffixClearImageHPC=15.6
   
   headerColor=-1:-1:-1
   headerXPC=19.29
   headerYPC=8
   headerFontSize=20
   fontSize=16

   itemXPC=10.9
   itemYPC=20
   itemWidthPC=78.13
   itemHeightPC=10 
   itemGap=0   
   itemImageWidthPC=0
   itemImageHeightPC=0
   itemAlignt="center"

   rollItems="yes"
   >
<idleImage> image/POPUP_LOADING_01.png </idleImage>
<idleImage> image/POPUP_LOADING_02.png </idleImage>
<idleImage> image/POPUP_LOADING_03.png </idleImage>
<idleImage> image/POPUP_LOADING_04.png </idleImage>
<idleImage> image/POPUP_LOADING_05.png </idleImage>
<idleImage> image/POPUP_LOADING_06.png </idleImage>
<idleImage> image/POPUP_LOADING_07.png </idleImage>
<idleImage> image/POPUP_LOADING_08.png </idleImage>

<backgroundDisplay>
    <image  offsetXPC=0 offsetYPC=0 widthPC=100 heightPC=100>
      image/mele/backgd.jpg
    </image>  
</backgroundDisplay> 

<onUserInput>
userInput = currentUserInput();
print("userInput=:", userInput);
if (userInput == "edit" &amp;&amp; getFocusItemIndex() &gt; 0)
{
        rss = "rss_file://./IMS_Modules/News/scripts/popMenu.rss";
        ret = doModalRss(rss);
        print("get the result of popMenu , it is:", ret);
        if (ret == "Confirm")
        {
              if(getFocusItemIndex() &gt; systemItemMaxIndex) {
                rss = "rss_file://./IMS_Modules/News/scripts/deleteDialog.rss";
                ret = doModalRss(rss);
                print("get the result of deleteDialog, it is:", ret);
                if( ret == "Confirm" ) {
                    ret = getFocusItemIndex();
                    deleteItem(getFocusItemIndex());
                    setFocusItemIndex(ret-1);
                }
              }
              else
              {
                rss = "rss_file://./IMS_Modules/News/scripts/noticeDialog.rss";
                doModalRss(rss);
              }         
        }
        "true";
}
else
  "false";
</onUserInput>   
</mediaDisplay>

    <channel>
        <title>Control Panel</title>
        <link>http://localhost/cgi-bin/ewcp-rss.cgi</link>
        <menu>control panel main menu</menu>

<item>
<title>Daemons status</title>
<link>http://localhost/cgi-bin/DaemonsStatus-rss.cgi</link>
<canEnterItem>false</canEnterItem>
</item>

<item>
<title>Utilities</title>
<link>http://localhost/cgi-bin/Utilities-rss.cgi</link>
</item>


<item>
<title>Updates</title>
<link>http://localhost/cgi-bin/Updates-rss.cgi</link>
<canEnterItem>false</canEnterItem>
</item>

<item>
<title>Services</title>
<link>http://localhost/cgi-bin/Services-rss.cgi</link>
<canEnterItem>false</canEnterItem>
</item>

</channel>
</rss>
EOF