<?php
/*-------------------------
 *    Developed by Maicros
 *      GNU/GPL Licensed
 * ------------------------*/

class SaveFavouriteWebsiteAction extends Action {

    public function dispatch() {
        if( isset($_GET["id"]) ) {
            //Save
            $websiteId = $_GET["id"];
            $connection = ConnectionFactory::getDataConnection();
            $website = $connection->getScraperById($websiteId);            
            if($website) {
                $type = $website->getType();
                if( $website->getType() == "mixed") {
                    $type = "movie";
                }
                var_dump($website);
                $connection->addWebsiteFavourite(
                        $website->getId(),
                        $type,
                        $website->getName(),
                        $website->getLink()
                );
                echo "OK";

            }else {
                echo "ERROR";
            }
        }else {
            echo "ERROR";
        }

    }

    public static function getActionName() {
        return "saveFavouriteWebsite";
    }

}

?>