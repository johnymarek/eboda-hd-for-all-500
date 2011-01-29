<?php echo "<?xml version='1.0' encoding='UTF8' ?>";
$host = "http://127.0.0.1:82";
?>
<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/">
<mediaDisplay name="threePartsView" itemBackgroundColor="0:0:0" backgroundColor="0:0:0" sideLeftWidthPC="0" itemImageXPC="5" itemXPC="20" itemYPC="20" itemWidthPC="65" capWidthPC="70" unFocusFontColor="101:101:101" focusFontColor="255:255:255" idleImageXPC="45" idleImageYPC="42" idleImageWidthPC="20" idleImageHeightPC="26">
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
		Dailymotion
		</text>			
</mediaDisplay>
<channel>
<title>dailymotion</title>
<link>/dm.rss</link>

<item>
<title>Search</title>
<link>rss_command://search</link>
<search url="<?php echo $host; ?>/scripts/clip/php/dm_search.php?query=1,%s" />
<media:thumbnail url="/scripts/image/search.png" />
</item>

<item>
<title>Most viewed videos</title>
<link><?php echo $host; ?>/scripts/clip/php/dm.php?query=,http://www.dailymotion.com/en/visited</link>
</item>

<item>
<title>Most recent videos</title>
<link><?php echo $host; ?>/scripts/clip/php/dm.php?query=,http://www.dailymotion.com/en</link>
</item>

<item>
<title>Top rated videos</title>
<link><?php echo $host; ?>/scripts/clip/php/dm.php?query=,http://www.dailymotion.com/en/rated</link>
</item>

<item>
<title>Featured users</title>
<link><?php echo $host; ?>/scripts/clip/php/dm_user_main.php?query=,http://www.dailymotion.com/users/featured</link>
</item>

<item>
<title>football</title>
<link><?php echo $host; ?>/scripts/clip/php/dm.php?query=,http://www.dailymotion.com/creative-official/search/football</link>
</item>

<item>
<title>FOX Sports Interactive</title>
<link><?php echo $host; ?>/scripts/clip/php/dm.php?query=,http://www.dailymotion.com/user/FOX_Sports_Interactive</link>
</item>

<item>
<title>Animals</title>
<link><?php echo $host; ?>/scripts/clip/php/dm.php?query=,http://www.dailymotion.com/en/channel/animals</link>
</item>

<item>
<title>Arts</title>
<link><?php echo $host; ?>/scripts/clip/php/dm.php?query=,http://www.dailymotion.com/en/channel/creation</link>
</item>

<item>
<title>Auto-Moto</title>
<link><?php echo $host; ?>/scripts/clip/php/dm.php?query=,http://www.dailymotion.com/en/channel/auto</link>
</item>

<item>

<title>College</title>
<link><?php echo $host; ?>/scripts/clip/php/dm.php?query=,http://www.dailymotion.com/featured/channel/school</link>
</item>

<item>
<title>Featured videos</title>
<link><?php echo $host; ?>/scripts/clip/php/dm.php?query=,http://www.dailymotion.com/en/featured</link>
</item>

<item>
<title>Film & TV</title>
<link><?php echo $host; ?>/scripts/clip/php/dm.php?query=,http://www.dailymotion.com/en/channel/shortfilms</link>
</item>

<item>
<title>Funny</title>
<link><?php echo $host; ?>/scripts/clip/php/dm.php?query=,http://www.dailymotion.com/en/channel/fun</link>
</item>

<item>
<title>Gaming</title>
<link><?php echo $host; ?>/scripts/clip/php/dm.php?query=,http://www.dailymotion.com/en/channel/videogames</link>
</item>

<item>
<title>HD videos</title>
<link><?php echo $host; ?>/scripts/clip/php/dm.php?query=,http://www.dailymotion.com/en/hd</link>
</item>

<item>
<title>Life & Style</title>
<link><?php echo $host; ?>/scripts/clip/php/dm.php?query=,http://www.dailymotion.com/en/channel/lifestyle</link>
</item>

<item>
<title>Most visited</title>
<link><?php echo $host; ?>/scripts/clip/php/dm.php?query=,http://www.dailymotion.com/en/visited-week</link>
</item>

<item>
<title>Motionmaker videos</title>
<link><?php echo $host; ?>/scripts/clip/php/dm.php?query=,http://www.dailymotion.com/en/creative</link>
</item>

<item>
<title>Music</title>
<link><?php echo $host; ?>/scripts/clip/php/dm.php?query=,http://www.dailymotion.com/en/channel/music</link>
</item>

<item>
<title>News & Politics</title>
<link><?php echo $host; ?>/scripts/clip/php/dm.php?query=,http://www.dailymotion.com/en/channel/news</link>
</item>

<item>
<title>Official Content videos</title>
<link><?php echo $host; ?>/scripts/clip/php/dm.php?query=,http://www.dailymotion.com/en/official</link>
</item>

<item>
<title>People & Family</title>
<link><?php echo $host; ?>/scripts/clip/php/dm.php?query=,http://www.dailymotion.com/featured/channel/people</link>
</item>

<item>
<title>Sexy</title>
<link><?php echo $host; ?>/scripts/clip/php/dm.php?query=,http://www.dailymotion.com/featured/channel/sexy</link>
</item>

<item>
<title>Sports & Extreme</title>
<link><?php echo $host; ?>/scripts/clip/php/dm.php?query=,http://www.dailymotion.com/en/channel/sport</link>
</item>

<item>
<title>Tech & Science</title>
<link><?php echo $host; ?>/scripts/clip/php/dm.php?query=,http://www.dailymotion.com/en/channel/tech</link>
</item>

<item>
<title>Travel</title>
<link><?php echo $host; ?>/scripts/clip/php/dm.php?query=,http://www.dailymotion.com/en/channel/travel</link>
</item>

<item>
<title>Webcam & Vlogs</title>
<link><?php echo $host; ?>/scripts/clip/php/dm.php?query=,http://www.dailymotion.com/featured/channel/webcam</link>
</item>

</channel>
</rss>