<?php
# Version 0.3
$smversion = "0.3";
$skinpath = "skins";
$versionfile ="$skinpath/original/version.txt";
$internetversionfile ="http://xtreamer-web-sdk.googlecode.com/svn/trunk/xmp/skins/original/version.txt";
$extractpath = "/usr/local/bin/Resource/bmp/";


$skinpathoffset  = "/scripts/scripts9/";
$scriptfile  = "http://127.0.0.1/media/sda1/scripts/skin_manager.php";

$skin     = $_GET["skin"];
$urlskin  = rawurlencode($skin);
$mdskin   = str_replace(" ", "\ ", $skin);

$original = $_GET["original"];
$newskins = $_GET["newskins"];
$root = $_GET["root"];
$home   = $_GET["home"];
$backup   = $_GET["backup"];
$update = $_GET["update"];
$debug    = $_GET["debug"] ;
$skinpage = "http://xtreamer-web-sdk.googlecode.com/svn/trunk/xmp/skins";

$skinmainicon = "http://xtreamer-web-sdk.googlecode.com/svn/trunk/rss/scripts/image/skin_browser.jpg";
$skinmainiconnew = "http://xtreamer-web-sdk.googlecode.com/svn/trunk/rss/scripts/image/skin_browser_new.jpg";

$skinoriginalicon = "http://xtreamer-web-sdk.googlecode.com/svn/trunk/rss/scripts/image/original_backup.jpg";
$skinbrowserupgrade = "http://xtreamer-web-sdk.googlecode.com/svn/trunk/rss/scripts/image/skin_browser_upgrade.jpg";

header("Content-type: text/xml");
echo "<?xml version='1.0' ?>";
echo '<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/">'."\n";
echo "<channel>\n";


/* MAIN */
if ( "" != $home  ){
   exec("echo -n '!' > /tmp/ir");
}
else if ( "" != $skin  ){
   changeSkin( );
}
else if ( "" != $newskins  ){
   getNewSkins( );
   entermainmenu();
}
else if ( "" != $root  ){
   skin_browser();
}
else if ( "" != $update  ){
   skin_browser_update();
   printitem( "Reload Skin Browser", $scriptfile , $skinmainicon, 'photoView23' );
}
else if ( "" != $backup  ){
   backup_original_skin();
}
else
{
   entermainmenu();
}




function entermainmenu()
{
   global $skinpath, $scriptfile, $skinmainicon, $skinmainiconnew;
   printitem( "Skin Browser", $scriptfile.'?root=true' , $skinmainicon, 'photoView23' );
   printitem( "Check for new skins", $scriptfile.'?newskins=true' , $skinmainiconnew, 'photoView23' );
   if (! file_exists("$skinpath") )  {
      system("mkdir $skinpath" );
   }
   checkNewOriginalSkinVersion();
   checkNewSkinManagerVersion();
}

function checkNewSkinManagerVersion()
{
   global $smversion, $scriptfile, $skinbrowserupgrade;

   $skinbrowserversion = substr( file_get_contents("http://xtreamer-web-sdk.googlecode.com/svn/trunk/rss/scripts/skin_manager.php"), 16, 3) ;
   if( $skinbrowserversion != $smversion){
      printitem( "New Skinmanager version $skinbrowserversion available, current is $smversion", $scriptfile.'?update=true' , $skinbrowserupgrade, 'photoView23' );
   }
}

function skin_browser_update()
{
   $filename = "skin_manager.php";
   if( is_file($filename) ){
      $filecontent = file_get_contents("http://xtreamer-web-sdk.googlecode.com/svn/trunk/rss/scripts/skin_manager.php");
      $f = fopen($filename,'wb');
      fwrite($f,$filecontent,strlen($filecontent));
      fclose($f);
   }
}

function changeSkin(  )
{
   global $scriptfile,$extractpath, $skinpage, $skinpath, $mdskin, $urlskin, $skin,$skinmainicon,$skinpathoffset;
   $title = "$skin skin installed successfull !";
   if ( ! file_exists( "$skinpath/$skin/$skin.zip" ) ){
      exec("wget '$skinpage/$urlskin/$urlskin.zip' -O '$skinpath/$mdskin/$mdskin.zip'", $output[], $retval );
   }

   if ($retval) {
      print_r($output);
      $title = "file wget $skin failed ";
   }
   else {
      if ( file_exists( "$skinpath/$skin/$skin.zip" ) ) {
         system("unzip -o '$skinpath/$skin/$skin.zip' -d $extractpath", $retval);
         if ( $retval != "0"){ $title = 'Install failed!'; }
      }
      else if ( file_exists( "$skinpath/$skin/$skin.tar.gz" ) ){
         system("./busybox tar -xzvf '$skinpath/$skin/$skin.tar.gz' -C /", $retval);
         if ( $retval != "0") { $title = 'Install failed!'; }
      }
      else{
         $title = "file $skinpath/$skin/$skin.zip not found";
      }
   }
   echo "<title>$title</title>\n";
   printitem( "Return to MAIN MENU", $scriptfile.'?home=1', "$skinpathoffset$skinpath/$skin/$skin.jpg", 'photoView23' );
   printitem( "Return to SKIN BROWSER", $scriptfile, $skinmainicon, 'photoView23' );

}


function skin_browser()
{
   global $scriptfile, $skinpath, $skinpathoffset, $skinpage, $smversion;
   $title = "SKIN BROWSER V$smversion";
   echo "<title>$title</title>\n";

   exec("ls $skinpathoffset$skinpath/*/*.jpg", $aSkins );
   foreach( $aSkins as $skinfile ){
      $skinname = basename(dirname($skinfile));
      printitem( $skinname, $scriptfile.'?skin='.urlencode($skinname), $skinfile, 'photoView23' );
   }
} //


