<?php
/*-------------------------
 *    Developed by Maicros
 *      GNU/GPL Licensed
 * ------------------------*/

include_once '../../config/config.php';
include_once 'AnivideSeriesTemplate.php';
include_once "../../util/VideoUtil.php";
include_once "../../util/RssScriptUtil.php";
include_once '../../action/Action.php';
include_once '../../action/rss/SaveBookmarkAction.php';
include_once '../../action/rss/DeleteBookmarkAction.php';
define("SCRAPER_URL", SERVER_HOST_AND_PATH . "php/scraper/anivide/");

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

}else if( isset($_GET["letter"]) ) {
    $letter = $_GET["letter"];
    $type = "http://kino.to/Series.html";
    fetchLetterItems($type,$letter,"Series: " . $letter);

}else if( isset($_GET["serie"]) ) {
    $serie = base64_decode($_GET["serie"]);
    $title = base64_decode($_GET["title"]);
    fetchSerieEpisodes($serie,$title);

}else if( isset($_GET["episode"]) ) {
    $episode = base64_decode($_GET["episode"]);
    $title = base64_decode($_GET["title"]);
    fetchSerieSeasonEpisodeLinks($episode,$title);

}else if( isset ($_GET["host"])) {
    $host = base64_decode($_GET["host"]);
    $link = base64_decode($_GET["link"]);
    fetchPlayEpisode($host,$link);

}else {
    fetchCategories();
}

//------------------------------------------------------------------------------
//------------------------------------------------------------------------------
//------------------------------------------------------------------------------

/**
 * Show initial categories.
 */
function fetchCategories() {
    $template = new AnivideSeriesTemplate();
    $letters = array(
            "A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z","~"
    );

    $template->setSearch( array(
            resourceString("search_by") . "...",
            resourceString("search_by") . "...",
            "rss_command://search",
            SCRAPER_URL . "series.php?search=%s" . URL_AMP . "title=" . base64_encode(resourceString("search_by") . "...") . URL_AMP . "PHPSESID=" . session_id(),
            ""
            )
    );

    $template->addItem(
            "NEWEST",
            resourceString("goto_letter") . " NEWEST",
            SCRAPER_URL . "series.php?letter=new" . URL_AMP . "title=" . base64_encode($title) . URL_AMP . "PHPSESID=" . session_id(),
            ""
    );

    $template->addItem(
            "ALL",
            resourceString("goto_letter") . " ALL",
            SCRAPER_URL . "series.php?letter=all" . URL_AMP . "title=" . base64_encode($title) . URL_AMP . "PHPSESID=" . session_id(),
            ""
    );

    foreach ($letters as $letter) {
        $template->addItem(
                $letter,
                resourceString("goto_letter") . $letter,
                SCRAPER_URL . "series.php?letter=" . $letter . URL_AMP . "title=" . base64_encode($title) . URL_AMP . "PHPSESID=" . session_id(),
                ""
        );
    }
    $template->generateView(AnivideSeriesTemplate::VIEW_CATEGORY );
}

/**
 * Fetch search result items.
 */
function fetchSearch($type,$pageTitle) {
    $template = new AnivideSeriesTemplate();
    $content = file_get_contents("http://www.anivide.com/searchmore.html?q=".$type);
    preg_match_all("/series.png(.*)<a onclick\=\"return false;\" href\=\"(.*)\">(.*)<\/a>/U", $content, $links, PREG_SET_ORDER);

    if($links) {
        foreach ($links as $value) {
            $template->addItem(
                    html_entity_decode(utf8_decode($value[3])),
                    "",
                    SCRAPER_URL . "series.php?serie=" . base64_encode($value[2]) . URL_AMP . "title=" . base64_encode($value[3]) . URL_AMP . "PHPSESID=" . session_id(),
                    ""
            );
        }
    }

    $template->generateView(AnivideSeriesTemplate::VIEW_SERIE, "");
}

/**
 * Get category movies and pages.
 */
