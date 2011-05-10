<?php
/*-------------------------
 *    Developed by Maicros
 *      GNU/GPL Licensed
 * ------------------------*/

include_once '../../config/config.php';
include_once 'MyvodtvTemplate.php';
include_once "../../util/VideoUtil.php";
include_once "../../util/RssScriptUtil.php";
include_once '../../action/Action.php';
include_once '../../action/rss/SaveBookmarkAction.php';
include_once '../../action/rss/DeleteBookmarkAction.php';
define("SCRAPER_URL", SERVER_HOST_AND_PATH . "php/scraper/myvodtv/");

//Start session
if(isset($_GET["PHPSESID"])) {
    session_id($_GET["PHPSESID"]);
}
session_start();

$template = new MyvodtvTemplate();

//Do action
if(isset($_GET["search"])) {
    $search = "http://www.myvod.tv/index.php?s=" . $_GET["search"];
    $title = base64_decode($_GET["title"]);
    fetchCategoryPages($search,$title);

}else if(isset($_GET["type"])) {
    $type = base64_decode($_GET["type"]);
    $title = base64_decode($_GET["title"]);
    fetchCategoryPages($type,$title);

}else if(isset($_GET["page"])) {
    $page = $_GET["page"];
    $maxPages = $_GET["pages"];
    $category = base64_decode($_GET["cat"]);
    $title = base64_decode($_GET["title"]);
    $template->setActualPage($page);
    $template->setCategory($category);
    $template->setMaxPages($maxPages);
    fetchCategoryPageMovies($title,$page,$category,false,$maxPages);

}else if(isset($_GET["movieId"])) {
    $movieId = base64_decode($_GET["movieId"]);
    $title = base64_decode($_GET["title"]);
    $movieImage = base64_decode($_GET["image"]);
    fetchMovie($movieId,$title,$movieImage);

}else {
    fetchCategories();
}

//------------------------------------------------------------------------------
//------------------------------------------------------------------------------

function fetchCategories() {
    global $template;
    //Get principal page and parse categories side bar
    $content = file_get_contents("http://www.myvod.tv");
    $newlines = array("\t","\n","\r","\x20\x20","\0","\x0B");
    $content = str_replace($newlines, "", html_entity_decode($content));

    //Gets sidebar
    preg_match("/<div id=\"l_sidebar\">(.*)<\/div>/siU", $content, $div);
    $div = $div[1];
    //Get category links
    preg_match_all("/<a href=\"(.*)\" title=\"(.*)\">(.*)</siU", $div, $links, PREG_SET_ORDER);

    $template->setSearch( array(
            resourceString("search_by") . "...",
            resourceString("search_by") . "...",
            "rss_command://search",
            SCRAPER_URL . "index.php?search=%s" . URL_AMP . "title=" . base64_encode(resourceString("search_by")) . URL_AMP . "PHPSESID=" .  session_id(),
            ""
            )
    );

    foreach ($links as $link) {
        $name = htmlspecialchars_decode($link[3], ENT_QUOTES);
        $template->addItem(
                $name,
                "",
                SCRAPER_URL . "index.php?type=" . base64_encode($link[1]) . URL_AMP . "title=" . base64_encode($name) . URL_AMP . "PHPSESID=" . session_id(),
                ""
        );
    }
    $template->generateView(MyvodtvTemplate::VIEW_CATEGORY, "myvod.tv" );
}

//------------------------------------------------------------------------------
//------------------------------------------------------------------------------

function fetchCategoryPages($type,$title) {
    global $template;
    //Get principal category page and parse movies and pages
    $content = file_get_contents($type );
    preg_match("/<span class\=\"pages\">\&\#8201\;(.*)</siU", $content, $pages);
    $pages = str_replace("&#8201;", "", $pages[1]);
    $pages = explode(" ", $pages);
    if( $pages ) {
        $maxPage = $pages[ count($pages)-1 ];

        //Show first page
        $template->setActualPage(1);
        $template->setCategory(base64_encode($type));
        $template->setMaxPages($maxPage);
        $template->setTitle($title);
        fetchCategoryPageMovies($title,"1",$type,$content,$maxPage);
//        for( $i=1;$i<=$maxPage;++$i) {
//            $template->addItem(
//                    $i,
//                    "",
//                    SCRAPER_URL . "index.php?page=".$i.URL_AMP."cat=".$type.URL_AMP."pages=".$maxPage,
//                    ""
//            );
//        }

    }
    //$template->generateView(MyvodtvTemplate::VIEW_PAGE, $title );
    //--------------------------------------------------------------------------
}

//------------------------------------------------------------------------------
//------------------------------------------------------------------------------

