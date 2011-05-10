<?php
/*-------------------------
 *    Developed by Maicros
 *      GNU/GPL Licensed
 * ------------------------*/


class ViewPlaylistWebPageAction extends Action {

    const SUBACTION_PLAYLIST_DELETE = 1;
    const SUBACTION_PLAYLIST_OPEN = 2;
    const SUBACTION_PLAYLIST_LINK = 3;
    const SUBACTION_PLAYLIST_LINK_ADD = 4;
    const SUBACTION_PLAYLIST_LINK_SAVE = 5;
    const SUBACTION_PLAYLIST_LINK_DELETE = 16;
    const SUBACTION_PLAYLIST_FOLDER_OPEN = 6;
    const SUBACTION_PLAYLIST_SAVE = 7;
    const SUBACTION_PLAYLIST_ADD = 8;
    const SUBACTION_PLAYLIST_ADD_SAVE = 9;
    const SUBACTION_FOLDER_ADD = 10;
    const SUBACTION_FOLDER_DELETE = 11;
    const SUBACTION_FOLDER_DOWNLOAD = 12;
    const SUBACTION_PLAYLIST_DOWNLOAD = 13;
    const SUBACTION_PLAYLIST_UPLOAD = 14;
    const SUBACTION_PLAYLIST_UPLOAD_SAVE = 15;

    private $basepath = null;

    public function  __construct() {
	$this->basepath = XTREAMER_PATH . "playlist";
    }

