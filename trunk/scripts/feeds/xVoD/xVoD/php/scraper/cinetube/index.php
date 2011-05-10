<?php
/*-------------------------
 *    Developed by Maicros
 *     GNU/GPL v2 Licensed
 * ------------------------*/

include_once '../../config/config.php';
include_once 'CinetubeTemplate.php';
include_once "../../util/VideoUtil.php";
include_once "../../util/RssScriptUtil.php";
include_once '../../action/Action.php';
include_once '../../action/rss/SaveBookmarkAction.php';
include_once '../../action/rss/DeleteBookmarkAction.php';
define("SCRAPER_URL", SERVER_HOST_AND_PATH . "php/scraper/cinetube/");
define("CINETUBE_URL", "http://www.cinetube.es/" );
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
//Init session
if(isset($_GET["PHPSESID"])) {
    session_id($_GET["PHPSESID"]);
}
session_start();

if(isset($_GET["search"])) {    //Search view
    $type = $_GET["type"];
    $search = $_GET["search"];
    switch($type) {
        case "doc":
            fetchDocumentarySearch($type,$search);
            break;
        case "mov":
            fetchMovieSearch($type,$search);
            break;
        case "ser":
            fetchSerieSearch($type,$search);
            break;
    }

}else if(isset($_GET["play"])) {   // Show play links --------------------------
    $type = $_GET["type"];
    $play = base64_decode($_GET["play"]);
    //$title = base64_decode($_GET["title"]);
    fetchPlaySources($type,$play);

}else if(isset($_GET["episode"])) {   // Show serie season episode links -------
    $type = $_GET["type"];
    $episodeLink = base64_decode($_GET["episode"]);
    $episodeName = base64_decode($_GET["episodeName"]);
    fetchSerieSeasonEpisode($type, $episodeName,$episodeLink);

}else if(isset($_GET["season"])) {   // Show serie season episodes--------------
    $type = $_GET["type"];
    $season = base64_decode($_GET["season"]);
    fetchSerieSeason($type, $season);

}else if(isset($_GET["item"])) {   // Show items ------------------------------
    $type = $_GET["type"];
    $item = base64_decode($_GET["item"]);
    $title = base64_decode($_GET["title"]);
    switch($type) {
        case "doc":
            fetchDocumentary($type,$item,$title);
            break;
        case "mov":
            fetchMovie($type,$item,$title);
            break;
        case "ser":
            fetchSerie($type,$item,$title);
            break;
    }

}else if(isset($_GET["cat"])) {    //Category view ----------------------------
    $type = $_GET["type"];
    $category = base64_decode($_GET["cat"]);
    $title = base64_decode($_GET["title"]);
    switch($type) {
        case "doc":
            fetchDocumentaryCategoryItems($type,$category,$title);
            break;
        case "mov":
            fetchMovieCategoryItems($type,$category,$title);
            break;
        case "ser":
            fetchSerieCategoryItems($type,$category,$title);
            break;
    }

}else if(isset($_GET["type"])) {    // Category list view ---------------------
    $type = $_GET["type"];
    switch($type) {
        case "doc":
            fetchDocumentaryCategories($type);
            break;
        case "mov":
            fetchMovieCategories($type);
            break;
        case "ser":
            fetchSerieCategories($type);
            break;
    }

}else {     // Show home principal view ---------------------------------------
    fetchHome();
}

//------------------------------------------------------------------------------
//------------------------------------------------------------------------------

/**
 * Get principal scraper view.
 */
function fetchHome() {
    $template = new CinetubeTemplate();
    $template->addItem(
            resourceString("anime") . " - " . resourceString("movie"),
            resourceString("anime") . " - " . resourceString("movie"),
            SCRAPER_URL . "anime.php?type=mov" . URL_AMP . "PHPSESID=" . session_id(),
            ""
    );
    $template = new CinetubeTemplate();
    $template->addItem(
            resourceString("anime") . " - " . resourceString("serie"),
            resourceString("anime") . " - " . resourceString("serie"),
            SCRAPER_URL . "anime.php?type=ser" . URL_AMP . "PHPSESID=" . session_id(),
            ""
    );
    $template->addItem(
            resourceString("documentary"),
            resourceString("documentary"),
            SCRAPER_URL . "index.php?type=doc" . URL_AMP . "PHPSESID=" . session_id(),
            ""
    );
    $template->addItem(
            resourceString("movie"),
            resourceString("movie"),
            SCRAPER_URL . "index.php?type=mov" . URL_AMP . "PHPSESID=" . session_id(),
            ""
    );
    $template->addItem(
            resourceString("serie"),
            resourceString("serie"),
            SCRAPER_URL . "index.php?type=ser" . URL_AMP . "PHPSESID=" . session_id(),
            ""
    );
    $template->addItem(
            resourceString("configure"),
            resourceString("configure"),
            SCRAPER_URL . "config/setup.php" . URL_AMP . "PHPSESID=" . session_id(),
            ""
    );
    $template->generateView(CinetubeTemplate::VIEW_HOME, "Cinetube");
}

//------------------------------------------------------------------------------
//------------------------------------------------------------------------------

/**
 * Get documetnary categories
 */
function fetchDocumentaryCategories($type) {
    $template = new CinetubeTemplate();
    $template->setType($type);
    $typeArray = array(
            resourceString("latest_releases")=>"documentales/",
            "Top " . resourceString("documentaries") =>"documentales-top/"
    );

    //Get web categories
    $content = file_get_contents("http://www.cinetube.es/documentales/");
    $content = html_entity_decode($content);
    //Get categories block
    preg_match("/<ul class=\"categorias\">(.*)<\/ul>/siU", $content, $matches);
    if($matches) {
        //Get categories links
        preg_match_all("/<a href=\"(.*)\"><span>(.*)</siU", $matches[1], $links, PREG_SET_ORDER);
        foreach ($links as $link) {
            $typeArray[$link[2]] = $link[1];
        }
    }

    //Add rss links to template
    foreach ($typeArray as $key => $value ) {
        $template->addItem(
                $key,
                resourceString("category") . " " . $key,
                SCRAPER_URL . "index.php?type=$type" . URL_AMP . "cat=" . base64_encode($value) . URL_AMP . "title=" . base64_encode($key) . URL_AMP . "PHPSESID=" . session_id(),
                ""
        );
    }
    //Add serach link to template
    $template->setSearch( array(
            resourceString("search_by") . "...",
            resourceString("search_by") . "...",
            "rss_command://search",
            SCRAPER_URL . "index.php?search=%s" . URL_AMP . "type=$type" . URL_AMP . "title=" . base64_encode("Search by") . URL_AMP . "PHPSESID=" . session_id(),
            ""
            )
    );
    $template->generateView(CinetubeTemplate::VIEW_CATEGORY, "Documentales");
}

