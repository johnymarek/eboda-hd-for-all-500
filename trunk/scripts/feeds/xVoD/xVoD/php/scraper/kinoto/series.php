<?php
/*-------------------------
 *    Developed by Maicros
 *      GNU/GPL Licensed
 * ------------------------*/

include_once '../../config/config.php';
include_once 'KinotoSeriesTemplate.php';
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
    $letter = $_GET["letter"];
    $type = "http://kino.to/Series.html";
    fetchLetterItems($type,$letter,"Series: " . $letter);

}else if( isset($_GET["serie"]) ) {
    $serie = base64_decode($_GET["serie"]);
    $title = base64_decode($_GET["title"]);
    fetchSerieSeasons($serie,$title);

}else if( isset($_GET["season"]) ) {
    $season = base64_decode($_GET["season"]);
    $title = base64_decode($_GET["title"]);
    fetchSerieSeasonEpisodes($season,$title);

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
    $template = new KinotoSeriesTemplate();
    $letters = array(
	    "A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z","0"
    );

    $template->setSearch( array(
	    resourceString("search_by") . "...",
	    resourceString("search_by") . "...",
	    "rss_command://search",
	    SCRAPER_URL . "series.php?search=%s" . URL_AMP . "title=" . base64_encode(resourceString("search_by") . "...") . URL_AMP . "PHPSESID=" . session_id(),
	    ""
	    )
    );

    foreach ($letters as $letter) {
	$template->addItem(
		$letter,
		resourceString("goto_letter") . $letter,
		SCRAPER_URL . "series.php?letter=" . $letter . URL_AMP . "title=" . base64_encode($title) . URL_AMP . "PHPSESID=" . session_id(),
		""
	);
    }
    $template->generateView(KinotoSeriesTemplate::VIEW_CATEGORY );
}

/**
 * Fetch search result items.
 */
function fetchSearch($type,$pageTitle) {
    $template = new KinotoSeriesTemplate();
    $content = file_get_contents("http://kino.to/Search.html?q=".$type,false,getExplorerContext(getSiteHash()));
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

    $template->generateView(KinotoSeriesTemplate::VIEW_SERIE, "");
}

/**
 * Get category movies and pages.
 */
function fetchLetterItems($type,$letter,$title) {
    $template = new KinotoSeriesTemplate();
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
	$template->generateView(KinotoSeriesTemplate::VIEW_PAGE_NUMBERS );

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
	preg_match_all("/<a href=\"\/(.*)\" title=\"(.*)\" onclick=\"return false;\">(.*)<\/a>/U", $content, $links, PREG_SET_ORDER);
	//var_dump ($links);
	if($links) {
	    foreach ($links as $value) {
		$title = html_entity_decode(utf8_decode($value[3]));
		$itemUrl = "/".$value[1];
		//if( strpos($itemUrl, '"')) {
		//    $itemUrl = substr($itemUrl, 0, strpos($itemUrl, '"'));
		//}
		$template->addItem(
			$title,
			"",
			SCRAPER_URL . "series.php?serie=" . base64_encode($itemUrl) . URL_AMP . "title=" . base64_encode($title) . URL_AMP . "PHPSESID=" . session_id(),
			""
		);
	    }
	}

	$template->generateView(KinotoSeriesTemplate::VIEW_SERIE, "");
    }
}

/**
 * Show selected serie seasons.
 */