    public function dispatch() {
	//Check for session path
	if( !isset($_SESSION["webPlaylistActualPath"]) ) {
	    $_SESSION["webPlaylistActualPath"] = $this->basepath;
	}
	//
	$subaction = $_GET["subaction"];
	switch( $subaction ) {
	    case ViewPlaylistWebPageAction::SUBACTION_PLAYLIST_DELETE: //------------------------------------------------
		if( isset($_GET["path"]) ) {
		    $path = base64_decode($_GET["path"]);
		    $message = $this->deletePlaylist( $_SESSION["webPlaylistActualPath"] . "/" . $path );
		}
		$template = $this->createDefaultTemplateFolderExplorer();
		$template->setMessage($message);
		break;

	    case ViewPlaylistWebPageAction::SUBACTION_PLAYLIST_OPEN:   //-------------------------------------------------
		$path = $_SESSION["webPlaylistActualPath"] . "/" . base64_decode($_GET["playlist"]);
		$template = new PlaylistWebTemplate("..:: xVoD ::..:: Playlist Playlist View ::..");

		try {
		    $playlist = $this->openPlaylist( $path );
		    $_SESSION["webLoadedPlaylist"] = serialize($playlist);
		    $template->setPlaylist($playlist);
		    $template->setTitle( ($playlist->getName()!=null) ? $playlist->getName() . ' (' . $playlist->getFilename() . ')' : $playlist->getFilename() );

		}catch(Exception $e) {
		    $template->setDescription($e->getMessage());
		}
		break;

	    case ViewPlaylistWebPageAction::SUBACTION_PLAYLIST_FOLDER_OPEN: //--------------------------------------------
		$selectedFolder = base64_decode($_GET['folder']);
		//Check for base path or return folder
		if( ($_SESSION["webPlaylistActualPath"] == $this->basepath) && ($selectedFolder == "..") ) {
		    $path = $this->basepath;
		}else if($selectedFolder == "..") {
		    $path = $_SESSION["webPlaylistActualPath"];
		    $path = substr($path, 0, strrpos($path, "/"));
		}else {
		    $path = $_SESSION["webPlaylistActualPath"];
		    $path = $path . "/" . $selectedFolder;
		}
		//Load folder playlist file list
		$_SESSION["webPlaylistActualPath"] = $path;
		$items = $this->getFolderPlaylist( $path );
		$template = new PlaylistExploreWebTemplate( $this->convertRssPathTitle($path) );
		$template->setItems($items);
		$template->setBaseFolder($path);
		break;

	    case ViewPlaylistWebPageAction::SUBACTION_PLAYLIST_LINK: //-----------------------------------------------------
		$playlist = unserialize($_SESSION["webLoadedPlaylist"]);
		$key = base64_decode($_GET["link"]);
		$playlistLink = $playlist->getPlaylistLink($key);
		$template = new PlaylistLinkWebTemplate( $playlistLink->getTitle() );
		$template->setPlaylistLink( $playlistLink );
		$template->setPlaylist($playlist);
		break;

	    case ViewPlaylistWebPageAction::SUBACTION_PLAYLIST_LINK_ADD: //-------------------------------------------------
		$template = new PlaylistLinkAddWebTemplate();
		$template->setPlaylist(unserialize($_SESSION["webLoadedPlaylist"]));
		break;

	    case ViewPlaylistWebPageAction::SUBACTION_PLAYLIST_LINK_SAVE: //------------------------------------------------
		$playlist = unserialize($_SESSION["webLoadedPlaylist"]);

		//Create playlist link and recover data
		$playlistLink = new PlaylistLink();
		$playlistLink->setKey(uniqid());
		$playlistLink->setTitle(	utf8_encode( html_entity_decode($_GET["title"]) ) );
		$playlistLink->setDescription(	utf8_encode( html_entity_decode($_GET["description"]) ) );
		$playlistLink->setLanguage(	utf8_encode( html_entity_decode($_GET["language"]) ) );
		$playlistLink->setThumbnail(	utf8_encode( html_entity_decode($_GET["thumbnail"]) ) );
		$playlistLink->setType(		utf8_encode( html_entity_decode($_GET["type"]) ) );
		$playlistLink->setFormat(	utf8_encode( html_entity_decode($_GET["format"]) ) );

		//Set link or ids
		if( $_GET["type"] == "HTTP" ) {
		    $playlistLink->setLink($_GET["link"]);
		    $playlist->addPlaylistLink($playlistLink);

		}else if( ($_GET["type"] == "MV") || ($_GET["type"] == "MU") ) {
		    $ids = split(" ", $_GET["link"]);
		    $order = 0;
		    foreach ( $ids as $id ) {
			$playlistLink->addId($order, $id);
			++$order;
		    }
		}

		//Save playlist
		$playlist->addPlaylistLink($playlistLink);
		$this->savePlaylist( $playlist->getPath() . "/" . $playlist->getFilename(), $playlist );
		$_SESSION["webLoadedPlaylist"] = serialize($playlist);

		//
		$template = new PlaylistLinkAddWebTemplate();
		$template->setPlaylist($playlist);
		break;

	    case ViewPlaylistWebPageAction::SUBACTION_PLAYLIST_LINK_DELETE: //----------------------------------------------
		$playlist = unserialize($_SESSION["webLoadedPlaylist"]);
		$playlist->deletePlaylistLink(base64_decode($_GET["link"]));
		$this->savePlaylist( $playlist->getPath() . "/" . $playlist->getFilename(), $playlist );
		$_SESSION["webLoadedPlaylist"] = serialize($playlist);
		$template = new PlaylistWebTemplate("..:: xVoD ::..:: Playlist Playlist View ::..");
		$template->setTitle( ($playlist->getName()!=null) ? $playlist->getName() . ' (' . $playlist->getFilename() . ')' : $playlist->getFilename() );
		$template->setPlaylist($playlist);
		break;

	    case ViewPlaylistWebPageAction::SUBACTION_PLAYLIST_ADD: //------------------------------------------------------
		$template = new PlaylistAddWebTemplate();
		$template->setBasepath( $_SESSION["webPlaylistActualPath"] );
		break;

	    case ViewPlaylistWebPageAction::SUBACTION_PLAYLIST_ADD_SAVE: //-------------------------------------------------
		$playlist = new Playlist();
		$playlist->setName($_GET["name"]);
		$playlist->setDescription($_GET["description"]);
		$playlist->setPath($_GET["path"]);
		$playlist->setFilename($_GET["filename"]);
		$this->savePlaylist( $playlist->getPath() . "/" . $playlist->getFilename() . ".xpls", $playlist );
		$template = $this->createDefaultTemplateFolderExplorer();
		break;

	    case ViewPlaylistWebPageAction::SUBACTION_PLAYLIST_SAVE: //------------------------------------------------------
		$playlist = unserialize($_SESSION["webLoadedPlaylist"]);
		$key = base64_decode($_GET["link"]);
		$playlistLink = $playlist->getPlaylistLink($key);
		$template = new PlaylistLinkTemplate( ($playlistLink->getTitle()!=null) ? $playlistLink->getTitle() : $playlistLink->getFilename() );
		$template->setPlaylistLink( $playlistLink );
		break;

	    case ViewPlaylistWebPageAction::SUBACTION_FOLDER_DELETE: //-------------------------------------------------------
		if( isset($_GET["folder"]) ) {
		    $folderName = base64_decode( $_GET["folder"] );
		    $this->deleteFolder( $_SESSION["webPlaylistActualPath"] . "/" . $folderName );
		}
		$template = $this->createDefaultTemplateFolderExplorer();
		break;

	    case ViewPlaylistWebPageAction::SUBACTION_FOLDER_ADD: //-----------------------------------------------------------
		if( isset($_GET["folder"]) ) {
		    $folderName = $_GET["folder"];
		    $message = $this->createFolder( $_SESSION["webPlaylistActualPath"] . "/" . $folderName );
		}
		$template = $this->createDefaultTemplateFolderExplorer();
		$template->setMessage($message);
		break;

	    case ViewPlaylistWebPageAction::SUBACTION_PLAYLIST_DOWNLOAD: //----------------------------------------------------
		if( isset($_GET["download"]) ) {
		    $folderName = base64_decode( $_GET["download"] );
		    $this->downloadFile( $_SESSION["webPlaylistActualPath"], $folderName );
		}
		break;

	    case ViewPlaylistWebPageAction::SUBACTION_FOLDER_DOWNLOAD:
		if( isset($_GET["download"]) ) {
		    $folderName = base64_decode( $_GET["download"] );
		    $this->downloadFolder( $_SESSION["webPlaylistActualPath"], $folderName );
		}
		break;

	    case ViewPlaylistWebPageAction::SUBACTION_PLAYLIST_UPLOAD: //-------------------------------------------------------
		$template = new PlaylistUploadWebTemplate();
		$template->setBasePath( strstr( $_SESSION["webPlaylistActualPath"], "xVoD") );
		break;

	    case ViewPlaylistWebPageAction::SUBACTION_PLAYLIST_UPLOAD_SAVE: //--------------------------------------------------
		$message = array();
		//Save http file
		if( isset($_POST["uploadFileWeb"]) && ( $_POST["uploadFileWeb"] != "http://") ) {
		    try {
			$content = @file_get_contents($_POST["uploadFileWeb"]);
			if( strpos($content, "</playlist>") ) {
			    $file = $_SESSION["webPlaylistActualPath"] . "/" . $_POST["uploadFileWebName"] . ".xpls";
			    $fp = fopen($file, 'w');
			    fwrite($fp, utf8_encode($content) );
			    fclose($fp);
			    array_push($message, "File '" . $_POST["uploadFileWebName"] . ".xpls has been saved correctly." );
			}else {
			    array_push($message, "File '" . $_POST["uploadFileWebName"] . ".xpls has been saved correctly." );
			}
		    }catch(Exception $e) {
			array_push($message, "An error has occurred: " . $e->getMessage() . ".");
		    }

		}
		//Save upload file
		if( isset ($_FILES['uploadFile']) ) {
		    $fileName = $_FILES['uploadFile']['name'];
		    $fileExtension = $_FILES['uploadFile']['type'];
		    $fileSize = $_FILES['uploadFile']['size'];
		    if ( strpos($fileName, "xpls") ) {
			if( move_uploaded_file($_FILES['uploadFile']['tmp_name'], $_SESSION["webPlaylistActualPath"] . "/" . $fileName) ) {
			    array_push($message, "File '" . $fileName . " with size " . $fileSize . " has been saved correctly." );
			}else {
			    array_push($message, "An error has occurred saving file!!" );
			}
		    }else {
			array_push($message, "Only files with XPLS extension be accepted." );
		    }
		}
		//Return to explorer or show upload view another time
		if( isset($_POST["returnExplorer"]) && $_POST["returnExplorer"] == "ON" ) {
		    $template = $this->createDefaultTemplateFolderExplorer();
		    if( $message && count($message) > 0 ) {
			$temp = "";
			foreach ( $message as $value ) {
			    $temp .= "<br/>" . $value;
			}
			$template->setMessage( $temp );
		    }
		}else {
		    $template = new PlaylistUploadWebTemplate();
		    $template->setMessage( $message );
		    $template->setBasePath( $_SESSION["webPlaylistActualPath"] );
		}
		break;

	    default: //---------------------------------------------------------------------------------------------------------
		$template = $this->createDefaultTemplateFolderExplorer();
		break;
	}
	//
	if($template) {
	    $template->show();
	}
    }

