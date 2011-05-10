<?php
/*-------------------------
 *    Developed by Maicros
 *     GNU/GPL v2 Licensed
 * ------------------------*/

include_once '../../config/config.php';
include_once 'MegastreamingTemplate.php';
include_once "../../util/VideoUtil.php";
include_once "../../util/RssScriptUtil.php";
include_once '../../action/Action.php';
include_once '../../action/rss/SaveBookmarkAction.php';
include_once '../../action/rss/DeleteBookmarkAction.php';
define("SCRAPER_URL", SERVER_HOST_AND_PATH . "php/scraper/megastreaming/");

//Start session
if(isset($_GET["PHPSESID"])) {
    session_id($_GET["PHPSESID"]);
}
session_start();

//
if(isset($_GET["cat"])) {    //Category movie view -----------------------------
    $type = $_GET["type"];
    $category = base64_decode($_GET["cat"]);
    $title = base64_decode($_GET["title"]);
    fetchMovieCategoryItems($type,$category,$title);

}else if(isset($_GET["item"])) {    //Movie detail view -------------------------------
    $type = $_GET["type"];
    $item = base64_decode($_GET["item"]);
    $title = base64_decode($_GET["title"]);
    fetchMovie($type,$item,$title);

}else if(isset($_GET["serie"])) {    // Serie seasons view ---------------------
    $type = $_GET["type"];
    $serieLink = base64_decode($_GET["serie"]);
    $title = base64_decode($_GET["title"]);
    fetchSerieSeasons($type,$serieLink,$title);

}else if(isset($_GET["season"])) {    // Serie season episodes view ------------
    $type = $_GET["type"];
    $seasonLink = base64_decode($_GET["season"]);
    fetchSerieSeasonEpisodes($type,$seasonLink);

}else if(isset($_GET["episode"])) {    // Serie episode links view -------------
    $type = $_GET["type"];
    $episodeLink = base64_decode($_GET["episode"]);
    $episodeName = base64_decode($_GET["episodeName"]);
    $seasonTitle = base64_decode($_GET["seasonTitle"]);
    fetchSerieSeasonEpisodeLinks($type,$episodeLink,$episodeName,$seasonTitle);

}else if(isset($_GET["type"])) {    // Show home view --------------------------
    $type = $_GET["type"];
    switch($type) {
        case "mov":
            fetchMovieCategories($type);
            break;
        case "ser":
            fetchSerieCategories($type);
            break;
    }

}else {     // Show home principal view ----------------------------------------
    fetchHome();
}




//------------------------------------------------------------------------------
//------------------------------------------------------------------------------

/**
 * Get principal scraper view.
 */
function fetchHome() {
    $_SESSION["megastreamingLastReferer"] = "http://www.megastreaming.ws";
    $template = new MegastreamingTemplate();
    $template->addItem(
            resourceString("movie"),
            resourceString("movie"),
            SCRAPER_URL . "index.php?type=mov". URL_AMP . "PHPSESID=" . session_id(),
            ""
    );
    $template->addItem(
            resourceString("serie"),
            resourceString("serie"),
            SCRAPER_URL . "index.php?type=ser". URL_AMP . "PHPSESID=" . session_id(),
            ""
    );
    $template->generateView(MegastreamingTemplate::VIEW_HOME, "Megastreaming");

}


//------------------------------------------------------------------------------
//------------------------------------------------------------------------------

/**
 */
