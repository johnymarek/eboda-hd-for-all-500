<?php
/*-------------------------
 *    Developed by Maicros
 *	  modified for hd-box.org
 *		by Mezzo v0.3
 *     GNU/GPL v2 Licensed
 * ------------------------*/

include_once '../../config/config.php';
include_once 'HdboxTemplate.php';
include_once "../../util/VideoUtil.php";
include_once "../../util/RssScriptUtil.php";
include_once '../../action/Action.php';
include_once '../../action/rss/SaveBookmarkAction.php';
include_once '../../action/rss/DeleteBookmarkAction.php';
define("SCRAPER_URL", SERVER_HOST_AND_PATH . "php/scraper/hdbox/");

$tmpcache      = '/tmp/lastquery.tmp';
$serverquery = !empty($_SERVER['QUERY_STRING']) ? $_SERVER['QUERY_STRING'] : "";


if(isset($_GET["download"]) && isset($_GET["link"]) && isset($_GET["title"])) {
   $extension = " > /dev/null 2>&1 & echo $!";
   $outputdir = "/tmp/hdd/volumes/HDD1/movie/";
   $outfile = $outputdir.utf8_encode($_GET["title"]).'.flv';
   $lastquery =  file_get_contents($tmpcache);
   $wget = "/opt/bin/wget";
   if ( !file_exists( $wget )){
        $lastquery .="&downloadmsg=WGET+PROGRAM+FEHLT";
   }else
        if ( file_exists( $outfile )){
        $lastquery .="&downloadmsg=FILM+EXISTIERT+BEREITS";     
   }
   else{
        chmod($wget, 0755);
        $command ="$wget ".$_GET["link"]." -O '".$outfile."'";
        exec($command.$extension, $op, $return_var );
        if ( 0 == $return_var ){
                $lastquery .="&downloadmsg=DOWNLOAD+ERFOLGREICH+GESTARTET";
        }else{
                $outfile = $outputdir.utf8_encode($_GET["title"]).'.wgeterror.txt';
                file_put_contents($outfile, $op );
                $lastquery .="&downloadmsg=DOWNLOAD+MISLUNGEN+VERSUCHS+SPAETER";        
        }
   }

   @header ( 'Location: '. SCRAPER_URL ."?$lastquery" );
}
else
if(isset($_GET["cat"])) {    //Category movie view -----------------------------
   if ($_GET["cat"] == "tv"){
    	fetchTvSender();
   }
	else 
   if ($_GET["cat"] == "top10"){
    	fetchTop10Movies();
   }
	else 
   if ($_GET["cat"] == "ov"){
    	fetchMovieByGenre();
   }
	else
   if ($_GET["cat"] == "imdb"){
    	fetchMovieByImdb();
   }
   else
   if ($_GET["cat"] == "jahr"){
    	fetchMovieByYear();
   } 
	else 
	if ($_GET["cat"] == "all"){
		fetchAllMovieByLetters();
	}
	else if ($_GET["cat"] == "akt"){
		fetchAktMovie();
	}
    else{
    	$category = base64_decode($_GET["cat"]);
    	$title = base64_decode($_GET["title"]);
    	fetchMovieCategoryItems($category,$title);
    }

}else if(isset($_GET["item"])) {    //Movie detail view -------------------------------
    $item = base64_decode($_GET["item"]);
    $title = base64_decode($_GET["title"]);
    $image = base64_decode($_GET["image"]);
    fetchMovie($item,$title,$image);
    file_put_contents($tmpcache, $serverquery );

}else if(isset($_GET["letter"])) {
    $letter = $_GET["letter"];
    fetchAllMovieItems($letter);

}else if(isset($_GET["search"])){
	 $type = $_GET["search"];
	 fetchSearch($type);
}else {    // Show home view --------------------------

     $template = new HdboxTemplate();

     $template->addItem(
        	"Alle Filme",
        	"",
     		SCRAPER_URL . "index.php?cat=all",
        	""
        );
     $template->addItem(
        	"Aktuelle",
        	"",
     		SCRAPER_URL . "index.php?cat=akt",
        	""
        );

     $template->addItem(
        	"Genres",
        	"",
     		SCRAPER_URL . "index.php?cat=ov",
        	""
        );
        
     $template->addItem(
        	"IMDB-Bewertung",
        	"",
     		SCRAPER_URL . "index.php?cat=imdb",
        	""
        );
        
     $template->addItem(
        	"Erscheinungsjahr",
        	"",
     		SCRAPER_URL . "index.php?cat=jahr",
        	""
        );
     $template->addItem(
        	"Top 10",
        	"",
     		SCRAPER_URL . "index.php?cat=top10",
        	""
        );
/*
     $template->addItem(
        	"TV Sender",
        	"",
     		SCRAPER_URL . "index.php?cat=tv",
        	""
        );
     $template->addItem(
        	"TV Programm",
        	"",
     		SCRAPER_URL . "index.php?cat=prog",
        	""
        );
*/
     $template->setSearch( array(
            resourceString("search_by") . "...",
            resourceString("search_by") . "...",
            "rss_command://search",
            SCRAPER_URL . "index.php?search=%s" . URL_AMP . "type=$type" . URL_AMP . "title=" . base64_encode("Search by"),
            ""
            )
     );

    $template->generateView(HdboxTemplate::VIEW_CATEGORY, "");

}