    public static function getActionName() {
	return "viewWebPlaylistPage";
    }

    /**
     * Create default template view.
     * @return WebTemplate
     */
    private function createDefaultTemplateFolderExplorer() {
	$items = $this->getFolderPlaylist( $_SESSION["webPlaylistActualPath"] );
	$template = new PlaylistExploreWebTemplate( $this->convertRssPathTitle($_SESSION["webPlaylistActualPath"]) );
	$template->setItems($items);
	$template->setBaseFolder($_SESSION["webPlaylistActualPath"]);
	return $template;
    }

    /**
     * Open playlist by full path, including filename.
     * @param String $fullPath
     * @return Playlist
     */
    private function openPlaylist($fullPath) {
	$playlist = new Playlist();
	if($fullPath) {
	    $xml = @simplexml_load_file($fullPath,'SimpleXMLElement', LIBXML_NOCDATA);
	    if(!$xml) {
		throw new Exception("Error loading Playlist on '" . $fullPath . "'.");
	    }
	    $attributes = $xml->attributes();
	    $playlist->setFilename( (String)basename($fullPath) );
	    $playlist->setPath( (String)dirname($fullPath) );
	    if($attributes['name']) {
		$playlist->setName( utf8_decode((String)$attributes['name']) );
	    }
	    if($attributes['description']) {
		$playlist->setDescription( utf8_decode((String)$attributes['description']) );
	    }
	    //Get playlist links
	    foreach ($xml->children() as $second_gen) {
		$playlistLink = new PlaylistLink();
		//Get node attributes
		$attributes = $second_gen->attributes();
		$playlistLink->setKey( (String)$attributes['key'] );
		if( $attributes['type'] ) {
		    $playlistLink->setType( (String)$attributes['type'] );
		}
		if( $attributes['thumbnail'] ) {
		    $playlistLink->setThumbnail( utf8_decode((String)$attributes['thumbnail']) );
		}
		//Get child nodes
		if($second_gen->title) {
		    $playlistLink->setTitle( utf8_decode((String)$second_gen->title) );
		}
		if($second_gen->description) {
		    $playlistLink->setDescription( utf8_decode((String)$second_gen->description) );
		}
		if($second_gen->format) {
		    $playlistLink->setFormat( utf8_decode((String)$second_gen->format) );
		}
		if($second_gen->link) {
		    $playlistLink->setLink( utf8_decode((String)$second_gen->link) );
		}
		if($second_gen->language) {
		    $playlistLink->setLanguage( utf8_decode((String)$second_gen->language) );
		}
		//Get ids
		$order = 1;
		$second_gen = $second_gen->part;
		if($second_gen && $second_gen->children()) {
		    foreach ($second_gen->children() as $third_gen) {
			$attributes = $third_gen->attributes();
			if( $attributes['order'] ) {
			    $playlistLink->addId((Integer)$attributes['order'],(String)$third_gen);
			}else {
			    ++$order;
			    $playlistLink->addId((Integer)$order,(String)$third_gen);
			}
		    }
		}
		//Add link to playlist
		$playlist->addPlaylistLink($playlistLink);
	    }
	}
	return $playlist;
    }

