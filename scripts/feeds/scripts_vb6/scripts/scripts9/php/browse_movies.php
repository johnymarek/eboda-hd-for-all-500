<?php

/*******************************************************
 * Configuration
 */

$roottitle           = "RSS MOVIE BROWSER";
$root                = "/tmp/usbmounts/";

$directorydepth      = 6;
$moviedb             = "/tmp/usbmounts/sda1/scripts/php/moviedb.txt";
$moviefolderscfg     = "/tmp/usbmounts/sda1/scripts/php/scan_folder_settings.txt";
$fontsize            = 16;
$defaultposterfolder = 'http://xtreamer-web-sdk.googlecode.com/svn/trunk/rss/scripts/image/defaultposterfolder.png';
$defaultpostermovies = 'http://xtreamer-web-sdk.googlecode.com/svn/trunk/rss/scripts/image/defaultpostermovies.png';
$defaultfanart       = 'http://xtreamer-web-sdk.googlecode.com/svn/trunk/rss/scripts/image/background.jpg';
$scriptfile          = "http://127.0.0.1/media/sda1/scripts/php/browse_movies.php";
$scanforfolderposter = "folder.jpg";

//not all working extensions?!
$supported_extensions = array( "iso", "mov", "3g2", "3gp", "asf", "asx", 
                               "avi", "avs", "d2v", "d3v", "dat", "divx", 
                               "dv", "dvr-ms", "dvx", "f4v", "m1v", "m2t", 
                               "m2ts", "m2v", "m4v", "mgv", "mkv", "mp4", 
                               "mpeg", "mpg", "mts", "ogm", "ogv", "rm", 
                               "rts", "swf", "ts", "wmv", "xvid" 
                               );

/*******************************************************/



header("Content-type: text/xml");
echo"<?xml version='1.0' ?>";
echo '<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/">';
echo '<channel>';

$moviearray    = array();
$aMovieFolder  = array();
$aMovieFiles   = array();
$moviedbcontent = array();
$moviepage     = $_GET["page"] ;
$debug         = $_GET["debug"] ;
$searchkey     = $_GET["searchkey"] ;
$firstletter   = $_GET["firstletter"] ;
$tmpfile       = "/tmp/searchmoviedb.txt";
$moviewallversion  = "/tmp/.moviewall.v0.7";



/*******************************************************
 * Main
 */

if ("" != $searchkey || "" != $firstletter ){   
   echo "<title>$searchkey</title>\n";
   if ( file_exists( $moviedb ) ) {
      $movies = unserialize(file_get_contents($moviedb)); 
      searchmovie( $movies, $searchkey, $firstletter );
   }
   else{
      createdb();
      $movies = unserialize(file_get_contents($moviedb)); 
      searchmovie( $movies, $searchkey, $firstletter );
   }
   printfiles();
}
else if ( "" == $moviepage ){
   echo "<title>$roottitle</title>\n";
   if ( ! file_exists( $moviewallversion ) || ! file_exists( $moviedb ) || ! filesize( $moviedb ) ){
      debugprint("createdb!", "$moviewallversion - $moviedb - ".file_exists( $moviedb )." - ".filesize( $moviedb ) );
      createdb();
      @exec("touch ".$moviewallversion );
   }
   
   entermainmenu();
}
else{
   $moviepage = str_replace("%20", " ", $moviepage);
   $title = strtoupper(basename($moviepage));
   echo "<title>$title</title>\n";
   if ( file_exists( $moviedb ) ) {
      $moviedbcontent = unserialize(file_get_contents($moviedb)); 
   }  
   
   if ($root == $moviepage){
      $allowedscanpath = file( $moviefolderscfg );
      $pages = array();
      foreach ($allowedscanpath as $page ){
         scanfolder( (trim($page)), $moviedbcontent, true );
      }
   }
   else
   {
      scanfolder( $moviepage, $moviedbcontent );
   }
   printfolder();
   printfiles();
}






/*******************************************************
 *                    FUNCTIONS
 *******************************************************/

/*******************************************************
 * entermainmenu - first menu entry.
 */