function fetchSerieSeasons($serie,$title) {
    $template = new KinotoSeriesTemplate();

    //Parse serie page
    $content = file_get_contents("http://kino.to" . $serie,false,getExplorerContext(getSiteHash()));
    //Get image
    //var_dump($content);
    preg_match("/<div class=\"Grahpics\">(.*)src=\"(.*)\"/U", $content, $image);
    $image = $image[2];
    $template->setImage($image);

    //Get description
    $description = strstr($content,"Descriptore");
    $description = strstr($description,">");
    $description = substr($description, 1, strpos($description, "<")-1);
    $template->setDescription($description);

    preg_match("/SeasonSelection(.*)<\/select>/siU", $content, $select);
    //var_dump($select);
    preg_match("/rel\=\"(.*)\"/siU", $select[1], $serieUrl);
    $serieUrl = str_replace("&amp;", "&", $serieUrl[1]);
    $select[1] = strstr($select[1],"<option value=\"1\"");
    if (!$select[1]){
    preg_match("/SeasonSelection(.*)<\/select>/siU", $content, $select);
    $select[1] = strstr($select[1],"<option value=\"2\"");
    }
    //var_dump($select[1]);
    preg_match_all("/<option value\=\"(.*)\" rel=\"(.*)\"(.*)>(.*)</siU", $select[1], $episodes, PREG_SET_ORDER);

    $seasons = array();
    foreach ($episodes as $item) {
	$season = array(
		$item[4],
		$item[2],
		"http://kino.to/aGET/MirrorByEpisode/" . $serieUrl."&Season=".$item[1]."&Episode=");
	$seasons["$item[4]"] = $season;

	//Add links
	$template->addItem(
		strtoupper($item[4]),
		"",
		SCRAPER_URL . "series.php?season=" . base64_encode($item[4]) . URL_AMP . "PHPSESID=" . session_id(),
		""
	);
    }

    $_SESSION["seasons"] = serialize($seasons);
    $_SESSION["serieTitle"] = $title;
    $_SESSION["serieImage"] = $image;
    $_SESSION["serieDescription"] = $description;

    $template->setSeasons($seasons);
    $template->generateView(KinotoSeriesTemplate::VIEW_SEASONS, $title);
}

/**
 * Show selected serie season episodes.
 */
function fetchSerieSeasonEpisodes($season,$title) {
    $template = new KinotoSeriesTemplate();

    //Recover info and set to template
    $seasons = unserialize( $_SESSION["seasons"] );
    $template->setSeasons($seasons);
    $template->setMovieTitle($_SESSION["serieTitle"]);
    $template->setImage($_SESSION["serieImage"]);
    $template->setDescription($_SESSION["serieDescription"]);

    //Get season episodes and add links
    $season = $seasons[$season];
    $episodes = explode(",", $season[1]);
    $template->setEpisodes($episodes);
    $template->setSelectedSeason($season[0]);
    foreach ($episodes as $episode) {
	$template->addItem(
		sprintf("%02d",$episode),
		"",
		SCRAPER_URL . "series.php?title=" . $episode . URL_AMP . "episode=" . base64_encode($season[2].$episode) . URL_AMP . "PHPSESID=" . session_id(),
		""
	);
    }

    $template->generateView(KinotoSeriesTemplate::VIEW_EPISODES, $_SESSION["serieTitle"]);
}

/**
 * Get season episode available mirrors.
 * @var $episode Full episode page link.
 */
function fetchSerieSeasonEpisodeLinks($episode,$title) {
    $template = new KinotoSeriesTemplate();

    //Recover info and set to template
    $template->setMovieTitle($_SESSION["serieTitle"]);
    $template->setImage($_SESSION["serieImage"]);
    $template->setDescription($_SESSION["serieDescription"]);

    $content = file_get_contents( $episode, false, getExplorerContext(getSiteHash()) );
    preg_match_all("/rel=\"(.*)\"/siU", $content, $links, PREG_SET_ORDER);
    foreach ($links as $link) {
	$link = "http://kino.to/aGET/Mirror/" . html_entity_decode($link[1]);
	$content = file_get_contents( $link, false, getExplorerContext(getSiteHash()) );

	if( strpos($content, "Megavideo.com") ) {
	    $host = "Megavideo.com";
	}else if( strpos($content, "Bitload.com (Flash)") ) {
	    $host = "Bitload.com (Flash)";
	}else if( strpos($content, "Bitload.com (DivX)") ) {
	    $host = "Bitload.com (DivX)";
	}else if( strpos($content, "Various (Flash)") ) {
	    $host = "Various (Flash)";
	}else if( strpos($content, "Archiv.to (Flash)") ) {
	    $host = "Archiv.to (Flash)";
	}else if( strpos($content, "Archiv.to (DivX)") ) {
	    $host = "Archiv.to (DivX)";
	}else {
	    $host = false;
	}

	if($host) {
	    $template->addItem(
		    $host,
		    "",
		    SCRAPER_URL . "series.php?host=" . base64_encode($host) . URL_AMP . "link=" . base64_encode($link) . URL_AMP . "PHPSESID=" . session_id(),
		    ""
	    );
	}

    }

    $template->generateView(KinotoSeriesTemplate::VIEW_EPISODE_DETAIL, $_SESSION["serieTitle"]);
}

