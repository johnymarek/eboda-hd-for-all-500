<?php
/*-------------------------
 *    Developed by Maicros
 *     GNU/GPL v2 Licensed
 * ------------------------*/

include_once '../../config/config.php';
include_once 'MarocTemplate.php';
include_once "../../util/VideoUtil.php";
include_once "../../util/RssScriptUtil.php";
include_once '../../action/Action.php';
include_once '../../action/rss/SaveBookmarkAction.php';
include_once '../../action/rss/DeleteBookmarkAction.php';
define("SCRAPER_URL", SERVER_HOST_AND_PATH . "php/scraper/maroc/");
if(isset($_GET["download"])) {
	$downloadfile = "/tmp/xvod_links.txt";
	if (file_exists( $downloadfile )){
		$extension = " > /dev/null 2>&1 & echo $!";
		$outputdir = "/tmp/hdd/volumes/HDD1/movie/";
		$command ="/opt/bin/wget -i$downloadfile -P $outputdir";
   		exec($command.$extension, $op);
	}
}
else
//Start session
if(isset($_GET["PHPSESID"])) {
    session_id($_GET["PHPSESID"]);
}
session_start();

//
if(isset($_GET["cat"])) {    //Category movie view -----------------------------
    $category = base64_decode($_GET["cat"]);
    $title = base64_decode($_GET["title"]);
    fetchMovieCategoryItems($category,$title);

}else if(isset($_GET["item"])) {    //Movie detail view -------------------------------
    $item = base64_decode($_GET["item"]);
    $title = base64_decode($_GET["title"]);
    $image = base64_decode($_GET["image"]);
    fetchMovie($item,$title,$image);

}else {    // Show home view --------------------------
    fetchMovieCategories();
}




//------------------------------------------------------------------------------
//------------------------------------------------------------------------------

/**
 */
function fetchMovieCategories() {
    $template = new MarocTemplate();

    $content = @file_get_contents( "http://www.01maroc.com/modules/films/index.php" );
    $newlines = array("\t","\n","\r","\x20\x20","\0","\x0B");
    $content = str_replace($newlines, "", html_entity_decode($content));

    $content = strstr($content,"<!-- Start category loop -->");
    $content = substr($content, 0, strpos($content,"<!-- End category loop -->"));
    //echo $content;

    preg_match_all("/<td width\=\"5%\" style=\"text-align\: center;\"><a href\=\"(.*)\"><img src\=\"(.*)\" title\=\"(.*)\"(.*)\/><\/a>(.*)<b>(.*)<\/b>/U", $content, $links, PREG_SET_ORDER);

    //var_dump($links);

//    $template->addItem(
//            "Tous les films Par date",
//            resourceString("category") . " Tous les films Par date",
//            SCRAPER_URL . "index.php?type=$type" . URL_AMP . "cat=" . base64_encode("http://www.megastreaming.ws/streaming/films") . URL_AMP . "title=" . base64_encode($link[3]) . URL_AMP . "PHPSESID=" .  session_id(),
//            ""
//    );

    foreach ( $links as $link ) {
        $template->addItem(
                $link[6],
                $link[3],
                SCRAPER_URL . "index.php?cat=" . base64_encode($link[1]) . URL_AMP . "title=" . base64_encode($link[6]) . URL_AMP . "PHPSESID=" .  session_id(),
                $link[2]
        );
    }

//    $template->setSearch( array(
//            resourceString("search_by") . "...",
//            resourceString("search_by") . "...",
//            "rss_command://search",
//            SCRAPER_URL . "index.php?search=%s" . URL_AMP . "type=$type" . URL_AMP . "title=" . base64_encode("Search by") . URL_AMP . "PHPSESID=" .  session_id(),
//            ""
//            )
//    );

    $template->generateView(MarocTemplate::VIEW_CATEGORY, "");
}

/**
 */
