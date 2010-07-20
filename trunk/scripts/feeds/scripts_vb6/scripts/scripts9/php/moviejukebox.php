<?php
header("Content-type: text/xml");
echo"<?xml version='1.0'?>";
?>
<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/">
<channel>
<title>Local Movies</title>
<menu>main menu</menu>
<mediaDisplay  name="onePartView" imageLeftSide="image/MVIX_LIVE_MAIN_BG_2.jpg"
   sideLeftWidthPC="10"
   sideRightWidthPC="0"
   sideColorRight="0:0:0"
   sideColorLeft="0:0:0"
        headerImageWidthPC="0"
        headerImageXPC="10"
        headerXPC="10"
       itemImageXPC="12" 
   itemImageYPC="18"
        itemImageHeightPC="8"
   itemImageWidthPC="7"
        capXPC="0"
        capYPC="0"
        capWidthPC="70"
        capHeightPC="7"
        itemXPC="20"
        itemYPC="18"
        itemHeightPC="9"
        itemWidthPC="60"
        itemPerPage="9"
   backgroundColor="0:0:0"
   idleImageXPC="45"
   idleImageYPC="42"
   idleImageWidthPC="10"
   idleImageHeightPC="16"
     
   >
  <idleImage> image/POPUP_LOADING_01.jpg </idleImage>
  <idleImage> image/POPUP_LOADING_02.jpg </idleImage>
  <idleImage> image/POPUP_LOADING_03.jpg </idleImage>
  <idleImage> image/POPUP_LOADING_04.jpg </idleImage>
  <idleImage> image/POPUP_LOADING_05.jpg </idleImage>
  <idleImage> image/POPUP_LOADING_06.jpg </idleImage>
</mediaDisplay>
<?php
//array with the movies folder and the folder with the pictures
$aMoviesFolder[] = array('movies' => '/tmp/usbmounts/sda1/Movies/', 'images' => '/tmp/usbmounts/sda1/Jukebox/', 'sharedfolder' =>  false, 'user' => '', 'pass' => '');

//where this file is located
$sThisFile = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
//image for the background
$sBackGroundImage = '/scripts/scripts9/image/background.jpg';

