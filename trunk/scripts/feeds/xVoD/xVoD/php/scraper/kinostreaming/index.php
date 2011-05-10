<?php
/*-------------------------
 *    Developed by Maicros
 *      GNU/GPL Licensed
 * ------------------------*/

include_once '../../config/config.php';
include_once 'KinostreamingTemplate.php';
include_once "../../util/VideoUtil.php";
include_once "../../util/RssScriptUtil.php";
include_once '../../action/Action.php';
include_once '../../action/rss/SaveBookmarkAction.php';
include_once '../../action/rss/DeleteBookmarkAction.php';
define("SCRAPER_URL", SERVER_HOST_AND_PATH . "php/scraper/kinostreaming/");

//Do action
if( isset($_GET["search"]) ) {
    $type = $_GET["search"];
    $pageTitle = base64_decode($_GET["title"]);
    if(isset($_GET["view"])) {
        $view = $_GET["view"];
    }else {
        $view = "";
    }
    fetchSearch($type,$view,$pageTitle);

}else if( isset($_GET["type"]) ) {
    $type = base64_decode($_GET["type"]);
    $pageTitle = base64_decode($_GET["title"]);
    fetchCategoryItems($type,$pageTitle);

}else if(isset($_GET["item"])) {
    $item = base64_decode($_GET["item"]);
    $title = base64_decode($_GET["title"]);
    $image = base64_decode($_GET["image"]);
    fetchMovie($item,$title,$image);

}else {
    fetchCategories();
}

//------------------------------------------------------------------------------
//------------------------------------------------------------------------------

function fetchCategories() {
    $template = new KinostreamingTemplate();
    //Get principal page and parse categories side bar
    $content = file_get_contents("http://kinostreaming.com/publ");
    $newlines = array("\t","\n","\r","\x20\x20","\0","\x0B");
    $input = str_replace($newlines, "", utf8_decode( $content) );
    preg_match("|<\!-- <block2> -->(.*)<\!-- <\/block2> -->|U", $input, $div);
    preg_match_all("|<a href\=\"(.*)\" class\=\"catName\">(.*)<\/a>|U", $div[1], $div, PREG_SET_ORDER);
    foreach ($div as $link) {
        $template->addItem(
                $link[2],
                "",
                SCRAPER_URL . "index.php?type=" . base64_encode($link[1]) . URL_AMP . "title=" . base64_encode($link[2]),
                ""
        );
    }

    $template->generateView(KinostreamingTemplate::VIEW_CATEGORY, "Kinostreaming.com" );
}

function fetchCategoryItems($type,$title) {
    $template = new KinostreamingTemplate();
    //Start session
    if(isset($_GET["PHPSESID"])) {
        session_id($_GET["PHPSESID"]);
    }
    session_start();

    //If page equal "x" goto page number list, in other case process actual category page
    if( isset($_GET["page"]) && $_GET["page"] == "x" ) {
        $maxPages = $_GET["pages"];
        for($i=1;$i<=$maxPages;++$i) {
            $template->addItem(
                    $i,
                    resourceString("goto_page") . $i,
                    SCRAPER_URL . "index.php?type=" . base64_encode($type) . URL_AMP . "page=" . $i . URL_AMP . "pages=" . $maxPages,
                    ""
            );
        }
        $template->generateView(KinostreamingTemplate::VIEW_PAGE_NUMBERS );

    }else {
        if(!isset($_GET["page"])) {
            $pages = getPages($type."-1-3");
            $template->setActualPage(1);
            $template->setMaxPages($pages[1]);
            $content = $pages[0];
        }else {
            $template->setActualPage($_GET["page"]);
            $template->setMaxPages($_GET["pages"]);
            $content = file_get_contents( $type . "-" . $_GET["page"] . "-3" );
            $newlines = array("\t","\n","\r","\x20\x20","\0","\x0B");
            $content = str_replace($newlines, "", html_entity_decode($content));
        }

        preg_match_all("/<div class\=\"eTitle\"(.*)><a href\=\"(.*)\">(.*)<\/a>(.*)<img src\=\"(.*)\"/U", $content, $links, PREG_SET_ORDER);
        
        if($links) {
            foreach ($links as $value) {
                $image = $value[5];
                if(!$image) {
                    $image = XTREAMER_IMAGE_PATH . "background/nocover.jpg";
                }
                $template->addItem(
                        utf8_decode($value[3]),
                        "",
                        SCRAPER_URL . "index.php?item=" . base64_encode($value[2]) . URL_AMP . "title=" . base64_encode($value[3]) . URL_AMP . "image=" . base64_encode($image) . URL_AMP . "PHPSESID=" .  session_id(),
                        $image
                );
            }
        }

        $template->generateView(KinostreamingTemplate::VIEW_MOVIE, "");
    }
}

