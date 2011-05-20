<?php echo "<?xml version='1.0' encoding='UTF8' ?>"; ?>
<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/">
<onEnter>
  setRefreshTime(1);
</onEnter>
<onRefresh>
  setRefreshTime(-1);
  itemCount = getPageInfo("itemCount");
</onRefresh>
<mediaDisplay name="photoView" 
	fontSize="16" 
	rowCount="7"
	columnCount="3"
	sideColorBottom="10:105:150"
	sideColorTop="10:105:150"
	itemYPC="25"
	itemXPC="5"
	itemGapXPC="1" 
	itemGapYPC="1"     
	rollItems="yes"
	drawItemText="yes" 
	itemOffsetXPC="5"
	itemImageWidthPC="0.1"
	itemImageHeightPC="0.1"
	imageBorderPC="1.5"        
	forceFocusOnItem="yes"
	itemCornerRounding="yes"
	idleImageWidthPC="10"
	idleImageHeightPC="10"
	sideTopHeightPC=20
	bottomYPC=80
	sliding=yes
	showHeader=no
	showDefaultInfo=no
	>
  	<text align="center" offsetXPC="0" offsetYPC="0" widthPC="100" heightPC="20" fontSize="30" backgroundColor="10:105:150" foregroundColor="100:200:255">
		  <script>getPageInfo("pageTitle");</script>
		</text>

  	<text redraw="yes" offsetXPC="85" offsetYPC="12" widthPC="10" heightPC="6" fontSize="20" backgroundColor="10:105:150" foregroundColor="60:160:205">
		  <script>sprintf("%s / ", focus-(-1))+itemCount;</script>
		</text>
  	<text  redraw="yes" align="center" offsetXPC="0" offsetYPC="80" widthPC="100" heightPC="15" fontSize="22" backgroundColor="10:105:150" foregroundColor="100:200:255">
		  <script>print(annotation); annotation;</script>
		</text>
        <idleImage>image/POPUP_LOADING_01.png</idleImage>
        <idleImage>image/POPUP_LOADING_02.png</idleImage>
        <idleImage>image/POPUP_LOADING_03.png</idleImage>
        <idleImage>image/POPUP_LOADING_04.png</idleImage>
        <idleImage>image/POPUP_LOADING_05.png</idleImage>
        <idleImage>image/POPUP_LOADING_06.png</idleImage>
        <idleImage>image/POPUP_LOADING_07.png</idleImage>
        <idleImage>image/POPUP_LOADING_08.png</idleImage>
		<itemDisplay>
				<script>
					idx = getQueryItemIndex();
					focus = getFocusItemIndex();
					if(focus==idx) 
					{
					  annotation = getItemInfo(idx, "annotation");
					}
				</script>
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
    idx -= -21;
    if(idx &gt;= itemSize)
      idx = itemSize-1;
  }
  else
  {
    idx -= 21;
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
<channel>
<?php
function str_between($string, $start, $end){ 
	$string = " ".$string; $ini = strpos($string,$start); 
	if ($ini == 0) return ""; $ini+=strlen($start); $len = strpos($string,$end,$ini) - $ini; 
	return substr($string,$ini,$len); 
}
function str_between2($string, $start, $end){ 
	$string = " ".$string; $ini = strpos($string,$start); 
	if ($ini == 0) return ""; $len = strrpos($string,$end,$ini) - $ini; 
	return substr($string,$ini,$len+strlen($end)); 
}
$host = "http://127.0.0.1:82";
$script = "/scripts";
$base = $host.$script."http://webcast.berkeley.edu/courses.php?semesterid=";


$filelink=$_ENV["QUERY_STRING"];
#$filelink="http://webcast.berkeley.edu/courses.php?semesterid=2008-D";
//http://www.filmesubtitrate.info/seriale-online-subtitrate-in-romana
//http://www.seriale.filmesubtitrate.info/p/seriale-online-subtitrate-in-romana.html
//
$html = file_get_contents($filelink);
$channel_name=str_between($html,'<h4>','</h4>');

	echo '<title>'.$channel_name.'</title>
	<menu>UC Berkeley Webcasts | Video</menu>';

$channel_name=str_between($html,'<h4>','</h4>');
$courses=str_between($html,'<table cellpadding="1" border="0" class="program-listing">','</table>');


$courses2 = explode('</tr><tr',$courses);

foreach ($courses2 as $course)
  {

   $code=str_between($course,'<td class="course-code"><a href=','</td>');
   $code=str_between($code,'">','</a>');
   $description=str_between($course,'<td class="course-name">','</td>');
   $video_rss=str_between($course,'<td class="view"><a href="','">');
   $audio_rss=str_between($course,'<td class="course-name">','</td>');
   
   
  if ($code <> "" and $video_rss <> "")
    {
        echo '
			<item>
			<title>'.$code.' - '.$description.'</title>
			<link>'.$video_rss.'</link>
                        <annotation>'.$description.'</annotation>
			</item>
		';
      
    }
    
  }



/* $html = str_between2($html,'<select id="semester_select" name="semesterid"','</select>'); */
/* $html = str_between2($html,'option value="','</option>'); */
/* $hlps1 = explode('/option>', $html); */


/* foreach($hlps1 as $hlp1) { */
/* 	/\* $videos=explode('href="',$cat); *\/ */
/* 	/\* unset($videos[0]); *\/ */
/* 	/\* $videos=array_values($videos); *\/ */
/* 	/\* foreach($videos as $video) { *\/ */
/* 	/\* 	$t1=explode('"',$video); *\/ */
/* 	/\* 	$link=trim($t1[0]); *\/ */
/* 	/\* 	$t3=explode(">",$video); *\/ */
/* 	/\* 	$t4=explode("<",$t3[1]); *\/ */
/* 	/\* 	$title=str_title($t4[0]); *\/ */
/* 	/\* 	$link = $host."/scripts/filme/php/filmesubtitrate_info.php?query=".$link.",".urlencode($title); *\/ */
/*         /\* if (($title <> "") && (strpos($link,"html") !==false)) { *\/ */
/* #echo $hlp1; */
/*   $id = str_between($hlp1,'"','"'); */
/*   $title = str_between($hlp1,'>','<'); */
/*   if ($title <> "")  */
/*     { */
/*         echo ' */
/* 			<item> */
/* 			<title>'.$title.'</title> */
/* 			<link>'.$base.$id.'</link> */
/* 			</item> */
/* 		'; */
      
/*     } */
    
/*     } */


?>
</channel>
</rss>
