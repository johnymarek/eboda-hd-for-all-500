<?php
/*-------------------------
 *    Developed by Maicros
 *      GNU/GPL Licensed
 * ------------------------*/

//Data connectors, beans and utils
include_once "MegavideoDatabase.php";
include_once "MegavideoLinkBean.php";
//
include_once '../../config/config.php';
include_once 'MegavideoTemplate.php';
include_once "../../util/VideoUtil.php";
include_once "../../util/RssScriptUtil.php";
include_once '../../action/Action.php';
include_once '../../action/rss/SaveBookmarkAction.php';
include_once '../../action/rss/DeleteBookmarkAction.php';
define("SCRAPER_URL", SERVER_HOST_AND_PATH . "php/scraper/megavideo/");

//Start session ----------------------------------------------------------------
if(isset($_GET["PHPSESID"])) {
    session_id($_GET["PHPSESID"]);
}
session_start();

//Parse user actions -----------------------------------------------------------
if( isset($_GET["type"])) {
    $type = $_GET["type"];
    switch($type) {
        case "list":
            showMegavideoLinkList();
            break;

        case "id":
            $id = strtoupper($_GET["id"]);
            showMegavideoLink($id);
            break;

        case "idsave":
            $id = strtoupper($_GET["id"]);
            saveMegavideoLink($id);
            showMegavideoLink($id);
            break;
        case "iddelete":
            $id = strtoupper($_GET["itemId"]);
            deleteMegavideoLink($id);
            //showMegavideoLinkList();
            break;
    }

}else {
    fetchHome();
}

//------------------------------------------------------------------------------
//------------------------------------------------------------------------------

/**
 * Show principal links on home page.
 */
function fetchHome() {
    $template = new MegavideoTemplate();
    $template->addSearchItem(
            "Insert Megavideo ID",
            "",
            SCRAPER_URL . "index.php?id=%s" . URL_AMP . "type=id" . URL_AMP . "PHPSESID=" . session_id(),
            ""
    );

    $template->addSearchItem(
            "Insert and Save Megavideo ID",
            "",
            SCRAPER_URL . "index.php?id=%s" . URL_AMP . "type=idsave" . URL_AMP . "PHPSESID=" . session_id(),
            ""
    );

    //Show first links
    $database = new MegavideoDatabase();
    //Check database
    $database->createDatabase();
    //
    $links = $database->getMegavideoLinks();
    $template->setMegavideoLinks($links);

    $template->generateView(MegavideoTemplate::VIEW_HOME);
}

/**
 * Show megavideo saved link list.
 */
function showMegavideoLinkList() {
    $template = new MegavideoTemplate();
    $database = new MegavideoDatabase();
    $links = $database->getMegavideoLinks();

    //Set link to show
    $template->setMegavideoLinks($links);
    $template->generateView(MegavideoTemplate::VIEW_LINK_LIST);
}

/**
 * Show megavideo info and play link by id.
 */
function showMegavideoLink($megavideo_id) {
    $template = new MegavideoTemplate();
    $database = new MegavideoDatabase();
    $megavideoLink = $database->getMegavideoLinkById($megavideo_id);
    if( !$megavideoLink ) {
        //Get link info and set to template
        $megavideoLink = getMegavideoInfo($megavideo_id);
        if( $megavideoLink->getId() != $megavideo_id){
            $megavideo_id = $megavideoLink->getId();
        }
    }
    $template->setMegavideoLink($megavideoLink);

    //Get enclosure link
    if( COOKIE_STATE_ACTIVATED && $megavideo_id ) {
        $array = VideoUtil::generateMegavideoPremiumLink($megavideo_id);
        if($array) {
            $template->addMediaItem(
                    substr( $array[1], strrpos($array[1],"/")+1 ),
                    "",
                    $array[1],
                    "",
                    $array[2]
            );
        }
    }

    $template->generateView(MegavideoTemplate::VIEW_LINK);
}

/**
 * Save megavideo info on database.
 */
function saveMegavideoLink($megavideo_id) {
    $database = new MegavideoDatabase();
    $megavideoLink = getMegavideoInfo($megavideo_id);
    $database->addMegavideoLink(
            $megavideoLink->getId(),
            $megavideoLink->getTitle(),
            $megavideoLink->getDescription(),
            $megavideoLink->getUser(),
            $megavideoLink->getViews(),
            $megavideoLink->getDateAdded(),
            $megavideoLink->getImage()
    );
}

/**
 * Delete megavideo info from database by id.
 */
function deleteMegavideoLink($megavideo_id) {
    $database = new MegavideoDatabase();
    $database->deleteMegavideoLink($megavideo_id);
}

/**
 * Get link info by megavideo id.
 */
function getMegavideoInfo($megavideo_id) {
    $content = @file_get_contents("http://www.megavideo.com/?v=" . $megavideo_id);//, false, getExplorerContext());
    if( !strpos($content, 'flashvars.v = "') ) {
        $content = @file_get_contents("http://www.megavideo.com/?d=" . $megavideo_id);
        preg_match("/flashvars.v = \"(.*)\"/siU", $content, $newId);
        $megavideo_id = $newId[1];
    }
    $content = strstr($content,"var flashvars = {};");
    preg_match("/flashvars.title = \"(.*)\"/siU", $content, $title);
    preg_match("/flashvars.description = \"(.*)\"/siU", $content, $description);
    preg_match("/flashvars.username = \"(.*)\"/siU", $content, $user);
    preg_match("/flashvars.views = \"(.*)\"/siU", $content, $views);
    preg_match("/flashvars.added = \"(.*)\"/siU", $content, $dateAdded);
    preg_match("/flashvars.embed = \"(.*)" . $megavideo_id . "(.*)%/siU", $content, $image);
    $image = "http://img3.megavideo.com/" . $image[2] . ".jpg";

    return new MegavideoLinkBean(
            $megavideo_id,
            strtoupper( html_entity_decode(urldecode($title[1]),ENT_QUOTES) ),
            strtoupper( html_entity_decode(urldecode($description[1]),ENT_QUOTES) ),
            strtoupper( html_entity_decode(urldecode($user[1]),ENT_QUOTES) ),
            strtoupper( html_entity_decode(urldecode($views[1]),ENT_QUOTES) ),
            strtoupper( html_entity_decode(urldecode($dateAdded[1]),ENT_QUOTES) ),
            $image
    );
}

function getMegavideoInfoWithParamD($megavideo_id) {

}

/**
 * Get context for Megavideo connection.
 */
function getExplorerContext() {
    $opts = array(
            'http'=>array(
                    'method'=>"GET",
                    'header'=> "Host: www.megavideo.com\r\n".
                            "User-Agent: Mozilla/5.0 (Windows; U; Windows NT 5.1; es-ES; rv:1.9.2.10) Gecko/20100914 Firefox/3.6.10 (.NET CLR 3.5.30729)\r\n".
                            "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8\r\n".
                            "Accept-Language: es-es,es;q=0.8,en-us;q=0.5,en;q=0.3\r\n".
                            "Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7\r\n".
                            "Keep-Alive: 115\r\n".
                            "Connection: keep-alive\r\n".
                            "Cookie: l=" . LANGUAGE . "; user=" . MEGAUPLOAD_COOKIE . ";\r\n"
            )
    );
    $context = stream_context_create($opts);
    return $context;
}

?>