function fetchLetterItems($type,$letter,$title) {
    $template = new AnivideSeriesTemplate();
    $template->setType($type);
    $template->setLetter($letter);

    //If page equal "x" goto page number list, in other case process actual category page
    if( isset($_GET["page"]) && $_GET["page"] == "x" ) {
        $maxPages = $_GET["pages"];
        for($i=1;$i<=$maxPages;++$i) {
            $template->addItem(
                    $i,
                    resourceString("goto_page") . $i,
                    SCRAPER_URL . "series.php?letter=" . $letter . URL_AMP . "title=" . base64_encode($title) . URL_AMP . "page=" . $i . URL_AMP . "pages=" . $maxPages . URL_AMP . "PHPSESID=" . session_id(),
                    ""
            );
        }
        $template->generateView(AnivideSeriesTemplate::VIEW_PAGE_NUMBERS );

    }else {
        if(!isset($_GET["page"])) {
            $pages = getPages($type,$letter);
            $template->setActualPage(1);
            $template->setMaxPages($pages[1]);
            $content = $pages[0];
        }else {
            $page = $_GET["page"];
            $template->setActualPage($_GET["page"]);
            $template->setMaxPages($_GET["pages"]);
            if($letter == "all") {
                $url = "http://www.anivide.com/index.html?list=anime&type=series&page=".$page;
            }else if($letter == "new") {
                $url = "http://www.anivide.com/index.html?list=anime&view=new&page=".$page;
            }else {
                $url = "http://www.anivide.com/index.html?list=anime&type=series&letter=".$letter."&page=".$page;
            }
            $content = file_get_contents($url);
        }

        //Remove backslashes
        $content = html_entity_decode($content);
        preg_match_all("/<div class=\"animelist\"><a href=\"(.*)\"><img src=\"(.*)\" border=\"0\"><br><br><b>(.*)<\/b><br>(.*)</U", $content, $links, PREG_SET_ORDER);

        if($links) {
            foreach ($links as $value) {
                $title = html_entity_decode(utf8_decode($value[2]));
                $template->addItem(
                        $value[3],
                        $value[4],
                        SCRAPER_URL . "series.php?serie=" . base64_encode($value[1]) . URL_AMP . "title=" . base64_encode($value[3]) . URL_AMP . "PHPSESID=" . session_id(),
                        $value[2]
                );
            }
        }

        $template->generateView(AnivideSeriesTemplate::VIEW_SERIE, "");
    }
}

/**
 * Show selected serie season episodes.
 */
function fetchSerieEpisodes($serie,$title) {
    //This anime has been removed as requested
    $template = new AnivideSeriesTemplate();

    //Parse serie page
    $content = file_get_contents("http://www.anivide.com/" . $serie);
    $content = html_entity_decode($content);
    //Get image
    preg_match("/<img src=\"http:\/\/www\.anivide\.com\/thumb\/(.*)\"/U", $content, $image);
    $image = $image[1];
    $template->setImage("http://www.anivide.com/thumb/".$image);

    //Get description
    preg_match("/Plot Summary: <\/b>(.*)</siU", $content, $description);
    $description = $description[1];
    $template->setDescription($description);

    if(!strpos($content,"his anime has been removed as requested by")) {
        $episodes = getPagesEpisodes("http://www.anivide.com/" . $serie,$content);
        //preg_match_all("/<div class=\"episode\"><a href=\"(.*)\"><b>(.*)</siU", $content, $episodes, PREG_SET_ORDER)

        $episodesArray = array();
        foreach ($episodes as $item) {
            $episodesArray["$item[2]"] = $item[1];

            //Add links
            $template->addItem(
                    $item[2],
                    "",
                    SCRAPER_URL . "series.php?episode=" . base64_encode($item[1]) . URL_AMP . "PHPSESID=" . session_id(),
                    ""
            );
        }

        $_SESSION["anivideSerieEpisodes"] = serialize($episodesArray);
        $_SESSION["anivideSerieTitle"] = $title;
        $_SESSION["anivideSerieImage"] = "http://www.anivide.com/thumb/".$image;
        $_SESSION["anivideSerieDescription"] = $description;
        $template->setRemoved(false);

    }else {
        $template->setRemoved(true);
    }

    $template->generateView(AnivideSeriesTemplate::VIEW_EPISODES, $title);
}

