<?php
/*-------------------------
 *    Developed by Maicros
 *    GNU/GPL v2  Licensed
 * ------------------------*/

class ScraperBean {

    private $id = null;
    private $name = null;
    private $description = null;
    private $language = null;
    private $image = null;
    private $link = null;
    private $type = null;

    public function  __construct($id,$name,$description,$language,$image,$link,$type) {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->language = $language;
        $this->image = $image;
        $this->link = $link;
        $this->type = $type;
    }

    public function getId(){
        return $this->id;
    }

    public function getName(){
        return $this->name;
    }

    public function getDescription(){
        return $this->description;
    }

    public function getLanguage(){
        return $this->language;
    }

    public function getImage(){
        return $this->image;
    }

    public function getLink(){
        return $this->link;
    }

    public function getType(){
        return $this->type;
    }

}

?>