function entermainmenu()
{
   global $scriptfile, $moviedb, $root;
   printitem( "Browse HDD", $scriptfile.'?page='.$root , "http://xtreamer-web-sdk.googlecode.com/svn/trunk/rss/scripts/image/X.png" );
      
   $sFirstLetter = "";
   if ( file_exists( $moviedb ) ) {
      printitem( "Search video", "rss_command://search", "http://xtreamer-web-sdk.googlecode.com/svn/trunk/rss/scripts/image/X.png", $scriptfile.'?searchkey=%s' );
      $movies = unserialize(file_get_contents($moviedb)); 
      //debugprint("entermainmenu", print_r($movies));
        
      foreach( $movies as $movie ) {
         //debugprint("entermainmenu", $file);
         $sFirstLetter .= strtoupper(substr(basename($movie['file']), 0, 1 ));
      }
      foreach (count_chars($sFirstLetter,1) as $sLetter => $iCount) {      
         echo printitem(chr($sLetter)."  ( ".$iCount." movie".($iCount > 1 ? "s" : "")." )", $scriptfile.'?firstletter='.urlencode(chr($sLetter)), "http://xtreamer-web-sdk.googlecode.com/svn/trunk/rss/scripts/image/X.png"  );
      }
   }
}


/*******************************************************
 * createdb - called once from main menu if db not exists.
 */
function createdb()
{
   global $supported_extensions, $moviedb, $moviefolderscfg, $directorydepth, $root;
   $extended_grep = "\.dummy";  
   foreach( $supported_extensions as $extension ) {
      $extended_grep .= "|\.$extension";
   }
   $moviearray = array();
   $aMovieArray = array();
   $allowedscanpath = file( $moviefolderscfg );
   foreach( $allowedscanpath as $allowedpath ) {      
      //exec('du -xashd '.$directorydepth.' '.$allowedpath.' | grep -E "('.$extended_grep.')"  >> '.$moviedb );
      exec('du -xashd '.$directorydepth.' '.$allowedpath, $moviearray );
   }
   debugprint("DB", print_r($moviearray));
   foreach( $moviearray as $movie ){
      list( $size, $file ) = explode("\t", $movie );
      $file = trim($file);
      if ( extensionAllowed( $file )){         
         $mov['ext'] = substr( $movie, -3, 3 );
         $mov['size'] = $size;
         $mov['file'] = $file;
         $mov['fname'] = basename($file);
         $aMovieArray[] = $mov;

      }else if (@is_dir($file)){
         $mov['ext'] = "dir";
         $mov['size'] = $size;
         $mov['file'] = $file;
         $mov['fname'] = basename($file);
         $aMovieArray[] = $mov;
      }
   }
   debugprint("DB", print_r($aMovieArray));
   
   $fp = fopen($moviedb, 'w') or die("I could not open $filename.");
   fwrite($fp, serialize($aMovieArray));
   fclose($fp);
}

/*******************************************************
 * searchmovie - called from main menu 
 *               or from search movie (sub)menu
 */
function searchmovie( $movies, $key, $firstletter ){
   global $aMovieFiles;
       
   foreach( $movies as $movie ) {
      if( $firstletter != "" ){
         if( strtoupper($firstletter) == strtoupper(substr(basename($movie['file']), 0, 1 )) ) {
            $aMovieFiles[] = $movie;
         }
      }else
      if (FALSE != stristr($movie['file'], $key)) {
         $aMovieFiles[] = $movie;
      }
   }
}

/*******************************************************
 * scanfolder - called when browse movies from hdd
 */