/**
 * Get season episode available mirrors.
 * @var $episode Full episode page link.
 */
function fetchSerieSeasonEpisodeLinks($episode,$title) {
    $template = new AnivideSeriesTemplate();

    //Recover info and set to template
    $template->setMovieTitle($_SESSION["anivideSerieTitle"]);
    $template->setImage($_SESSION["anivideSerieImage"]);
    $template->setDescription($_SESSION["anivideSerieDescription"]);

    $content = file_get_contents( "http://www.anivide.com/" . $episode );
    $content = html_entity_decode($content);

    //Check for part list or single link
    if( strpos($content,'<div class="videoparts">') ) {
        preg_match("/<div class=\"videoparts\">(.*)<\/div>/siU", $content, $content);
        preg_match_all("/<img src=\"(.*)\" alt=\"(.*)\" title=\"(.*)\"> <a href=(.*)>(.*)<\/a>/siU", $content[1], $parts, PREG_SET_ORDER);
        foreach ($parts as $link) {
            if( (strtolower($link[2]) == "megavideo") || (strtolower($link[2]) == "myspace") ) {
                $template->addItem(
                        $link[2],
                        "",
                        SCRAPER_URL . "series.php?host=" . base64_encode($link[2]) . URL_AMP . "link=" . base64_encode($link[4]) . URL_AMP . "PHPSESID=" . session_id(),
                        ""
                );
            }
        }

    }else {
        $url = strstr($episode,"?") . "&part=1";
        $content = file_get_contents( "http://www.anivide.com/vidplayer.php?test=1&sid35=1285540124047", false, getLinkContext($url) );
        if(strpos($content,"megavideo")) {
            $host = "Megavideo";
        }else if(strpos($content,"myspace")) {
            $host = "MySpace";
        }else if(strpos($content,"guba.com")) {
            $host = "Guba.com";
        }
        $template->addItem(
                $host,
                "",
                SCRAPER_URL . "series.php?host=" . base64_encode($host) . URL_AMP . "link=" . base64_encode($url) . URL_AMP . "PHPSESID=" . session_id(),
                ""
        );
    }

    $template->generateView(AnivideSeriesTemplate::VIEW_EPISODE_DETAIL, $_SESSION["anivideSerieTitle"]);
}

function fetchPlayEpisode($host,$link) {
    $template = new AnivideSeriesTemplate();

    //Recover info and set to template
    $template->setMovieTitle($_SESSION["anivideSerieTitle"]);
    $template->setImage($_SESSION["anivideSerieImage"]);
    $template->setDescription($_SESSION["anivideSerieDescription"]);

    $content = file_get_contents( "http://www.anivide.com/vidplayer.php?test=1&sid35=1285540124047" . $link, false, getLinkContext($link) );

    switch(strtolower($host)) {
        case "megavideo";
            addMegavideoLink($template,$content);
            break;
        case "myspace";
            addMySpaceLink($template,$content);
            break;
        case "guba.com";
            addGubaComFlash($template,$content);
            break;
    }

    $template->generateView(AnivideSeriesTemplate::VIEW_PLAY, $_SESSION["anivideSerieTitle"]);
}

function addMegavideoLink($template,$content) {
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

            if( $megavideo_id ) {
                //If megaupload cookie is defined, use it, in other case, use alternative method
                if( COOKIE_STATE_ACTIVATED ) {
                    //generateMegavideoPremiumLink($tempTitle, $imageUrl, $counter, $megavideo_id);
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
        }
    }
}

function addMySpaceLink($template,$content) {
    preg_match("/file=(.*)&/siU", $content, $link);
    if($link) {
        $link = $link[1];
        $template->addMediaItem(
                substr($link, strrpos($link,"/")+1),
                "",
                $link,
                "",
                VideoUtil::getEnclosureMimetype($link)
        );
    }else {
        preg_match("/<param name=\"movie\" value=\"(.*)\"/siU", $content, $link);
        if($link) {
            $link = $link[1];
            preg_match("/m=(.*),/siU", $link, $id);
            $content = file_get_contents("http://mediaservices.myspace.com/services/rss.ashx?videoID=" . $id[1] . "&type=video");
            preg_match("/content url=\"(.*)\" type=\"(.*)\"/siU", $content, $link);
            if($link) {
                $template->addMediaItem(
                        substr($link[1], strrpos($link[1],"/")+1),
                        "",
                        $link[1],
                        "",
                        $link[2]
                );
            }
        }
    }
}