function getNewSkins( )
{
   global $skinpage, $skinpath;
   @exec("ping google.de", $retval);

   if ( substr_count( $retval[0] , "is alive!") == 1) {
      $filecontent = explode("\n", @file_get_contents( $skinpage ) );
      foreach( $filecontent as $line ){
         list($key, $val) = explode("<li><a href=\"", $line );
         if( $key != "" && $val ){
            list($skin, $val) = explode("/\"", $val );
            $skin     = str_replace("%20", " ", $skin);
            $urlskin  = rawurlencode($skin);
            $mdskin   = str_replace(" ", "\ ", $skin);

            if( "" != $skin && ".." != $skin && ! file_exists( "$skinpath/$skin/$skin.jpg" )  ) {
               exec("mkdir $skinpath/$mdskin" );
               exec("wget '$skinpage/$urlskin/$urlskin.jpg' -O '$skinpath/$mdskin/$mdskin.jpg'" );
            }
         }
      } // end foreach
   }
}



function backup_original_skin()
{
   global $skinpath, $extractpath, $scriptfile, $skinpage, $skinmainicon, $skinpathoffset;

   if (! file_exists("./busybox") )  {
      @exec("wget http://xtreamer-web-sdk.googlecode.com/svn/trunk/xmp/busybox" );
      @exec("chmod +x ./busybox" );
   }

   if ( file_exists( "./busybox" ) ){
      if (! file_exists("$skinpath/original") )  {
         system("mkdir $skinpath/original" );
         system("wget '$skinpage/original/original.jpg' -O '$skinpath/original/original.jpg'");
      }
      if (! file_exists("$skinpath/original/original.jpg") )  {
         system("wget '$skinpage/original/original.jpg' -O $skinpath/original/original.jpg");
      }

      if (! file_exists("$skinpath/original/original.tar.gz") )  {
         system("rm -f $skinpath/original/original.tar.gz" );
      }

      @system("./busybox tar -czvf $skinpath/original/original.tar.gz $extractpath*.bmp", $retval );
      if ( $retval == "0") {
         $version = getVersion();
         system("echo $version > $skinpath/original/version.txt");
         $title = "Original backup successfull!";
      }
      else  $title = " cmd (\"./busybox tar -czvf $skinpath/original/original.tar.gz $extractpath*.bmp \" failed<br>\n";
   }
   else{
      $title = "busybox application not found in xmp !";
   }
   echo "<title>$title</title>\n";
   printitem( "Return to Skin Browser", $scriptfile, $skinmainicon, 'photoView23' );
   printitem( "Return to Main Menu", $scriptfile.'?home=1', "$skinpathoffset$skinpath/original/original.jpg", 'photoView23' );

}

function checkNewOriginalSkinVersion()
{
   global $versionfile, $internetversionfile, $skinoriginalicon;
   $title = "";
   $internetversion = rtrim( file_get_contents($internetversionfile) );
   $version = getVersion();

   if ($internetversion == $version ){
      system("wget '$skinpage/original/original.tar.gz' -O $skinpath/original/original.tar.gz");
      system("echo $version > $skinpath/original/version.txt");
   }

   if ( file_exists( $versionfile ) ){
      $foundversion = rtrim( file_get_contents($versionfile) );
      if ( $version != $foundversion ) {
         $title = "New Version found : $foundversion, expected: $version, please perform backup";
      }
   }
   else{
      $title =  "versionfile: $versionfile not found! Please perform backup!";
   }
   return $title;
   if( "" != $title ){
      printitem( $title, $scriptfile.'?backup=true' , $skinoriginalicon, 'photoView23' );
   }
}

function getVersion()
{
   // check if original backup is too old:
   // cat /usr/local/etc/dvdplayer/XTR_setup.dat
   // content of XTR_setup.dat: ?� VER 2.1.2??dddddddddddd�?????d????/tmp/usbmounts/sda1/xmp/www
   $versionstring = file_get_contents("/usr/local/etc/dvdplayer/XTR_setup.dat");
   $version = substr($versionstring, strpos($versionstring, "VER")+4, 3);
   return $version;
}

/*******************************************************
 * printitem - helper function for folder items
 *             including subentries
 */
function printitem( $title, $link, $mediaimage, $style, $searchurl="")
{
   global $fontsize, $scriptfile, $defaultfanart;

   $output =  "<item>\n";
   $output.=  "<title>$title</title>\n";
   $output.=  '<link>'.$link."</link>\n";
   $output.=  getItemThumbnail($mediaimage);
   $output.= $style();
   //$output.= submenu( "Original skin backup", $scriptfile.'?backup=true', 'photoView23' );
   $output.= "\n</item>\n\n";
   echo $output;
}


function submenu( $title, $link, $style )
{
   $output = '
   <submenu name="'.$title.'" description="'.$title.'" width="200">
         <title>'.$title.'</title>
         <link>'.$link.'</link>
         '.$style().'
   </submenu>';
   return $output;
}


function getItemThumbnail( $image )
{
   global $debug;
   $image = str_replace(" ", "%20", $image);
   $ret = '<media:thumbnail url="'.$image.'" />'."\n";

   if ( "" != $debug )
      $ret = "";
   return $ret;
}

function photoView23()
{
   global $fontsize;
   $output =  '<mediaDisplay name=photoView
            rowCount="2"
            columnCount="3"
            itemBorderColor="0:255:180"
            drawItemText="no"
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
      ';
      return $output;
}


?>
</channel>
</rss>
