<?php
/*-------------------------
 *    Developed by Maicros
 *      GNU/GPL Licensed
 * ------------------------*/

include_once '../../config/config.php';
include_once 'WatchnewfilmsTemplate.php';
include_once "../../util/VideoUtil.php";
include_once "../../util/RssScriptUtil.php";
include_once '../../action/Action.php';
include_once '../../action/rss/SaveBookmarkAction.php';
include_once '../../action/rss/DeleteBookmarkAction.php';
define("SCRAPER_URL", SERVER_HOST_AND_PATH . "php/scraper/watchnewfilms/");
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
//Load template
$template = new WatchnewfilmsTemplate();

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

}else if( isset($_GET["type"]) && !isset($_GET["page"]) ) {
    $type = base64_decode($_GET["type"]);
    $pageTitle = base64_decode($_GET["title"]);
    fetchCategoryPages($type,$pageTitle);

}else if(isset($_GET["page"])) {
    $template->setUrl(SCRAPER_URL . "index.php?page=" . $_GET["page"] . URL_AMP . "type=" . $_GET["type"] . URL_AMP . "title=" . $_GET["title"]);
    $type = base64_decode($_GET["type"]);
    $page = base64_decode($_GET["page"]);
    $pageTitle = base64_decode($_GET["title"]);
    if(isset($_GET["view"])) {
        $view = $_GET["view"];
    }else {
        $view = "";
    }
    fetchCategoryPageMovies($type,$page,$pageTitle,$view);

}else if(isset($_GET["movieId"])) {
    $movieId = base64_decode($_GET["movieId"]);
    $pageTitle = base64_decode($_GET["title"]);
    $movieImage = base64_decode($_GET["image"]);
    fetchMovie($movieId,$pageTitle,$movieImage);

}else {
    fetchCategories();
}

//------------------------------------------------------------------------------
//------------------------------------------------------------------------------

function fetchCategories() {
    global $template;
    //Get principal page and parse categories side bar
    $content = file_get_contents("http://www.watchnewfilms.com/");
    $newlines = array("\t","\n","\r","\x20\x20","\0","\x0B");
    $input = str_replace($newlines, "", utf8_decode( $content) );
    preg_match_all("|<a href\=\"http\:\/\/(www\.)?watchnewfilms.com\/movies2\.php\?(.*)\">(.*)<\/a>|U", $input, $div);
    if($div) {
        $links = $div[2];
        $names = $div[3];
        for ($i=0; $i<count($links); ++$i ) {
            $name = $names[$i];
            $link = $links[$i];
            $template->addItem(
                    $name,
                    "",
                    SCRAPER_URL . "index.php?type=" . base64_encode($link) . URL_AMP . "title=" . base64_encode($name),
                    ""
            );
        }
    }

    $template->generateView(WatchnewfilmsTemplate::VIEW_CATEGORY, "WatchNewFilms.com" );
}