/**
 * Get movie categories.
 */
function fetchMovieCategories($type) {
    $template = new CinetubeTemplate();
    $template->setType($type);
    $typeArray = array(
            "Top " . resourceString("latest_releases")=>"peliculas/top-estrenos/",
            "Top " . resourceString("movies") =>"peliculas-top/",
            "Estrenos de Cine" => "peliculas/estrenos-de-cine/",
            "Estrenos de DVD" => "peliculas/estrenos-dvd/",
            "Estrenos Sub" => "peliculas/estrenos-sub/",
            "Solo HD-RIP" => "peliculas/filtrar/?idioma=&calidad=11&desde=&hasta=&categoria=&valoracion=",
            "Solo SUBs" => "peliculas/filtrar/?idioma=3&calidad=&desde=&hasta=&categoria=&valoracion=",
            "Solo V.O." => "peliculas/filtrar/?idioma=4&calidad=&desde=&hasta=&categoria=&valoracion="
    );

    //Get web categories
    $content = file_get_contents("http://www.cinetube.es/peliculas/");
    $content = html_entity_decode($content);
    //Get categories block
    preg_match("/<ul class=\"categorias\">(.*)<\/ul>/siU", $content, $matches);
    if($matches) {
        //Get categories links
        preg_match_all("/<a href=\"(.*)\"><span>(.*)</siU", $matches[1], $links, PREG_SET_ORDER);
        foreach ($links as $link) {
            $typeArray[$link[2]] = $link[1];
        }
    }
    //Add rss links to template
    foreach ($typeArray as $key => $value ) {
        $template->addItem(
                $key,
                resourceString("category") . " " . $key,
                SCRAPER_URL . "index.php?type=$type" . URL_AMP . "cat=" . base64_encode($value) . URL_AMP . "title=" . base64_encode($key) . URL_AMP . "PHPSESID=" . session_id(),
                ""
        );
    }
    //Add serach link to template
    $template->setSearch( array(
            resourceString("search_by") . "...",
            resourceString("search_by") . "...",
            "rss_command://search",
            SCRAPER_URL . "index.php?search=%s" . URL_AMP . "type=$type" . URL_AMP . "title=" . base64_encode("Search by") . URL_AMP . "PHPSESID=" . session_id(),
            ""
            )
    );
    $template->generateView(CinetubeTemplate::VIEW_CATEGORY, "Peliculas");
}

/**
 * Get serie categories.
 */
function fetchSerieCategories($type) {
    $template = new CinetubeTemplate();
    $template->setType($type);
    $typeArray = array(
            resourceString("latest_releases")=>"series/",
            "Top " . resourceString("series") =>"series-top/"
    );
    //Get web categories
    $content = file_get_contents("http://www.cinetube.es/series/");
    $content = html_entity_decode($content);
    //Get categories block
    preg_match("/<ul class=\"categorias\">(.*)<\/ul>/siU", $content, $matches);
    if($matches) {
        //Get categories links
        preg_match_all("/<a href=\"(.*)\"><span>(.*)</siU", $matches[1], $links, PREG_SET_ORDER);
        foreach ($links as $link) {
            $typeArray[$link[2]] = $link[1];
        }
    }
    //Add rss links to template
    foreach ($typeArray as $key => $value ) {
        $template->addItem(
                $key,
                resourceString("category") . " " . $key,
                SCRAPER_URL . "index.php?type=$type" . URL_AMP . "cat=" . base64_encode($value) . URL_AMP . "title=" . base64_encode($key) . URL_AMP . "PHPSESID=" . session_id(),
                ""
        );
    }
    //Add search link to template
    $template->setSearch( array(
            resourceString("search_by") . "...",
            resourceString("search_by") . "...",
            "rss_command://search",
            SCRAPER_URL . "index.php?search=%s" . URL_AMP . "type=$type" . URL_AMP . "title=" . base64_encode("Search by") . URL_AMP . "PHPSESID=" . session_id(),
            ""
            )
    );
    $template->generateView(CinetubeTemplate::VIEW_CATEGORY, "Series");
}

//------------------------------------------------------------------------------
//------------------------------------------------------------------------------

