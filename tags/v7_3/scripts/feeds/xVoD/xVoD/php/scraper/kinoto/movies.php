<?php
/*-------------------------
 *    Developed by Maicros
 *      GNU/GPL Licensed
 * ------------------------*/
include_once '../../config/config.php';
include_once 'KinotoTemplate.php';
include_once 'KinoToUtil.php';
include_once "../../util/VideoUtil.php";
include_once "../../util/RssScriptUtil.php";
include_once '../../action/Action.php';
include_once '../../action/rss/SaveBookmarkAction.php';
include_once '../../action/rss/DeleteBookmarkAction.php';
define("SCRAPER_URL", SERVER_HOST_AND_PATH . "php/scraper/kinoto/");

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
    $type = base64_decode($_GET["type"]);
    $letter = $_GET["letter"];
    $pageTitle = base64_decode($_GET["title"]);
    fetchCategoryItems($type,$letter,$pageTitle);

}else if( isset($_GET["type"]) ) {
    $type = base64_decode($_GET["type"]);
    $pageTitle = base64_decode($_GET["title"]);
    if($type == "nov") {
        fetchCategoryNewest();
    }else if($type == "pop") {
        fetchCategoryPopular();
    }else if($type == "est") {
        fetchCategoryFirstRun();
    }else if($type == "doc") {
        fetchCategoryFirstRun();
    }else {
        fetchCategoryLetters($type,$pageTitle);
    }

}else if(isset($_GET["item"])) {
    $item = base64_decode($_GET["item"]);
    $title = base64_decode($_GET["title"]);
    fetchMovie($item,$title);

}else {
    fetchCategories();
}

//------------------------------------------------------------------------------
//------------------------------------------------------------------------------

/**
 * Show category list.
 */
function fetchCategories() {
    $template = new KinotoTemplate();
    //Get site cookie hash
    $hash = getSiteHash();
    //Get principal page and parse categories side bar
    $content = file_get_contents("http://kino.to/Genre.html",false,getExplorerContext($hash));
    //$newlines = array("\t","\n","\r","\x20\x20","\0","\x0B");
    //$content = str_replace($newlines, "", utf8_decode( $content) );
    preg_match_all("/<td class\=\"Title\"><a href\=\"(.*)\">(.*)<\/a><\/td>/U", $content, $div, PREG_SET_ORDER);


    $template->setSearch( array(
            resourceString("search_by") . "...",
            resourceString("search_by") . "...",
            "rss_command://search",
            SCRAPER_URL . "movies.php?search=%s" . URL_AMP . "title=" . base64_encode(resourceString("search_by") . "...") . URL_AMP . "PHPSESID=" . session_id(),
            ""
            )
    );

    $template->addItem(
            "Kinofilme",
            "",
            SCRAPER_URL . "movies.php?type=" . base64_encode("est") . URL_AMP . "title=" . base64_encode($link[2]) . URL_AMP . "PHPSESID=" . session_id(),
            ""
    );
    $template->addItem(
            "Popular",
            "",
            SCRAPER_URL . "movies.php?type=" . base64_encode("pop") . URL_AMP . "title=" . base64_encode($link[2]) . URL_AMP . "PHPSESID=" . session_id(),
            ""
    );
    $template->addItem(
            "Neuste Filme",
            "",
            SCRAPER_URL . "movies.php?type=" . base64_encode("nov") . URL_AMP . "title=" . base64_encode($link[2]) . URL_AMP . "PHPSESID=" . session_id(),
            ""
    );

    foreach ($div as $link) {
        $template->addItem(
                utf8_decode($link[2]),
                "",
                SCRAPER_URL . "movies.php?type=" . base64_encode("http://kino.to".$link[1]) . URL_AMP . "title=" . base64_encode($link[2]) . URL_AMP . "PHPSESID=" . session_id(),
                ""
        );
    }

    $template->generateView(KinotoTemplate::VIEW_CATEGORY, "kino.to" );
}

/**
 * Show newest category movies.
 */
