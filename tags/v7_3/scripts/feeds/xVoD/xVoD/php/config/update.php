<?php

$oldDB = "data/db/xvod.sqlite3.db";
$newDB = "data/db/xvod.sqlite3.new.db";
$configFile = "config/config.php";

if( file_exists($oldDB) && file_exists($newDB) ){
    //Get connection
    $connection = ConnectionFactory::getDataConnection();
    //Get user bookmarks
    $bookmarks = $connection->getBookmarks();
    //Delete old db and change new one
    rename($oldDB,"data/db/xvod.sqlite3.old.db");
    rename($newDB,$oldDB);

    //Connection to new database
    $connection = ConnectionFactory::getDataConnection();
    foreach ( $bookmarks as $id => $bookmark){
	$connection->addBookmark(
		$bookmark->getName(),
		$bookmark->getDescription(),
		$bookmark->getLink(),
		$bookmark->getImage()
		);
    }

    //Set updated
    $lines = file($configFile);
    $out = "";
    foreach ($lines as $line) {
	if( strpos($line,"UPDATE_DB") ) {
	   $change = strstr($line,"true") ? true : false;
	   $line = str_replace( $change?"true":"false", !$change?"true":"false", $line);
	}
	$out .= $line;
    }
    $f = fopen($configFile, "w");
    fwrite($f, $out);
    fclose($f);
    
}else if( !file_exists($oldDB) && file_exists($newDB) ){
    rename($newDB,$oldDB);
    //Set updated
    $lines = file($configFile);
    $out = "";
    foreach ($lines as $line) {
	if( strpos($line,"UPDATE_DB") ) {
	   $change = strstr($line,"true") ? true : false;
	   $line = str_replace( $change?"true":"false", !$change?"true":"false", $line);
	}
	$out .= $line;
    }
    $f = fopen($configFile, "w");
    fwrite($f, $out);
    fclose($f);
    
}else{
    //Set updated
    $lines = file($configFile);
    $out = "";
    foreach ($lines as $line) {
	if( strpos($line,"UPDATE_DB") ) {
	   $change = strstr($line,"true") ? true : false;
	   $line = str_replace( $change?"true":"false", !$change?"true":"false", $line);
	}
	$out .= $line;
    }
    $f = fopen($configFile, "w");
    fwrite($f, $out);
    fclose($f);

}

?>