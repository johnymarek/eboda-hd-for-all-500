<?php
/*-------------------------
 *    Developed by Maicros
 *      GNU/GPL Licensed
 * ------------------------*/


class ViewScraperPageAction extends Action {

    const SUBACTION_SCRAPER_DELETE = 1;
    const SUBACTION_SCRAPER_ADD = 2;
    const SUBACTION_SCRAPER_SAVE = 3;
    const SUBACTION_SCRAPER_FAVOURITE = 4;

    public function dispatch() {
        $template = new ScraperWebTemplate();
        $forceLoad = false;

        $subaction = $_GET["subaction"];
        switch( $subaction ) {
            case ViewScraperPageAction::SUBACTION_SCRAPER_DELETE: //--------------------------------
                if( isset( $_GET["id"] ) ){
                    $connection = ConnectionFactory::getDataConnection();
                    $connection->deleteScraper($_GET["id"]);
                    $forceLoad = true;
                }
                break;

            case ViewScraperPageAction::SUBACTION_SCRAPER_ADD: //-----------------------------------
                $template->setShowScrapersView(false);
                break;

            case ViewScraperPageAction::SUBACTION_SCRAPER_SAVE: //----------------------------------
                $name = $_POST["name"];
                $description = $_POST["description"];
                $language = $_POST["language"];
                $image = $_POST["image"];
                $link = $_POST["link"];
                $type = $_POST["type"];
                if( $name && $description && $language && $image && $link && $type ){
                    $connection = ConnectionFactory::getDataConnection();
                    $scraper = new ScraperBean(null,$name,$description,$language,$image,$link,$type);
                    $connection->addScraper($scraper);
                    $forceLoad = true;
                }
                break;

            case ViewScraperPageAction::SUBACTION_SCRAPER_FAVOURITE: //-----------------------------
                if( isset($_GET["id"]) ) {
                    $websiteId = $_GET["id"];
                    $connection = ConnectionFactory::getDataConnection();
                    $website = $connection->getScraperById($websiteId);
                    if($website) {
                        $type = $website->getType();
                        if( $website->getType() == "mixed") {
                            $type = "movie";
                        }
                        //var_dump($website);
                        $connection->addWebsiteFavourite(
                                $website->getId(),
                                $type,
                                $website->getName(),
                                $website->getLink()
                        );
                        $forceLoad = true;
                    }
                }
                break;
        }

        $template->setScrapers( $this->getScrapers($forceLoad) );
        $template->setFavourites( $this->getFavouriteScrapers($forceLoad) );

        $template->show();
    }

    public static function getActionName() {
        return "viewWebScraperPage";
    }

    /**
     * Get database scrapers array.
     * @return array Scrapers array.
     */
    private function getScrapers($forceLoad) {
        if( !$forceLoad && isset($_SESSION["webScrapers"]) ) {
            $scrapers = unserialize($_SESSION["webScrapers"]);
        }else {
            $connection = ConnectionFactory::getDataConnection();
            $scrapers = $connection->getScrapers();
            $_SESSION["webScrapers"] = serialize($scrapers);
        }
        return $scrapers;
    }

    /**
     * Get scrapers marked as favourites to show it on first xVoD screen.
     * @return array Scrapers mark as favourites.
     */
    private function getFavouriteScrapers($forceLoad) {
        if( !$forceLoad && isset($_SESSION["webScrapersFavourites"]) ) {
            $favourites = unserialize($_SESSION["webScrapersFavourites"]);
        }else {
            $connection = ConnectionFactory::getDataConnection();
            $favourites = $connection->getWebsiteFavourites();
            $_SESSION["webScrapersFavourites"] = serialize($favourites);
        }
        return $favourites;
    }

}

?>