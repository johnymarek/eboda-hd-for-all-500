<?php
/*-------------------------
 *    Developed by Maicros
 *      GNU/GPL Licensed
 * ------------------------*/

class ViewWebsitesPageAction extends Action {

    public function dispatch() {
        $connection = ConnectionFactory::getDataConnection();
        $scrapers = $connection->getScrapers();
        if( $scrapers ) {
            $template = new WebsitesTemplate($scrapers, "..:: Xtreamer Video on Demand ::....:: xVoD ::..");
            //Check for type filter
            if(isset($_GET["type"])){
                $template->setShowType($_GET["type"]);
            }
            $template->showTemplate();
        } else {

        }
    }

    public static function getActionName() {
        return "viewWebsitesPage";
    }

}

?>
