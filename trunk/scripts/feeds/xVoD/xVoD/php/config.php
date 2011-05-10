<?php

//Megaupload cookie
define("MEGAUPLOAD_USER", "");
define("MEGAUPLOAD_COOKIE", "");

//Automated cookie state definition, true with cookie
if( !defined("MEGAUPLOAD_COOKIE") || (MEGAUPLOAD_COOKIE == null) || MEGAUPLOAD_COOKIE == "" ) {
    define("COOKIE_STATE_ACTIVATED", false);
}else {
    define("COOKIE_STATE_ACTIVATED", true);
}

define("UPDATE_DB",false);

//Host server to php pages
define("HOST", "http://127.0.0.1:82");
//Server host with path to pages
define("SERVER_HOST_AND_PATH", HOST . "/xVoD/");
//define("SERVER_HOST_AND_PATH", HOST . "/media/sda1/scripts/xVoD/");
//define("SERVER_HOST_AND_PATH", HOST . "/xVoD/");
//define server path for web interface
define("SERVER_PATH", "http://127.0.0.1:82/xVoD/");
//Internal xtreamer path
define("XTREAMER_PATH", "/tmp/hdd/volumes/HDD1/scripts/xVoD/");
//define("XTREAMER_PATH", "/tmp/usbmounts/sda1/scripts/xVoD/");
//define("XTREAMER_PATH", "xVoD/");
//Internal xtreamer path to images
define("XTREAMER_IMAGE_PATH", "/tmp/hdd/volumes/HDD1/scripts/xVoD/image/");


define("URL_AMP","&amp;");

//------------------------------------------------------------------------------
// xVoD Language - Autoconfig language

if( !isset($_SESSION["xVoDLanguages"]) ) {
    //Recover system language
    $languages = array(
	    0 => "en",	    1 => "cn",	    3 => "es",	4 => "fr",	5 => "de",
	    6 => "it",	    7 => "kr",	    8 => "nl",	9 => "ru",	11 => "he",
	    13 => "hu",	    14 => "pr-b",   16 => "sw",	17 => "sl",	18 => "fi",
	    19 => "ar",	    20 => "pl",	    22 => "ro",	24 => "gr",	25 => "et",
	    998 => "ca",    999 => "pr-p"
    );
    if( file_exists('/tmp/OSDLang') ) {
	$file = @file_get_contents('/tmp/OSDLang', true);
    }else {
	$file = 0;
    }
    //Load full language strings
    //$language = parse_ini_file('lang/default.ini', true, INI_SCANNER_NORMAL );
    //Load user language strings
    if( file_exists( XTREAMER_PATH . 'php/config/lang/' . $languages[ round($file,0) ] . '.ini') ) {
	$languageUser = parse_ini_file('lang/' . $languages[ round($file,0) ] . '.ini', true, INI_SCANNER_NORMAL);
	foreach ($languageUser as $group=>$groupValues) {
	    foreach ($groupValues as $key=>$value) {
		$language[ $group ][ $key ] = $value;
	    }
	}
    }

    $_SESSION["xVoDLanguages"] = serialize( $language );
}

//------------------------------------------------------------------------------
// Get resourceBundle language strings
function resourceString($key) {
    $language = unserialize( $_SESSION["xVoDLanguages"] );
    return $language["language"][$key];
}

//------------------------------------------------------------------------------
//Set loader images for rss
function xVoDLoader($usb=null) {
    if($usb) {
	?>
<idleImage><? echo XTREAMER_IMAGE_PATH; ?>busy/usbpendrive_mount_g.png</idleImage>
<idleImage><? echo XTREAMER_IMAGE_PATH; ?>busy/usbpendrive_mount_r.png</idleImage>
	<?php
    }else {
	?>
<idleImage><? echo XTREAMER_IMAGE_PATH; ?>busy/hdd_mount_g.png</idleImage>
<idleImage><? echo XTREAMER_IMAGE_PATH; ?>busy/hdd_mount_r.png</idleImage>
	<?php
    }
}

?>