function fetchCategoryNewest() {
    $template = new KinotoTemplate();

    $content = file_get_contents("http://kino.to/Movies.rss",false,getExplorerContext(getSiteHash()));
    $newlines = array("\t","\n","\r","\x20\x20","\0","\x0B");
    $content = str_replace($newlines, "", html_entity_decode($content));
    preg_match_all("/<title><\!\[CDATA\[(.*)\]\]><\/title>(.*)<link>(.*)<\/link>(.*)src=\"(.*)\"/siU", $content, $links, PREG_SET_ORDER);

    foreach ($links as $link) {
        $template->addItem(
                utf8_decode(html_entity_decode($link[1], ENT_COMPAT, "UTF-8")),
                "",
                SCRAPER_URL . "movies.php?item=" . base64_encode($link[3]) . URL_AMP . "title=" . base64_encode($link[1]) . URL_AMP . "PHPSESID=" . session_id(),
                $link[5]
        );
    }
    $template->generateView(KinotoTemplate::VIEW_MOVIE, "");
}

/**
 * Show popular category movies.
 */
function fetchCategoryPopular() {
    $template = new KinotoTemplate();
    $content = file_get_contents("http://kino.to/Popular-Movies.html",false,getExplorerContext(getSiteHash()));
    preg_match_all("/<a onclick\=\"return false;\" href\=\"(.*)\">(.*)<\/a>/U", $content, $links, PREG_SET_ORDER);

    if($links) {
        foreach ($links as $value) {
            $template->addItem(
                    utf8_decode($value[2]),
                    "",
                    SCRAPER_URL . "movies.php?item=" . base64_encode($value[1]) . URL_AMP . "title=" . base64_encode($value[2]) . URL_AMP . "PHPSESID=" . session_id(),
                    ""
            );
        }
    }

    $template->generateView(KinotoTemplate::VIEW_MOVIE, "");
}


/**
 * Show first run category movies.
 */
function fetchCategoryFirstRun() {
    $template = new KinotoTemplate();

    $content = file_get_contents("http://kino.to/Cine-Films.rss",false,getExplorerContext(getSiteHash()));
    $newlines = array("\t","\n","\r","\x20\x20","\0","\x0B");
    $content = str_replace($newlines, "", html_entity_decode($content));
    preg_match_all("/<title><\!\[CDATA\[(.*)\]\]><\/title>(.*)<link>(.*)<\/link>(.*)src=\"(.*)\"/siU", $content, $links, PREG_SET_ORDER);

    foreach ($links as $link) {
        $template->addItem(
                utf8_decode($link[1]),
                "",
                SCRAPER_URL . "movies.php?item=" . base64_encode($link[3]) . URL_AMP . "title=" . base64_encode($link[1]) . URL_AMP . "PHPSESID=" . session_id(),
                $link[5]
        );
    }
    $template->generateView(KinotoTemplate::VIEW_MOVIE, "");
}

/**
 * Get search found items.
 */
function fetchSearch($type,$title) {
    $template = new KinotoTemplate();
    $content = file_get_contents("http://kino.to/Search.html?q=".$type,false,getExplorerContext(getSiteHash()));
    preg_match_all("/(.*).png(.*)<a onclick\=\"return false;\" href\=\"(.*)\">(.*)<\/a>/U", $content, $links, PREG_SET_ORDER);

    if($links) {
        foreach ($links as $value) {
            $template->addItem(
                    html_entity_decode(utf8_decode($value[4])),
                    "",
                    SCRAPER_URL . "movies.php?item=" . base64_encode($value[3]) . URL_AMP . "title=" . base64_encode($value[4]) . URL_AMP . "PHPSESID=" . session_id(),
                    ""
            );
        }
    }

    $template->generateView(KinotoTemplate::VIEW_MOVIE, "");
}

/**
 * Print category letter list on screen.
 */
function fetchCategoryLetters($type,$title) {
    $template = new KinotoTemplate();
    $letters = array(
            "A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z","0"
    );
    foreach ($letters as $letter) {
        $template->addItem(
                $letter,
                resourceString("goto_letter") . $letter,
                SCRAPER_URL . "movies.php?type=" . base64_encode($type) . URL_AMP . "letter=" . $letter . URL_AMP . "title=" . base64_encode($title) . URL_AMP . "PHPSESID=" . session_id(),
                ""
        );
    }
    $template->generateView(KinotoTemplate::VIEW_PAGE_NUMBERS );
}