//walk $aMoviesFolder array, find out if its network shared folder, mount it and create new array with local and mounted directories 
foreach($aMoviesFolder as $key => $aLocations) {
   
   $aMoviesFolders[$key]['movies'] = $aLocations['movies'];
   $aMoviesFolders[$key]['images'] = $aLocations['images'];
   
   //check if the folder is a shared folder and mount if it is
   if($aLocations['sharedfolder'] == true) {
      $sMname = eregi_replace('\\\\', '-',$aLocations['movies']);
      
      //mount movies directory
      exec('mkdir -p /tmp/myshare/'.$sMname.'-movies');
      exec('umount -f \'/tmp/myshare/'.$sMname.'-movies\'');
      exec('mount -t cifs \''.$aLocations['movies'].'\' \'/tmp/myshare/'.$sMname.'-movies\' -o username='.$aLocations['user'].',password='.$aLocations['pass'].',iocharset=utf8,mapchars,soft,ro');
      $aMoviesFolders[$key]['movies'] = '/tmp/myshare/'.$sMname.'-movies/';
      
      //mount images directory
      exec('mkdir -p /tmp/myshare/'.$sMname.'-images');
      exec('umount -f \'/tmp/myshare/'.$sMname.'-images\'');
      exec('mount -t cifs \''.$aLocations['images'].'\' \'/tmp/myshare/'.$sMname.'-images\' -o username='.$aLocations['user'].',password='.$aLocations['pass'].',iocharset=utf8,mapchars,soft,ro');
      $aMoviesFolders[$key]['images'] = '/tmp/myshare/'.$sMname.'-images/';
   }
}
//list all files and put in an array
foreach($aMoviesFolders as $key => $sMoviesFolders) {
   $aFiles[$key]['movies'] = $sMoviesFolders['movies'];
   $aFiles[$key]['images'] = $sMoviesFolders['images'];
   exec('ls '.$sMoviesFolders['movies'], $aFiles[$key]);
}
//create new array with movie title, location and image location
foreach($aFiles as $aMovie) {
$i = 0;
   foreach($aMovie as $key => $sFile) {
      if($i > 1) {
         $aNmarr[] = array('title' => $sFile, 'location' => $aMovie['movies'], 'image' => $aMovie['images']);
      }
      $i++;
   }
}
//search function that will return the key from matched value
function array_ereg_search($val, $array) {
   $i = 0;
   $return = array();
   foreach($array as $key => $aV) {
      if(eregi($val, $aV['title'])) {
            $return[] = $i;
         }
         
      $i++;
   }
return $return;
}
//function for showing rss item
function generate_item($sTitle, $sLink, $sSearchurl=null) {
   global $sBackGroundImage;
   $item = "<item>\n";
   $item .= "<title>".$sTitle."</title>\n";
   $item .= "<link>".$sLink."</link>\n";
   $item .=(isset($sSearchurl) ? "<search url=\"".$sSearchurl."\" />\n" : "");
   $item .= '<mediaDisplay name=photoFocusView
   imageTopSide="'.$sBackGroundImage.'"
   imageFocus=null
   imageParentFocus=null
   backgroundColor="0:0:0"
   rowCount="1"
   columnCount="5"
   drawItemText="no"
   fontSize="15"
   sideTopHeightPC="100"
   sideColorTop="0:0:0"
   sideColorBottom="0:0:0"
   itemOffsetXPC="9"
   itemOffsetYPC="49"
   itemWidthPC="12.5"
   itemHeightPC="33.3"
   itemBackgroundWidthPC="13.5"
   itemBackgroundHeightPC="35"
   itemGapXPC="1.5"
   focusItemOffsetYPC="20"
   focusItemWidthPC="23.43"
   focusItemHeightPC="62.5"
   focusItemBackgroundWidthPC="24.5"
   focusItemBackgroundHeightPC="65"
   itemBackgroundColor="0:0:0"
   bottomYPC="85"
   itemBorderColor="0:0:0"
   showHeader="no"
   showDefaultInfo="yes"
   idleImageXPC="45"
   idleImageYPC="42"
   idleImageWidthPC="10"
   idleImageHeightPC="16"
   >
   <idleImage> image/POPUP_LOADING_01.jpg </idleImage>
   <idleImage> image/POPUP_LOADING_02.jpg </idleImage>
   <idleImage> image/POPUP_LOADING_03.jpg </idleImage>
   <idleImage> image/POPUP_LOADING_04.jpg </idleImage>
   <idleImage> image/POPUP_LOADING_05.jpg </idleImage>
   <idleImage> image/POPUP_LOADING_06.jpg </idleImage>
   </mediaDisplay>';
   $item .= "\n</item>\n\n";
return $item;
}
//generate new array with the keys returned from search function
if(isset($_GET['action']) && $_GET['action'] == 'movies' && isset($_GET['q']) && $_GET['q'] != '') {
   $res = array_ereg_search($_GET['q'], $aNmarr);
   if(count($res) > 0) {
      foreach($res as $key) {
         $aMovieL[] = $aNmarr[$key];
      }
   }      
}
//display this and exit when array with movies is empty
if(count($aNmarr) == 0 or isset($_GET['action']) && $_GET['action'] == 'movies' && isset($_GET['q']) && $_GET['q'] != '' && count($aMovieL) == 0) {
   echo "<item>\n";
   echo "<title>#No movies found!</title>\n";
   echo "</item>\n";
   echo "</channel>\n";
   echo "</rss>\n";
   
   exit;
}
//generate array with only the first letters of the movies
foreach ($aNmarr as $key => $val) {
   $aFirstLetter[] = ucfirst(substr($val['title'], 0, 1));
}
//get keys from movie titles which begins with the selected first letter
if (isset($_GET['action']) && $_GET['action'] == 'movies') {
   if($_GET['q'] == '') {
      $arrkeys = (isset($_GET['letter']) && $_GET['letter'] != '' && in_array($_GET['letter'], $aFirstLetter)? array_keys($aFirstLetter, $_GET['letter']) : array_keys($aFirstLetter));
      foreach($arrkeys as $key => $keys) {
         $aMovieL[] = $aNmarr[$keys];
      }
   }

   sort($aMovieL);
   foreach ($aMovieL as $aMovie) {
      $sFile = $aMovie['location'].$aMovie['title'];
      $aFileinfo = stat($sFile);
      $info = pathinfo($sFile);
      $file_name = basename($sFile, '.'.$info['extension']);
      $file_name = eregi_replace("\'", " ", $file_name);
      $file_name = eregi_replace("\.", " ", $file_name);
      $file_name = eregi_replace("(_)", " ", $file_name);
      $sCimagepath = $aMovie['image'].$file_name.'_large.png';
      if (file_exists($sCimagepath)) {
         $sCimage = $sCimagepath;
      }
      else {
         $sCimage = $aMovie['image'].'nocover.png';
      }
      echo "<item>\n";
      echo '<title>#'.$iResCount.' '.$file_name." ( ".$aFileinfo['size']." Bytes )</title>\n";
      echo '<media:thumbnail url="'.$sCimage."\" />\n";
      echo(is_dir($sFile) ? '<link>file://'.$sFile."</link>\n" : '');
      echo(is_dir($sFile) ? '' : "<enclosure type=\"video/mp4\" url=\"".$sFile."\"/>\n");
      echo '<mediaDisplay name="onePartView"
      imageLeftSide="'.$sBackGroundImage.'"
      sideLeftWidthPC="100"
      sideRightWidthPC="0"
      sideBottomWidth="100"
      backgroundColor="0:0:0"
      sideColorBottom="0:0:0"
      itemXPC="10"
      itemYPC="20"
      itemHeightPC="8"
      itemWidthPC="80"
      itemPerPage="8"
      showHeader="no"
      bottomYPC="85"      
      idleImageXPC="45"
      idleImageYPC="42"
      idleImageWidthPC="10"
      idleImageHeightPC="16"
      >
      <idleImage> image/POPUP_LOADING_01.jpg </idleImage>
      <idleImage> image/POPUP_LOADING_02.jpg </idleImage>
      <idleImage> image/POPUP_LOADING_03.jpg </idleImage>
      <idleImage> image/POPUP_LOADING_04.jpg </idleImage>
      <idleImage> image/POPUP_LOADING_05.jpg </idleImage>
      <idleImage> image/POPUP_LOADING_06.jpg </idleImage>
      </mediaDisplay>';
      echo "\n</item>\n\n";
   }
}
else {
   echo generate_item("Show all", $sThisFile."?action=movies");
   echo generate_item("Search Movies", "rss_command://search", $sThisFile."?action=movies&amp;q=%s");      
   
   foreach (array_count_values($aFirstLetter) as $sLetter => $iCount) {
      echo generate_item($sLetter."         ( ".$iCount." movie".($iCount > 1 ? "s" : "")." )", $sThisFile."?action=movies&amp;letter=".$sLetter);
   }
}
?>
</channel>
</rss>