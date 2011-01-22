
<? echo "<?xml version='1.0' ?>"; ?>
<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/">

   <bookmark>RTL_GEMIST</bookmark>

<!--	sideTopHeightPC=10 sideBottomHeightPC=10 sideLeftWidthPC=5 sideRightWidthPC=10
	viewAreaXPC=0 viewAreaYPC=0 viewAreaWidthPC=100 viewAreaHeightPC=100
	itemOffsetXPC=10  itemImageXPC=10 itemXPC=20
	rollMenu=yes forceFocusOnMenu=yes menuPerPage=1 canAddToFavorit=yes
 -->
 <mediaDisplay name=photoView rowCount=6  columnCount=2 
	sliding=yes drawItemText=yes circlingItems=no rollItems=yes fontSize=11 showHeader=yes showDefaultInfo=yes canAddToFavorit=yes
	menuXPC=5 menuYPC=12 menuWidthPC=10 menuOffsetXPC=4 menuOffsetYPC=10 menuItemHeightPC=5 menuItemWidthPC=9
	menuBorderColor=0:0:0 sideColorBottom=0:0:0 sideColorTop=0:0:0 focusFontColor=255:0:0 itemBorderColor=255:0:0 itemBackgroundColor=0:0:0
	itemGapXPC=1 itemGapYPC=2 itemOffsetXPC=16 itemWidthPC=39
	viewAreaXPC=0 viewAreaYPC=0 viewAreaWidthPC=100 viewAreaHeightPC=100
	sideTopHeightPC=8 sideBottomHeightPC=6 sideLeftWidthPC=5 sideRightWidthPC=5
	idleImageXPC=45   idleImageYPC=42   idleImageWidthPC=10   idleImageHeightPC=16  >
	<idleImage> image/POPUP_LOADING_01.jpg </idleImage>
	<idleImage> image/POPUP_LOADING_02.jpg </idleImage>
	<idleImage> image/POPUP_LOADING_03.jpg </idleImage>
	<idleImage> image/POPUP_LOADING_04.jpg </idleImage>
	<idleImage> image/POPUP_LOADING_05.jpg </idleImage>
	<idleImage> image/POPUP_LOADING_06.jpg </idleImage>
 </mediaDisplay>

<!-- RTL Gemist RSS script for all my dutch fans :) by Tweakradje. version 1.2 (16 juli 2010)
--> 

<submenu>
  <menu>RTL Gemist</menu>
  <title>Vandaag</title>  
  <onClick>
	url="http://127.0.0.1/media/sda1/scripts/xLive/RtlGemist.php";
   </onClick>
</submenu>
<submenu>
  <menu>RTL Gemist</menu>
  <title>Maandag</title>  
  <onClick>
	url="http://127.0.0.1/media/sda1/scripts/xLive/RtlGemist.php?day=1";
   </onClick>
</submenu>
<submenu name="Dinsdag" >
  <onClick>
	url="http://127.0.0.1/media/sda1/scripts/xLive/RtlGemist.php?day=2";
   </onClick>
</submenu>
<submenu name="Woensdag" >
  <onClick>
	url="http://127.0.0.1/media/sda1/scripts/xLive/RtlGemist.php?day=3";
   </onClick>
</submenu>
<submenu name="Donderdag" >
  <onClick>
	url="http://127.0.0.1/media/sda1/scripts/xLive/RtlGemist.php?day=4";
   </onClick>
</submenu>
<submenu name="Vrijdag" >
  <onClick>
	url="http://127.0.0.1/media/sda1/scripts/xLive/RtlGemist.php?day=5";
   </onClick>
</submenu>
<submenu name="Zaterdag" >
  <onClick>
	url="http://127.0.0.1/media/sda1/scripts/xLive/RtlGemist.php?day=6";
   </onClick>
</submenu>
<submenu name="Zondag" >
  <onClick>
	url="http://127.0.0.1/media/sda1/scripts/xLive/RtlGemist.php?day=7";
   </onClick>
</submenu>

<channel>
   <title>RTL Gemist</title>
   <menu>RTL Gemist</menu>

<?

#
# mp4 streams for 7 days on http://www.rtl.nl/service/gemist/device/ipad/feed/index.xml  more  ?day=1 (monday)
#

# day=1 monday
$argument = $_GET["day"];
if($argument) {
  $url = "http://www.rtl.nl/service/gemist/device/ipad/feed/index.xml?day=".$argument;
} else {
  $url = "http://www.rtl.nl/service/gemist/device/ipad/feed/index.xml";
}

$html = file_get_contents($url);