function fetchMovieCategoryItems($category,$title,$search=null) {
    $template = new MarocTemplate();
    $template->setCategory($category);

    //Check for name ordered
    if( !strpos($category,"orderby") ) {
        $category = $category . "&orderby=titleA";
    }

    //If page equal "x" goto page number list, in other case process actual category page
    if( isset($_GET["page"]) && $_GET["page"] == "x" ) {
        $maxPages = $_GET["pages"];
        for($i=1;$i<=$maxPages;++$i) {
            $template->addItem(
                    $i,
                    resourceString("goto_page") . $i,
                    SCRAPER_URL . "index.php?cat=" . base64_encode($category) . URL_AMP . "page=" . $i . URL_AMP . "pages=" . $maxPages . URL_AMP . "PHPSESID=" .  session_id(),
                    ""
            );
        }
        $template->generateView(MarocTemplate::VIEW_PAGE_NUMBERS );

    }else {
        if(!isset($_GET["page"])) {
            $pages = getPages($category);
            $template->setActualPage(1);
            $template->setMaxPages($pages[1]);
            $content = $pages[0];
        }else {
            $template->setActualPage($_GET["page"]);
            $template->setMaxPages($_GET["pages"]);
            $content = @file_get_contents( $category . "&start=" . ((((int)$_GET["page"])-1)*10) . "/");
            $newlines = array("\t","\n","\r","\x20\x20","\0","\x0B");
            $content = str_replace($newlines, "", html_entity_decode($content,ENT_QUOTES,"UTF-8"));
        }

        //Get movies block
        $content = strstr($content,"<!-- Start link loop -->");
        $content = substr($content, 0, strpos($content,"<!-- End link loop -->"));

        preg_match_all("/<div style=\"float: left; padding: 0 4px 4px 0;\">(.*)<a href=\"(.*)\" target=\"\"><img src=\"(.*)\"(.*)title=\"(.*)\"/siU", $content, $links, PREG_SET_ORDER);
        //var_dump($links);
        if($links) {
            foreach ($links as $link) {
                $template->addItem(
                        $link[5],
                        $movieDescription,
                        SCRAPER_URL . "index.php?title=" . base64_encode($link[5]) . URL_AMP . "item=" . base64_encode($link[2]) . URL_AMP . "image=" . base64_encode($link[3]) . URL_AMP . "PHPSESID=" .  session_id(),
                        $link[3]
                );
            }
        }

        $template->generateView(MarocTemplate::VIEW_MOVIE, "");
    }
}

/**
 */
function fetchMovie($movie,$title,$image) {
    $template = new MarocTemplate();
    $template->setMovieTitle($title);
    $template->setImage($image);

    //Parse movie page
    $content = file_get_contents($movie);
    $newlines = array("\t","\n","\r","\x20\x20","\0","\x0B");
    $content = str_replace($newlines, "", html_entity_decode( $content,ENT_QUOTES,"UTF-8") );

    $content = strstr($content,"<fieldset class=\"film_description\">");
    $content = strstr($content, "</table>");
    $description = substr($content, 8, strpos($content, "</fieldset>")-8);
    $template->setDescription($description);

    //Get megavideo id and link
    preg_match("/wwwstatic.megavideo.com\/mv_player.swf(.*)&v=(.*)\"/siU", $content, $links);
    if($links && $links[2]) {
        $megavideo_id = $links[2];
        if( COOKIE_STATE_ACTIVATED && $megavideo_id ) {
            $array = VideoUtil::generateMegavideoPremiumLink($megavideo_id);
            if($array) {
                $template->addMediaItem(
                        $title,
                        $description,
                        $array[1],
                        "",
                        $image
                );
            }
        }

    }

    $template->generateView(MarocTemplate::VIEW_MOVIE_DETAIL);
}

//------------------------------------------------------------------------------
//------------------------------------------------------------------------------

function getPages($url) {
    $content = @file_get_contents($url);
    $newlines = array("\t","\n","\r","\x20\x20","\0","\x0B");
    $content = str_replace($newlines, "", html_entity_decode($content,ENT_QUOTES,"UTF-8"));

    //Get page list begin
    $newcontent = strstr($content, "<b>(1)");
    $newcontent = substr($newcontent, 0, strpos($newcontent, "</div>") );

    preg_match_all("/start=(.*)\"/siU", $newcontent, $pages, PREG_SET_ORDER);

    if($pages) {
        $pages = $pages[ count($pages)-2 ];
        $numPages = ((int)trim($pages[1]))/10 + 1;
    }else {
        $numPages = 1;
    }
    return array($content,$numPages);
}


?>