function fetchPlaySources($type,$play) {
    $template = new CinetubeTemplate();
    $template->setType($type);

    //Check for session info
    if(isset($_SESSION["cinetubeTitle"])) {
        $movieTitle = $_SESSION["cinetubeTitle"];
        $description = $_SESSION["cinetubeDescription"];
        $image = $_SESSION["cinetubeImage"];
        $template->setMovieTitle($movieTitle);
        $template->setDescription($description);
        $template->setImage($image);
    }

    $content = file_get_contents("http://www.cinetube.es" .  $play);
    //Get megavideo links
    if( strpos($content, "www.megavideo.com/?v=" ) ) {
        preg_match_all("|www\.megavideo\.com\/\?v\=(.*)\"|U", $content, $links);
        if($links && $links[1]) {
            $links = $links[1];
            $links = array_unique( $links );
            foreach($links as $megavideo_id ) {
                if( COOKIE_STATE_ACTIVATED ) {
                    $array = VideoUtil::generateMegavideoPremiumLink($megavideo_id);
                    if($array) {
                        //echo $megavideo_id;
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
    //Get megaupload links
    if( strpos($content, "www.megaupload.com/?d=" ) ) {
        preg_match_all("|www\.megaupload\.com\/\?d\=(.*)\"|U", $content, $links);
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
    $template->generateView(CinetubeTemplate::VIEW_PLAY, "");
}

//------------------------------------------------------------------------------
//------------------------------------------------------------------------------

/**
 * Search documentaries that contents given word.
 */
function fetchDocumentarySearch($type,$search) {
    $template = new CinetubeTemplate();
    $template->setSearchTerm($search);
    $template->setType($type);

    //If page equal "x" goto page number list, in other case process actual category page
    if( isset($_GET["page"]) && $_GET["page"] == "x" ) {
        $maxPages = $_GET["pages"];
        for($i=1;$i<=$maxPages;++$i) {
            $template->addItem(
                    $i,
                    resourceString("goto_page") . $i,
                    SCRAPER_URL . "index.php?type=" . $type . URL_AMP . "search=" . $search . URL_AMP . "page=" . $i . URL_AMP . "pages=" . $maxPages  . URL_AMP . "PHPSESID=" . session_id(),
                    ""
            );
        }
        $template->generateView(CinetubeTemplate::VIEW_PAGE_NUMBERS );

    }else {
        if(!isset($_GET["page"])) {
            $pages = getPages($type,$search);
            $template->setActualPage(1);
            $template->setMaxPages($pages[1]);
            $content = $pages[0];
        }else {
            $template->setActualPage($_GET["page"]);
            $template->setMaxPages($_GET["pages"]);
            $content = file_get_contents(CINETUBE_URL . $category . "buscar/documentales/?palabra=" . $search . "&pag=" . $_GET["page"]);
        }

        //Parse first page documentaries
        preg_match_all("/<div class\=\"peli_item textcenter\">(.*)<\/div>\s*<\/div>/siU", $content, $divs, PREG_SET_ORDER);
        if($divs) {
            //$divs = $divs[0];
            foreach ($divs as $movie) {
                $movie = $movie[0];
                preg_match_all("/(<a href=\"(.*)\">)*\s*<img\s*src=\"(.*)\" alt=\"(.*)\"\s(\/)*>\s*(<\/a>)*/siU", $movie, $info, PREG_SET_ORDER);
                //Get info
                parseCoverPageInfo($info,$type,$title,$template,false);
            }

        }

        $template->generateView(CinetubeTemplate::VIEW_DOCUMENTARY, $title);
    }
}

/**
 * Search movies that contents given word.
 */
function fetchMovieSearch($type,$search) {
    $template = new CinetubeTemplate();
    $template->setType($type);
    $template->setSearchTerm($search);
    //If page equal "x" goto page number list, in other case process actual category page
    if( isset($_GET["page"]) && $_GET["page"] == "x" ) {
        $maxPages = $_GET["pages"];
        for($i=1;$i<=$maxPages;++$i) {
            $template->addItem(
                    $i,
                    resourceString("goto_page") . $i,
                    SCRAPER_URL . "index.php?type=" . $type . URL_AMP . "search=" . $search . URL_AMP . "page=" . $i . URL_AMP . "pages=" . $maxPages  . URL_AMP . "PHPSESID=" . session_id(),
                    ""
            );
        }
        $template->generateView(CinetubeTemplate::VIEW_PAGE_NUMBERS );

    }else {
        if(!isset($_GET["page"])) {
            $pages = getPages($type,$search);
            $template->setActualPage(1);
            $template->setMaxPages($pages[1]);
            $content = $pages[0];
        }else {
            $template->setActualPage($_GET["page"]);
            $template->setMaxPages($_GET["pages"]);
            $content = file_get_contents(CINETUBE_URL . $category . "buscar/peliculas/?palabra=" . $search . "&pag=" . $_GET["page"]);
        }
        //Parse first page movies
        preg_match_all("/<div class\=\"peli_item textcenter\">(.*)<\/div>\s*<\/div>/siU", $content, $divs, PREG_SET_ORDER);
        if($divs) {
            //$divs = $divs[0];
            foreach ($divs as $movie) {
                $movie = $movie[0];
                preg_match_all("/(<a href=\"(.*)\">)*\s*<img\s*src=\"(.*)\" alt=\"(.*)\"\s(\/)*>\s*(<\/a>)*/siU", $movie, $info, PREG_SET_ORDER);
                //Get info
                parseCoverPageInfo($info,$type,$title,$template,true);
            }

        }

        $template->generateView(CinetubeTemplate::VIEW_MOVIE, $title);
    }
}

/**
 * Search series that contents given word.
 */
function fetchSerieSearch($type,$search) {
    $template = new CinetubeTemplate();
    $template->setType($type);
    $template->setSearchTerm($search);

    //If page equal "x" goto page number list, in other case process actual category page
    if( isset($_GET["page"]) && $_GET["page"] == "x" ) {
        $maxPages = $_GET["pages"];
        for($i=1;$i<=$maxPages;++$i) {
            $template->addItem(
                    $i,
                    resourceString("goto_page") . $i,
                    SCRAPER_URL . "index.php?type=" . $type . URL_AMP . "search=" . $search . URL_AMP . "page=" . $i . URL_AMP . "pages=" . $maxPages  . URL_AMP . "PHPSESID=" . session_id(),
                    ""
            );
        }
        $template->generateView(CinetubeTemplate::VIEW_PAGE_NUMBERS );

    }else {
        if(!isset($_GET["page"])) {
            $pages = getPages($type,$search);
            $template->setActualPage(1);
            $template->setMaxPages($pages[1]);
            $content = $pages[0];
        }else {
            $template->setActualPage($_GET["page"]);
            $template->setMaxPages($_GET["pages"]);
            $content = file_get_contents(CINETUBE_URL . $category . "buscar/series/?palabra=" . $search . "&pag=" . $_GET["page"]);
        }

        //Parse first page series
        $newlines = array("\t","\n","\r","\x20\x20","\0","\x0B");
        $input = str_replace($newlines, "", $content );
        preg_match("/<ul class\=\"ver_series_list\">(.*)<\/ul>/siU", $input, $divs);
        preg_match_all("/<li>(.*)<\/li>/siU", $divs[0], $divs, PREG_SET_ORDER);
        if($divs) {
            //$divs = $divs[0];
            foreach ($divs as $movie) {
                $movie = $movie[1];
                preg_match_all("/(<a href=\"(.*)\">)*\s*<img\s*src=\"(.*)\" alt=\"(.*)\"\s(\/)*>\s*(<\/a>)*|<p class\=\"tit_ficha\">(.*)<\/p>/siU", $movie, $info, PREG_SET_ORDER);
                //Get info
                $movieIcons = array();

                foreach( $info as $key => $detail ) {
                    if( $key == 0 ) {
                        if( strpos($detail[2],'"') ) {
                            $movieLink = substr($detail[2], 0, strpos($detail[2],'"'));
                        }else {
                            $movieLink = $detail[2];
                        }
                        $movieThumbnail = html_entity_decode($detail[3]);
                    }else if(count($detail) == 8) {
                        $movieTitle = $detail[7];

                    }else if($detail[4]) {
                        if(!strpos($detail[4],"escarga")) {
                            array_push( $movieIcons, html_entity_decode($detail[4]) );
                        }

                    }else {
                        //megavideo, veoh, tutv, google
                        array_push( $movieIcons, html_entity_decode(substr($detail[3], strrpos($detail[3], "/")+1, strrpos($detail[3], "\.")-4)) );
                    }

                }
                //Add video
                $template->addItem(
                        $movieTitle,
                        strtoupper(getArrayString($movieIcons).""),
                        SCRAPER_URL . "index.php?type=ser" . URL_AMP . "item=" . base64_encode($movieLink) . URL_AMP . "title=" . base64_encode($title) . URL_AMP . "PHPSESID=" . session_id(),
                        $movieThumbnail
                );
            }

        }

        $template->generateView(CinetubeTemplate::VIEW_SERIE, $title);
    }
}

//------------------------------------------------------------------------------
//------------------------------------------------------------------------------

/**
 * Get given documentary category pages and first page items.
 */
function fetchDocumentaryCategoryItems($type,$category,$title) {
    $template = new CinetubeTemplate();
    $template->setCategory($category);
    $template->setType($type);
    //If page equal "x" goto page number list, in other case process actual category page
    if( isset($_GET["page"]) && $_GET["page"] == "x" ) {
        $maxPages = $_GET["pages"];
        for($i=1;$i<=$maxPages;++$i) {
            $template->addItem(
                    $i,
                    resourceString("goto_page") . $i,
                    SCRAPER_URL . "index.php?type=" . $type . URL_AMP . "cat=" . base64_encode($category) . URL_AMP . "page=" . $i . URL_AMP . "pages=" . $maxPages  . URL_AMP . "PHPSESID=" . session_id(),
                    ""
            );
        }
        $template->generateView(CinetubeTemplate::VIEW_PAGE_NUMBERS );


    }else {
        if(!isset($_GET["page"])) {
            $pages = getPages($category);
            $template->setActualPage(1);
            $template->setMaxPages($pages[1]);
            $content = $pages[0];
        }else {
            $template->setActualPage($_GET["page"]);
            $template->setMaxPages($_GET["pages"]);
            $content = file_get_contents(CINETUBE_URL . $category . $_GET["page"] . ".html");
        }

        //Parse first page documentaries
        preg_match_all("/<div class\=\"peli_item textcenter( peli_item_puntos)?\">(.*)<\/div>\s*<\/div>/siU", $content, $divs, PREG_SET_ORDER);
        if($divs) {
            //$divs = $divs[0];
            foreach ($divs as $movie) {
                $movie = $movie[0];
                preg_match_all("/(<a href=\"(.*)\">)*\s*<img\s*src=\"(.*)\" alt=\"(.*)\"\s(\/)*>\s*(<\/a>)*/siU", $movie, $info, PREG_SET_ORDER);
                //Get info
                parseCoverPageInfo($info,$type,$title,$template,false);
            }

        }

        $template->generateView(CinetubeTemplate::VIEW_DOCUMENTARY, $title);
    }
}

/**
 * Get given movie category pages and first page items.
 */
function fetchMovieCategoryItems($type,$category,$title) {
    $template = new CinetubeTemplate();
    $template->setCategory($category);
    $template->setType($type);

    //If page equal "x" goto page number list, in other case process actual category page
    if( isset($_GET["page"]) && $_GET["page"] == "x" ) {
        $maxPages = $_GET["pages"];
        for($i=1;$i<=$maxPages;++$i) {
            $template->addItem(
                    $i,
                    resourceString("goto_page") . $i,
                    SCRAPER_URL . "index.php?type=" . $type . URL_AMP . "cat=" . base64_encode($category) . URL_AMP . "page=" . $i . URL_AMP . "pages=" . $maxPages,
                    ""
            );
        }
        $template->generateView(CinetubeTemplate::VIEW_PAGE_NUMBERS );

    }else {
        if(!isset($_GET["page"])) {
            $pages = getPages($category);
            $template->setActualPage(1);
            $template->setMaxPages($pages[1]);
            $content = $pages[0];
        }else {
            $template->setActualPage($_GET["page"]);
            $template->setMaxPages($_GET["pages"]);
            $content = file_get_contents(CINETUBE_URL . $category . $_GET["page"] . ".html");
        }

        //Parse first page movies
        preg_match_all("/<div class\=\"peli_item textcenter( peli_item_puntos)?\">(.*)<\/div>\s*<\/div>/siU", $content, $divs, PREG_SET_ORDER);
        if($divs) {
            //$divs = $divs[0];
            foreach ($divs as $movie) {
                $movie = $movie[0];
                preg_match_all("/(<a href=\"(.*)\">)*\s*<img\s*src=\"(.*)\" alt=\"(.*)\"\s(\/)*>\s*(<\/a>)*/siU", $movie, $info, PREG_SET_ORDER);
                //Get info
                parseCoverPageInfo($info,$type,$title,$template,true);
            }

        }

        $template->generateView(CinetubeTemplate::VIEW_MOVIE, $title);
    }
}

/**
 * Get given serie category pages, first page items or page number list.
 */
function fetchSerieCategoryItems($type,$category,$title) {
    //Init template
    $template = new CinetubeTemplate();
    $template->setCategory($category);
    $template->setType($type);

    //If page equal "x" goto page number list, in other case process actual category page
    if( isset($_GET["page"]) && $_GET["page"] == "x" ) {
        $maxPages = $_GET["pages"];
        for($i=1;$i<=$maxPages;++$i) {
            $template->addItem(
                    $i,
                    resourceString("goto_page") . $i,
                    SCRAPER_URL . "index.php?type=" . $type . URL_AMP . "cat=" . base64_encode($category) . URL_AMP . "page=" . $i . URL_AMP . "pages=" . $maxPages  . URL_AMP . "PHPSESID=" . session_id(),
                    ""
            );
        }
        $template->generateView(CinetubeTemplate::VIEW_PAGE_NUMBERS );

    }else {
        if(!isset($_GET["page"])) {
            $pages = getPages($category);
            $template->setActualPage(1);
            $template->setMaxPages($pages[1]);
            $content = $pages[0];
        }else {
            $template->setActualPage($_GET["page"]);
            $template->setMaxPages($_GET["pages"]);
            $content = file_get_contents(CINETUBE_URL . $category . $_GET["page"] . ".html");
        }

        //Parse first page series
        $newlines = array("\t","\n","\r","\x20\x20","\0","\x0B");
        $input = str_replace($newlines, "", $content );
        preg_match("/<ul class\=\"ver_series_list( ver_series_list_puntos)?\">(.*)<\/ul>/siU", $input, $divs);
        preg_match_all("/<li>(.*)<\/li>/siU", $divs[0], $divs, PREG_SET_ORDER);

        //For new serie releases dont works
        if($category != "series/") {
            if($divs) {
                //$divs = $divs[0];
                foreach ($divs as $movie) {
                    $movie = $movie[1];
                    preg_match_all("/(<a href=\"(.*)\">)*\s*<img\s*src=\"(.*)\" alt=\"(.*)\"\s(\/)*>\s*(<\/a>)*|<p class\=\"tit_ficha\">(.*)<\/p>/siU", $movie, $info, PREG_SET_ORDER);
                    //Get info
                    $movieIcons = array();

                    foreach( $info as $key => $detail ) {
                        if( $key == 0 ) {
                            if( strpos($detail[2],'"') ) {
                                $movieLink = substr($detail[2], 0, strpos($detail[2],'"'));
                            }else {
                                $movieLink = $detail[2];
                            }
                            $movieThumbnail = html_entity_decode($detail[3]);
                        }else if(count($detail) == 8) {
                            $movieTitle = $detail[7];

                        }else if($detail[4]) {
                            if(!strpos($detail[4],"escarga")) {
                                array_push( $movieIcons, html_entity_decode($detail[4]) );
                            }

                        }else {
                            //megavideo, veoh, tutv, google
                            array_push( $movieIcons, html_entity_decode(substr($detail[3], strrpos($detail[3], "/")+1, strrpos($detail[3], "\.")-4)) );
                        }

                    }
                    //Add video
                    $template->addItem(
                            $movieTitle,
                            strtoupper(getArrayString($movieIcons).""),
                            SCRAPER_URL . "index.php?type=ser" . URL_AMP . "item=" . base64_encode($movieLink) . URL_AMP . "title=" . base64_encode($title) . URL_AMP . "PHPSESID=" . session_id(),
                            $movieThumbnail
                    );
                }

            }

            $template->generateView(CinetubeTemplate::VIEW_SERIE, $title);
        }else {
            if($divs) {
                //$divs = $divs[0];
                foreach ($divs as $movie) {
                    $movie = $movie[1];
                    preg_match_all("/<img src\=\"(.*)\"(.*)<a class\=\"tit_ficha\"(.*)href\=\"(.*)\">(.*)<\/a>(.*)<p class\=\"tem_fich\">(.*)<\/p>/siU", $movie, $info, PREG_SET_ORDER);
                    $info = $info[0];
                    if( strpos($info[7],"Cap") ) {

                        $template->addItem(
                                html_entity_decode($info[5]),
                                $info[7],
                                SCRAPER_URL . "index.php?type=" . $type . URL_AMP . "episodeName=" . base64_encode($info[7]) . URL_AMP . "episode=" . base64_encode($info[4]) . URL_AMP . "seasonNum=" . URL_AMP . "image=" . base64_encode($info[1]) . URL_AMP . "serieTitle=" . base64_encode($info[5]) . URL_AMP . "PHPSESID=" . session_id(),
                                $info[1]
                        );
                    }else {

                    }
                }
            }
            $template->generateView(CinetubeTemplate::VIEW_SERIE, $title);
        }
    }
}

//------------------------------------------------------------------------------
//------------------------------------------------------------------------------
/**
 * Get movie links.
 */
function fetchMovie($type,$item,$title) {
    $template = new CinetubeTemplate();
    $template->setType($type);

    $content = file_get_contents( CINETUBE_URL . substr($item,1) );
    $newlines = array("\t","\n","\r","\x20\x20","\0","\x0B");
    $content = str_replace($newlines, "", html_entity_decode($content));

    preg_match("/<div class\=\"ficha_img pelicula_img\"><img src\=\"(.*)\"(.*)<div class\=\"ficha_des\">(.*)<h1 class\=\"bold\">(.*)<\/h1>(.*)<p>(.*)<\/p>/U",$content,$description);
    $thumbnail = $description[1];
    $movieTitle = $description[4];
    $template->setMovieTitle($movieTitle);
    $description = $description[6];
    $template->setImage($thumbnail);

    //Save info to session
    $_SESSION["cinetubeTitle"] = $movieTitle;
    $_SESSION["cinetubeDescription"] = $description;
    $_SESSION["cinetubeImage"] = $thumbnail;

    //Get mirrors
    preg_match_all("/<div class\=\"tit_opts\"><a(.*)href\=\"(.*)\"(.*)><p\>(.*)<\/p><p\><span\>(.*)<\/span><\/p>(.*)<\/div>/siU", $content, $divs, PREG_SET_ORDER);
    if($divs) {
        foreach ($divs as $value) {
            //Add video
            if(!strpos(strtolower($value[4]),"rar")) {
                $template->addItem(
                        $value[4] . "\n" . str_replace("| ", "\n", $value[5]),
                        strtoupper($description),
                        SCRAPER_URL . "index.php?type=" . $type . URL_AMP . "play=" . base64_encode( $value[2] ) . URL_AMP . "PHPSESID=" . session_id(),
                        $thumnail
                );
            }
        }
    }
    $template->generateView(CinetubeTemplate::VIEW_MOVIE_DETAIL,$title);
}

//------------------------------------------------------------------------------
//------------------------------------------------------------------------------
/**
 * Get documentary episodes, or redirect to show documentary links if it hasn't episodes.
 */
function fetchDocumentary($type,$item,$title) {
    //Get content
    $content = file_get_contents(CINETUBE_URL . substr($item,1));
    $newlines = array("\t","\n","\r","\x20\x20","\0","\x0B");
    $content = str_replace($newlines, "", $content );
    //Show episode detail or episode list
    if( strstr($content,"tit_opts") ) {
        fetchDocumentaryEpisode($type,$item,$title,$content);

    }else {
        $template = new CinetubeTemplate();
        $template->setType($type);

        //Get page info
        preg_match("/<div class\=\"ficha_img pelicula_img\">(.*)src\=\"(.*)\"/U",$content,$thumnail);
        $thumnail = $thumnail[2];
        $template->setImage($thumnail);
        preg_match("/<h1 class\=\"big\"><a href\=\"(.*)\">(.*)<\/a><\/h1>/U",$content,$seasonTitle);
        $seasonTitle = html_entity_decode($seasonTitle[2]);
        $template->setMovieTitle($seasonTitle);
        preg_match("/<div class\=\"ficha_des\"><h1 class\=\"bold\">(.*)<\/h1><p>(.*)<\/p><\/div>/U",$content,$description);
        $description = strtoupper( html_entity_decode($description[2]) );
//        preg_match("/<table class\=\"tb_peliculas\">(.*)<\/table>/U",$content,$detail);
//        $detail = html_entity_decode($detail[0]);
        //Get episodes
        preg_match_all("/<div class\=\"title\">\s<a(.*)href\=\"(.*)\">(.*)<\/a>/siU", $content, $divs, PREG_SET_ORDER);
        if($divs) {
            foreach ($divs as $value) {
                //Add video
                $template->addItem(
                        str_replace( $seasonTitle, "", html_entity_decode($value[3]) ),
                        $description . $detail,
                        SCRAPER_URL . "index.php?type=" . $type . URL_AMP . "item=" . base64_encode( $value[2] ) . URL_AMP . "image=" . base64_encode($thumnail) . URL_AMP . "title=" . base64_encode($seasonTitle) . URL_AMP . "PHPSESID=" . session_id(),
                        $thumnail
                );
            }
        }
        $template->generateView(CinetubeTemplate::VIEW_DOCUMENTARY_EPISODE, $title);
    }
}

/**
 * Get links from episode, or documentary without episodes.
 */
function fetchDocumentaryEpisode($type,$item,$title,$content=null) {
    $template = new CinetubeTemplate();
    $template->setType($type);

    if(!$content) {
        $content = file_get_contents( CINETUBE_URL . substr($item,1) );
        $newlines = array("\t","\n","\r","\x20\x20","\0","\x0B");
        $content = str_replace($newlines, "", html_entity_decode($content));
    }

    if(strpos($content,"ficha_img pelicula_img")) {
        preg_match("/<div class\=\"ficha_img pelicula_img\"><img src\=\"(.*)\"(.*)<div class\=\"ficha_des\">(.*)<h1 class\=\"bold\">(.*)<\/h1>(.*)<p>(.*)<\/p>/U",$content,$description);
        $thumbnail = $description[1];
        $movieTitle = html_entity_decode($description[4]);
        $template->setMovieTitle($movieTitle);
        $description = html_entity_decode($description[6]);
        $template->setImage($thumbnail);

        //Save info to session
        $_SESSION["cinetubeTitle"] = $movieTitle;
        $_SESSION["cinetubeDescription"] = $description;
        $_SESSION["cinetubeImage"] = $thumbnail;

        preg_match_all("/<div class\=\"tit_opts\"><a(.*)href\=\"(.*)\"(.*)><p>(.*)<\/p><p><span\>(.*)<\/span><\/p>(.*)<\/div>/siU", $content, $divs, PREG_SET_ORDER);
        //G et mirrors
        if($divs) {
            foreach ($divs as $value) {
                //Add video
                $template->addItem(
                        html_entity_decode($value[4] . "\n" . str_replace("| ", "\n", $value[5])),
                        $description,
                        SCRAPER_URL . "index.php?type=" . $type . URL_AMP . "play=" . base64_encode( $value[2] ) . URL_AMP . "PHPSESID=" . session_id(),
                        $thumbnail
                );
            }
        }

    }else {
        if(isset($_GET["image"])) {
            $template->setImage(base64_decode($_GET["image"]));
        }
        if(isset($_GET["title"])) {
            $template->setMovieTitle(base64_decode($_GET["title"]));
        }
        preg_match_all("/<div class\=\"tit_opts\"><a(.*)href\=\"(.*)\"(.*)><p>(.*)<span(.*)span><\/p><p><span\>(.*)<\/span><\/p>(.*)<\/div>/siU", $content, $divs, PREG_SET_ORDER);
        //Get mirrors
        if($divs) {
            foreach ($divs as $value) {
                //Add video
                $template->addItem(
                        html_entity_decode($value[4] . "\n" . str_replace("| ", "\n", $value[6])),
                        $description,
                        SCRAPER_URL . "index.php?type=" . $type . URL_AMP . "play=" . base64_encode( $value[2] ) . URL_AMP . "PHPSESID=" . session_id(),
                        $thumbnail
                );
            }
        }
    }
    $template->generateView(CinetubeTemplate::VIEW_DOCUMENTARY_EPISODE,$title);
}

//------------------------------------------------------------------------------
//------------------------------------------------------------------------------
/**
 * Get serie links.
 */
function fetchSerie($type,$item,$title) {
    $template = new CinetubeTemplate();
    $template->setType($type);

    if( isset($_SESSION["seasons"]) && array_key_exists($item, unserialize($_SESSION["seasons"]))) {
        $seasons = unserialize( $_SESSION["seasons"] );
        $seasons = $seasons[$item];
        $serieTitle = $_SESSION["serieTitle"];
        $serieDescription = $_SESSION["serieDescription"];
        $serieCover = $_SESSION["serieCover"];

    }else {
        //Get serie seasons and info, save to session
        $content = file_get_contents("http://www.cinetube.es" . $item);
        $newlines = array("\t","\n","\r","\x20\x20","\0","\x0B");
        $content = str_replace($newlines, "", $content );

        //Get serie info
        preg_match("/<div class\=\"ficha_des des_move\">(.*)<a(.*)>(.*)<\/a><span>(.*)<\/span><\/h1><p>(.*)<\/p>(.*)caratulas.cinetube.es\/series\/(.*)\"/U",$content,$divs);
        $serieTitle = html_entity_decode( $divs[3] );
        $serieCategory = html_entity_decode( $divs[4] );
        $serieDescription = html_entity_decode( $divs[5] );
        $serieCover = "http://caratulas.cinetube.es/series/" . $divs[7];

        //Get serie seasons
        preg_match_all("/<a href\=\"(.*)\">(.*)<\/a>(.*)<a class\=\"caps\"(.*)>(.*)<\/a>/siU", $divs[6], $divs, PREG_SET_ORDER);
        $seasons = array();
        foreach ($divs as $season) {
            $episodeNumber = explode(" ",$season[5]);
            $seasons[$season[2]] = array($season[1],$episodeNumber[0]);
        }

        //Save data to session
        session_start();
        $_SESSION["serieTitle"] = $serieTitle;
        $_SESSION["serieCategory"] = $serieCategory;
        $_SESSION["serieDescription"] = $serieDescription;
        $_SESSION["serieCover"] = $serieCover;
        $_SESSION["seasons"] = serialize( array( $item => $seasons ) );
    }

    $template->setSerie($seasons);
    $template->setMovieTitle($serieTitle);
    $template->setDescription($serieDescription);
    $template->setImage($serieCover);
    $template->generateView(CinetubeTemplate::VIEW_SERIE_SEASON, $title);
}

/**
 * Get serie season links
 */
function fetchSerieSeason($type,$seasonTitle,$title=null) {
    $template = new CinetubeTemplate();
    $template->setType($type);

    //Recover session info
    $serieTitle = $_SESSION["serieTitle"];
    $serieCategory = $_SESSION["serieCategory"];
    $serieDescription = $_SESSION["serieDescription"];
    $serieCover = $_SESSION["serieCover"];
    $seasons = unserialize( $_SESSION["seasons"] );
    $_SESSION["seasonTitle"] = $seasonTitle;

    $seasonKey = array_keys($seasons);
    $seasonKey = $seasonKey[0];
    $seasonLink = $seasons[$seasonKey];
    $seasonLink = $seasonLink[$seasonTitle];
    //If array count isn't 3  load data from page
    if( count($seasonLink) == 3 ) {
        $episodes = $seasonLink[2];

    }else {
        $seasonLink = $seasonLink[0];
        //Get season episodes and save to sesion array
        $content = file_get_contents("http://www.cinetube.es" . $seasonLink);
        $newlines = array("\t","\n","\r","\x20\x20","\0","\x0B");
        $content = str_replace($newlines, "", $content );
        preg_match_all("/<div class\=\"title\"> <a class\=\"bold\" href\=\"(.*)\">(.*)<\/a>/siU", $content, $divs, PREG_SET_ORDER);

        //Create episode array and save in session
        if($divs) {
            $episodes = array();
            foreach ($divs as $episode) {
                $episodes[$episode[2]] = $episode[1];
            }
            $arraySeasons = $seasons[$seasonKey];
            array_push( $arraySeasons[$seasonTitle], $episodes );

            $_SESSION["seasons"] = serialize( array( $seasonKey => $arraySeasons ) );
        }
    }


    //Set data to template
    $template->setSerie($seasons[$seasonKey]);
    $template->setSeason($episodes);
    $template->setSeasonTitle($seasonTitle);
    $template->setMovieTitle($serieTitle);
    $template->setDescription($serieDescription);
    $template->setImage($serieCover);

    $template->generateView(CinetubeTemplate::VIEW_SERIE_EPISODE, $title);
}

/**
 * Get serie season episode links
 */
function fetchSerieSeasonEpisode($type, $episodeTitle, $episodeLink, $title=null) {
    $template = new CinetubeTemplate();
    $template->setType($type);

    //Recover session info
    $seasonTitle = $_SESSION["seasonTitle"];
    if(isset($_GET["serieTitle"])) {
        $serieTitle = base64_decode($_GET["serieTitle"]);
    }else {
        $serieTitle = $_SESSION["serieTitle"];
    }
    $serieCategory = $_SESSION["serieCategory"];
    $serieDescription = $_SESSION["serieDescription"];
    if( isset($_GET["image"])) {
        $serieCover = base64_decode($_GET["image"]);
    }else {
        $serieCover = $_SESSION["serieCover"];
    }
    $seasons = unserialize( $_SESSION["seasons"] );

    //Set data to template
    //$template->setSerie($seasons[$seasonKey]);
    $template->setEpisodeTitle($episodeTitle);
    $template->setSeasonTitle($seasonTitle);
    $template->setSerieTitle($serieTitle);
    $template->setDescription($serieDescription);
    $template->setImage($serieCover);

    //Save info to session
    $_SESSION["cinetubeTitle"] = $serieTitle . "\n" . $seasonTitle . " | " . $episodeTitle;
    $_SESSION["cinetubeDescription"] = $serieDescription;
    $_SESSION["cinetubeImage"] = $serieCover;

    //Get page content
    $content = file_get_contents( CINETUBE_URL . substr($episodeLink,1) );
    $newlines = array("\t","\n","\r","\x20\x20","\0","\x0B");
    $content = str_replace($newlines, "", html_entity_decode($content));

    //Get links
    preg_match_all("/<div class\=\"tit_opts\"><a(.*)href\=\"(.*)\"(.*)><p>(.*)<span(.*)span><\/p><p><span\>(.*)<\/span><\/p>(.*)<\/div>/siU", $content, $divs, PREG_SET_ORDER);
    //Get mirrors
    if($divs) {
        foreach ($divs as $value) {
            //Add video
            $template->addItem(
                    html_entity_decode($value[4] . "\n" . str_replace("| ", "\n", $value[6])),
                    $serieDescription,
                    SCRAPER_URL . "index.php?type=" . $type . URL_AMP . "play=" . base64_encode( $value[2] ) . URL_AMP . "PHPSESID=" . session_id(),
                    $serieCover
            );
        }
    }

    $template->generateView(CinetubeTemplate::VIEW_SERIE_EPISODE_LINK);
}



/**
 * -----------------------------------------------------------------------------
 * Get a comma separeted string from array.
 */
function getArrayString(array $array) {
    $result = "";
    for ($i=0; $i<count($array); ++$i) {
        $result .= $array[$i];
        if( $i<count($array)-1) {
            $result .= ", ";
        }
    }
    return $result;
}

/**
 * -----------------------------------------------------------------------------
 * Get category page count and first page content
 */
function getPages($category,$search=null) {
    $readAgain = true;
    if($search) {
        switch($category) {
            case "doc":
                $word = "documentales";
                break;
            case "mov":
                $word = "peliculas";
                break;
            case "ser":
                $word = "series";
                break;
        }
        $foundPages = array("/buscar/$word/?palabra=".$search."&pag=1" => "1");
        $initPage = "buscar/$word/?palabra=" . $search;
    }else {
        $foundPages = array("/".$category."1.html" => "1");
        $initPage = $category;
    }
    //Add pages
    while( $readAgain == true ) {
        $url = CINETUBE_URL . $initPage;
        $content = file_get_contents($url);
        if(!$initContentPage) {
            $initContentPage = $content;
        }
        $newlines = array("\t","\n","\r","\x20\x20","\0","\x0B");
        $content = str_replace($newlines, "", html_entity_decode($content));
        if(strpos($content, '<li class="pagina">') ) {
            //Get pages links
            preg_match_all("/<li class\=\"pagina\"><a\s[^>]*href=(\"??)([^\" >]*?)\\1[^>]*>(.*)<\/a><\/li>/siU", $content, $pages, PREG_SET_ORDER);
            if($pages) {
                $addedPages = 0;
                foreach ($pages as $page) {
                    if(!array_key_exists($page[2], $foundPages)) {
                        $foundPages[$page[2]] = $page[3];
                        $initPage = substr($page[2],1);
                        ++$addedPages;
                    }
                }
                //If read less than 4 pages is the last page list
                if($addedPages < 4) {
                    $readAgain = false;
                }
            }else {
                $readAgain = false;
            }
        }else {
            $readAgain = false;
        }
    }
    return array($initContentPage,count($foundPages));
}

/**
 * Parse cinetube cover info and add rss item to template.
 * @param $info
 * @param $type   Movie, documentary or serie (mov, doc, ser)
 * @param $title
 * @param $template
 * @param $showRipType True to parse rip type.
 */
function parseCoverPageInfo($info,$type,$title,$template,$showRipType) {
    //Get info
    $movieIcons = array();

    foreach( $info as $key => $detail ) {
        if($key == 1 ) {
            preg_match_all("/<span class\=\"rosa\">(.*)<\/span>/siU", $detail[0], $rips);
            if($rips && (count($rips) > 1) ) {
                $movieRipType = getArrayString($rips[1]);
            }
        }
        //
        if( $key == 0 ) {
            if( strpos($detail[2],'"') ) {
                $movieLink = substr($detail[2], 0, strpos($detail[2],'"'));
            }else {
                $movieLink = $detail[2];
            }
            $movieTitle = html_entity_decode($detail[4]);
            $movieThumbnail = html_entity_decode($detail[3]);

        }else if($detail[4]) {
            if(!strpos($detail[4],"escarga")) {
                array_push( $movieIcons, html_entity_decode($detail[4]) );
            }else {
                array_push( $movieIcons, "MEGAUPLOAD" );
            }

        }else {
            //megavideo, veoh, tutv, google
            array_push( $movieIcons, html_entity_decode(substr($detail[3], strrpos($detail[3], "/")+1, strrpos($detail[3], "\.")-4)) );
        }

    }
    //Add video
    if($showRipType) {
        $movieDescription = strtoupper($movieRipType . " | " . getArrayString($movieIcons) . "" );
    }else {
        $movieDescription = strtoupper( getArrayString($movieIcons) . "" );
    }
    $template->addItem(
            $movieTitle,
            $movieDescription,
            SCRAPER_URL . "index.php?type=$type" . URL_AMP . "item=" . base64_encode($movieLink) . URL_AMP . "title=" . base64_encode($title),
            $movieThumbnail
    );
}

?>
