<?php
/*-------------------------
 *    Developed by Maicros
 *     GNU/GPL v2 Licensed
 * ------------------------*/

include_once '../../config/config.php';
include_once 'MegavideolinkTemplate.php';
include_once "../../util/VideoUtil.php";
include_once "../../util/RssScriptUtil.php";
include_once '../../action/Action.php';
include_once '../../action/rss/SaveBookmarkAction.php';
include_once '../../action/rss/DeleteBookmarkAction.php';
define("SCRAPER_URL", SERVER_HOST_AND_PATH . "php/scraper/megavideolink/");
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
    $_SESSION["megavideolinkLastReferer"] = "http://www.megavideolink.com";
    $template = new MegavideolinkTemplate();
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
    $template->generateView(MegavideolinkTemplate::VIEW_HOME, "Megavideolink");

}


//------------------------------------------------------------------------------
//------------------------------------------------------------------------------

function fetchMovieCategories($type) {
    $template = new MegavideolinkTemplate();
    $template->setType($type);

    $content = @file_get_contents( "http://www.megavideolink.com" );
    $newlines = array("\t","\n","\r","\x20\x20","\0","\x0B");
    $content = str_replace($newlines, "", html_entity_decode($content));
    $_SESSION["megavideolinkLastReferer"] = "http://www.megavideolink.com";

    $content = strstr($content,"TOUS LES FILMS");
    $content = substr($content, 0, strpos($content,"</ul>"));
    preg_match_all("/<a href\=\"(.*)\"(.*)>(.*)</U", $content, $links, PREG_SET_ORDER);

    foreach ( $links as $link ) {
        $link[1] = substr($link[1], 0, -1);
        $template->addItem(
                $link[3],
                resourceString("category") . " " . $link[3],
                SCRAPER_URL . "index.php?type=$type" . URL_AMP . "cat=" . base64_encode($link[1]) . URL_AMP . "title=" . base64_encode($link[3]) . URL_AMP . "PHPSESID=" .  session_id(),
                ""
        );
    }

    $template->setSearch( array(
            resourceString("search_by") . "...",
            resourceString("search_by") . "...",
            "rss_command://search",
            SCRAPER_URL . "index.php?search=%s" . URL_AMP . "type=$type" . URL_AMP . "title=" . base64_encode("Search by") . URL_AMP . "PHPSESID=" .  session_id(),
            ""
            )
    );

    $template->generateView(MegavideolinkTemplate::VIEW_CATEGORY, "");
}

function fetchMovieCategoryItems($type,$category,$title) {
    $template = new MegavideolinkTemplate();
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
        $template->generateView(MegavideolinkTemplate::VIEW_PAGE_NUMBERS );

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
            $_SESSION["megavideolinkLastReferer"] = $category . "page/" . $_GET["page"] . "/";
            $newlines = array("\t","\n","\r","\x20\x20","\0","\x0B");
            $content = str_replace($newlines, "", html_entity_decode($content, ENT_QUOTES));
        }

        preg_match_all("/<div class\=\"Styleazer2\">(.*)<\/table>/siU", $content, $links, PREG_SET_ORDER);
        if($links) {
            foreach ($links as $value) {
                //Link and Title
                preg_match("/<h3><a href\=\"(.*)\">(.*)</siU", $value[1], $matches);
                $movieLink = $matches[1];
                $movieTitle = $matches[2];
                //Image
                preg_match("/<img alt\=\"film streaming\" src\=\"(.*)\"/siU", $value[1], $matches);
                if(!$matches) {
                    $image = XTREAMER_IMAGE_PATH . "background/transparent_square.png";
                }else {
                    $image = $matches[1];
                }
                //Description
                preg_match("/<\/h3><p>(.*)<\/p><p>(.*)<\/p><p>(.*)<\/p>/siU", $value[1], $matches);
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

        $template->generateView(MegavideolinkTemplate::VIEW_MOVIE, "");
    }
}

function fetchMovie($type,$movie,$title) {
    $template = new MegavideolinkTemplate();
    $template->setType($type);
    $template->setMovieTitle($title);

    //Parse movie page
    $movie = str_replace("www.megavideolink.com", "www.megavideolink.cc", $movie);
    $content = @file_get_contents($movie);
    $newlines = array("\t","\n","\r","\x20\x20","\0","\x0B");
    $content = str_replace($newlines, "", utf8_decode( $content) );
    $_SESSION["megavideolinkLastReferer"] = $movie;

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
                    $newValue = VideoUtil::separateMegavideoIdWithImage($value);
                    $megavideo_id = $newValue[0];
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
        preg_match_all("|www\.megaupload\.com\/\?d\=(.*)\s?\"|U", $content, $links);
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

    $template->generateView(MegavideolinkTemplate::VIEW_MOVIE_DETAIL);
}