    /**
     * Remove playlist file.
     * @param String $file
     */
    private function deletePlaylist($file) {
	@unlink($file);
    }

    /**
     * Create folder
     * @param folder
     * @return String Result message.
     */
    private function createFolder($folder) {
	if(@mkdir($folder , 0777)) {
	    return "Directory has been created successfully...";
	}
	else {
	    return "Failed to create directory: " . $folder;
	}
    }

    /**
     * Delete folder.
     * @param folder
     * @return String Result message.
     */
    function deleteFolder($dir) {
	if (substr($dir, strlen($dir)-1, 1) != '/'){
	    $dir .= '/';
	}
	if ($handle = opendir($dir)) {
	    while ($obj = readdir($handle)) {
		if ($obj != '.' && $obj != '..') {
		    if (is_dir($dir.$obj)) {
			if (!$this->deleteFolder($dir.$obj))
			    return false;
		    }else if (is_file($dir.$obj)) {
			if (!unlink($dir.$obj)){
			    return false;
			}
		    }
		}
	    }
	    closedir($handle);
	    if (!@rmdir($dir)){
		return false;
	    }
	    return true;
	}
	return false;
    }

    /**
     * Get folder playlist files.
     * @param String $folder
     */
    private function getFolderPlaylist($folder) {
	$folders = array();
	$items = array();
	//If $folder not exists, load default base path.
	try {
	    $dir = new DirectoryIterator($folder);
	}catch(UnexpectedValueException $uve) {
	    $_SESSION["webPlaylistActualPath"] = $this->basepath;
	    return $this->getFolderPlaylist( $this->basepath );
	}
	//Load folder files
	foreach ($dir as $fileInfo) {
	    if($fileInfo->getFilename() == "..") {
		if($folder != $this->basepath ) {
		    array_push($folders, "..");
		}

	    }else if($fileInfo->isDir() && ($fileInfo->getFilename() != ".") ) {
		array_push($folders, $fileInfo->getFilename() );

	    }else if($fileInfo->getFilename() != ".") {
		if( strpos($fileInfo->getFilename(),".xpls") ) {
		    try {
			$playlist = $this->openPlaylist( $fileInfo->getPath() . "/" . $fileInfo->getFilename() );
			$playlist->setPath( $fileInfo->getPath() );
			$playlist->setFilename( $fileInfo->getFilename() );
			array_push( $items, $playlist );
		    }catch(Exception $e) {
			//TODO Guardar y mostrar error
		    }
		}
	    }
	}
	sort( $folders );
	$items = array_merge($folders,$items);

	return $items;
    }