function scanfolder( $moviepage, $movies, $scancurrentdir = false )
{
   global $aMovieFolder, $aMovieFiles, $moviedb, $root;
   
   debugprint("scanfolder moviepage", $moviepage );
   $folder2 = str_replace(" ", "\ ", $moviepage);
   debugprint("scanfolder moviepage", $folder2 );
   $cmd = ($scancurrentdir) ? 'du -ahd 0 '.$folder2 : 'du -ahd 1 '.$folder2;
   debugprint("scanfolder", $cmd );
   @exec( $cmd , $moviearray );
   print_r( $moviearray );


   foreach( $moviearray as $movie ){
      list( $size, $file ) = explode("\t", trim($movie), 2 );
      $file = trim($file);
   debugprint("scanfolder file", $file);

      if ( extensionAllowed( $file )){         
   debugprint("scanfolder allowed", $file);
         $mov['ext'] = substr( $movie, -3, 3 );
         $mov['size'] = $size;
         $mov['file'] = $file;
         $mov['fname'] = basename($file);
         $aMovieFiles[] = $mov;

      }else if (is_dir($file) && ( realpath($moviepage) != realpath($file) || $scancurrentdir ) ){
   debugprint("scanfolder dir", $file);
         $mov['ext'] = "dir";
         $mov['size'] = $size;
         $mov['file'] = $file;
         $mov['fname'] = basename($file);
         $aMovieFolder[] = $mov;
      }
   }
   /*
   //debugprint("scanfolder(db)", print_r($movies) );
   foreach( $movies as $moviefile ) {
      //debugprint("scanfolder(mov)", print_r($moviefile) );
      $scandir = ($scancurrentdir) ? $moviefile['file'] : dirname($moviefile['file']);
      if ( "dir" == ( $moviefile['ext'] ) )
      {
         if ( $scandir == realpath($moviepage)) {
            debugprint("scanfolder(dir)", $moviefile['file']." - ".$moviepage );
            $moviefolderfile = checkForMoviefolder( $moviefile['file'] );
            if ( "" != $moviefolderfile ) {
               debugprint("scanfolder(mf-)", $moviefolderfile );
               $aMovieFiles[] = $moviefolderfile;
            }
            else{
               debugprint("scanfolder(f)", $moviefile['file'] );    
               $aMovieFolder[] = $moviefile;
            }
         }
      }else{
         if ( $scandir == realpath($moviepage) ) {
            debugprint("scanfolder(m)", $moviefile['file'] );    
            $aMovieFiles[] = $moviefile;
         }
      }
   }
   */
}


/*******************************************************
 * printfolder - print out all folder items
 */
function printfolder( )
{
   global $aMovieFolder, $defaultposterfolder, $scriptfile, $defaultfanart;
   
   if ( 0 < count($aMovieFolder))
   foreach( $aMovieFolder as $aFolder ) {
      debugprint("printfolder(m)", $aFolder['file'] );    
      $sFile = realpath($aFolder['file'])."/";         
      $sCimage = $aFolder['file'].'/folder.jpg';
    
      if( !file_exists($sCimage)) {
         $sCimage = $defaultposterfolder;
      }

      $title = strtoupper(basename($aFolder['file']))." - ".$aFolder['size'];
      printitem($title, $scriptfile.'?page='.urlencode($aFolder['file']) , $sCimage  );
   }   
}

function cmp_fname($a, $b)
{
    if ( strtolower( $a[ 'fname' ] )== strtolower( $b[ 'fname' ] ) ) {
        return 0;
    }
    return ( (strtolower( $a[ 'fname' ] ) < strtolower( $b[ 'fname' ] ) ) ? -1 : 1);
}

/*******************************************************
 * printfiles - print out all file/movie items
 */
function printfiles( )
{
   global $aMovieFiles, $supported_extensions, $debug, $defaultpostermovies, $scanforfolderposter;
   debugprint( "printfiles ar", print_r($aMovieFiles) );
   usort($aMovieFiles,'cmp_fname');
   if ( 0 < count($aMovieFiles))
   foreach( $aMovieFiles as $aFile ) {        
      $file_name =  substr($aFile['fname'], 0 , -4 );
      $sCimage = dirname($aFile['file'])."/".$file_name.'.jpg';

      if( !file_exists($sCimage)) {
         if( basename(dirname($aFile['file'])) == $file_name ) {
            $sCimage = dirname($aFile['file'])."/$scanforfolderposter";
         }else{
           $sCimage = $defaultpostermovies;
         }
      }
      
      $output = "<item>\n";
      
      $output.= "<title>$file_name - ".$aFile['size']."</title>\n" ;
      $output.=  getItemThumbnail($sCimage);
      $output.= '<link>file://'.$aFile['file'].'</link>';
      $output.= "<enclosure type=\"video/mp4\" url=\"".$aFile['file']."\"/>\n";
      
      $output.= "\n</item>\n\n";
      echo $output;
   }
}