function fetchCategoryPageMovies($title,$page,$cat,$content=null,$maxPages=null) {
    global $template;
//    if($maxPages){
//        $template->setMaxPages($maxPages);
//    }
//    $template->setActualPage($page);
//    $template->setCategory(base64_encode($cat));
    //
    if( $page == "x" ) {
        for($i=1;$i<=$maxPages;++$i) {
            $template->addItem(
                    $i,
                    "Go to page " . $i,
                    SCRAPER_URL . "index.php?page=".$i.URL_AMP."cat=".base64_encode($cat).URL_AMP."pages=".$maxPages . URL_AMP . "PHPSESID=" . session_id(),
                    ""
            );
        }
        $template->generateView(MyvodtvTemplate::VIEW_PAGE_NUMBERS, $title );
    }else {
        if(!$content) {
            //Check for search, if contains index.php, or category url
            if(strpos($cat,"index.php")){
                $content = file_get_contents( str_replace("index.php", "page/".$page, $cat) );
            }else{
                $content = file_get_contents($cat . "/page/" . $page );
            }
        }
        $newlines = array("\t","\n","\r","\x20\x20","\0","\x0B");
        $content = str_replace($newlines, "", html_entity_decode($content));


        //
        //<div class="posti_inside">
        preg_match_all("/<div class=\"paneleft\"><a href=\"(.*)\" title=\"(.*)\"><img src=\"(.*)\"/siU", $content, $movies, PREG_SET_ORDER);
        //preg_match_all("|<div class\=\"paneleft\">(.*)</div>|U", $content, $movies, PREG_SET_ORDER);
        foreach ($movies as $value) {
            $image = urldecode($value[3]);
            if( (!strpos($image,"jpg") && !strpos($image,"jpeg") && !strpos($image,"gif") && !strpos($image,"png")) ) {
                $image = XTREAMER_IMAGE_PATH . "background/nocover.jpg";
            }
            if(strpos($image,"&")) {
                $image = substr($image, 0, strpos($image,"&"));
            }
            //Check for specific images
            if(strpos($image,"idown.me/resize.php?img=")) {
                $image = "http://www.idown.me/files/downloads" . substr($image, strrpos($image,"/"));
            }
            $template->addItem(
                    $value[2],
                    "",
                    SCRAPER_URL . "index.php?"."title=".base64_encode($value[2]).URL_AMP."movieId=".base64_encode($value[1]).URL_AMP."image=".base64_encode($image) . URL_AMP . "PHPSESID=" . session_id(),
                    $image
            );


        }
        $template->generateView(MyvodtvTemplate::VIEW_MOVIE, $title );
    }
}

//------------------------------------------------------------------------------
//------------------------------------------------------------------------------

function fetchMovie($movieId,$title,$movieImage) {
    global $template;
    $content = file_get_contents( $movieId );
    $newlines = array("\t","\n","\r","\x20\x20","\0","\x0B");
    $content = str_replace($newlines, "", html_entity_decode($content));

    //Check for different format
    preg_match("/<div class\=\"singletext\">(.*)<p><img src\=\"(.*)\"(.*)>(.*)<\/p>/U",$content,$divs);
    if( strpos($divs[4],"br />" )) {
        preg_match("/<div class\=\"singletext\">(.*)<p><img src\=\"(.*)\"(.*)><br \/>(.*)<\/p>/U",$content,$divs);
        if($divs) {
            $description = $divs[4];
            $template->setDescription($description);
            $image = $divs[2];
            $template->setImage($image);
        }

    }else {
        $newlines = array("<strong>","</strong>");
        preg_match("/<div class\=\"singletext\">(.*)<p><img src\=\"(.*)\"(.*)>(.*)<\/p><p>(.*)<\/p>/U",$content,$divs);
        if($divs) {
            $description = str_replace($newlines, "", $divs[5]);
            $template->setDescription($description);
            $image = $divs[2];
            $template->setImage($image);
        }
    }

    //<li class="online">
    //Get film avaible links
    if( strpos($content, "http://www.megavideo.com/v" ) ) {
        preg_match_all("|www.megavideo.com\/v\/(.*)\"|U", $content, $links);
        if($links && $links[1]) {
            $links = $links[1];
            $links = array_unique( $links );
            foreach ($links as $value) {
                //Get megavideo id
                if( strlen($value) > 40 ){
                    $value = separateMegavideoIdWithImage($value);
	            	$megavideo_id = $value[0];
                }else{
                    $megavideo_id = substr($value, 0, -32);
                }
                if( $megavideo_id ) {
                    //If megaupload cookie is defined, use it, in other case, use alternative method
                    if( COOKIE_STATE_ACTIVATED ) {
                        //generateMegavideoPremiumLink($tempTitle, $imageUrl, $counter, $megavideo_id);
                        $array = VideoUtil::generateMegavideoPremiumLink($megavideo_id);
                        $unicodeLink =  html_entity_decode($array[1], ENT_QUOTES, "UTF-8");
                        $unicodeTitle = html_entity_decode($array[0], ENT_QUOTES, "UTF-8");

                        $template->addMediaItem(
                                $unicodeTitle,
                                "",
                                $unicodeLink,
                                $movieImage,
                                $array[2]
                        );
                    }
                }
            }
        }


    }else if( strpos($content, "http://www.youtube.com/v" ) ) {
//        $link = substr($content, strpos($content, "http://www.youtube.com/v"));
//        $link = substr($link, strpos($link, "v/")+2);
//        $link = "http://www.youtube.com/get_video?video_id=" . substr($link, 0, strpos($link,"&"));
//        $template->addMediaItem(
//                "[Youtube] ".$title,
//                "",
//                $link,
//                $movieImage,
//                "video/x-flv"
//        );
    }

    $template->generateView(MyvodtvTemplate::VIEW_PLAY, $title );
}

function separateMegavideoIdWithImage($idWithImage){
        $content = file_get_contents("http://www.megavideo.com/v/" . $idWithImage );
        foreach ($http_response_header as $value) {
            if( strpos( $value, "ocation: " ) ){
                $value = strstr($value, "=" );
                $image = substr($value, 1, strpos($value,"&")-1  );
                $value = strstr($value, "v=" );
                $id = substr($value, 2  );
                return array( $id, $image );
            }
        }
    }

?>