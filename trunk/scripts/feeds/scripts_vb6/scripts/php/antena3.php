<?php echo "<?xml version='1.0' ?>"; ?>
<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/">
<mediaDisplay name="threePartsView" itemBackgroundColor="0:0:0" backgroundColor="0:0:0" sideLeftWidthPC="0" itemImageXPC="5" itemXPC="20" itemYPC="20" itemWidthPC="65" capWidthPC="70" unFocusFontColor="101:101:101" focusFontColor="255:255:255" idleImageXPC="45" idleImageYPC="42" idleImageWidthPC="10" idleImageHeightPC="16">
		<idleImage> http://ims.hdplayers.net/scripts/image/busy1.png </idleImage>
		<idleImage> http://ims.hdplayers.net/scripts/image/busy2.png </idleImage>
		<idleImage> http://ims.hdplayers.net/scripts/image/busy3.png </idleImage>
		<idleImage> http://ims.hdplayers.net/scripts/image/busy4.png </idleImage>
		<idleImage> http://ims.hdplayers.net/scripts/image/busy5.png </idleImage>
		<idleImage>http://ims.hdplayers.net/scripts/image/busy6.png</idleImage><idleImage>http://ims.hdplayers.net/scripts/image/busy7.png</idleImage><idleImage>http://ims.hdplayers.net/scripts/image/busy8.png</idleImage>
		<backgroundDisplay>
			<image  offsetXPC=0 offsetYPC=0 widthPC=100 heightPC=100>
			image/mele/backgd.jpg
			</image>  
		</backgroundDisplay>
		<image  offsetXPC=0 offsetYPC=2.8 widthPC=100 heightPC=15.6>
		image/mele/rss_title.jpg
		</image>
		<text  offsetXPC=40 offsetYPC=8 widthPC=35 heightPC=10 fontSize=20 backgroundColor=-1:-1:-1 foregroundColor=255:255:255>
		Antena3
		</text>			
	    </mediaDisplay>
<channel>
	<title>Emisiuni Antena3</title>
	<menu>main menu</menu>


<?php

$query = $_GET["query"];
if($query) {
   $queryArr = explode(',', $query);
   $data = $queryArr[0];
   $tip = $queryArr[1];
}
$azi = date('Y-m-d');
$ieri=date("Y-m-d",strtotime("-1 day"));
$alta_ieri=date("Y-m-d",strtotime("-2 day"));
$y = date('Y');
$m = date('m');
$l = strlen($data);
if ($l == 1) {
	if ($data == 1) 
		$d = $azi;
	elseif ($data == 2)
		$d = $ieri;
	elseif ($data ==3)
		$d = $alta_ieri;
} elseif ($l == 2)
		$d = $y."-".$m."-".$data;
elseif ($l == 4) {
		$m1 = substr($data,0,2);
		$d1 = substr($data,-2);
		$d = $y."-".$m1."-".$d1;
} elseif ($l == 8) {
		$y1 = substr($data,0,4);
		$m1 = substr($data,4,2);
		$d1 = substr($data,6,2);
		$d = $y1."-".$m1."-".$d1;
} else
	$d = $azi;