/*******************************************************
 * printitem - helper function for folder items
 *             including subentries
 */
function printitem( $title, $link, $mediaimage, $searchurl="")
{
   global $fontsize, $scriptfile,$defaultfanart;
   
   $output =  "<item>\n";
   $output.=  "<title>$title</title>\n";
   $output.=  '<link>'.$link."</link>\n";
   $output.=  getItemThumbnail($mediaimage);
   $output.=  ($searchurl == "") ? '' : '<search url="'.$searchurl.'" />'."\n";
   $output.=  '<mediaDisplay name="photoView" 
      width="200"
      fontSize="'.$fontsize.'" 
      rowCount="2"
      columnCount="7"

      menuBorderColor="20:20:20"
      menuOffsetYPC="8"
      menuOffsetXPC="8"
      menuWidthPC="100"
      
      rollItems="no"
      drawItemText="no"
      sideColorBottom="0:0:0"
      sideColorTop="0:0:0"
      sideColorLeft="0:0:0"
      sideColorRight="0:0:0" 
      itemImageXPC="10"
      itemImageYPC="0"

      itemOffsetXPC="7"
      itemOffsetYPC="20"
      backgroundColor="0:0:0"   
      itemBorderColor="0:255:180"
      '.            
      /*
      sideTopHeightPC="10"
      centerYPC="35"
      centerHeightPC="90"
      itemBackgroundColor="0:0:0"
      imageBottomSide="http://xtreamer-web-sdk.googlecode.com/svn/trunk/rss/scripts/image/background.jpg"
      backgroundImage="http://xtreamer-web-sdk.googlecode.com/svn/trunk/rss/scripts/image/background.jpg"
      canAddToFavorit="no"
      viewAreaXPC="2"
      menuOffsetYPC="6"
      */
      '
      sliding="no"
      idleImageXPC="45"
      idleImageYPC="42"
      idleImageWidthPC="7"
      idleImageHeightPC="16"
      >
       <idleImage> image/POPUP_LOADING_01.jpg </idleImage>
       <idleImage> image/POPUP_LOADING_02.jpg </idleImage>
       <idleImage> image/POPUP_LOADING_03.jpg </idleImage>
   
       <idleImage> image/POPUP_LOADING_04.jpg </idleImage>
       <idleImage> image/POPUP_LOADING_05.jpg </idleImage>
       <idleImage> image/POPUP_LOADING_06.jpg </idleImage>
                    
      </mediaDisplay>
      ';
      
      if($searchurl == "" && $firstletter == ""){
         $output.= '
         <submenu name="Main Menu" description="Go to Main Browser Menu" width="200">
              <title>Movie Browser</title>
              <link>http://127.0.0.1/media/sda1/scripts/browse_movies.php</link>
              '.getItemThumbnail( "http://xtreamer-web-sdk.googlecode.com/svn/trunk/rss/scripts/image/moviewall.jpg" ).'
              <mediaDisplay name="photoView"
                  rowCount="8" columnCount="4" 
                  itemBorderColor="0:255:180"
                  drawItemText="yes"
                menuBorderColor="20:20:20"
                sideColorBottom="20:20:20"
                sideColorTop="20:20:20"
                itemImageXPC="10"
                itemOffsetXPC="7"
                backgroundColor="0:0:0"
                     idleImageXPC="45"
                     idleImageYPC="42"
                     idleImageWidthPC="7"
                     idleImageHeightPC="16"
                  >
             <idleImage> image/POPUP_LOADING_01.jpg </idleImage>
             <idleImage> image/POPUP_LOADING_02.jpg </idleImage>
             <idleImage> image/POPUP_LOADING_03.jpg </idleImage>
         
             <idleImage> image/POPUP_LOADING_04.jpg </idleImage>
             <idleImage> image/POPUP_LOADING_05.jpg </idleImage>
             <idleImage> image/POPUP_LOADING_06.jpg </idleImage>
            </mediaDisplay>
         </submenu>
         
         <submenu name="view showcase" description="showcase demo" width="200">
            <title>'.$title.'</title>
            <link>'.$link.'</link>
            <mediaDisplay name="photoFocusView" 
               imageTopSide="'.$defaultfanart.'" 
               imageFocus="null" 
               imageParentFocus="null" 
               backgroundColor="0:0:0" 
               rowCount="1" 
               columnCount="9" 
               drawItemText="no" 
               fontSize="15"    
   
              sideTopHeightPC="100"
              sideColorTop="0:0:0"
              sideColorBottom="0:0:0"
               itemOffsetXPC="7"
               itemOffsetYPC="60"
               itemWidthPC="8"
               itemHeightPC="25"
               itemBorderColor="0:250:180"
               itemBackgroundWidthPC="0"
               itemBackgroundHeightPC="0"
               itemBackgroundColor="0:250:180"
               itemGapXPC="1"
              focusItemOffsetYPC="54"
              focusItemWidthPC="12"
              focusItemHeightPC="32"
              focusItemBackgroundWidthPC="12.5"
              focusItemBackgroundHeightPC="32.5"
               bottomYPC="88"
               showHeader="no"
           capXPC="90"
                          capYPC="22"
                          capHeightPC="10"
                    headerImageWidthPC="0"
                         headerXPC="2"
                         headerYPC="3"
                         headerWidthPC="100"
                         headerCapXPC="90"
                         headerCapYPC="10"
                         headerCapWidthPC="0"
                           menuWidthPC="25"
                           menuXPC="5"
                showDefaultInfo="yes"/>
         </submenu>
   
         <submenu name="Search Movie" description="Search Movies using keyword" width="200">
             <url>'.$scriptfile.'?searchkey=%s</url>
             <nextPageItemCount>48</nextPageItemCount>
             <input name="keyword">keyword</input>
         </submenu>
         '.
         /*
         <submenu name="Kinder" description="Favouriten Kinder" width="100">
             <url>'.$scriptfile.'?page=/tmp/usbmounts/sdb1/kinder/</url>
             <nextPageItemCount>48</nextPageItemCount>
         </submenu>
         */            
         '';
      }

   $output.= "\n</item>\n\n";
   echo $output; 
}










