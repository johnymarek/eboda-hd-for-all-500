<?php
/*-------------------------
 *    Developed by Maicros
 *      GNU/GPL Licensed
 * ------------------------*/

class BookmarkBean{

    private $id = null;
    private $name = null;
    private $description = null;
    private $image = null;
    private $link = null;

    public function  __construct($id,$name,$description,$image,$link) {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->image = $image;
        $this->link = $link;
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

    public function getImage(){
        return $this->image;
    }

    public function getLink(){
        return $this->link;
    }


}

?>