function fetchSearch($type, $view, $pageTitle) {
    global $template;
    //Get principal category page and parse movies and pages
    $content = file_get_contents("http://www.watchnewfilms.com/search.php?search=" . $type );
    $newlines = array("\r","\x20\x20","\0","\x0B");
    $content = str_replace($newlines, "", $content);
    $newlines = array("\n","\r","\t","\x20\x20","\0","\x0B");

    $categories = array();
    while($content) {
        $content = strstr($content, "&nbsp;&nbsp;&nbsp;");
        $title = str_replace($newlines, "", substr($content, 0, strpos($content, "<")) );
        $title = str_replace("&nbsp;", "", $title);
        $content = strstr($content, "<" );
        preg_match_all("/<a class\=\"thumbnail\" href\=\"(.*)\">\s*\S*<img src\=\"(.*)\"(.*)<br>(.*)<\/span><\/a>/siU", $content, $div);
        array_splice($div,0,1);
        array_splice($div,2,1);
        if($div) {
            $links = $div[0];
            $image = $div[1];
            $name = $div[2];
            for($i=0; $i<count($links); ++$i) {
                $newName = substr($name[$i], 0, strrpos($name[$i],"("));
                $template->addItem(
                        $newName,
                        "",
                        SCRAPER_URL . "index.php?title=" . base64_encode($pageTitle . " - " . $newName) . URL_AMP . "movieId=" . base64_encode($links[$i]) . URL_AMP . "image=" . base64_encode($image[$i]),
                        $image[$i]
                );
            }
        }
    }
    //Select view for template
    if($view == "grid") {
        $view = WatchnewfilmsTemplate::VIEW_MOVIE_GRID;
    }else if($view == "list") {
        $view = WatchnewfilmsTemplate::VIEW_MOVIE_LIST;
    }else if($view == "detail") {
        $view = WatchnewfilmsTemplate::VIEW_MOVIE;
    }else {
        $view = WatchnewfilmsTemplate::VIEW_MOVIE_GRID;
    }
    $template->generateView($view, $pageTitle );
    //--------------------------------------------------------------------------
}


function fetchCategoryPages($type,$pageTitle) {
    global $template;
    //Get principal category page and parse movies and pages
    $content = file_get_contents("http://www.watchnewfilms.com/movies2.php?" . $type );
    $newlines = array("\r","\x20\x20","\0","\x0B");
    $content = str_replace($newlines, "", $content);
    $newlines = array("\n","\r","\t","\x20\x20","\0","\x0B");

    $categories = array();
    while($content) {
        $content = strstr($content, "&nbsp;&nbsp;&nbsp;");
        $title = str_replace($newlines, "", substr($content, 0, strpos($content, "<")) );
        $content = strstr($content, "<" );
        //echo $title . "\n";
        $title = str_replace("&nbsp;", "", $title);
        if($title && ($title[0] != " ") && !strpos($title,"only select High Quality Movies") ) {
            array_push($categories, $title);
        }
    }

    //Show found categories
    if( $categories ) {
        foreach ($categories as $value) {
            $template->addItem(
                    $value,
                    "",
                    SCRAPER_URL . "index.php?page=" . base64_encode($value) . URL_AMP . "type=" . $_GET["type"] . URL_AMP . "title=" . base64_encode($pageTitle . " - " . $value),
                    ""
            );
        }
    }
    $template->generateView(WatchnewfilmsTemplate::VIEW_PAGE, $pageTitle );

    //--------------------------------------------------------------------------
}


function fetchCategoryPageMovies($type,$page,$pageTitle,$view) {
    global $template;
    //Get principal category page and parse movies and pages
    $content = file_get_contents("http://www.watchnewfilms.com/movies2.php?" . $type );
    $newlines = array("\r","\x20\x20","\0","\x0B");
    $content = str_replace($newlines, "", $content);
    $newlines = array("\n","\r","\t","\x20\x20","\0","\x0B");

    $categories = array();
    while($content) {
        $content = strstr($content, "&nbsp;&nbsp;&nbsp;");
        $title = str_replace($newlines, "", substr($content, 0, strpos($content, "<")) );
        $title = str_replace("&nbsp;", "", $title);
        $content = strstr($content, "<" );

        if($title && ($title[0] != " ") && !strpos($title,"only select High Quality Movies") && ($page == $title) ) {
            $subcontent = substr($content, 0, strpos($content, "&nbsp;&nbsp;&nbsp;") );
            preg_match_all("/<a class\=\"thumbnail\" href\=\"(.*)\">\s*\S*<img src\=\"(.*)\"(.*)<br>(.*)<\/span><\/a>/siU", $subcontent, $div);
            array_splice($div,0,1);
            array_splice($div,2,1);
            if($div) {
                $links = $div[0];
                $image = $div[1];
                $name = $div[2];
                for($i=0; $i<count($links); ++$i) {
                    $newName = substr($name[$i], 0, strrpos($name[$i],"("));
                    $template->addItem(
                            $newName,
                            "",
                            SCRAPER_URL . "index.php?title=" . base64_encode($pageTitle . " - " . $newName) . URL_AMP . "movieId=" . base64_encode($links[$i]) . URL_AMP . "image=" . base64_encode($image[$i]),
                            $image[$i]
                    );
                }
            }
            break;
        }
    }
    //Select view for template
    if($view == "grid") {
        $view = WatchnewfilmsTemplate::VIEW_MOVIE_GRID;
    }else if($view == "list") {
        $view = WatchnewfilmsTemplate::VIEW_MOVIE_LIST;
    }else if($view == "detail") {
        $view = WatchnewfilmsTemplate::VIEW_MOVIE;
    }else {
        $view = WatchnewfilmsTemplate::VIEW_MOVIE_GRID;
    }
    $template->generateView($view, $pageTitle );
    //--------------------------------------------------------------------------
}