/*******************************************************
 * debugprint - for debug purposes
 */
function debugprint( $msg, $value )
{
   global $debug;
   if ( "" != $debug )
      echo "### $msg: $value <br/>\n";
}


/*******************************************************
 * getItemThumbnail - wrapper for debug purposes
 *   because firefox can't validate media:thumbnail tag.
 */
function getItemThumbnail( $image )
{
   global $debug;
   $ret = '<media:thumbnail url="'.$image.'" width="80" height="120" />'."\n";

   if ( "" != $debug )
      $ret = "";
   return $ret;
}

/*******************************************************
 * extensionAllowed - check for right extension.
 */
function extensionAllowed( $file )
{
   global $supported_extensions;
   $retval = false;
   $extension = substr( $file, -3, 3); 
   if ( FALSE !== array_search ( strtolower( $extension ), $supported_extensions ) ){
      $retval = true;
   }
   return $retval;
}

/*******************************************************
 * checkForMoviefolder - check for movie in folder with same name.
 */
function checkForMoviefolder( $folder )
{
   global $tmpfile;
   
   $returnfile = "";
   $folder2 = quotemeta($folder);
   $folder2 = str_replace(" ", "\ ", $folder2);
   $result = exec('du -ash '.$folder2.'/'.basename($folder2).'.* > '.$tmpfile );
   //debugprint("result", 'du -ash '.$folder2.'/'.basename($folder2).'* > '.$tmpfile );
   $movies = file( $tmpfile );
   
   if(0 < count($movies)){      
      foreach( $movies as $moviefile ) {
         $moviefile = trim($moviefile);
         debugprint("Moviefolder", $moviefile );
         if( extensionAllowed( basename($moviefile) ) ){
            list( $size, $file ) = explode("\t", $moviefile );
            $file = trim($file);
            $returnfile = array();
            $returnfile['file'] = $file;
            $returnfile['size'] = $size;
            $returnfile['ext'] = "dummy";
            break;
         }         
      }
   }
   return $returnfile;
}


?>
</channel>
</rss>