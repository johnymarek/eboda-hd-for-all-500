<?php echo "<?xml version='1.0' ?>"; ?>
<?php
$titlu = $_GET["title"];
$title = str_replace('_',' ',$titlu);
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
	itemWidthPC="45"
	itemHeightPC="8"
	capXPC="8"
	capYPC="25"
	capWidthPC="45"
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
		<image  redraw="yes" offsetXPC=66 offsetYPC=30 widthPC=20 heightPC=20>
		<script>print(img); img;</script>
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
					  annotation = getItemInfo(idx, "annotation");
					  img = getItemInfo(idx,"image");
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
$image = "http://inregistrari.antena3.ro".str_between($html,'img src="','"');
$server = "fms1";
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
	$ora = "20-00";
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
	$ora = "23-10";
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
	$ora = "19-00";
	$emisiune = "Punctul_de_intalnire";
} elseif(strpos($link, "na_financiar") !== false) {
	$ora = "19-30";
	$emisiune = "saptamana_financiara";
} elseif(strpos($link, "Vorbe_grele_cu_Victor_Ciutacu") !== false) {
	$ora = "23-00";
	$emisiune = "Vorbe_grele_cu_Victor_Ciutacu";
} elseif(strpos($link, "In_Premiera_cu_Carmen_Avram") !== false) {
	$ora = "21-00";
	$emisiune = "In_Premiera";
} elseif(strpos($link, "Esential") !== false) {
	$ora = "15-00";
	$emisiune = "Esential";
} elseif(strpos($link, "100_de_minute") !== false) {
	$ora = "17-00";
	$emisiune = "100_de_minute";
} elseif(strpos($link, "Stiri_ora_21:00_Sambata") !== false) {
	$ora = "21-00";
	$emisiune = "Stiri_ora_21";
} elseif(strpos($link, "Clubul_Camerelor_de_Comert") !== false) {
	$ora = "14-00";
	$emisiune = "si_oameni_siafaceri";
} elseif(strpos($link, "Editie_de_weekend") !== false) {
	$ora = "13-04";
	$emisiune = "editie_de_weekend3";
} elseif(strpos($link, "Se_intampla_in_Romania") !== false) {
	$ora = "11-00";
	$emisiune = "Se_intampla_acum_I";
} elseif(strpos($link, "Se_intampla_in_Romania_II") !== false) {
	$ora = "13-00";
	$emisiune = "Se_intampla_acum_II";
} elseif(strpos($link, "Previziunile_zilei") !== false) {
	$ora = "10-00";
	$emisiune = "Previziunile_zilei";
} elseif(strpos($link, "Stirile_diminetii") !== false) {
	$ora = "06-00";
	$emisiune = "Stirile_diminetii";
} elseif(strpos($link, "Editie_Speciala_cu_Paula_Rusu") !== false) {
	$ora = "23-00";
	$emisiune = "Editie_Speciala_cu_Paula_Rusu_Sambata";
} elseif(strpos($link, "Editie_Speciala_cu_Razvan_Dumitrescu_si_Mihai_Gadea") !== false) {
	$ora = "20-58";
	$emisiune = "Editie_Speciala_cu_Razvan_Dumitrescu_si_Mihai_Gadea";
} elseif(strpos($link, "Editie_Speciala_ora_10") !== false) {
	$ora = "12-00";
	$emisiune = "Editii_Speciale";
} elseif(strpos($link, "Editie_Speciala_ora_14") !== false) {
	$ora = "13-58";
	$emisiune = "Editie_speciala_ora_14";
} elseif(strpos($link, "Editie_Speciala_ora_18") !== false) {
	$ora = "17-58";
	$emisiune = "Editie_speciala_ora_18";
} elseif(strpos($link, "Stiri_ora_14") !== false) {
	$ora = "14-00";
	$emisiune = "Stiri_ora_14";
} elseif(strpos($link, "Stiri_ora_24") !== false) {
	$ora = "23-59";
	$emisiune = "Stiri_ora_24";
} else {
	$ora = "00-00";
	$emisiune = "necunoscuta";
}
$videos = explode("<div class='day_active", $html);
unset($videos[0]);
$videos = array_values($videos);
$videos = array_reverse($videos);
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
	$link = "http://127.0.0.1:82/scripts/util/ant3.cgi?".$link;
	echo '
    <item>
	<title>'.$title.'</title>
    <onClick>playItemURL("'.$link.'",10);</onClick>
	<image>'.$image.'</image>
	</item>
    ';
  }
?>
</channel>
</rss>  