function fetchMovie($movieId,$pageTitle,$movieImage) {
    global $template;
    $content = file_get_contents( "http://www.watchnewfilms.com/" . $movieId );
    $newlines = array("\t","\n","\r","\x20\x20","\0","\x0B");
    $content = str_replace($newlines, "", html_entity_decode($content));
    //Get film avaible links
    //Get principal megavideo link
    if( strpos($content, "http://www.megavideo.com/v" ) ) {
        preg_match_all("|www.megavideo.com\/v\/(.*)\"|U", $content, $links);
        if($links && $links[1]) {
            $movieTitle = substr($pageTitle, strrpos($pageTitle,"-")+2);
            $links = $links[1];
            $links = array_unique( $links );
            foreach ($links as $value) {
                //Get megavideo id
                $megavideo_id = substr($value, 0, -32);

                if( COOKIE_STATE_ACTIVATED && $megavideo_id ) {
                    //If megaupload cookie is defined, use it, in other case, use alternative method
                    $array = VideoUtil::generateMegavideoPremiumLink($megavideo_id);
                    if($array) {
                        $template->addMediaItem(
                                $array[0],
                                "",
                                $array[1],
                                $movieImage,
                                $array[2]
                        );
                    }
                }
            }
        }

    }

    //Get alternative megavideo links
    if( strpos($content, "http://www.megavideo.com/?v=" ) ) {
        preg_match_all("/www.megavideo.com\/\?v\\=(.*)\'/U", $content, $links);
        if($links && $links[1]) {
            $movieTitle = substr($pageTitle, strrpos($pageTitle,"-")+2);
            $links = $links[1];
            $links = array_unique( $links );
            foreach ($links as $megavideo_id) {
                if( $megavideo_id != null ) {
                    //If megaupload cookie is defined, use it, in other case, use alternative method
                    if( COOKIE_STATE_ACTIVATED ) {
                        //generateMegavideoPremiumLink($tempTitle, $imageUrl, $counter, $megavideo_id);
                        $array = VideoUtil::generateMegavideoPremiumLink($megavideo_id);
                        //echo $megavideo_id;
                        if($array) {
                            $template->addMediaItem(
                                    $array[0],
                                    "",
                                    $array[1],
                                    $movieImage,
                                    $array[2]
                            );
                        }
                    }
                }
            }
        }
    }
    //Get youtube links
    if( strpos($content, "http://www.youtube.com/v" ) ) {
        $link = substr($content, strpos($content, "http://www.youtube.com/v"));
        $link = substr($link, strpos($link, "v/")+2);
        $link = VideoUtil::generateYoutubeLink(substr($link, 0, strpos($link,"&")));
        $template->addMediaItem(
                "[Youtube] ".$movieTitle,
                "",
                $link,
                $movieImage,
                "video/x-flv"
        );
    }
    $template->setImage($movieImage);
    $template->generateView(WatchnewfilmsTemplate::VIEW_PLAY, $pageTitle );

}


?>

