<?php
/*-------------------------
 *    Developed by Maicros
 *      GNU/GPL Licensed
 * ------------------------*/

class FavouriteWebsiteBean{

    private $id = null;    
    private $type = null;
    private $name = null;
    private $link = null;

    public function  __construct($id,$type,$name,$link) {
        $this->id = $id;
        $this->type = $type;
        $this->name = $name;        
        $this->link = $link;
    }

    public function getId(){
        return $this->id;
    }

    public function getType(){
        return $this->type;
    }

    public function getName(){
        return $this->name;
    }

    public function getLink(){
        return $this->link;
    }


}

?>
