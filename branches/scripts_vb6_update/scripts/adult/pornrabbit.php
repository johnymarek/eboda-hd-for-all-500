#!/usr/local/bin/Resource/www/cgi-bin/php
<?php echo "<?xml version='1.0' encoding='UTF8' ?>";
$host = "http://127.0.0.1/cgi-bin";
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
    channelImage = "/usr/local/etc/www/cgi-bin/scripts/adult/image/pornrabbit.gif";
  </script>
<channel>
	<title>pornrabbit.com</title>
	<menu>main menu</menu>


<item>
	<title>Most Recent</title>
<link><?php echo $host; ?>/scripts/adult/php/pornrabbit.php?query=1,http://www.pornrabbit.com/page</link>
</item>
<item><title>Amateur</title><link><?php echo $host; ?>/scripts/adult/php/pornrabbit.php?query=1,http://www.pornrabbit.com/category/amateur/page</link></item>
<item><title>Anal</title><link><?php echo $host; ?>/scripts/adult/php/pornrabbit.php?query=1,http://www.pornrabbit.com/category/anal/page</link></item>
<item><title>Asian</title><link><?php echo $host; ?>/scripts/adult/php/pornrabbit.php?query=1,http://www.pornrabbit.com/category/asian/page</link></item>
<item><title>Ass</title><link><?php echo $host; ?>/scripts/adult/php/pornrabbit.php?query=1,http://www.pornrabbit.com/category/ass/page</link></item>
<item><title>Babe</title><link><?php echo $host; ?>/scripts/adult/php/pornrabbit.php?query=1,http://www.pornrabbit.com/category/babe/page</link></item>
<item><title>Big tits</title><link><?php echo $host; ?>/scripts/adult/php/pornrabbit.php?query=1,http://www.pornrabbit.com/category/big_tits/page</link></item>
<item><title>Blonde</title><link><?php echo $host; ?>/scripts/adult/php/pornrabbit.php?query=1,http://www.pornrabbit.com/category/blonde/page</link></item>
<item><title>Blowjob</title><link><?php echo $host; ?>/scripts/adult/php/pornrabbit.php?query=1,http://www.pornrabbit.com/category/blowjob/page</link></item>
<item><title>Brunette</title><link><?php echo $host; ?>/scripts/adult/php/pornrabbit.php?query=1,http://www.pornrabbit.com/category/brunette/page</link></item>
<item><title>Creampie</title><link><?php echo $host; ?>/scripts/adult/php/pornrabbit.php?query=1,http://www.pornrabbit.com/category/creampie/page</link></item>
<item><title>Cumshot</title><link><?php echo $host; ?>/scripts/adult/php/pornrabbit.php?query=1,http://www.pornrabbit.com/category/cumshot/page</link></item>
<item><title>Ebony</title><link><?php echo $host; ?>/scripts/adult/php/pornrabbit.php?query=1,http://www.pornrabbit.com/category/ebony/page</link></item>
<item><title>Fetish</title><link><?php echo $host; ?>/scripts/adult/php/pornrabbit.php?query=1,http://www.pornrabbit.com/category/fetish/page</link></item>
<item><title>Group</title><link><?php echo $host; ?>/scripts/adult/php/pornrabbit.php?query=1,http://www.pornrabbit.com/category/group/page</link></item>
<item><title>Handjob</title><link><?php echo $host; ?>/scripts/adult/php/pornrabbit.php?query=1,http://www.pornrabbit.com/category/handjob/page</link></item>
<item><title>Hardcore</title><link><?php echo $host; ?>/scripts/adult/php/pornrabbit.php?query=1,http://www.pornrabbit.com/category/hardcore/page</link></item>
<item><title>Interracial</title><link><?php echo $host; ?>/scripts/adult/php/pornrabbit.php?query=1,http://www.pornrabbit.com/category/interracial/page</link></item>
<item><title>Large girls</title><link><?php echo $host; ?>/scripts/adult/php/pornrabbit.php?query=1,http://www.pornrabbit.com/category/large_girls/page</link></item>
<item><title>Latina</title><link><?php echo $host; ?>/scripts/adult/php/pornrabbit.php?query=1,http://www.pornrabbit.com/category/latina/page</link></item>
<item><title>Lesbian</title><link><?php echo $host; ?>/scripts/adult/php/pornrabbit.php?query=1,http://www.pornrabbit.com/category/lesbian/page</link></item>
<item><title>Masturbation</title><link><?php echo $host; ?>/scripts/adult/php/pornrabbit.php?query=1,http://www.pornrabbit.com/category/masturbation/page</link></item>
<item><title>Mature</title><link><?php echo $host; ?>/scripts/adult/php/pornrabbit.php?query=1,http://www.pornrabbit.com/category/mature/page</link></item>
<item><title>Milf</title><link><?php echo $host; ?>/scripts/adult/php/pornrabbit.php?query=1,http://www.pornrabbit.com/category/milf/page</link></item>
<item><title>Teen</title><link><?php echo $host; ?>/scripts/adult/php/pornrabbit.php?query=1,http://www.pornrabbit.com/category/teen/page</link></item>

</channel>
</rss>