//------------------------------------------------------------------------------
//------------------------------------------------------------------------------

function fetchAllMovieItems($letter){
	$letter = strtolower($letter);
	$template = new HdboxTemplate();
    $template->setLetter($letter);

    //If page equal "x" goto page number list, in other case process actual category page
    if( isset($_GET["page"]) && $_GET["page"] == "x" ) {
        $maxPages = $_GET["pages"];
        for($i=1;$i<=$maxPages;++$i) {
            $template->addItem(
                    $i,
                    resourceString("goto_page") . $i,
                    SCRAPER_URL . "index.php?letter=" . $letter . URL_AMP . "page=" . $i . URL_AMP . "pages=" . $maxPages,
                    ""
            );
        }
        $template->generateView(HdboxTemplate::VIEW_PAGE_NUMBERS );

    }else {
        if(!isset($_GET["page"])) {
            $pages = getPages("/index.php?option=com_zoo&task=alphaindex&app_id=1&alpha_char=".$letter."&Itemid=3");
            $template->setActualPage(1);
            $template->setMaxPages($pages[1]);
            $content = $pages[0];
        }else {
            $template->setActualPage($_GET["page"]);
            $template->setMaxPages($_GET["pages"]);
            $content = file_get_contents("http://hd-box.org/index.php?option=com_zoo&task=alphaindex&app_id=1&alpha_char=".$letter."&Itemid=3&page=" . ($_GET["page"]));
            $newlines = array("\t","\n","\r","\x20\x20","\0","\x0B");
            $content = str_replace($newlines, "", html_entity_decode($content,ENT_QUOTES,"UTF-8"));
        }
    preg_match_all("/<div class=\"pos-media media-center\"> <a href=\"(.*)\" title=\"(.*)\"><img src=\"(.*)\" title=\"(.*)\"/siU", $content, $links, PREG_SET_ORDER);
    if($links) {
            foreach ($links as $link) {
                $template->addItem(
                        utf8_decode($link[2]),
                        "",
                        SCRAPER_URL . "index.php?title=" . base64_encode($link[2]) . URL_AMP . "item=" . base64_encode($link[1]) . URL_AMP . "image=" . base64_encode($link[3]),
                        $link[3]
                );
            }
        }
        $template->generateView(HdboxTemplate::VIEW_MOVIE, "");
        }
}



