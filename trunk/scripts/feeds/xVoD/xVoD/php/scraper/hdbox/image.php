<?php

$USE_CACHE = true;

$cachefolder = getcwd()."/cache/";

if( !file_exists( $cachefolder ) ) 
   mkdir( $cachefolder, 0755);

if(isset ($_GET["getimage"])){
   $url =  $_GET["getimage"];
   $hdrs = array( 'http' => array(
       'header'=> "accept-language: en\r\n" . 
           "Host:hd-box.org\r\n" .
           "Referer: http://hd-box.org\r\n" .
           "Content-Type: image/jpeg\r\n"       
       )   
   );
   $context = stream_context_create($hdrs);
   
   $cacheimage = $cachefolder.basename( $url );
   $image = "";
   if ( true == $USE_CACHE && file_exists( $cacheimage ) ){
      $image = file_get_contents( $cacheimage );
   }else {
      $image = file_get_contents( $url, false, $context );
      if( true == $USE_CACHE )
         file_put_contents( $cacheimage, $image );
   }
   
   header("Content-Type: image/jpeg");
   echo $image;
}
else
{
   exit(1);
}

?>