function addGubaComFlash($template,$content) {
    preg_match("/video_url=(.*)&/siU", $content, $link);
    if($link) {
        $link = $link[1];
        $template->addMediaItem(
                substr($link, strrpos($link,"/")+1),
                "",
                $link,
                "",
                VideoUtil::getEnclosureMimetype($link)
        );
    }
}

//------------------------------------------------------------------------------
//------------------------------------------------------------------------------

/**
 * Get number of pages and retrieve first page content.
 */
function getPages($url,$letter) {
    if($letter == "all") {
        $url = "http://www.anivide.com/index.html?list=anime&type=series";
    }else if($letter == "new") {
        $url = "http://www.anivide.com/index.html?list=anime&view=new";
    }else {
        $url = "http://www.anivide.com/index.html?list=anime&type=series&letter=".$letter;
    }
    $content = file_get_contents($url);

    //Get letter number of entries
    preg_match("/<i>\((.*) pages\)/U", $content, $numberEntries);
    if($numberEntries) {
        $numPages = $numberEntries[1];
    }else {
        $numberEntries = 0;
    }
    return array($content,$numPages);
}

function getLinkContext($url) {
    //Get page session id from cookie
    file_get_contents("http://www.anivide.com/index.html" . $url);
    foreach ($http_response_header as $value) {
        if(strpos($value,"PHPSESSID")) {
            preg_match("/PHPSESSID=(.*);/siU", $value, $cookie);
            $cookie = $cookie[1];
            break;
        }
    }
    //Create context
    $opts = array(
            'http'=>array(
                    'method'=>"GET",
                    'header'=> "Host: www.anivide.com\r\n".
                            "User-Agent: Mozilla/5.0 (Windows; U; Windows NT 5.1; es-ES; rv:1.9.2.10) Gecko/20100914 Firefox/3.6.10 (.NET CLR 3.5.30729)\r\n".
                            "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8\r\n".
                            "Accept-Language: es-es,es;q=0.8,en-us;q=0.5,en;q=0.3\r\n".
                            "Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7\r\n".
                            "Keep-Alive: 115\r\n".
                            "Connection: keep-alive\r\n".
                            "Referer: http://www.anivide.com/index.html" . $url . "\r\n".
                            "Cookie: PHPSESSID=" . $cookie . ";\r\n"
            )
    );
    //"Cookie: sitechrx=" . $hash . ";Path=/;\r\n"
    $context = stream_context_create($opts);
    return $context;
}


function getPagesEpisodes($url,$content) {
    $episodesRecovered = array();
    //Get number of episodes pages
    preg_match("/<i>\((.*) pages\)/siU", $content, $episodeNumber);
    $episodeNumber = $episodeNumber[1];

    //Get all episodes
    preg_match_all("/<div class=\"episode\"><a href=\"(.*)\"><b>(.*)</siU", $content, $episodes, PREG_SET_ORDER);
    $episodesRecovered = mergeArrays($episodesRecovered, $episodes);
    for($i=2;$i<=$episodeNumber;++$i) {
        $content = file_get_contents( $url . "&page=" . $i );
        preg_match_all("/<div class=\"episode\"><a href=\"(.*)\"><b>(.*)</siU", $content, $episodes, PREG_SET_ORDER);
        $episodesRecovered = mergeArrays($episodesRecovered, $episodes);
        if( $i > 20 ) {
            return;
        }
    }
    return $episodesRecovered;
}

function mergeArrays($sourceArray, $copyArray) {
    foreach ($copyArray as $value) {
        array_push($sourceArray, $value);
    }
    return $sourceArray;
}

?>