function fetchTvSender() {
    $template = new HdboxTemplate();

    $content = file_get_contents("http://hd-box.org/index.php?option=com_zoo&view=category&Itemid=35");
    $newlines = array("\t","\n","\r","\x20\x20","\0","\x0B");
    $content = str_replace($newlines, "", html_entity_decode($content));
    //var_dump($content);
    preg_match("/<div class=\"row first-row\"><div class=\"width25 first-item\">(.*)<\/div><\/div><\/div><\/div><\/div><\!-- END: CONTENT -->/U", $content, $content);
    //var_dump($content);
    /*
            [1] => /index.php?option=com_zoo&task=item&item_id=220&Itemid=35
            [2] => Sport1
            [3] => http://hd-box.org/cache/com_zoo/images/f55f9546c819b6deaca87c0837c05b1d.jpg
    */
	preg_match_all("/<a href=\"(.*)\" title=\"(.*)\"\><img src=\"(.*)\" title/U", $content[1], $links, PREG_SET_ORDER);
	//print_r( $links );

	foreach ( $links as $link ) {
        $template->addItem(
                utf8_decode($link[2]),
                "",
                SCRAPER_URL . "index.php?cat=" . base64_encode($link[1]),
                $link[3]
        );
    }
    $template->generateView(HdboxTemplate::VIEW_MOVIE, "");
}


function fetchMovieByImdb() {
    $template = new HdboxTemplate();

    $content = file_get_contents("http://hd-box.org/index.php?option=com_zoo&view=category&Itemid=3");
    $newlines = array("\t","\n","\r","\x20\x20","\0","\x0B");
    $content = str_replace($newlines, "", html_entity_decode($content));
    //var_dump($content);
    preg_match("/<div class=\"zoo-tag list-ordered\"><b>IMDB-Bewertung: <\/b>(.*)<\/div>/U", $content, $content);
    //var_dump($content);
	preg_match_all("/<a href=\"(.*)\">(.*)<\/a>/U", $content[1], $links, PREG_SET_ORDER);
	foreach ( $links as $link ) {
        $template->addItem(
                utf8_decode($link[2]),
                "",
                SCRAPER_URL . "index.php?cat=" . base64_encode($link[1]) . URL_AMP . "title=" . base64_encode($link[2]),
                ""
        );
    }
    $template->generateView(HdboxTemplate::VIEW_CATEGORY, "");
}

function fetchMovieByYear() {
    $template = new HdboxTemplate();

    $content = file_get_contents("http://hd-box.org/index.php?option=com_zoo&view=category&Itemid=3");
    $newlines = array("\t","\n","\r","\x20\x20","\0","\x0B");
    $content = str_replace($newlines, "", html_entity_decode($content));
    //var_dump($content);
    preg_match("/<div class=\"zoo-tag list-ordered\"><b>Erscheinungjahr: <\/b>(.*)<\/div>/U", $content, $content);
    //var_dump($content);
	preg_match_all("/<a href=\"(.*)\">(.*)<\/a>/U", $content[1], $links, PREG_SET_ORDER);
	foreach ( $links as $link ) {
	     $year = ( 20 < $link[2] )? "19".$link[2] : "20".$link[2];
        $template->addItem(
                utf8_decode($year),
                "",
                SCRAPER_URL . "index.php?cat=" . base64_encode($link[1]) . URL_AMP . "title=" . base64_encode($link[2]),
                ""
        );
    }
    $template->generateView(HdboxTemplate::VIEW_CATEGORY, "");
}

/**
 */
function fetchMovieByGenre() {
    $template = new HdboxTemplate();

    $content = file_get_contents("http://hd-box.org/index.php?option=com_zoo&view=category&Itemid=3");
    $newlines = array("\t","\n","\r","\x20\x20","\0","\x0B");
    $content = str_replace($newlines, "", html_entity_decode($content));
    //var_dump($content);
    preg_match("/<center><div class=\"zoo-tag list-ordered\"><b>Genre: <\/b>(.*)<\/div>/U", $content, $content);
    //var_dump($content);
	preg_match_all("/<a href=\"(.*)\">(.*)<\/a>/U", $content[1], $links, PREG_SET_ORDER);
	foreach ( $links as $link ) {
        $template->addItem(
                utf8_decode($link[2]),
                "",
                SCRAPER_URL . "index.php?cat=" . base64_encode($link[1]) . URL_AMP . "title=" . base64_encode($link[2]),
                ""
        );
    }
    $template->generateView(HdboxTemplate::VIEW_CATEGORY, "");
}

/**
 */

