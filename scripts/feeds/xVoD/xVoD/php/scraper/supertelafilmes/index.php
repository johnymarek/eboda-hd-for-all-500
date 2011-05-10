<?php
/*-------------------------
 *    Developed by Maicros
 *    GNU/GPL v2 Licensed
 * ------------------------*/

include_once '../../config/config.php';
include_once 'SupertelafilmesTemplate.php';
include_once "../../util/VideoUtil.php";
include_once "../../util/RssScriptUtil.php";
include_once '../../action/Action.php';
include_once '../../action/rss/SaveBookmarkAction.php';
include_once '../../action/rss/DeleteBookmarkAction.php';
define("SCRAPER_URL", SERVER_HOST_AND_PATH . "php/scraper/supertelafilmes/");

if (isset($_GET["cat"])) {
    $type = $_GET["type"];
    switch($type) {
        case "mov":
            fetchMovieCategory();
            break;
//        case "ser":
//            fetchSerieCategory();
//            break;
    }

}else if(isset($_GET["type"])) {    // Category list view ---------------------
    $type = $_GET["type"];
    switch($type) {
        case "mov":
            fetchMovieCategories($type);
            break;
        case "ser":
            fetchSeries($type);
            break;
    }

}else {     // Show home principal view ---------------------------------------
    fetchHome();
}

//------------------------------------------------------------------------------
//------------------------------------------------------------------------------

/**
 * -------------------------------------------------------------------------
 */
function fetchHome() {
    $template = new SupertelafilmesTemplate();
    //Start session
    if(isset($_GET["PHPSESID"])) {
        session_id($_GET["PHPSESID"]);
    }
    session_start();
    $template->addItem(
            "Filmes",
            "Assista filmes on-line.",
            SCRAPER_URL . "index.php?type=mov" . URL_AMP . "PHPSESID=" . session_id(),
            ""
    );
    $template->addItem(
            "Séries",
            "Assista séries on-line.",
            SCRAPER_URL . "index.php?type=ser" . URL_AMP . "PHPSESID=" . session_id(),
            ""
    );
    $template->generateView(SupertelafilmesTemplate::VIEW_CATEGORY, "Supertelafilms - Filmes & Séries" );
}

//------------------------------------------------------------------------------
//------------------------------------------------------------------------------

/**
 * -------------------------------------------------------------------------
 */
function fetchMovieCategories() {
    $template = new SupertelafilmesTemplate();
    //Start session
    if(isset($_GET["PHPSESID"])) {
        session_id($_GET["PHPSESID"]);
    }
    session_start();

    $content = file_get_contents("http://www.supertelafilmes.com");
    $newlines = array("\t","\n","\r","\x20\x20","\0","\x0B");
    $input = str_replace($newlines, "", utf8_decode( $content) );
    preg_match("/Filmes Online<\/h2>(.*)<\/div>/U", $input, $div);
    //Get categories
    preg_match_all("/<a href\=\"(.*)\">(.*)<\/a>/siU", $div[0], $divs, PREG_SET_ORDER);

    //Add links
    if($divs) {
        foreach ($divs as $category) {
            $template->addItem(
                    $category[2],
                    $category[2],
                    SCRAPER_URL . "index.php?type=mov" . URL_AMP . "cat=" . base64_encode($category[1]). URL_AMP . "PHPSESID=" . session_id(),
                    ""
            );
        }
    }
    $template->generateView(SupertelafilmesTemplate::VIEW_CATEGORY, "Supertelafilms - Filmes" );
    //
}

//------------------------------------------------------------------------------
//------------------------------------------------------------------------------

/**
 * -------------------------------------------------------------------------
 */
function fetchMovieCategory($type,$link){

}

/**
 * -------------------------------------------------------------------------
 */
function fetchSeries($type,$link){
    $template = new SupertelafilmesTemplate();
    //Start session
    if(isset($_GET["PHPSESID"])) {
        session_id($_GET["PHPSESID"]);
    }
    session_start();

    $content = file_get_contents("http://www.supertelafilmes.com");
    $newlines = array("\t","\n","\r","\x20\x20","\0","\x0B");
    $input = str_replace($newlines, "", utf8_decode( $content) );
    preg_match("/Seriados Online<\/h2>(.*)<\/div>/U", $input, $div);
    //Get categories
    preg_match_all("/<a href\=\"(.*)\">(.*)<\/a>/siU", $div[0], $divs, PREG_SET_ORDER);

    //Add links
    if($divs) {
        foreach ($divs as $category) {
            $template->addItem(
                    $category[2],
                    $category[2],
                    SCRAPER_URL . "index.php?type=ser" . URL_AMP . "cat=" . base64_encode($category[1]). URL_AMP . "PHPSESID=" . session_id(),
                    ""
            );
        }
    }
    $template->generateView(SupertelafilmesTemplate::VIEW_CATEGORY, "Supertelafilms - Seriados" );
}

?>