/**
 * Get category movies and pages.
 */
function fetchCategoryItems($type,$letter,$title) {
    $template = new KinotoTemplate();
    $template->setType($type);
    $template->setLetter($letter);

    //If page equal "x" goto page number list, in other case process actual category page
    if( isset($_GET["page"]) && $_GET["page"] == "x" ) {
        $maxPages = $_GET["pages"];
        for($i=1;$i<=$maxPages;++$i) {
            $template->addItem(
                    $i,
                    resourceString("goto_page") . $i,
                    SCRAPER_URL . "movies.php?type=" . base64_encode($type) . URL_AMP . "letter=" . $letter . URL_AMP . "title=" . base64_encode($title) . URL_AMP . "page=" . $i . URL_AMP . "pages=" . $maxPages . URL_AMP . "PHPSESID=" . session_id(),
                    ""
            );
        }
        $template->generateView(KinotoTemplate::VIEW_PAGE_NUMBERS );

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
            $content = file_get_contents(getMovieListLink($type,$letter,$page),false,getExplorerContext(getSiteHash()));
        }

        //Remove backslashes
        $content = str_replace( "\\", "", $content);
   		//var_dump($content);
   		preg_match_all("/(movie|documentation)\",\"<a href=\"\/(.*)\" title=\"(.*)\" onclick=\"return false;\">(.*)<\/a>/U", $content, $links, PREG_SET_ORDER);
        	//var_dump($links);
        	if($links) {
            foreach ($links as $value) {
			$itemUrl = "/".$value[2];
				if( strpos($itemUrl, '"')){
			    $itemUrl = substr($itemUrl, 0, strpos($itemUrl, '"'));
				}
            	    $template->addItem(
                	        html_entity_decode($value[3],ENT_QUOTES,"UTF-8"),
                    	    "",
                        	SCRAPER_URL . "movies.php?title=" . base64_encode($value[3]) . URL_AMP . "item=" . base64_encode($itemUrl) . URL_AMP . "PHPSESID=" . session_id(),
      	                  ""
        	        );
       		 }

       		 $template->generateView(KinotoTemplate::VIEW_MOVIE, "");

    		}
    }
}

/**
 * Get movie host mirrors.
 */
function fetchMovie($item,$title) {
    $template = new KinotoTemplate();
    $template->setMovieTitle($title);

    //Parse movie page
    if(!strpos($item,"//kino.to")) {
        $item = "http://kino.to" . $item;
    }
    $content = file_get_contents($item,false,getExplorerContext(getSiteHash()));

    //Get image
    preg_match("/<div class=\"Grahpics\">(.*)src=\"(.*)\"/U", $content, $image);
    $image = $image[2];
    $template->setImage($image);

    //Get description
    $description = strstr($content,"Descriptore");
    $description = strstr($description,">");
    $description = substr($description, 1, strpos($description, "<")-1);
    $template->setDescription(html_entity_decode($description,ENT_QUOTES));

    //Get Mirror list
    $mirrorList = strstr($content,"HosterList");
    $mirrorList = substr($mirrorList, 0, strpos($mirrorList, "</ul>"));
    preg_match_all("|rel\=\"(.*)\"(.*)<div class\=\"Named\">(.*)<\/div>|U", $mirrorList, $mirrors, PREG_SET_ORDER);

    foreach ($mirrors as $mirror) {
        if( ($mirror[3] == "Megavideo.com") ||
                ($mirror[3] == "Bitload.com (Flash)") ||
                 ($mirror[3] == "Bitload.com (DivX)") ||
                ($mirror[3] == "Various (Flash)") ||
                 ($mirror[3] == "Archiv.to (DivX)") ||
                ($mirror[3] == "Archiv.to (Flash)")
        ) {

            $template->addItem(
                    $mirror[3],
                    "",
                    SCRAPER_URL . "moviesPreLink.php?params=" . base64_encode($mirror[1]) . URL_AMP . "host=" . base64_encode($mirror[3]) . URL_AMP .
                    "title=" . base64_encode($title) . URL_AMP . "image=" . base64_encode($image) . URL_AMP . "PHPSESID=" . session_id(),
                    ""
            );

        }
    }

    $template->generateView(KinotoTemplate::VIEW_MOVIE_DETAIL);
}

