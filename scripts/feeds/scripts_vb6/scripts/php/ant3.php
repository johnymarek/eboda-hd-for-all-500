<?php echo "<?xml version='1.0' ?>"; ?>
<?php
$titlu = $_GET["title"];
$title = str_replace('_',' ',$titlu);
?>
<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/">
<mediaDisplay name="threePartsView" itemBackgroundColor="0:0:0" backgroundColor="0:0:0" sideLeftWidthPC="0" itemImageXPC="5" itemXPC="20" itemYPC="20" itemWidthPC="65" capWidthPC="70" unFocusFontColor="101:101:101" focusFontColor="255:255:255" idleImageXPC="45" idleImageYPC="42" idleImageWidthPC="20" idleImageHeightPC="26">
        <idleImage>image/busy1.png</idleImage>
        <idleImage>image/busy2.png</idleImage>
        <idleImage>image/busy3.png</idleImage>
        <idleImage>image/busy4.png</idleImage>
        <idleImage>image/busy5.png</idleImage>
        <idleImage>image/busy6.png</idleImage>
        <idleImage>image/busy7.png</idleImage>
        <idleImage>image/busy8.png</idleImage>
		<backgroundDisplay>
			<image  offsetXPC=0 offsetYPC=0 widthPC=100 heightPC=100>
			image/mele/backgd.jpg
			</image>  
		</backgroundDisplay>
		<image  offsetXPC=0 offsetYPC=2.8 widthPC=100 heightPC=15.6>
		image/mele/rss_title.jpg
		</image>
		<text  offsetXPC=40 offsetYPC=8 widthPC=35 heightPC=10 fontSize=20 backgroundColor=-1:-1:-1 foregroundColor=255:255:255>
		<?php echo $title; ?>
		</text>			
	    </mediaDisplay>
<channel>
	<title><?php echo $title; ?></title>
	<menu>main menu</menu>


<?php
function str_between($string, $start, $end){ 
	$string = " ".$string; $ini = strpos($string,$start); 
	if ($ini == 0) return ""; $ini += strlen($start); $len = strpos($string,$end,$ini) - $ini; 
	return substr($string,$ini,$len); 
}