//------------------------------------------------------------------------------
//------------------------------------------------------------------------------

function fetchSerieCategories($type) {
    session_start();
    $template = new MegavideolinkTemplate();
    $template->setType($type);
    $seriesLoaded = false;

    //Check for loaded series on session
    if(isset($_SESSION["megavideolinkSeries"])) {
        $div = unserialize($_SESSION["megavideolinkSeries"]);
        $seriesLoaded = true;
    }else {
        //Get principal page and parse category list
        $content = @file_get_contents("http://www.megavideolink.com/series-tv.html");
        $newlines = array("\t","\n","\r","\x20\x20","\0","\x0B");
        $input = str_replace($newlines, "", utf8_decode( $content) );
        $_SESSION["megavideolinkLastReferer"] = "http://www.megavideolink.com/series-tv.html";
        preg_match("/<option value\=\"#\">(.*)<\/select>/U", $input, $div);
        $div = $div[1];
        preg_match_all("/<option value\=\"(.*)\">(.*)<\/option>/U", $div, $div, PREG_SET_ORDER);
    }

    if($div) {
        foreach ($div as $value) {
            $serieLink = SCRAPER_URL . "index.php?type=" . $type . URL_AMP . "serie=" . base64_encode($value[1]) . URL_AMP . "title=" . base64_encode($value[2]). URL_AMP . "PHPSESID=" . session_id();
            $template->addItem(
                    html_entity_decode($value[2]),
                    html_entity_decode($value[2]),
                    $serieLink,
                    ""
            );
        }
    }
    //If series has been loaded from page, save to session
    if(!$seriesLoaded) {
        $_SESSION["megavideolinkSeries"] = serialize($div);
    }

    $template->generateView(MegavideolinkTemplate::VIEW_CATEGORY, "");
}

function fetchSerieSeasons($type,$serieLink,$title) {
    //Init template
    $template = new MegavideolinkTemplate();
    $template->setType($type);

    //Parse first page series
    $content = @file_get_contents($serieLink);
    $newlines = array("\t","\n","\r","\x20\x20","\0","\x0B");
    $input = str_replace($newlines, "", utf8_decode( $content) );
    $_SESSION["megavideolinkLastReferer"] = $serieLink;

    //Get data
    preg_match("/<select(.*)<h2/U", $input, $div);

    $div = $div[1];
    $div = strstr($div, '<img' );
    $div = strstr($div, 'src="' );
    $posterImage = substr($div, 5, strpos($div,'" ')-5);
    $div = substr($div, strpos($div,'<p>')+3);
    $description = substr($div, 0, -4);
    if( strpos($description,"</p>")) {
        $description = substr($div, 0, strpos($description,"</p>"));
    }
    $template->setSerieTitle($title);
    $template->setHeaderImage($posterImage);
    $template->setDescription(html_entity_decode($description));

    $seasons = array();

    $input = strstr($input,"<select ");
    preg_match_all("/<h2(.*)>(.*)<\/h2><p>(.*)((<\/p>)|(<\/td>))/U", $input, $div, PREG_SET_ORDER);

    foreach ($div as $value) {
        $episodes = array();
        preg_match_all("/href\=\"(.*)\">(.*)<\/a>/U", $value[3], $links, PREG_SET_ORDER);
        foreach ($links as $link) {
            $episodeName = $link[2];
            $episodeName = str_replace(array("<strong>","</strong>"), "", $episodeName );
            if( strpos($link[1],"./")) {
                $episodes[$episodeName] = str_replace("..", "http://www.megavideolink.com", $link[1]);
                $lastLink  = $episodes[$episodeName];
            }else {
                $episodes[$episodeName] = $link[1];
                $lastLink =  $link[1];
            }
        }
        $seasonName = html_entity_decode($value[2]);
        $seasonName = str_replace(array("<strong>","</strong>"), "", $seasonName );
        if(strpos($value[2],"<")) {
            $seasonName = substr($value[2], 0, strpos($value[2],"<"));
        }
        $seasons[$seasonName] = $episodes;
    }
    ksort($seasons);
    $template->setSerie($seasons);

    //Get cover
    $content = @file_get_contents($lastLink);
    if(strpos($content,"caticon/")) {
        $content = strstr($content,"caticon/");
        $coverImage = "http://www.megavideolink.cc/wp-content/uploads/" . substr($content, 0, strpos($content, '"'));
    }else if(strpos($content,"yapb_cache/")) {
        $content = strstr($content,"yapb_cache/");
        $coverImage = "http://www.megavideolink.cc/wp-content/uploads/" . substr($content, 0, strpos($content, '"'));
    }
    $template->setImage($coverImage);

    //save data to session
    $_SESSION["serieTitle"] = $title;
    $_SESSION["serieLink"] = $serieLink;
    $_SESSION["serieDescription"] = $description;
    $_SESSION["seriePoster"] = $posterImage;
    $_SESSION["serieCover"] = $coverImage;
    $_SESSION["seasons"] = serialize( $seasons );

    $template->generateView(MegavideolinkTemplate::VIEW_SERIE_SEASON, $title);

}