    /**
     * Create playlist xml document and save to file.
     * @param $file     Ruta al archivo
     * @param $playlist Playlist.
     */
    private function savePlaylist($file,Playlist $playlist) {
	//Save to xml
	$simpleXml = new SimpleXmlElement('<?xml version="1.0" encoding="UTF-8"?><playlist name="' . utf8_encode($playlist->getName()) . '" description="' . utf8_encode($playlist->getDescription()) . '"></playlist>');
	$count = 1;
	foreach ($playlist->getPlaylistLinks() as $key => $playlistLink) {
	    $element = $simpleXml->addChild("xfile");
	    $element->addAttribute("key", $playlistLink->getKey());
	    if($playlistLink->getType() != null ) {
		$element->addAttribute("type", $playlistLink->getType());
	    }else {
		$element->addAttribute("type", $count );
		++$count;
	    }
	    if($playlistLink->getThumbnail() != null ) {
		$element->addAttribute("thumbnail", $playlistLink->getThumbnail() );
	    }
	    if($playlistLink->getTitle() != null ) {
		$element->addChild("title" , "<![CDATA[" . $playlistLink->getTitle() . "]]>");
	    }
	    if($playlistLink->getDescription() != null ) {
		$element->addChild("description" , "<![CDATA[" . $playlistLink->getDescription() . "]]>");
	    }
	    if($playlistLink->getLink() != null ) {
		$element->addChild("link" , "<![CDATA[" . $playlistLink->getLink() . "]]>");
	    }
	    if($playlistLink->getFormat() != null ) {
		$element->addChild("format" , "<![CDATA[" . $playlistLink->getFormat() . "]]>");
	    }
	    if($playlistLink->getLanguage() != null ) {
		$element->addChild("language" , "<![CDATA[" . $playlistLink->getLanguage() . "]]>");
	    }
	    if( count($playlistLink->getIds()) > 0 ) {
		$elementId = $element->addChild("part");
		foreach ($playlistLink->getIds() as $order => $idValue) {
		    $temp = $elementId->addChild("id" , $idValue);
		    $temp->addAttribute("order", $order);
		}
	    }

	}
	$fp = fopen($file, 'w');
	fwrite($fp, html_entity_decode(  $this->xmlpp($simpleXml->asXML(),false)  ) );
	fclose($fp);
    }