function fetchPlayEpisode($host,$link) {
    $template = new KinotoSeriesTemplate();

    //Recover info and set to template
    $template->setMovieTitle($_SESSION["serieTitle"]);
    $template->setImage($_SESSION["serieImage"]);
    $template->setDescription($_SESSION["serieDescription"]);

    $content = file_get_contents( $link, false, getExplorerContext(getSiteHash()) );

    switch($host) {
	case "Megavideo.com";
	    addMegavideoLink($template,$content);
	    break;
	case "Bitload.com (Flash)";
	    addBitloadLink($template,$content);
	    break;
	case "Bitload.com (DivX)";
	    addBitloadDivxLink($template,$content);
	    break;
	case "Various (Flash)":
	    addNovamovLink($template,$content);
	    break;
	case "Archiv.to (Flash)":
	    addArchivToFlash($template,$content);
	    break;
	case "Archiv.to (DivX)":
	    addArchivToDivx($template,$content);
	    break;
    }

    $template->generateView(KinotoSeriesTemplate::VIEW_PLAY, $_SESSION["serieTitle"]);
}

function addMegavideoLink($template,$content) {
    $content = str_replace( "\\", "", $content);

    preg_match("|www.megavideo.com\/v\/(.*)\"|U", $content, $links);
    if($links) {
	$megavideo_id = $links[1];
	if( COOKIE_STATE_ACTIVATED && $megavideo_id ) {
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


function addNovamovLink($template,$content) {
    $content = str_replace( "\\", "", $content);

    //Get novamov mirror links
    preg_match_all("/http\:\/\/www\.novamov\.com\/video\/(.*)\"/U", $content, $parts, PREG_SET_ORDER);
    foreach ($parts as $part) {
	$content = file_get_contents("http://www.novamov.com/video/" . $part[1] );
	//Get final file link
	preg_match_all("|s1\.addVariable\(\"file\"\,\"(.*)\"|U", $content, $newLink);
	if($newLink) {
	    $newLink = $newLink[1];
	    $newLink = $newLink[0];
	    $template->addMediaItem(
		    substr($newLink, strrpos($newLink,"/")+1),
		    "",
		    $newLink,
		    "",
		    VideoUtil::getEnclosureMimetype($newLink)
	    );
	}
    }
}

function addArchivToFlash($template,$content) {
    $content = str_replace( "\\", "", $content);

	 //Get mirror links
     if (preg_match_all("/http\:\/\/archiv\.to\/GET\/(.*)\"/U", $content, $parts2, PREG_SET_ORDER)){
      foreach ($parts2 as $part2) {
        $content = file_get_contents("http://archiv.to/GET/".$part2[1]);
        //$content = strstr($content,"</object>");

        //Get final file link
        preg_match("/value=\"file=(.*)\&(.*)\"/U", $content, $link);

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
  }
     else{
     preg_match_all("/http\:\/\/archiv\.to\/view\/flv\/(.*)\"/U", $content, $parts, PREG_SET_ORDER);
        foreach ($parts as $part) {
        $content = file_get_contents("http://archiv.to/view/flv/".$part[1]);
        //$content = strstr($content,"</object>");

        //Get final file link
        preg_match("/value=\"file=(.*)\&(.*)\"/U", $content, $link);
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
  }
}
function addArchivToDivx($template,$content) {
      $content = str_replace( "\\", "", $content);

	 if (preg_match_all("/http\:\/\/archiv\.to\/GET\/(.*)\"/U", $content, $parts2, PREG_SET_ORDER)){
      foreach ($parts2 as $part2) {
        $content = file_get_contents("http://archiv.to/GET/".$part2[1]);
        //$content = strstr($content,"</object>");

        //Get final file link
        preg_match("/value=\"(.*)\" name=\"src\"/U", $content, $link);

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
  }
    else {
    //Get mirror links
    preg_match_all("/http\:\/\/archiv\.to\/view\/divx\/(.*)\"/U", $content, $parts, PREG_SET_ORDER);
        foreach ($parts as $part) {
        $content = file_get_contents("http://archiv.to/view/divx/".$part[1]);
        //$content = strstr($content,"</object>");

        //Get final file link
        preg_match("/value=\"(.*)\" name=\"src\"/U", $content, $link);
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
    }
}

function addBitloadLink($template,$content) {

    $content = str_replace( "\\", "", $content);
	if (preg_match_all("/http\:\/\/www\.mystream\.to\/file-(.*)-(.*)-(.*)\"/U", $content, $parts2, PREG_SET_ORDER)){
	foreach ($parts2 as $part2) {
        $content = getHeadersFlash('http://www.bitload.com/f/'.$part2[1]."/".$part2[2].'?m=def&c=free');

    preg_match("/Set-Cookie: PHPSESSID=(.*); path=\//", $headers[4], $sessionid);
    $content = file_get_contents("http://www.bitload.com/f/".$part2[1]."/".$part2[2]."?m=def&c=free&PHPSESSID=".$sessionid);

        //Get final file link
        preg_match_all("/autoPlay\":false,\"url\"\:\"(.*)\"/U", $content, $newLink);
        if($newLink) {
         $newLink = $newLink[1];
            $newLink = $newLink[0];
           			$template->addMediaItem(
                    substr($newLink, strrpos($newLink,"/")+1),
                    "",
                    $newLink,
                    "",
                    VideoUtil::getEnclosureMimetype($newLink)
         			);
        			}
        }
    }
   else {
   preg_match_all("/http\:\/\/www\.bitload\.com\/f\/(.*)\"/U", $content, $parts, PREG_SET_ORDER);
    foreach ($parts as $part) {

    $content = getHeadersFlash('http://www.bitload.com/f/'.$part[1].'?m=def&c=free');

    preg_match("/Set-Cookie: PHPSESSID=(.*); path=\//", $headers[4], $sessionid);
    $content = file_get_contents("http://www.bitload.com/f/".$part[1]."?m=def&c=free&PHPSESSID=".$sessionid);

        //Get final file link
        preg_match_all("/autoPlay\":false,\"url\"\:\"(.*)\"/U", $content, $newLink);
        if($newLink) {
         $newLink = $newLink[1];
            $newLink = $newLink[0];
           			$template->addMediaItem(
                    substr($newLink, strrpos($newLink,"/")+1),
                    "",
                    $newLink,
                    "",
                    VideoUtil::getEnclosureMimetype($newLink)
            		);
        			}
    	}
	}
}

function addBitloadDivxLink($template,$content) {

    $content = str_replace( "\\", "", $content);
	if (preg_match_all("/http\:\/\/www\.mystream\.to\/file-(.*)-(.*)-(.*)\"/U", $content, $parts2, PREG_SET_ORDER)){
	foreach ($parts2 as $part2) {
     $content = getHeadersDivx('http://www.bitload.com/d/'.$part2[1]."/".$part2[2].'?m=def&c=free');

    preg_match("/Set-Cookie: PHPSESSID=(.*); path=\//", $headers[4], $sessionid);

    $content = file_get_contents("http://www.bitload.com/d/".$part2[1]."/".$part2[2]."?m=def&c=free&PHPSESSID=".$sessionid);

        //Get final file link
        preg_match_all("/var url = \'(.*)\'/U", $content, $newLink);
        if($newLink) {
         $newLink = $newLink[1];
            $newLink = $newLink[0];
           			$template->addMediaItem(
                    substr($newLink, strrpos($newLink,"/")+1),
                    "",
                    $newLink,
                    "",
                    VideoUtil::getEnclosureMimetype($newLink)
         			);
        			}
        }
    }
   else {
   preg_match_all("/http\:\/\/www\.bitload\.com\/d\/(.*)\"/U", $content, $parts, PREG_SET_ORDER);
  foreach ($parts as $part) {
    $content = getHeadersDivx('http://www.bitload.com/d/'.$part[1].'?m=def&c=free');

    preg_match("/Set-Cookie: PHPSESSID=(.*); path=\//", $headers[4], $sessionid);
    $content = file_get_contents("http://www.bitload.com/d/".$part[1]."?m=def&c=free&PHPSESSID=".$sessionid);
        //Get final file link
        preg_match_all("/var url = \'(.*)\'/U", $content, $newLink);
        if($newLink) {
         $newLink = $newLink[1];
            $newLink = $newLink[0];
           			$template->addMediaItem(
                    substr($newLink, strrpos($newLink,"/")+1),
                    "",
                    $newLink,
                    "",
                    VideoUtil::getEnclosureMimetype($newLink)
            		);
        			}
    	}
	}
}

//------------------------------------------------------------------------------
//------------------------------------------------------------------------------

/**
 * Get number of pages and retrieve first page content.
 */
/*function getPages($url,$letter) {
    $content = file_get_contents(getMovieListLink($url,$letter),false,getExplorerContext(getSiteHash()));

    //Get letter number of entries
    preg_match("/\"iTotalDisplayRecords\":\"(.*)\"/U", $content, $numberEntries);
    if($numberEntries) {
	$numPages = ceil($numberEntries[1] / 25);
    }else {
	$numPages = 0;
    }

    return array($content,$numPages);
}
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
            array("ä","ë","ï","ö","ü","Ä","Ë","�?","Ö","Ü","ß"),
            $content);

    return array(utf8_decode($content),$numPages);
}

/**
 * Generate link to get movie list content.
 */
function getMovieListLink($url,$letter,$page=null) {
    $genreId = substr($url, strrpos($url,"/")+1);
    if(!$page) {
	$page = 0;
    }
    //Create url to get data
    return "http://kino.to/aGET/List/?".
            "sEcho=3" .
            "&iColumns=7" .
            "&sColumns=".
            "&iSortCol_0=2" .
            "&iDisplayStart=" . ($page-1)*25 .
            "&iDisplayLength=25".
            "&iSortingCols=1" .
            "&bSortable_0=true" .
            "&bSortable_1=true" .
            "&bSortable_2=true" .
            "&bSortable_3=false".
            "&bSortable_4=false" .
            "&bSortable_5=false" .
            "&bSortable_6=true" .
            "&additional=%7B%22foo%22%3A%22bar%22%2C%22fGenre%22%3A%22" .
            $genreId .
            "%22%2C%22fType%22%3A%22".
            "series" .
            "%22%2C%22fLetter%22%3A%22" .
            $letter .
            "%22%7D";

/*    return "http://kino.to/aGET/List/?" .
	    "additional=" . urlencode('{"fType":"series","fLetter":"' . $letter . '"}') . "" .
	    "&bSortable_0=true" .
	    "&bSortable_1=true" .
	    "&bSortable_2=true" .
	    "&bSortable_3=false" .
	    "&bSortable_4=false" .
	    "&bSortable_5=false" .
	    "&bSortable_6=true" .
	    "&iColumns=7" .
	    "&iDisplayLength=25" .
	    "&iDisplayStart=0" .
	    "&iSortCol_0=2" .
	    "&iSortingCols=1" .
	    "&sColumns=" .
	    "&sEcho=1" .
	    "&sSortDir_0=asc";
*/
}
function getHeadersFlash($url)
{
	
	$path = parse_url($url);
	if (isset($path['query']))
	{
		$path['path'] .= '?' . $path['query'];
	}
	if (!isset($path['port']))
	{
		$path['port'] = 80;
	}

	$request	= "HEAD " . $path['path']. " HTTP/1.1\r\n";
	$request	.= "Host: " . $path['host'] . "\r\n";
	$request	.= "Content-type: application/x-www-form-urlencoded\r\n";
	$request	.= "Cache-Control: no-cache\r\n";
	$request	.= "User-Agent: MSIE\r\n";
	$request	.= "Connection: close\r\n";
	$request	.= "\r\n";

	$f = fsockopen($path['host'], $path['port'], $errno, $errstr);
	if ($f)
	{
	    fputs($f, $request);
	    while (!feof($f))
		{
			$headers[] = fgets($f);
		}

    preg_match("/Set-Cookie: PHPSESSID=(.*); path=\//", $headers[4], $sessionid);
    //var_dump($headers[4]);
    $content = file_get_contents($url."&PHPSESSID=".$sessionid);
	//var_dump($content);


	    fclose($f);
	}
	return $content;
	return $headers;
}

function getHeadersDivx($url)
{
	
	$path = parse_url($url);
	if (isset($path['query']))
	{
		$path['path'] .= '?' . $path['query'];
	}
	if (!isset($path['port']))
	{
		$path['port'] = 80;
	}

	$request	= "HEAD " . $path['path']. " HTTP/1.1\r\n";
	$request	.= "Host: " . $path['host'] . "\r\n";
	$request	.= "Content-type: application/x-www-form-urlencoded\r\n";
	$request	.= "Cache-Control: no-cache\r\n";
	$request	.= "User-Agent: MSIE\r\n";
	$request	.= "Connection: close\r\n";
	$request	.= "\r\n";

	$f = fsockopen($path['host'], $path['port'], $errno, $errstr);
	if ($f)
	{
	    fputs($f, $request);
	    while (!feof($f))
		{
			$headers[] = fgets($f);
		}

    preg_match("/Set-Cookie: PHPSESSID=(.*); path=\//", $headers[4], $sessionid);
    //var_dump(headers[4]);
    $content = file_get_contents($url."&PHPSESSID=".$sessionid);
	//var_dump($content);


	    fclose($f);
	}
	return $content;
	return $headers;
}




?>

