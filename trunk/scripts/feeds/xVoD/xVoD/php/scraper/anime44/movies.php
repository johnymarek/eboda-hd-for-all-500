<?php
/*-------------------------
 *    Developed by Maicros
 *      GNU/GPL Licensed
 * ------------------------*/

include_once '../../config/config.php';
include_once 'Anime44MoviesTemplate.php';
include_once "../../util/VideoUtil.php";
include_once "../../util/RssScriptUtil.php";
include_once '../../action/Action.php';
include_once '../../action/rss/SaveBookmarkAction.php';
include_once '../../action/rss/DeleteBookmarkAction.php';
define("SCRAPER_URL", SERVER_HOST_AND_PATH . "php/scraper/anime44/");

//Start session
if(isset($_GET["PHPSESID"])) {
    session_id($_GET["PHPSESID"]);
}
session_start();

//Filter user action and redirect to scrap function
if( isset($_GET["search"]) ) {
    $type = $_GET["search"];
    $pageTitle = base64_decode($_GET["title"]);
    fetchSearch($type,$pageTitle);

}else if(isset($_GET["item"])) {
    $item = base64_decode($_GET["item"]);
    $title = base64_decode($_GET["title"]);
    fetchMovie($item,$title);

}else if(isset($_GET["host"])) {
    $host = base64_decode($_GET["host"]);
    $link = base64_decode($_GET["link"]);
    $title = base64_decode($_GET["title"]);
    fetchLink($title,$host,$link);

}else {
    fetchCategoryItems("");
}

//------------------------------------------------------------------------------
//------------------------------------------------------------------------------

/**
 * Get category movies and pages.
 */
function fetchCategoryItems($title) {
    $template = new Anime44MoviesTemplate();
    $template->setLetter($letter);

    //If page equal "x" goto page number list, in other case process actual category page
    if( isset($_GET["page"]) && $_GET["page"] == "x" ) {
        $maxPages = $_GET["pages"];
        for($i=1;$i<=$maxPages;++$i) {
            $template->addItem(
                    $i,
                    resourceString("goto_page") . $i,
                    SCRAPER_URL . "movies.php?letter=" . $letter . URL_AMP . "title=" . base64_encode($title) . URL_AMP . "page=" . $i . URL_AMP . "pages=" . $maxPages . URL_AMP . "PHPSESID=" . session_id(),
                    ""
            );
        }
        $template->generateView(Anime44MoviesTemplate::VIEW_PAGE_NUMBERS );

    }else {
        if(!isset($_GET["page"])) {
            $pages = getPages();
            $template->setActualPage(1);
            $template->setMaxPages($pages[1]);
            $content = $pages[0];
            $showSearch = true;
        }else {
            $page = $_GET["page"];
            $template->setActualPage($_GET["page"]);
            $template->setMaxPages($_GET["pages"]);
            $content = file_get_contents("http://www.anime44.com/category/anime-movies/page/" . $page);
            $showSearch = false;
        }

        //Show search link on first page only
        if($showSearch) {
            $template->setSearch( array(
                    resourceString("search_by") . "...",
                    resourceString("search_by") . "...",
                    "rss_command://search",
                    SCRAPER_URL . "movies.php?search=%s" . URL_AMP . "title=" . base64_encode(resourceString("search_by") . "...") . URL_AMP . "PHPSESID=" . session_id(),
                    ""
                    )
            );
        }
        //
        $newlines = array("\t","\n","\r","\x20\x20","\0","\x0B");
        $content = str_replace($newlines, "", html_entity_decode($content,ENT_QUOTES,"UTF-8") );

        preg_match_all("/<div class=\"postlist\"><a href=\"(.*)\" rel=\"bookmark\" title=\"(.*)\">(.*)<\/a>/siU", $content, $links, PREG_SET_ORDER);

        if($links) {
            foreach ($links as $value) {
                $template->addItem(
                        $value[3],
                        "",
                        SCRAPER_URL . "movies.php?title=" . base64_encode($value[3]) . URL_AMP . "item=" . base64_encode($value[1]) . URL_AMP . "PHPSESID=" . session_id(),
                        ""
                );
            }
        }

        $template->generateView(Anime44MoviesTemplate::VIEW_MOVIE, "");
    }
}


