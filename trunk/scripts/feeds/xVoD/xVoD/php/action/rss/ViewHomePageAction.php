<?php
/*-------------------------
 *    Developed by Maicros
 *      GNU/GPL Licensed
 * ------------------------*/


class ViewHomePageAction extends Action {

    public function dispatch() {
        //Check for database creation
        $database = ConnectionFactory::getDataConnection();
        $database->createDatabase();
        //Load template
        $template = new InitTemplate("..:: Xtreamer Video on Demand ::....:: xVoD ::..");
        $this->parseFavouriteSites($template);
        $template->showTemplate();
    }

    public static function getActionName() {
        return "viewHomePage";
    }

    /**
     * Retrieve favourite sites and fill data in template.
     */
    private function parseFavouriteSites($template) {
        try {
            $connection = ConnectionFactory::getDataConnection();
            $favourites = $connection->getWebsiteFavourites();
            foreach ($favourites as $id => $favourite) {
                $name = $favourite->getName();
                $link = SERVER_HOST_AND_PATH . "php/scraper" . $favourite->getLink();
                switch($favourite->getType()) {
                    case "movie":
                        $template->setFavouriteMovieWebsite(array($name,$link));
                        break;
                    case "serie":
                        $template->setFavouriteSerieWebsite(array($name,$link));
                        break;
                    case "documentary":
                        $template->setFavouriteDocumentaryWebsite(array($name,$link));
                        break;
                    case "anime":
                        $template->setFavouriteAnimeWebsite(array($name,$link));
                        break;
                }
            }
        } catch (Exception $e) {
            //Ignored exception
        }
    }

}

?>
