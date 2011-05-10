<?php
/*-------------------------
 *    Developed by Maicros
 *      GNU/GPL Licensed
 * ------------------------*/

class MegavideoLinkBean{

    private $id = null;
    private $title = null;
    private $description = null;
    private $user = null;
    private $views = null;
    private $dateAdded = null;
    private $image = null;

    public function  __construct($id, $title, $description, $user, $views, $dateAdded, $image) {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->user = $user;
        $this->views = $views;
        $this->dateAdded = $dateAdded;
        $this->image = $image;
    }

    public function getId(){
        return $this->id;
    }

    public function getTitle(){
        return $this->title;
    }

    public function getDescription(){
        return $this->description;
    }

    public function getUser(){
        return $this->user;
    }

    public function getViews(){
        return $this->views;
    }

    public function getDateAdded(){
        return $this->dateAdded;
    }

    public function getImage(){
        return $this->image;
    }

}

?>
