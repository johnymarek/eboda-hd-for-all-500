<?php
/*-------------------------
 *    Developed by Maicros
 *      GNU/GPL Licensed
 * ------------------------*/

class PlaylistLink {

    const TYPE_MEGAVIDEO = "MV";
    const TYPE_MEGAUPLOAD = "MU";
    const TYPE_HTTP = "HTTP";

    private $key = null;
    private $type = null;
    private $title = null;
    private $description = null;
    private $thumbnail = null;
    private $ids = null;
    private $format = null;
    private $link = null;
    private $language = null;
    private $filename = null;

    public function  __construct($key=null,$type=null,array $ids=null,$title=null,$description=null,$thumbnail=null,$format=null,$link=null,$language=null,$filename=null) {
        $this->key = $key;
        $this->type = $type;
        $this->title = $title;
        $this->description = $description;
        $this->thumbnail = $thumbnail;
        $this->ids = $ids;
        $this->format = $format;
        $this->link = $link;
        $this->language = $language;
	$this->filename = $filename;
    }

    public function addId($order,$id){
        $this->ids[$order] = $id;
    }

    public function deleteId($order){
        unset($this->ids[$order]);
    }

    public function getId($order){
        return $this->ids[$order];
    }

    public function getKey(){
        return $this->key;
    }

    public function setKey($key){
        $this->key = $key;
    }

    public function getType(){
        return $this->type;
    }

    public function setType($type){
        $this->type = $type;
    }

    public function getTitle(){
        return $this->title;
    }

    public function setTitle($title){
        $this->title = $title;
    }

    public function getDescription(){
        return $this->description;
    }

    public function setDescription($description){
        $this->description = $description;
    }

    public function getThumbnail(){
        return $this->thumbnail;
    }

    public function setThumbnail($thumbnail){
        $this->thumbnail = $thumbnail;
    }

    public function getIds(){
        return $this->ids;
    }

    public function setIds($ids){
        $this->ids = $ids;
    }

    public function getFormat(){
        return $this->format;
    }

    public function setFormat($format){
        $this->format = $format;
    }

    public function getLink(){
        return $this->link;
    }

    public function setLink($link){
        $this->link = $link;
    }

    public function getLanguage(){
        return $this->language;
    }

    public function setLanguage($language){
        $this->language = $language;
    }

    public function getFilename(){
	return $this->filename;
    }

    public function setFilename($filename){
	$this->filename = $filename;
    }

    public function getTypeDescription(){
        $typeName = "";
        switch($this->type){
            case PlaylistLink::TYPE_MEGAUPLOAD:
                $typeName = "MEGAUPLOAD";
                break;
            case PlaylistLink::TYPE_MEGAVIDEO:
                $typeName = "MEGAVIDEO";
                break;
	    case PlaylistLink::TYPE_HTTP:
                $typeName = "HTTP FILE";
                break;
        }
        return $typeName;
    }


}

?>