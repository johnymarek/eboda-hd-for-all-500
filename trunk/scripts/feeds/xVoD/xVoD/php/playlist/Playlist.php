<?php
/*-------------------------
 *    Developed by Maicros
 *      GNU/GPL Licensed
 * ------------------------*/

class Playlist {

    private $name = null;
    private $description = null;
    private $filename = null;
    private $path = null;    
    private $playlistLinks = array();

    public function  __construct($name=null,$description=null,$filename=null,$path=null,$playlistLinks=null) {
        $this->name = $name;
        $this->description = $description;
        $this->path = $path;
        $this->playlists = $playlistLinks;
    }

    public function addPlaylistLink(PlaylistLink $link){
        $this->playlistLinks[$link->getKey()] = $link;
    }

    public function deletePlaylistLink($key){
        unset($this->playlistLinks[$key]);
    }

    public function getPlaylistLink($key){
        return $this->playlistLinks[$key];
    }

    public function setName($name){
        $this->name = $name;
    }

    public function getName(){
        return $this->name;
    }

    public function setDescription($description){
        $this->description = $description;
    }

    public function getDescription(){
        return $this->description;
    }


    public function setFilename($filename){
        $this->filename = $filename;
    }

    public function getFilename(){
        return $this->filename;
    }

    public function setPath($path){
        $this->path = $path;
    }

    public function getPath(){
        return $this->path;
    }

    public function getPlaylistLinks(){
        return $this->playlistLinks;
    }

}

?>