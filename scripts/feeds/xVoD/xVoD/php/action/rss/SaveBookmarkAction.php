<?php
/*-------------------------
 *    Developed by Maicros
 *      GNU/GPL Licensed
 * ------------------------*/

class SaveBookmarkAction extends Action {

    public function dispatch() {
        if(isset($_GET["data"])) {
            //Save
            $data = explode("-",$_GET["data"]);
            $title = base64_decode($data[0]);
            $link = base64_decode($data[1]);
            $link = substr($link, strpos($link,"xVoD")+5);
            $image = base64_decode($data[2]);
            if($title && $link ) {
                $connection = ConnectionFactory::getDataConnection();
                if( $connection->getBookmarkByLink($link) == null ){
                    $connection->addBookmark($title, $description, $link, $image);
                }
                echo "OK";
            }else{
                echo "ERROR";
            }
        }else {
            echo "ERROR";
        }

    }

    public static function getActionName() {
        return "saveBookmark";
    }

}

?>