function fetchMovie($item,$title,$image) {
    $template = new KinostreamingTemplate();
    $template->setMovieTitle($title);
    //Start session
    if(isset($_GET["PHPSESID"])) {
        session_id($_GET["PHPSESID"]);
    }
    session_start();

    //Parse movie page
    $content = file_get_contents($item);
    $newlines = array("\t","\n","\r","\x20\x20","\0","\x0B");
    $content = str_replace($newlines, "", utf8_decode( $content) );

    if( strpos($content,"<strong>DESCRIPTION</strong>")) {
        $content = strstr($content, "<strong>DESCRIPTION</strong>");
        $content = strstr($content, "<p>");
        $description = substr($content, 0, strrpos($content, "</p>"));
        $description = str_replace("<p>", "", $description);
        $template->setDescription($description);
    }

    if( strpos($content, "http://www.megavideo.com/v" ) ) {
        $regex = "|www.megavideo.com\/v\/(.*)\"|U";
    }else if( strpos($content, "&v=" ) ) {
        $regex = "|\&v\=(.*)\"|U";
    }else {
        $regex = false;
    }
    if($regex) {
        preg_match_all($regex, $content, $links);
        if($links && $links[1]) {
            $links = $links[1];
            $links = array_unique( $links );
            foreach ($links as $value) {
                //Get megavideo id
                if(count_chars($value) > 20 ) {
                    $megavideo_id = substr($value, 0, -32);
                }else {
                    $megavideo_id = $value;
                }
                if( COOKIE_STATE_ACTIVATED && $megavideo_id ) {
                    $array = VideoUtil::generateMegavideoPremiumLink($megavideo_id);
                    if($array) {
                        $template->addMediaItem(
                                $array[0],
                                $description,
                                $array[1],
                                "",
                                $array[2]
                        );
                    }
                }
            }
        }

    }

    //Get megaupload links
    if( strpos($content, "www.megaupload.com/?d=" ) ) {
        preg_match_all("|www\.megaupload\.com\/\?d\=(.*)\s?\" class\=\"Stylehopbleu\"|U", $content, $links);
        if($links && $links[1]) {
            $links = $links[1];
            $links = array_unique( $links );

            foreach($links as $megaupload_id ) {
                if( COOKIE_STATE_ACTIVATED ) {
                    $array = VideoUtil::generateMegauploadPremiumLink($megaupload_id);
                    if($array) {
                        //echo $megavideo_id;
                        $template->addMediaItem(
                                $array[0],
                                $description,
                                $array[1],
                                "",
                                $array[2]
                        );
                    }
                }
            }
        }
    }
    $content = strstr($content,"yapb_cache/");
    $image = "http://www.megavideolink.com/wp-content/uploads/" . substr($content, 0, strpos($content, '"'));
    $template->setImage($image);

    $template->generateView(KinostreamingTemplate::VIEW_MOVIE_DETAIL);
}


//------------------------------------------------------------------------------
//------------------------------------------------------------------------------

function getPages($url){
    //Add pages
    //<span class='pages'>Page 1 sur 72</span>
    $content = file_get_contents($url);
    $newlines = array("\t","\n","\r","\x20\x20","\0","\x0B");
    $content = str_replace($newlines, "", html_entity_decode($content));
    $ret = $content;

    while($content){
        $content = strstr($content,'<a class="swchItem1"');
        $content = strstr($content,'class');
        if($content && !strpos($content,'<a class="swchItem1"')){
            $lastPages = $content;
        }
    }
    preg_match("/spages\('(.*)','(.*)'\)/siU", $lastPages, $pages);
    if($pages){
        $numPages = (int)trim($pages[1]);
    }else{
        $numPages = 1;
    }
    return array($ret,$numPages);
}

?>