$link = $_GET["file"];
$link = urldecode($link);
$html = file_get_contents($link);
$server = "big01";
$port = "80";
$tip = "";
// emisiune
if (strpos($link, "Stiri_ora_18:00_cu_Mihaela_Birzila") !== false) {
	$ora = "18-00";
	$emisiune = "Stiri_ora_18";
} elseif (strpos($link, "Bizbazar_cu_Moise_Guran") !== false) {
	$ora = "16-05";
	$emisiune = "Bizbazar_cu_Moise_Guran_L-J";
	$tip = "bizbazar";
} elseif(strpos($link, "Reporter_Special") !== false) {
	$ora = "17-00";
	$emisiune = "Reporter_Special";
	$tip = "Reporter_Special";
} elseif(strpos($link, "Stirea_Zilei") !== false) {
	$ora = "20-02";
	$emisiune = "Stirea_Zilei";
} elseif(strpos($link, "Sinteza_Zilei_cu_Mihai_Gadea") !== false) {
	$ora = "21-30"; // mai sunt exceptii "21-45"
	$ora = "21-45"; // august 2010
	$emisiune = "Sinteza_Zilei_cu_Mihai_Gadea";
} elseif(strpos($link, "Subiectiv_cu_Razvan_Dumitrescu") !== false) {
	$ora = "21-00";
	$emisiune = "subiectiv";
	$tip = "subiectiv";
} elseif(strpos($link, "Editia_de_pranz_15") !== false) {
	$ora = "15-00";
	$emisiune = "Editia_de_pranz_15";
} elseif(strpos($link, "La_Ordinea_Zilei") !== false) {
	$ora = "18-45";
	$emisiune = "La_ordinea_zilei";
} elseif(strpos($link, "Conexiuni") !== false) {
	$ora = "22-00";
	$emisiune = "Conexiuni";
} elseif(strpos($link, "Editie_Speciala") !== false) {
	$ora = "14-30";
	$emisiune = "Editie_speciala";
} elseif(strpos($link, "Si_oameni,_si_afaceri") !== false) {
	$ora = "14-05";
	$emisiune = "si_oameni_siafaceri";
} elseif(strpos($link, "Stiri_Ora_08:00") !== false) {
	$ora = "08-00";
	$emisiune = "Stiri_ora_08"; // Mai ramane de studiat
} elseif(strpos($link, "In_gura_presei_cu_Mircea_Badea") !== false) {
	$ora = "23-05";
	$emisiune = "In_Gura_Presei";
} elseif(strpos($link, "Saptamana_de_stiri") !== false) {
	$ora = "16-05";
	$emisiune = "Saptamana_de_Stiri";
} elseif(strpos($link, "Stiri_ora_21") !== false) {
	$ora = "21-00";
	$emisiune = "Stiri_ora_21";
} elseif(strpos($link, "News_Magazine_cu_Alessandra_Stoicescu") !== false) {
	$ora = "10-05";
	$emisiune = "News_Magazine_cu_Alessandra_Stoicescu";
} elseif(strpos($link, "Editia_de_pranz_13") !== false) {
	$ora = "13-02";
	$emisiune = "Editia_de_pranz_13";
} elseif(strpos($link, "A_cu_Alessandra_Stoicescu_si_Floriana_Jucan") !== false) {
	$ora = "21-30";
	$emisiune = "QA_cu_Alessandra_Stoicescu_si_Floriana_Jucan";
} elseif(strpos($link, "Antena_3_Special") !== false) {
	$ora = "13-05";
	$emisiune = "Antena_3_Special";
	$tip = "ant3_special";
} elseif(strpos($link, "Radu_Tudor") !== false) {
	$ora = "19-05";
	$emisiune = "Punctul_de_intalnire";
} elseif(strpos($link, "na_financiar") !== false) {
	$ora = "19-30";
	$emisiune = "saptamana_financiara";
} else {
	$ora = "00-00";
	$emisiune = "necunoscuta";
}
$videos = explode("<div class='day_active", $html);
unset($videos[0]);
$videos = array_values($videos);
//Joi, 01 Jul 2010
foreach($videos as $video) {    
	$title = str_between($video,"<div class='day_body ui-corner-bottom'>","</div>");
	$t = explode(",",$title);
	$day = $t[0]; // ziua din saptamana
	list($d,$month,$year) = split(' ', trim($t[1]));
	$y = $year;
	$m = date('m');
	if ($month == "Jan") {
		$m = "01";
	}elseif ($month == "Feb") {
		$m = "02";
	}elseif ($month == "Mar") {
		$m = "03";
	}elseif ($month == "Apr") {
		$m = "04";
	}elseif ($month == "May") {
		$m = "05";
	}elseif ($month == "Jun") {
		$m = "06";
	}elseif ($month == "Jul") {
		$m = "07";
	}elseif ($month == "Aug") {
		$m = "08";
	}elseif ($month == "Sep") {
		$m = "09";
	}elseif ($month == "Oct") {
		$m = "10";
	}elseif ($month == "Nov") {
		$m = "11";
	}elseif ($month == "Dec") {
		$m = "12";
	}else {
		$m = "00";
	}
	$d = $y."-".$m."-".$d; // data difuzarii
	// Bizbazar	
	if (($tip == "bizbazar") && ($day == "Sambata")) {
		$emisiune = "Bizbazar_cu_Moise_Guran";
		$ora = "23-05";
	}elseif (($tip == "bizbazar") && ($day <> "Sambata")) {
		$ora = "16-05";
		$emisiune = "Bizbazar_cu_Moise_Guran_L-J";
	}
	// Subiectiv	
	if (($tip == "subiectiv") && ($day == "Vineri")) {
		$emisiune = "subiectiv_vineri";
		$ora = "21-00";
	}elseif (($tip == "subiectiv") && ($day <> "Vineri")) {
		$ora = "21-00";
		$emisiune = "Subiectiv";
	}
	// Antena 3 Special	
	if (($tip == "ant3_special") && ($day == "Vineri")) {
		$emisiune = "Antena3_special_vineri";
		$ora = "16-05";
	}elseif (($tip == "ant3_special") && ($day == "Sambata")) {
		$ora = "13-05";
		$emisiune = "Antena3_special_sambata";
	}elseif (($tip == "ant3_special") && ($day <> "Sambata") && ($day <> "Vineri")) {
		$ora = "16-05"; // august 2010
		$emisiune = "Antena3_special";
	}
	$link = "rtmpe://".$server.".mediadirect.ro:".$port."/recantena3?id=1676684/mp4:".$emisiune ;
	$link = $link."_".$d."_".$ora."-00.mp4";
	echo '<item>';
	echo '<title>'.$title.'</title>';
	echo '<link>'.$link.'</link>';
	echo '<enclosure type="video/mp4" url="http://127.0.0.1/cgi-bin/rtmp?'.$link.'"/>';
	echo '</item>'; 
	print "\n";   
  }
?>
</channel>
</rss>  