function fetchMovieCategories($type) {
    $template = new MegastreamingTemplate();
    $template->setType($type);

    $content = @file_get_contents( "http://www.megastreaming.ws" );
    $newlines = array("\t","\n","\r","\x20\x20","\0","\x0B");
    $content = str_replace($newlines, "", html_entity_decode($content));

    $content = strstr($content,"TOUS LES FILMS");
    $content = substr($content, 0, strpos($content,"</ul>"));

    preg_match_all("/<a href\=\"(.*)\"(.*)>(.*)</U", $content, $links, PREG_SET_ORDER);

    $template->addItem(
            "Tous les films Par date",
            resourceString("category") . " Tous les films Par date",
            SCRAPER_URL . "index.php?type=$type" . URL_AMP . "cat=" . base64_encode("http://www.megastreaming.ws/streaming/films") . URL_AMP . "title=" . base64_encode($link[3]) . URL_AMP . "PHPSESID=" .  session_id(),
            ""
    );

    foreach ( $links as $link ) {
        $template->addItem(
                $link[3],
                resourceString("category") . " " . $link[3],
                SCRAPER_URL . "index.php?type=$type" . URL_AMP . "cat=" . base64_encode($link[1]) . URL_AMP . "title=" . base64_encode($link[3]) . URL_AMP . "PHPSESID=" .  session_id(),
                ""
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

    $template->generateView(MegastreamingTemplate::VIEW_CATEGORY, "");
}

/**
 */
function fetchMovieCategoryItems($type,$category,$title,$search=null) {
    $template = new MegastreamingTemplate();
    $template->setCategory($category);
    $template->setType($type);

    //If page equal "x" goto page number list, in other case process actual category page
    if( isset($_GET["page"]) && $_GET["page"] == "x" ) {
        $maxPages = $_GET["pages"];
        for($i=1;$i<=$maxPages;++$i) {
            $template->addItem(
                    $i,
                    resourceString("goto_page") . $i,
                    SCRAPER_URL . "index.php?type=" . $type . URL_AMP . "cat=" . base64_encode($category) . URL_AMP . "page=" . $i . URL_AMP . "pages=" . $maxPages . URL_AMP . "PHPSESID=" .  session_id(),
                    ""
            );
        }
        $template->generateView(MegastreamingTemplate::VIEW_PAGE_NUMBERS );

    }else {
        if(!isset($_GET["page"])) {
            $pages = getPages($category);
            $template->setActualPage(1);
            $template->setMaxPages($pages[1]);
            $content = $pages[0];
        }else {
            $template->setActualPage($_GET["page"]);
            $template->setMaxPages($_GET["pages"]);
            $content = @file_get_contents( $category . "page/" . $_GET["page"] . "/");
            $newlines = array("\t","\n","\r","\x20\x20","\0","\x0B");
            $content = str_replace($newlines, "", html_entity_decode($content,ENT_QUOTES,"UTF-8"));
        }

        preg_match_all("/<div class\=\"Styleazer2\">(.*)<\/table>/siU", $content, $links, PREG_SET_ORDER);
        if($links) {
            foreach ($links as $value) {
                //Link and Title
                preg_match("/<a href\=\"(.*)\"(.*)>(.*)</siU", $value[1], $matches);
                $movieLink = $matches[1];
                $movieTitle = $matches[3];

                //Image
                preg_match("/<img alt\=\"film streaming\" src\=\"(.*)\"/siU", $value[1], $matches);
                if(!$matches) {
                    $image = XTREAMER_IMAGE_PATH . "background/transparent_square.png";
                }else {
                    $image = $matches[1];
                }
                //Description
                preg_match("/<\/h3><p>(.*)</siU", $value[1], $matches);
                if($matches) {
                    $movieDescription = $matches[ count($matches)-1 ];
                }

                $template->addItem(
                        utf8_decode($movieTitle),
                        utf8_decode($movieDescription),
                        SCRAPER_URL . "index.php?type=$type" . URL_AMP . "item=" . base64_encode($movieLink) . URL_AMP . "title=" . base64_encode($movieTitle) . URL_AMP . "image=" . base64_encode($image) . URL_AMP . "PHPSESID=" .  session_id(),
                        $image
                );
            }
        }

        $template->generateView(MegastreamingTemplate::VIEW_MOVIE, "");
    }
}

/**
 */
function fetchMovie($type,$movie,$title) {
    $template = new MegastreamingTemplate();
    $template->setType($type);
    $template->setMovieTitle($title);

    //Parse movie page
    $content = @file_get_contents($movie);
    $newlines = array("\t","\n","\r","\x20\x20","\0","\x0B");
    $content = str_replace($newlines, "", utf8_decode( $content) );
    $_SESSION["megastreamingLastReferer"] = $movie;

    if( strpos($content,"<strong>DESCRIPTION</strong>")) {
        $content = strstr($content, "<strong>DESCRIPTION</strong>");
        $content = strstr($content, "<p>");
        $description = substr($content, 0, strpos($content, "</p>"));
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
    $image = "http://www.megastreaming.ws/wp-content/uploads/" . substr($content, 0, strpos($content, '"'));
    $template->setImage($image);

    $template->generateView(MegastreamingTemplate::VIEW_MOVIE_DETAIL);
}

//------------------------------------------------------------------------------
//------------------------------------------------------------------------------

/**
 */
function fetchSerieCategories($type) {
    session_start();
    $template = new MegastreamingTemplate();
    $template->setType($type);
    $seriesLoaded = false;

    //Check for loaded series on session
    if(isset($_SESSION["megastreamingSeries"])) {
        $div = unserialize($_SESSION["megastreamingSeries"]);
        $seriesLoaded = true;
    }else {
        //Get principal page and parse category list
        $content = @file_get_contents("http://www.megastreaming.ws/series-tv.html");
        $newlines = array("\t","\n","\r","\x20\x20","\0","\x0B");
        $input = str_replace($newlines, "", $content );

        $content = strstr($content, "<!-- Breadcrumbs -->");
        $content = strstr($content, "<table");
        $content = substr($content, 0, strpos($content,"</table>"));
        $content = html_entity_decode($content,ENT_QUOTES,"UTF-8");
        preg_match_all("/href=\"(.*)\">(.*)<\/a>/U", $content, $div, PREG_SET_ORDER);
    }

    if($div) {
        $newlines = array("<strong>","</strong>");
        foreach ($div as $value) {
            $name = utf8_decode($value[2]);
            $name = str_replace($newlines, "", $name );
            if($name != "" && $name != " ") {
                $weblink = str_replace("../", "http://www.megastreaming.ws/", $value[1]);
                $serieLink = SCRAPER_URL . "index.php?type=" . $type . URL_AMP . "serie=" . base64_encode($weblink) . URL_AMP . "title=" . base64_encode($name). URL_AMP . "PHPSESID=" . session_id();
                $template->addItem(
                        $name,
                        $name,
                        $serieLink,
                        ""
                );
            }
        }
    }
    //If series has been loaded from page, save to session
    if(!$seriesLoaded) {
        $_SESSION["megastreamingSeries"] = serialize($div);
    }

    $template->generateView(MegastreamingTemplate::VIEW_CATEGORY, "");
}

function fetchSerieSeasons($type,$serieLink,$title) {
    //Init template
    $template = new MegastreamingTemplate();
    $template->setType($type);

    //Parse first page series
    $content = @file_get_contents($serieLink);
    $newlines = array("\t","\n","\r","\x20\x20","\0","\x0B");
    $input = str_replace($newlines, "", utf8_decode( $content) );
    $_SESSION["megastreamingLastReferer"] = $serieLink;

    //Get data
    preg_match("/<\!-- Breadcrumbs -->(.*)<table/U", $input, $div);
    $div = $div[1];
    $div = strstr($div, 'src="' );
    $posterImage = substr($div, 5, strpos($div,'" ')-5);
    $div = substr($div, strpos($div,'<p>')+3);
    $description = substr($div, 0, -4);
    if( strpos($description,"</p>")) {
        $description = substr($div, 0, strpos($description,"</p>"));
    }
    $template->setSerieTitle($title);
    $template->setHeaderImage($posterImage);
    $template->setDescription( utf8_decode( html_entity_decode($description,ENT_QUOTES,"UTF-8") ) );

    $seasons = array();

    preg_match_all("/<h2>(.*)<\/h2><p>(.*)((<\/p>)|(<\/td>))/U", $input, $div, PREG_SET_ORDER);

    foreach ($div as $value) {
        $episodes = array();
        preg_match_all("/href\=\"(.*)\">(.*)<\/a>/U", $value[2], $links, PREG_SET_ORDER);
        foreach ($links as $link) {
            $episodeName = $link[2];
            $episodeName = str_replace(array("<strong>","</strong>"), "", $episodeName );
            if( strpos($link[1],"./")) {
                $episodes[$episodeName] = str_replace("..", "http://www.megastreaming.ws", $link[1]);
                $lastLink  = $episodes[$episodeName];
            }else {
                $episodes[$episodeName] = $link[1];
                $lastLink =  $link[1];
            }
        }
        $seasonName = str_replace(array("<strong>","</strong>"), "", html_entity_decode($value[1],ENT_QUOTES,"UTF-8") );
        if(strpos($value[1],"<")) {
            $seasonName = substr($value[1], 0, strpos($value[1],"<"));
        }
        $seasons[$seasonName] = $episodes;
    }
    ksort($seasons);
    $template->setSerie($seasons);

    //Get cover
    $content = @file_get_contents($lastLink);
    if(strpos($content,"caticon/")) {
        $content = strstr($content,"caticon/");
        $coverImage = "http://www.megastreaming.ws/wp-content/uploads/" . substr($content, 0, strpos($content, '"'));
    }else if(strpos($content,"yapb_cache/")) {
        $content = strstr($content,"yapb_cache/");
        $coverImage = "http://www.megastreaming.ws/wp-content/uploads/" . substr($content, 0, strpos($content, '"'));
    }
    $template->setImage($coverImage);

    //save data to session
    $_SESSION["serieTitle"] = $title;
    $_SESSION["serieLink"] = $serieLink;
    $_SESSION["serieDescription"] = $description;
    $_SESSION["seriePoster"] = $posterImage;
    $_SESSION["serieCover"] = $coverImage;
    $_SESSION["seasons"] = serialize( $seasons );

    $template->generateView(MegastreamingTemplate::VIEW_SERIE_SEASON, $title);

}

function fetchSerieSeasonEpisodes($type,$season) {
    //Init template
    $template = new MegastreamingTemplate();
    $template->setType($type);

    //recover session data
    $template->setSerieTitle($_SESSION["serieTitle"]);
    $template->setHeaderImage($_SESSION["seriePoster"]);
    $template->setImage($_SESSION["serieCover"]);
    $template->setDescription($_SESSION["serieDescription"]);
    $template->setSeasonTitle($season);
    $seasons = unserialize($_SESSION["seasons"]);
    $template->setSerie($seasons);

    $episodes = $seasons[$season];
    $template->setSeason($episodes);

    //save data to session
    $_SESSION["seasonTitle"] = $season;

    $template->generateView(MegastreamingTemplate::VIEW_SERIE_EPISODE, $title);
}

function fetchSerieSeasonEpisodeLinks($type,$episodeLink,$episodeName,$seasonTitle) {
    //Init template
    $template = new MegastreamingTemplate();
    $template->setType($type);

    //recover session data
    $template->setSerieTitle($_SESSION["serieTitle"]);
    $template->setEpisodeTitle($episodeName);
    $template->setSeasonTitle($seasonTitle);
    $seasons = unserialize($_SESSION["seasonTitle"]);

    //Get page content
    $content = @file_get_contents( $episodeLink );
    $newlines = array("\t","\n","\r","\x20\x20","\0","\x0B");
    $content = str_replace($newlines, "", html_entity_decode(utf8_decode($content),ENT_QUOTES));
    $_SESSION["megastreamingLastReferer"] = $episodeLink;

    if( strpos($content,"<strong>DESCRIPTION</strong>")) {
        $content = strstr($content, "<strong>DESCRIPTION</strong>");
        $content = strstr($content, "<p>");
        $description = substr($content, 0, strpos($content, "</p>"));
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
                if(strlen($value) > 20 ) {
                    $megavideo_id = substr($value, 0, -32);
                }else {
                    $megavideo_id = $value;
                }
                //Show real link
                if( COOKIE_STATE_ACTIVATED && $megavideo_id ) {
                    $array = VideoUtil::generateMegavideoPremiumLink($megavideo_id);
                    if($array) {
                        $template->addMediaItem(
                                $array[0],
                                $description,
                                $array[1],
                                $movieImage,
                                $array[2]
                        );
                    }
                }
            }
        }

    }

    //Set cover image
    $template->setImage($_SESSION["serieCover"]);

    $template->generateView(MegastreamingTemplate::VIEW_SERIE_EPISODE_LINK,$_SESSION["serieTitle"]);
}

//------------------------------------------------------------------------------
//------------------------------------------------------------------------------

function getPages($url) {
    //Add pages
    //<span class='pages'>Page 1 sur 72</span>

    $content = file_get_contents($url);
    echo $url;
    echo $content;
    $url = substr($url, 0, -1);
    $content = file_get_contents($url);
    $newlines = array("\t","\n","\r","\x20\x20","\0","\x0B");
    $content = str_replace($newlines, "", html_entity_decode($content,ENT_QUOTES,"UTF-8"));
    $_SESSION["megastreamingLastReferer"] = $url;

    preg_match("/<span class\=\'pages\'>Page(.*)sur(.*)<\/span>/siU", $content, $pages);
    if($pages) {
        $numPages = (int)trim($pages[2]);
    }else {
        $numPages = 1;
    }
    return array($content,$numPages);
}


?>