if($html) {

# new images in one strip (creates one big jpg)  juli 2010 like:
### .image_strip_7{background-image:url(http://iptv.rtl.nl/nettv/imagestrip/default.aspx?&width=188&height=106&files=Mon02.RTL7_100711_23234907_RTL_Poker_Million_Dolla.poster.jpg~Sun23.RTL4_100711_21314523_RTL_Weer_s2_a192.MiMedi.poster.jpg~Mon00.RTL4_100711_20371510_Hollands_Got_Talent_s1_.poster.jpg~Sun23.RTL5_100711_20221218_Dames_In_De_Dop_s1_a2.M.poster.jpg,GT~Sun20.RTL4_100711_17591019_RTL_Weer_s1_a192.MiMedi.poster.jpg~Sun19.RTL4_100711_17100604_De_Bloemenstal_s1_a31.M.poster.jpg,AL~Sun19.RTL5_100711_16351924_The_Phone_s1_a2.MiMedia.poster.jpg,GT~Sun19.RTL4_100711_16080309_Gillend_Naar_Huis_s2_a1.poster.jpg,GT~Sun18.RTL8_100711_15301420_4Me_s3_a27.MiMedia_MP4_.poster.jpg,AL~Sun18.RTL7_100711_15295601_RTL_Autowereld_s17_a3.M.poster.jpg~Sun17.RTL7_100711_15015616_RTL_Transportwereld_s16.poster.jpg~Sun16.RTL5_100711_14151402_Take_5_s1_a21.MiMedia_M.poster.jpg,A,GT,9~Sun16.RTL7_100711_14002113_RTL_Gp_Wtcc_-_Portugal_.poster.jpg~Sun12.RTL4_100711_10201019_RTL_Consult_s1_a10.MiMe.poster.jpg,AL~Sun12.RTL7_100###      711_10115201_RTL_Gp_Htc_Dutch_Gt4_-_.poster.jpg~Sun12.RTL7_100711_09264714_Volleybal_s1_a3.MiMedia.poster.jpg~Sun12.RTL4_100711_09221518_Look_Of_Love_s1_a1.MiMe.poster.jpg,AL~Sun11.RTL7_100711_08570702_RTL_Gp_Rally_Report_s11.poster.jpg~Sun11.RTL4_100711_08511020_Gezond_Op_Straat_s1_a1.poster.jpg~Sun10.RTL7_100711_08303102_Dong_Energy_Frisian_Sol.poster.jpg~Sun10.RTL4_100711_08192307_Van_Kavel_Tot_Kasteel_s.poster.jpg,AL~Sun10.RTL7_100711_08041014_Vis_TV_s15_a5.MiMedia_M.poster.jpg,AL~Sun10.RTL7_100711_07341512_Regio_Business_Magazine.poster.jpg,AL~Sun09.RTL4_100711_06583519_Campinglife_s14_a3.MiMe.poster.jpg,AL);}
# url for image would be: http://iptv.rtl.nl/nettv/xxxxxxx.jpg
#$image_strip = explode('files=',$html);
#$image_strip = explode(');', $image_strip);
#now make array of separate image urls (seperator ~) elements may contain rating like ",ALL" and ",A,GT,9" might need care in image URL
#$image_strip = explode('~',$image_strip);

### easy new image url: image url = mp4 url - mp4 + poster.jpg
# http://iptv.rtl.nl/nettv/Mon02.RTL7_100711_23234907_RTL_Poker_Million_Dolla.mp4
# http://iptv.rtl.nl/nettv/Mon02.RTL7_100711_23234907_RTL_Poker_Million_Dolla.poster.jpg

# Get all items from html file (changed july 2010)
# $items = explode('<li class="video_item">', $html);

$items = explode('<li class="video_item', $html);

# We dont need first part of html file
unset($items[0]);

# we don't need last item in this case
#$last = count($items);
#unset($items[$last]);

$items = array_values($items);

#test# file_put_contents("c:\\temp\\xtreamer\\uzg_html.txt",$html);
#test# file_put_contents("c:\\temp\\xtreamer\\uzg_items.txt",$items);

# Now look at each item found in the html file

 foreach($items as $item) {

    $t1 = explode(' href="', $item);
    $t2 = explode('"', $t1[1]);
    $link = $t2[0];

#    $t1 = explode('background-image:url(', $item);
#    $t2 = explode(');', $t1[1]);
#    $image = $t2[0];

# name of program
    $t1 = explode('"text_link">', $item);
    $t2 = explode('<', $t1[1]);
    $title = $t2[0];
# add time
    $t1 = explode('<span>', $item);
    $t2 = explode('<', $t1[1]);
#    $title = $title."\n".$t2[0];   #newline would be nice to have here Realtek!
    $title = $title." (".$t2[0].")";


#test# echo "### Link: ".$link."\n";

    echo '<item>';
    echo '<title>'.$title.'</title>';
    echo '<link>'.$link.'</link>';
# does below work?
    echo '<media:thumbnail url="'.strstr($link,".",TRUE).'poster.jpg" />';
    echo '<enclosure type="video/mp4" url="'.$link.'"/>';
    echo '</item>';

 }
} else {
    echo '<item>';
    echo '<title>Probleem bij het lezen van HTML</title>';
    echo '<link></link>';
    echo '</item>'; 
}

?>

</channel>
</rss>