function fetchSerieSeasonEpisodes($type,$season) {
    //Init template
    $template = new MegavideolinkTemplate();
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

    $template->generateView(MegavideolinkTemplate::VIEW_SERIE_EPISODE, $title);
}

function fetchSerieSeasonEpisodeLinks($type,$episodeLink,$episodeName,$seasonTitle) {
    //Init template
    $template = new MegavideolinkTemplate();
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
    $_SESSION["megavideolinkLastReferer"] = $episodeLink;

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
                    $newValue = VideoUtil::separateMegavideoIdWithImage($value);
                    $megavideo_id = $newValue[0];
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

    //Get megaupload links
    if( strpos($content, "www.megaupload.com/?d=" ) ) {
        preg_match_all("|www\.megaupload\.com\/\?d\=(.*)\s?\"|U", $content, $links);
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

    //Set cover image
    $template->setImage($_SESSION["serieCover"]);

    $template->generateView(MegavideolinkTemplate::VIEW_SERIE_EPISODE_LINK,$_SESSION["serieTitle"]);
}

//------------------------------------------------------------------------------
//------------------------------------------------------------------------------

function getPages($url) {
    //Add pages
    //<span class='pages'>Page 1 sur 72</span>
    $content = @file_get_contents($url);
    $newlines = array("\t","\n","\r","\x20\x20","\0","\x0B");
    $content = str_replace($newlines, "", html_entity_decode($content));
    $_SESSION["megavideolinkLastReferer"] = $url;

    preg_match("/<span class\=\'pages\'>Page(.*)sur(.*)<\/span>/siU", $content, $pages);
    if($pages) {
        $numPages = (int)trim($pages[2]);
    }else {
        $numPages = 1;
    }
    return array($content,$numPages);
}

function getContext($cookie) {
    $opts = array(
            'http'=>array(
                    'method'=>"GET",
                    'header'=> "Host: www.megavideolink.com\r\n".
                            "User-Agent: Mozilla/5.0 (Windows; U; Windows NT 5.1; es-ES; rv:1.9.2.10) Gecko/20100914 Firefox/3.6.10 (.NET CLR 3.5.30729)\r\n".
                            "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8\r\n".
                            "Accept-Language: es-es,es;q=0.8,en-us;q=0.5,en;q=0.3\r\n".
                            "Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7\r\n".
                            "Keep-Alive: 115\r\n".
                            "Connection: keep-alive\r\n".
                            "Referer: " . $_SESSION["megavideolinkLastReferer"] . "\r\n".
                            $cookie . "\r\n"
            )
    );
    $context = stream_context_create($opts);
    return $context;
}


function getUrlContent($url) {
//    if(isset ($_SESSION["megavideoLinkCache"])) {
//        $cache = unserialize($_SESSION["megavideoLinkCache"]);
//    }else {
//        $cache = array();
//
//    }

    //Get contents from internet, or rudimentary session cache
    $content = @file_get_contents($url);
    //echo $content;
    $_SESSION["megavideolinkLastReferer"] = $url;
    $url = explode( " ", $http_response_header[5]);
    if (strpos($http_response_header[0], "404") || strpos($http_response_header[0], "301")) {
//        $content = $cache[$url];
//    }else{
//        $cache[$url] = $content;
//        //Save cache to session
//        $_SESSION["megavideoLinkCache"] = serialize($cache);
        $cookie = "Cookie: ";
        foreach ($_COOKIE as $key => $value) {
            $cookie = $cookie . $key . "=" . $value . "; ";
        }

        $content = @file_get_contents($url[1],false,getContext($cookie));
    }

    return $content;
}

?>
