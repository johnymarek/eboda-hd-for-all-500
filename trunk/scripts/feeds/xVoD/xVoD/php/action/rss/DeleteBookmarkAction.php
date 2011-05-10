<?php
/*-------------------------
 *    Developed by Maicros
 *      GNU/GPL Licensed
 * ------------------------*/

class DeleteBookmarkAction extends Action {

    public function dispatch() {
        if(isset($_GET["data"])){
            //Save
            $bookmarkId = $_GET["data"];
            $connection = ConnectionFactory::getDataConnection();
            if( $connection->deleteBookmark($bookmarkId) ){
                echo "OK";
            }else{
                echo "ERROR";
            }
        }else{
            echo "ERROR";
        }

    }

    public static function getActionName() {
        return "deleteBookmark";
    }

}

?>