    /**
     *  Convert path to show it.
     * @param String $path
     */
    private function convertRssPathTitle($path) {
	$path = strstr($path,"xVoD");
	return str_replace("/", " > ",$path);
    }

    /**
     * Load file and write to download it.
     * @param String $path Full file path access.
     * @param String $filename Filename.
     */
    private function downloadFile($path,$filename) {
	// define error message
	$err = '<p style="color:#990000">Sorry, the file you are requesting is unavailable.</p>';
	if (!$filename) {
	    echo $err;
	} else {
	    // check that file exists and is readable
	    $path = $path . "/" . $filename;
	    if (file_exists($path) && is_readable($path)) {
		// get the file size and send the http headers
		$size = filesize($path);
		header('Content-Type: application/octet-stream');
		header('Content-Length: '.$size);
		header('Content-Disposition: attachment; filename='.$filename);
		header('Content-Transfer-Encoding: binary');

		// open the file in binary read-only mode
		// display the error messages if the file can´t be opened
		$file = @fopen($path, "rb");
		if ($file) { // stream the file and exit the script when complete
		    fpassthru($file);
		    exit;
		} else {
		    echo $err;
		}
	    } else {
		echo $err;
	    }

	}

    }

    private function downloadFolder($path,$folderName) {
	//Get the directory to zip
	$filename_no_ext= $path . "/" . $folderName;
	// we deliver a zip file
	header("Content-Type: archive/zip");
	// filename for the browser to save the zip file
	header("Content-Disposition: attachment; filename=$folderName".".tar");
	// get a tmp name for the .zip
	$tmp_tar = tempnam ("tmp", "tempname") . ".tar.gz";
	//change directory so the zip file doesnt have a tree structure in it.
	chdir( $path . "/" . $folderName );
	// zip the stuff (dir and all in there) into the tmp_zip file
	//exec('zip '.$tmp_zip.' *');
	exec( 'busybox tar -cf ' . $tmp_tar . ' *' );
	// calc the length of the zip. it is needed for the progress bar of the browser
	$filesize = filesize($tmp_tar);
	header("Content-Length: $filesize");
	// deliver the zip file
	$fp = fopen("$tmp_tar","r");
	echo fpassthru($fp);
	// clean up the tmp zip file
	unlink($tmp_tar);
    }

    /** Prettifies an XML string into a human-readable and indented work of art
     *  @param string $xml The XML as a string
     *  @param boolean $html_output True if the output should be escaped (for use in HTML)
     */
    function xmlpp($xml, $html_output=false) {

	$xml_obj = new SimpleXMLElement($xml);
	$level = 4;
	$indent = 0; // current indentation level
	$pretty = array();

	// get an array containing each XML element
	$xml = explode("\n", preg_replace('/>\s*</', ">\n<", $xml_obj->asXML()));

	// shift off opening XML tag if present
	if (count($xml) && preg_match('/^<\?\s*xml/', $xml[0])) {
	    $pretty[] = array_shift($xml);
	}

	foreach ($xml as $el) {
	    if (preg_match('/^<([\w])+[^>\/]*>$/U', $el)) {
		// opening tag, increase indent
		$pretty[] = str_repeat(' ', $indent) . $el;
		$indent += $level;
	    } else {
		if (preg_match('/^<\/.+>$/', $el)) {
		    $indent -= $level;  // closing tag, decrease indent
		}
		if ($indent < 0) {
		    $indent += $level;
		}
		$pretty[] = str_repeat(' ', $indent) . $el;
	    }
	}
	$xml = implode("\n", $pretty);
	return ($html_output) ? htmlentities($xml) : $xml;
    }


}

?>