function fetchMovieCategoryItems($category,$title,$search=null) {
    $template = new HdboxTemplate();
    $template->setCategory($category);


    //If page equal "x" goto page number list, in other case process actual category page
    if( isset($_GET["page"]) && $_GET["page"] == "x" ) {
        $maxPages = $_GET["pages"];
        for($i=1;$i<=$maxPages;++$i) {
            $template->addItem(
                    $i,
                    resourceString("goto_page") . $i,
                    SCRAPER_URL . "index.php?cat=" . base64_encode($category) . URL_AMP . "page=" . $i . URL_AMP . "pages=" . $maxPages,
                    ""
            );
        }
        $template->generateView(HdboxTemplate::VIEW_PAGE_NUMBERS );

    }else {
        if(!isset($_GET["page"])) {
            $pages = getPages($category);
            $template->setActualPage(1);
            $template->setMaxPages($pages[1]);
            $content = $pages[0];
        }else {
            $template->setActualPage($_GET["page"]);
            $template->setMaxPages($_GET["pages"]);
            $content = file_get_contents("http://hd-box.org". $category . "&page=" . ($_GET["page"]));
            $newlines = array("\t","\n","\r","\x20\x20","\0","\x0B");
            $content = str_replace($newlines, "", html_entity_decode($content,ENT_QUOTES,"UTF-8"));
        }
        preg_match_all("/<div class=\"pos-media media-center\"> <a href=\"(.*)\" title=\"(.*)\"><img src=\"(.*)\" title=\"(.*)\"/siU", $content, $links, PREG_SET_ORDER);
        if($links) {
            foreach ($links as $link) {
                $template->addItem(
                        utf8_decode($link[2]),
                        "",
                        SCRAPER_URL . "index.php?title=" . base64_encode($link[2]) . URL_AMP . "item=" . base64_encode($link[1]) . URL_AMP . "image=" . base64_encode($link[3]),
                        $link[3]
                );
            }
        }

        $template->generateView(HdboxTemplate::VIEW_MOVIE, "");
    }
}

/**
 */

function fetchAllMovieByLetters() {
    $template = new HdboxTemplate();
    $letters = array(
            "A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z","0"
    );
    foreach ($letters as $letter) {
        $template->addItem(
                $letter,
                resourceString("goto_letter") . $letter,
                SCRAPER_URL . "index.php?letter=" . $letter,
                ""
        );
    }
    $template->generateView(HdboxTemplate::VIEW_PAGE_NUMBERS );
}


/**
 */
function fetchMovie($movie,$title,$image) {
    $template = new HdboxTemplate();
    $template->setMovieTitle($title);
    $template->setImage($image);

    //Parse movie page
    $content = file_get_contents("http://hd-box.org".$movie);
    $newlines = array("\t","\n","\r","\x20\x20","\0","\x0B");
    $content = str_replace($newlines, "", html_entity_decode($content,ENT_QUOTES,"UTF-8") );
	preg_match("/<div class=\"element element-textareafirst\"><div><p align=\"justify\"><font size=\"3\" face=\"arial\">(.*)<\/font><\/p><\/div><\/div>/U", $content, $desc);
    $description = $desc;
    $template->setDescription($description[1]);

    //Get LOOMBO.COM
    preg_match("/src=\'http:\/\/loombo.com\/(.*)\'/U", $content, $popup);
    //var_dump($popup);
    $content = file_get_contents("http://loombo.com/".$popup[1]);
   //var_dump($content);
    preg_match("/\(\'flashvars\',\'file=(.*)\'\)\;/U", $content, $links);
    //var_dump($links);
    if($links) {
        $link = $links[1];
                    $template->addMediaItem(
                    substr($link, strrpos($link,"/")+1),
                    utf8_decode($description[1]),
                    $link,
                    "",
                    VideoUtil::getEnclosureMimetype($link)
            );
        }

	/* Get Vidbux

	//var_dump($content);
	preg_match("/SRC=\"http:\/\/www.vidbux.com\/(.*)\"/U", $content, $popup);
    //var_dump($popup);
    $content = file_get_contents("http://vidbux.com/".$popup[1]);
    preg_match("/flashvars=\"file=(.*)&type=(.*)\"/U", $content, $links);
    var_dump($links);
    if($links) {
        $link = $links[1];
                    $template->addMediaItem(
                    substr($link, strrpos($link,"/")+1),
                    utf8_decode($description[1]),
                    $link,
                    "",
                    VideoUtil::getEnclosureMimetype($link)
            );
        }
*/
    $template->generateView(HdboxTemplate::VIEW_MOVIE_DETAIL);
}
/**
 */
