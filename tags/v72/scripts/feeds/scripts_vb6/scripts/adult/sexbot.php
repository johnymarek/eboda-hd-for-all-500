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
		<!--<image offsetXPC=5 offsetYPC=2 widthPC=20 heightPC=16>
		  <script>channelImage;</script>
		</image>-->
  	<text redraw="yes" offsetXPC="85" offsetYPC="12" widthPC="10" heightPC="6" fontSize="20" backgroundColor="10:105:150" foregroundColor="60:160:205">
		  <script>sprintf("%s / ", focus-(-1))+itemCount;</script>
		</text>
  	<text  redraw="yes" align="center" offsetXPC="0" offsetYPC="90" widthPC="100" heightPC="8" fontSize="17" backgroundColor="10:105:150" foregroundColor="100:200:255">
		  <script>print(annotation); annotation;</script>
		</text>
		<image  redraw="yes" offsetXPC=60 offsetYPC=35 widthPC=30 heightPC=30>
  <script>channelImage;</script>
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
					  annotation = getItemInfo(idx, "title");
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
<script>
    channelImage = "/scripts/adult/image/sexbot.png";
  </script>
<channel>
	<title>sexbot.com</title>
	<menu>main menu</menu>



<item><title>Porn videos</title><link><?php echo $host; ?>/scripts/adult/php/sexbot.php?query=1,http://www.sexbot.com/videos/latest/</link></item>
<item><title>Amateur Porn</title><link><?php echo $host; ?>/scripts/adult/php/sexbot.php?query=1,http://www.sexbot.com/category/videos/amateur/latest/</link></item>
<item><title>Anal Porn</title><link><?php echo $host; ?>/scripts/adult/php/sexbot.php?query=1,http://www.sexbot.com/category/videos/anal/latest/</link></item>
<item><title>Asian Porn</title><link><?php echo $host; ?>/scripts/adult/php/sexbot.php?query=1,http://www.sexbot.com/category/videos/asian/latest/</link></item>
<item><title>Babe Porn</title><link><?php echo $host; ?>/scripts/adult/php/sexbot.php?query=1,http://www.sexbot.com/category/videos/babe/latest/</link></item>
<item><title>Big Ass Porn</title><link><?php echo $host; ?>/scripts/adult/php/sexbot.php?query=1,http://www.sexbot.com/category/videos/big_ass/latest/</link></item>
<item><title>Big Cocks Porn</title><link><?php echo $host; ?>/scripts/adult/php/sexbot.php?query=1,http://www.sexbot.com/category/videos/big_cocks/latest/</link></item>
<item><title>Big Tits Porn</title><link><?php echo $host; ?>/scripts/adult/php/sexbot.php?query=1,http://www.sexbot.com/category/videos/big_tits/latest/</link></item>
<item><title>Black Porn</title><link><?php echo $host; ?>/scripts/adult/php/sexbot.php?query=1,http://www.sexbot.com/category/videos/black/latest/</link></item>
<item><title>Blowjobs Porn</title><link><?php echo $host; ?>/scripts/adult/php/sexbot.php?query=1,http://www.sexbot.com/category/videos/blowjobs/latest/</link></item>
<item><title>Camel Toe Porn</title><link><?php echo $host; ?>/scripts/adult/php/sexbot.php?query=1,http://www.sexbot.com/category/videos/camel_toe/latest/</link></item>
<item><title>College Porn</title><link><?php echo $host; ?>/scripts/adult/php/sexbot.php?query=1,http://www.sexbot.com/category/videos/college/latest/</link></item>
<item><title>Creampie Porn</title><link><?php echo $host; ?>/scripts/adult/php/sexbot.php?query=1,http://www.sexbot.com/category/videos/creampie/latest/</link></item>
<item><title>Cum Shots Porn</title><link><?php echo $host; ?>/scripts/adult/php/sexbot.php?query=1,http://www.sexbot.com/category/videos/cum_shots/latest/</link></item>
<item><title>Deep Throat Porn</title><link><?php echo $host; ?>/scripts/adult/php/sexbot.php?query=1,http://www.sexbot.com/category/videos/deep_throat/latest/</link></item>
<item><title>DP Porn</title><link><?php echo $host; ?>/scripts/adult/php/sexbot.php?query=1,http://www.sexbot.com/category/videos/dp/latest/</link></item>
<item><title>Euro Porn</title><link><?php echo $host; ?>/scripts/adult/php/sexbot.php?query=1,http://www.sexbot.com/category/videos/euro/latest/</link></item>
<item><title>Fetish Porn</title><link><?php echo $host; ?>/scripts/adult/php/sexbot.php?query=1,http://www.sexbot.com/category/videos/fetish/latest/</link></item>
<item><title>Foot Fetish Porn</title><link><?php echo $host; ?>/scripts/adult/php/sexbot.php?query=1,http://www.sexbot.com/category/videos/foot_fetish/latest/</link></item>
<item><title>Gang Bang Porn</title><link><?php echo $host; ?>/scripts/adult/php/sexbot.php?query=1,http://www.sexbot.com/category/videos/gang_bang/latest/</link></item>
<item><title>Group Sex Porn</title><link><?php echo $host; ?>/scripts/adult/php/sexbot.php?query=1,http://www.sexbot.com/category/videos/group_sex/latest/</link></item>
<item><title>Hardcore Porn</title><link><?php echo $host; ?>/scripts/adult/php/sexbot.php?query=1,http://www.sexbot.com/category/videos/hardcore/latest/</link></item>
<item><title>Homemade Porn</title><link><?php echo $host; ?>/scripts/adult/php/sexbot.php?query=1,http://www.sexbot.com/category/videos/homemade/latest/</link></item>
<item><title>Housewife Porn</title><link><?php echo $host; ?>/scripts/adult/php/sexbot.php?query=1,http://www.sexbot.com/category/videos/housewife/latest/</link></item>
<item><title>Interracial Porn</title><link><?php echo $host; ?>/scripts/adult/php/sexbot.php?query=1,http://www.sexbot.com/category/videos/interracial/latest/</link></item>
<item><title>Latina Porn</title><link><?php echo $host; ?>/scripts/adult/php/sexbot.php?query=1,http://www.sexbot.com/category/videos/latina/latest/</link></item>
<item><title>Lesbian Porn</title><link><?php echo $host; ?>/scripts/adult/php/sexbot.php?query=1,http://www.sexbot.com/category/videos/lesbian/latest/</link></item>
<item><title>Mature Porn</title><link><?php echo $host; ?>/scripts/adult/php/sexbot.php?query=1,http://www.sexbot.com/category/videos/mature/latest/</link></item>
<item><title>MILF Porn</title><link><?php echo $host; ?>/scripts/adult/php/sexbot.php?query=1,http://www.sexbot.com/category/videos/milf/latest/</link></item>
<item><title>Outdoor Porn</title><link><?php echo $host; ?>/scripts/adult/php/sexbot.php?query=1,http://www.sexbot.com/category/videos/outdoor/latest/</link></item>
<item><title>POV Porn</title><link><?php echo $host; ?>/scripts/adult/php/sexbot.php?query=1,http://www.sexbot.com/category/videos/pov/latest/</link></item>
<item><title>Reality Porn Porn</title><link><?php echo $host; ?>/scripts/adult/php/sexbot.php?query=1,http://www.sexbot.com/category/videos/reality_porn/latest/</link></item>
<item><title>Sleeping Porn</title><link><?php echo $host; ?>/scripts/adult/php/sexbot.php?query=1,http://www.sexbot.com/category/videos/sleeping/latest/</link></item>
<item><title>Squirting Porn</title><link><?php echo $host; ?>/scripts/adult/php/sexbot.php?query=1,http://www.sexbot.com/category/videos/squirting/latest/</link></item>
<item><title>Teen (18+) Porn</title><link><?php echo $host; ?>/scripts/adult/php/sexbot.php?query=1,http://www.sexbot.com/category/videos/teen/latest/</link></item>
<item><title>Threesome Porn</title><link><?php echo $host; ?>/scripts/adult/php/sexbot.php?query=1,http://www.sexbot.com/category/videos/threesome/latest/</link></item>
<item><title>Tranny Porn</title><link><?php echo $host; ?>/scripts/adult/php/sexbot.php?query=1,http://www.sexbot.com/category/videos/tranny/latest/</link></item>
<item><title>Vintage Porn</title><link><?php echo $host; ?>/scripts/adult/php/sexbot.php?query=1,http://www.sexbot.com/category/videos/vintage/latest/</link></item>
<item><title>Workout Porn</title><link><?php echo $host; ?>/scripts/adult/php/sexbot.php?query=1,http://www.sexbot.com/category/videos/workout/latest/</link></item>

</channel>
</rss>
