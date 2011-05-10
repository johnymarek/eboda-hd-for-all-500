<?php
/*-------------------------
 *    Developed by Maicros
 *      GNU/GPL Licensed
 * ------------------------*/

class ViewPlaylistPageAction extends Action {

    const SUBACTION_PLAYLIST_DELETE = 1;
    const SUBACTION_PLAYLIST_OPEN = 2;
    const SUBACTION_PLAYLIST_LINK = 3;
    const SUBACTION_PLAYLIST_FOLDER_OPEN = 4;

    private $basepath = null;

    public function  __construct() {
        $this->basepath = XTREAMER_PATH . "playlist";
    }

    public function dispatch() {
        //Check for session path
        if( !isset($_SESSION["playlistActualPath"]) ) {
            $_SESSION["playlistActualPath"] = $this->basepath;
        }
        //
        $subaction = $_GET["subaction"];
        switch( $subaction ) {
            case ViewPlaylistPageAction::SUBACTION_PLAYLIST_DELETE: //---------------------------
                $path = base64_decode($_GET["path"]);
                $this->deletePlaylist( $path );
                //Refresh
                $items = $this->getFolderPlaylist( $_SESSION["playlistActualPath"] );
                $template = new PlaylistFolderTemplate( $this->convertRssPathTitle($_SESSION["playlistActualPath"]) );
                $template->setItems($items);
                break;

            case ViewPlaylistPageAction::SUBACTION_PLAYLIST_OPEN:   //----------------------------
                $path = $_SESSION["playlistActualPath"] . "/" . base64_decode($_GET["playlist"]);
                $template = new PlaylistTemplate("..:: xVoD ::..:: Playlist Playlist View ::..");

                try {
                    $playlist = $this->openPlaylist( $path );
                    $_SESSION["loadedPlaylist"] = serialize($playlist);
                    $template->setPlaylist($playlist);
                    $template->setTitle( ($playlist->getName()!=null) ? $playlist->getName() . ' (' . $playlist->getFilename() . ')' : $playlist->getFilename() );

                }catch(Exception $e) {
                    $template->setDescription($e->getMessage());
                }
                break;

            case ViewPlaylistPageAction::SUBACTION_PLAYLIST_FOLDER_OPEN: //-----------------------
                $selectedFolder = base64_decode($_GET['folder']);
                //Check for base path or return folder
                if( ($_SESSION["playlistActualPath"] == $this->basepath) && ($selectedFolder == "..") ) {
                    $path = $this->basepath;
                }else if($selectedFolder == "..") {
                    $path = $_SESSION["playlistActualPath"];
                    $path = substr($path, 0, strrpos($path, "/"));
                }else {
                    $path = $_SESSION["playlistActualPath"];
                    $path = $path . "/" . $selectedFolder;
                }
                //Load folder playlist file list
                $_SESSION["playlistActualPath"] = $path;
                $items = $this->getFolderPlaylist( $path );
                $template = new PlaylistFolderTemplate( $this->convertRssPathTitle($path) );
                $template->setItems($items);
                $template->setBaseFolder($path);
                break;

            case ViewPlaylistPageAction::SUBACTION_PLAYLIST_LINK: //-------------------------------
                $playlist = unserialize($_SESSION["loadedPlaylist"]);
                $key = base64_decode($_GET["link"]);
                $playlistLink = $playlist->getPlaylistLink($key);
                $template = new PlaylistLinkTemplate( ($playlistLink->getTitle()!=null) ? $playlistLink->getTitle() : $playlistLink->getFilename() );
                $template->setPlaylistLink( $playlistLink );
                break;

            default: //-----------------------------------------------------------------------------
                $items = $this->getFolderPlaylist( $_SESSION["playlistActualPath"] );
                $template = new PlaylistFolderTemplate( $this->convertRssPathTitle($_SESSION["playlistActualPath"]) );
                $template->setItems($items);
                $template->setBaseFolder($_SESSION["playlistActualPath"]);
                break;
        }
        $template->showTemplate();
    }

    public static function getActionName() {
        return "viewPlaylistPage";
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
                $playlist->setName( (String)$attributes['name'] );
            }
            if($attributes['description']) {
                $playlist->setDescription( (String)$attributes['description'] );
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
                    $playlistLink->setThumbnail( (String)$attributes['thumbnail'] );
                }
                //Get child nodes
                if($second_gen->title) {
                    $playlistLink->setTitle( (String)$second_gen->title );
                }
                if($second_gen->description) {
                    $playlistLink->setDescription( (String)$second_gen->description );
                }
                if($second_gen->format) {
                    $playlistLink->setFormat( (String)$second_gen->format );
                }
                if($second_gen->filename) {
                    $playlistLink->setFilename( (String)$second_gen->filename );
                }
                if($second_gen->link) {
                    $playlistLink->setLink( (String)$second_gen->link );
                }
                if($second_gen->language) {
                    $playlistLink->setLanguage( (String)$second_gen->language );
                }
                //Get ids
                $order = 1;
                $second_gen = $second_gen->part;
                foreach ($second_gen->children() as $third_gen) {
                    $attributes = $third_gen->attributes();
                    if( $attributes['order'] ) {
                        $playlistLink->addId((Integer)$attributes['order'],(String)$third_gen);
                    }else {
                        ++$order;
                        $playlistLink->addId((Integer)$order,(String)$third_gen);
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
        unlink($file);
    }


    /**
     * Get folder playlist files.
     * @param String $folder
     */
    private function getFolderPlaylist($folder) {
        $items = array();
        //If $folder not exists, load default base path.
        try {
            $dir = new DirectoryIterator($folder);
        }catch(UnexpectedValueException $uve) {
            $_SESSION["playlistActualPath"] = $this->basepath;
            return $this->getFolderPlaylist( $this->basepath );
        }
        //Load folder files
        foreach ($dir as $fileInfo) {
            if($fileInfo->getFilename() == "..") {
                if($folder != $this->basepath ) {
                    array_push($items, "..");
                }

            }else if($fileInfo->isDir() && ($fileInfo->getFilename() != ".") ) {
                array_push($items, $fileInfo->getFilename() );

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

        return $items;
    }
    
    /**
     *  Convert path to show it.
     * @param String $path
     */
    private function convertRssPathTitle($path){
        $path = strstr($path,"xVoD");
        return str_replace("/", " > ",$path);
    }

}

?>