if ($tip == "bizbazar") {
echo '<item>';
echo '<title>Bizbazar cu Moise Guran - '.$d.' (HQ)</title>';
echo '<link>http://127.0.0.1/cgi-bin/rtmp?rtmpe://fms8.mediadirect.ro:80/recantena3?id=1676684/mp4:Bizbazar_cu_Moise_Guran_L-J_'.$d.'_16-05-00.mp4</link>';
echo '<media:thumbnail url="http://ims.hdplayers.net/scripts/image/antena3.jpg" />';
echo '<enclosure type="video/mp4" url="http://127.0.0.1/cgi-bin/rtmp?rtmpe://fms8.mediadirect.ro:80/recantena3?id=1676684/mp4:Bizbazar_cu_Moise_Guran_L-J_'.$d.'_16-05-00.mp4"/>';
echo '</item>';

echo '<item>';
echo '<title>Bizbazar cu Moise Guran - '.$d.' (LQ)</title>';
echo '<link>http://127.0.0.1/cgi-bin/rtmp?rtmpe://fms8.mediadirect.ro:80/recantena3?id=1676684/mp4:Bizbazar_cu_Moise_Guran_L-J_'.$d.'_16-05-00_low.mp4</link>';
echo '<media:thumbnail url="http://ims.hdplayers.net/scripts/image/antena3.jpg" />';
echo '<enclosure type="video/mp4" url="http://127.0.0.1/cgi-bin/rtmp?rtmpe://fms8.mediadirect.ro:80/recantena3?id=1676684/mp4:Bizbazar_cu_Moise_Guran_L-J_'.$d.'_16-05-00_low.mp4"/>';
echo '</item>';
} elseif ($tip == "ordinea_zilei") {
	//La ordinea zilei
	//rtmpe://fms8.mediadirect.ro:80/recantena3?id=1676684/mp4:La_ordinea_zilei_2010-06-18_18-45-00_low.mp4
echo '<item>';
echo '<title>La ordinea zilei - '.$d.' (HQ)</title>';
echo '<link>http://127.0.0.1/cgi-bin/rtmp?rtmpe://fms8.mediadirect.ro:80/recantena3?id=1676684/mp4:La_ordinea_zilei_'.$d.'_18-45-00.mp4</link>';
echo '<media:thumbnail url="http://ims.hdplayers.net/scripts/image/antena3.jpg" />';
echo '<enclosure type="video/mp4" url="http://127.0.0.1/cgi-bin/rtmp?rtmpe://fms8.mediadirect.ro:80/recantena3?id=1676684/mp4:La_ordinea_zilei_'.$d.'_18-45-00.mp4"/>';
echo '</item>';

echo '<item>';
echo '<title>La ordinea zilei - '.$d.' (LQ)</title>';
echo '<link>http://127.0.0.1/cgi-bin/rtmp?rtmpe://fms8.mediadirect.ro:80/recantena3?id=1676684/mp4:La_ordinea_zilei_'.$d.'_18-45-00_low.mp4</link>';
echo '<media:thumbnail url="http://ims.hdplayers.net/scripts/image/antena3.jpg" />';
echo '<enclosure type="video/mp4" url="http://127.0.0.1/cgi-bin/rtmp?rtmpe://fms8.mediadirect.ro:80/recantena3?id=1676684/mp4:La_ordinea_zilei_'.$d.'_18-45-00_low.mp4"/>';
echo '</item>';
} elseif ($tip == "stirea_zilei") {
	//Stirea zilei
	//rtmpe://fms8.mediadirect.ro:1935/recantena3?id=1676684/mp4:Stirea_Zilei_2010-06-18_20-02-00_low.mp4
echo '<item>';
echo '<title>Stirea zilei - '.$d.' (HQ)</title>';
echo '<link>http://127.0.0.1/cgi-bin/rtmp?rtmpe://fms8.mediadirect.ro:1935/recantena3?id=1676684/mp4:Stirea_Zilei_'.$d.'_20-02-00.mp4</link>';
echo '<media:thumbnail url="http://ims.hdplayers.net/scripts/image/antena3.jpg" />';
echo '<enclosure type="video/mp4" url="http://127.0.0.1/cgi-bin/rtmp?rtmpe://fms8.mediadirect.ro:1935/recantena3?id=1676684/mp4:Stirea_Zilei_'.$d.'_20-02-00.mp4"/>';
echo '</item>';

echo '<item>';
echo '<title>Stirea zilei - '.$d.' (LQ)</title>';
echo '<link>http://127.0.0.1/cgi-bin/rtmp?rtmpe://fms8.mediadirect.ro:1935/recantena3?id=1676684/mp4:Stirea_Zilei_'.$d.'_20-02-00_low.mp4</link>';
echo '<media:thumbnail url="http://ims.hdplayers.net/scripts/image/antena3.jpg" />';
echo '<enclosure type="video/mp4" url="http://127.0.0.1/cgi-bin/rtmp?rtmpe://fms8.mediadirect.ro:1935/recantena3?id=1676684/mp4:Stirea_Zilei_'.$d.'_20-02-00_low.mp4"/>';
echo '</item>';	
} elseif ($tip == "sinteza_zilei") {
	//Sinteza zilei
	//rtmpe://fms8.mediadirect.ro:80/recantena3?id=1676684/mp4:Sinteza_Zilei_cu_Mihai_Gadea_2010-06-17_21-30-00_low.mp4
echo '<item>';
echo '<title>Sinteza zilei - '.$d.' (HQ)</title>';
echo '<link>http://127.0.0.1/cgi-bin/rtmp?rtmpe://fms8.mediadirect.ro:80/recantena3?id=1676684/mp4:Sinteza_Zilei_cu_Mihai_Gadea_'.$d.'_21-30-00.mp4</link>';
echo '<media:thumbnail url="http://ims.hdplayers.net/scripts/image/antena3.jpg" />';
echo '<enclosure type="video/mp4" url="http://127.0.0.1/cgi-bin/rtmp?rtmpe://fms8.mediadirect.ro:80/recantena3?id=1676684/mp4:Sinteza_Zilei_cu_Mihai_Gadea_'.$d.'_21-30-00.mp4"/>';
echo '</item>';

echo '<item>';
echo '<title>Sinteza zilei - '.$d.' (LQ)</title>';
echo '<link>http://127.0.0.1/cgi-bin/rtmp?rtmpe://fms8.mediadirect.ro:80/recantena3?id=1676684/mp4:Sinteza_Zilei_cu_Mihai_Gadea_'.$d.'_21-30-00_low.mp4</link>';
echo '<media:thumbnail url="http://ims.hdplayers.net/scripts/image/antena3.jpg" />';
echo '<enclosure type="video/mp4" url="http://127.0.0.1/cgi-bin/rtmp?rtmpe://fms8.mediadirect.ro:80/recantena3?id=1676684/mp4:Sinteza_Zilei_cu_Mihai_Gadea_'.$d.'_21-30-00_low.mp4"/>';
echo '</item>';	
}	
?>

</channel>
</rss>