function fetchMovie($item,$title) {
    $template = new Anime44MoviesTemplate();
    $content = file_get_contents($item);

    $contentArray = array($content);
    if(strpos($content,"<div class=\"postcontent\">")) {
        preg_match("/<div class=\"postcontent\">(.*)<\/div>/siU", $content, $matches);
        if($matches) {
            preg_match_all("/<a href=\"(.*)\"/siU", $matches[1], $values, PREG_SET_ORDER);
            foreach ($values as $value) {
                array_push( $contentArray, file_get_contents($value[1]) );
            }
        }
    }

    $i = 1;
    foreach ($contentArray as $content) {
        $linkNumber = 1;
        //Megavideo
        preg_match_all("|www.megavideo.com\/v\/(.*)\"|U", $content, $links);
        if($links && $links[1]) {
            $links = $links[1];
            $links = array_unique( $links );
            foreach ($links as $value) {
                //Parse and get megavideo id
                if(strpos($value,".")) {
                    $value = substr($value, 0, strpos($value,"."));
                }
                $megavideo_id = substr($value, 0, -32);

                $value = str_replace($megavideo_id, "", $value);
                $image = "http://img3.megavideo.com/" . $value[0] . "/" . $value[1] . "/" . substr($value, 2) . ".jpg";
                $template->setImage($image);

                if( $megavideo_id ) {
                    $template->addItem(
                            "[Option " . $i . "][Link " . $linkNumber . "] Megavideo",
                            "",
                            SCRAPER_URL . "movies.php?host=" . base64_encode("Megavideo") . URL_AMP . "link=" . base64_encode($megavideo_id) . URL_AMP . "title=" . base64_encode($title) . URL_AMP . "PHPSESID=" . session_id(),
                            $image
                    );
                    ++$linkNumber;
                }
            }
        }

        //MySpace
        preg_match_all("/mediaservices.myspace.com\/(.*)\"/siU", $content, $links, PREG_SET_ORDER);
        foreach ($links as $value) {
            preg_match("/m=(.*),/siU", $value[1], $id);
            //Get video id
            $mscontent = file_get_contents("http://mediaservices.myspace.com/services/rss.ashx?videoID=" . $id[1] . "&type=video");
            //Get final link
            preg_match("/content url=\"(.*)\" type=\"(.*)\"/siU", $mscontent, $finalLink);
            if($finalLink) {
                $template->addMediaItem(
                        "[Option " . $i . "][Link " . $linkNumber . "] MySpace [" . substr($finalLink[1], strrpos($finalLink[1],"/")+1) . "]",
                        "",
                        $finalLink[1],
                        "",
                        $finalLink[2]
                );
                ++$linkNumber;
            }
            //Get image
            preg_match("/thumbnail url=\"(.*)\"/siU", $mscontent, $image);
            $image = $image[1];
            $template->setImage($image);
        }

        ++$i;
    }

    $template->generateView(Anime44MoviesTemplate::VIEW_MOVIE_DETAIL, $title);
}

function fetchLink($title,$host,$link) {
    $template = new Anime44MoviesTemplate();
    switch($host) {
        case "Megavideo":
            addMegavideoLink($template,$link);
            break;
    }
    $template->generateView(Anime44MoviesTemplate::VIEW_PLAY, $title);
}


function addMegavideoLink($template,$megavideo_id) {
    //If megaupload cookie is defined, use it
    if( COOKIE_STATE_ACTIVATED ) {
        $array = VideoUtil::generateMegavideoPremiumLink($megavideo_id);
        if($array) {
            $template->addMediaItem(
                    $array[0],
                    "",
                    $array[1],
                    "",
                    $array[2]
            );
        }
    }
}

//------------------------------------------------------------------------------
//------------------------------------------------------------------------------
/**
 * Get number of pages and retrieve first page content.
 */
function getPages() {
    $content = file_get_contents("http://www.anime44.com/category/anime-movies");

    //Get letter number of entries
    preg_match("/<div class=\"wp\-pagenavi\">(.*)<\/div>/siU", $content, $divPages);
    preg_match_all("/<a href=\"(.*)\" class=\"(.*)\"/U", $divPages[1], $links, PREG_SET_ORDER);

    foreach ($links as $value) {
        if($value[2] == "last" ) {
            $numPages = substr($value[1], strrpos($value[1],"/")+1);
        }
    }
    if(!$numPages) {
        $numPages = 1;
    }
    return array($content,$numPages);
}


?>