function fetchAktMovie() {
    $template = new HdboxTemplate();

    $content = file_get_contents("http://hd-box.org/index.php?option=com_zoo&view=category&Itemid=41");
    $newlines = array("\t","\n","\r","\x20\x20","\0","\x0B");
    $content = str_replace($newlines, "", html_entity_decode($content,ENT_QUOTES,"UTF-8") );
    preg_match_all("/<div class=\"pos-media media-center\"> <a href=\"(.*)\" title=\"(.*)\"><img src=\"(.*)\" title=\"(.*)\"/siU", $content, $links, PREG_SET_ORDER);
    //var_dump($links);
        if($links) {
            foreach ($links as $link) {
                $template->addItem(
                        utf8_decode($link[2]),
                        "",
                        SCRAPER_URL . "index.php?title=" . base64_encode($link[2]) . URL_AMP . "item=" . base64_encode($link[1]) . URL_AMP . "image=" . base64_encode($link[3]),
                        $link[3]
                );
            }
        }

        $template->generateView(HdboxTemplate::VIEW_MOVIE, "");
}


function fetchTop10Movies() {
    $template = new HdboxTemplate();

    $content = file_get_contents("http://hd-box.org/index.php?option=com_content&view=article&id=100517&Itemid=45");
    $newlines = array("\t","\n","\r","\x20\x20","\0","\x0B");

    $content = str_replace($newlines, "", html_entity_decode($content,ENT_QUOTES,"UTF-8") );
    preg_match_all("/<div class=\"media media-left\"> <a href=\"(.*)\" title=\"(.*)\"><img src=\"(.*)\" title=\"(.*)\"/siU", $content, $links, PREG_SET_ORDER);
    //print_r($links);
     if($links) {
         foreach ($links as $link) {
             $template->addItem(
                     utf8_decode($link[2]),
                     "",
                     SCRAPER_URL . "index.php?title=" . base64_encode($link[2]) . URL_AMP . "item=" . base64_encode($link[1]) . URL_AMP . "image=" . base64_encode($link[3]),
                     $link[3]
             );
         }
     }

     $template->generateView(HdboxTemplate::VIEW_MOVIE, "");
}


//------------------------------------------------------------------------------
//------------------------------------------------------------------------------

function getPages($url) {
    $content = file_get_contents("http://hd-box.org".$url);

    $newlines = array("\t","\n","\r","\x20\x20","\0","\x0B");
    $content = str_replace($newlines, "", html_entity_decode($content,ENT_QUOTES,"UTF-8"));

    //Get page list begin
    preg_match("/<a class=\"end\" href=\"\/index.php\?option=com_zoo&(.*)&page=(.*)&Itemid=(.*)\">/U", $content, $pages);

    if($pages) {
        $numPages = $pages[2];
    }else {
        $numPages = 1;
    }

	return array($content,$numPages);
}
function fetchSearch($type){
	$template = new HdboxTemplate();
	$content = file_get_contents("http://hd-box.org/index.php?searchword=".$type."&ordering=&searchphrase=all&option=com_search");
	$newlines = array("\t","\n","\r","\x20\x20","\0","\x0B");
    $content = str_replace($newlines, "", html_entity_decode($content,ENT_QUOTES,"UTF-8"));

    preg_match_all("/<\/span><a href=\"(.*)\">(.*)<\/a><\/div>/U", $content, $results, PREG_SET_ORDER);

    if($results){

    	foreach ($results as $link){
    			        $template->addItem(
                        utf8_decode($link[2]),
                        "",
                        SCRAPER_URL . "index.php?title=" . base64_encode($link[2]) . URL_AMP . "item=" . base64_encode($link[1]),
                        ""
                );
            }

    }
 $template->generateView(HdboxTemplate::VIEW_MOVIE, "");


}

?>