//------------------------------------------------------------------------------
//------------------------------------------------------------------------------
/**
 * Get number of pages and retrieve first page content.
 */
function getPages($url,$letter) {
    $content = file_get_contents(getMovieListLink($url,$letter),false,getExplorerContext(getSiteHash()));
	//Get letter number of entries
    preg_match("/\"iTotalDisplayRecords\":\"(.*)\"/U", $content, $numberEntries);

    if($numberEntries) {
        $numPages = ceil($numberEntries[1] / 25);
    }else {
        $numPages = 0;
    }
    $content = str_replace(
            array("\\u00e4","\\u00eb","\\u00ef","\\u00f6","\\u00fc","\\u00c4","\\u00cb","\\u00cf","\\u00d6","\\u00dc","\\u00df"),
            array("ä","ë","ï","ö","ü","Ä","Ë","Ï","Ö","Ü","ß"),
            $content);

    return array(utf8_decode($content),$numPages);
}

/**
 * Generate link to get movie list content.
 */
function getMovieListLink($url,$letter,$page=null) {
    $genreId = substr($url, strrpos($url,"/")+1);
     //var_dump($genreId);
    switch ($genreId) {
    	case "Action":
    		$genreId = "2";
    		break;
    	case "Adventure":
    		$genreId = "12";
    		break;
    	case "Animation":
    		$genreId = "13";
    		break;
    	case "Anime":
    		$genreId = "21";
    		break;
    	case "Comedy":
    		$genreId = "16";
    		break;
    	case "Crime":
    		$genreId = "14";
    		break;
    	case "Documentation":
    		$genreId = "9";
    		break;
    	case "Drama":
    		$genreId = "7";
    		break;
    	case "Family":
    		$genreId = "24";
    		break;
    	case "Fantasy":
    		$genreId = "11";
    		break;
        case "History":
    		$genreId = "15";
    		break;
    	case "Horror":
    		$genreId = "6";
    		break;
    	case "Kids":
    		$genreId = "19";
    		break;
    	case "Martial+Arts":
    		$genreId = "26";
    		break;
    	case "Music":
    		$genreId = "17";
    		break;
    	case "Mystery":
    		$genreId = "23";
    		break;
    	case "Romance":
    		$genreId = "20";
    		break;
    	case "Satire":
    		$genreId = "1";
    		break;
    	case "Science+Fiction":
    		$genreId = "10";
    		break;
    	case "Short-Film":
    		$genreId = "27";
    		break;
    	case "Sport":
    		$genreId = "22";
    		break;
    	case "StandUp":
    		$genreId = "4";
    		break;
    	case "Thriller":
    		$genreId = "8";
    		break;
    	case "War":
    		$genreId = "18";
    		break;
    	case "Western":
    		$genreId = "5";
    		break;

    }

    if(!$page) {
        $page = 0;
    }
    //Create url to get data
    return "http://kino.to/aGET/List/?".
            "sEcho=1" .
            "&iColumns=7" .
            "&sColumns=".
            "&iDisplayStart=" . ($page-1)*25 .
            "&iDisplayLength=25".
            "&iSortingCols=1" .
            "&iSortCol_0=2" .
            "&sSortDir_0=asc" .
            "&bSortable_0=true" .
            "&bSortable_1=true" .
            "&bSortable_2=true" .
            "&bSortable_3=false".
            "&bSortable_4=false" .
            "&bSortable_5=false" .
            "&bSortable_6=true" .
            "&additional=%7B%22foo%22%3A%22bar%22%2C%22fGenre%22%3A" .
            $genreId .
            "%2C%22fType%22%3A%22%22%2C%22fLetter%22%3A%22" .
            $letter .
            "%22%7D";
}

?>
