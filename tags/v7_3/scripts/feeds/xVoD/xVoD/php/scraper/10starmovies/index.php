<?php

/* -------------------------
 *    Developed by Maicros
 *		modified by Mezzo
 *		 to use loombo
 *    GNU/GPL v2  Licensed
 * ------------------------ */

include_once '../../config/config.php';
include_once 'TenstarmoviesTemplate.php';
include_once "../../util/VideoUtil.php";
include_once "../../util/RssScriptUtil.php";
include_once '../../action/Action.php';
include_once '../../action/rss/SaveBookmarkAction.php';
include_once '../../action/rss/DeleteBookmarkAction.php';
define("SCRAPER_URL", SERVER_HOST_AND_PATH . "php/scraper/10starmovies/");
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

if (isset($_GET["serie"])) {
    $serieLink = base64_decode($_GET["serie"]);
    $serieTitle = base64_decode($_GET["title"]);
    fetchSerie($serieLink, $serieTitle);

}else if (isset($_GET["season"])) {
    $season = $_GET["season"];
    fetchSeason($season);

}else if (isset($_GET["episode"])) {
    $season = $_GET["seasonNum"];
    $episode = $_GET["episode"];
    $episodeName = base64_decode($_GET["episodeName"]);
    fetchEpisode($season,$episode,$episodeName);

} else {
    fetchSeries();

}

//------------------------------------------------------------------------------
//------------------------------------------------------------------------------

function fetchEpisode($season,$episode,$episodeName) {
    $template = new TenstarmoviesTemplate();
    if(isset($_GET["PHPSESID"])) {
        session_id($_GET["PHPSESID"]);
        session_start();
        $serie = unserialize( $_SESSION["serie"] );
        $coverImage = $_SESSION["coverImage"];
        $title = $_SESSION["title"];
        $link = $serie[$season];
        $link = $link[$episode];
        $episodeLink = $link[1];
        $template->setEpisodeName($episodeName);
        $template->setCoverImage($coverImage);
        $template->setTitle($title);

        $content = file_get_contents($episodeLink);
        $newlines = array("\t","\n","\r","\x20\x20","\0","\x0B");
        $input = str_replace($newlines, "", utf8_decode( $content) );
        preg_match("/<script type=\"text\/javascript\"> function loadinitial(.*)<div id=\"video_loading_stat\">/U", $input, $div);
        
        //Get episode description
        if(strpos($input,"<div id=\"incomplete")) {
            preg_match("/<div id\=\"incomplete\" style\=\"display\:block\;\">(.*)</U", $input, $des);
        }else {
            preg_match("/<div class\=\"sum\">(.*)</U", $input, $des);
        }
        if($des) {
            $template->setDescription($des[1]);
        }

        //LOOMBO
		     if($div && strpos($div[1],"loombo")) {
        	$div2 = $div;
            preg_match_all("/<span>(.*)<\/span>/siU", $div2[1], $div2);
        
            //Get only loombo
            if( $div2) {
                $i2 = 0;
                foreach ($div2[1] as $value2) {
                    	if(strpos($value2,"loombo")) {
                        preg_match("/load_source_new\((.*)\,/U", $value2, $id2);
                        $loombo_id = file_get_contents(substr($episodeLink,0,strrpos($episodeLink,"/")) . "/play_source.php?id=".$id2[1]);
                        preg_match("/href=\"http:\/\/loombo\.com\/(.*)\"/U", $loombo_id, $loombo_id);
                        if( $loombo_id ) {
   						$content = file_get_contents("http://loombo.com/embed-".$loombo_id[1]."-0x0.html");
   						preg_match("/\(\'flashvars\',\'file=(.*)\'\)\;/U", $content, $links);
                            if($links) {
								    $link = $links[1];
                                    $template->addMediaItem(
                                            "[Loombo " . $i2 . "]",
                                            substr($link, strrpos($link,"/")+1),
                                            $link,
                                            "",
                                           VideoUtil::getEnclosureMimetype($link)
                                    );
                                    ++$i2;
                                }
                            }
                        }
                         if($i2 > 1) {
                       break;
                  }
                    }
                }
            }

        //MEGAVIDEO

        if($div && strpos($div[1],"megavideo")) {
            preg_match_all("/<span>(.*)<\/span>/siU", $div[1], $div);
            //Get only megavideos
            if( $div) {
                $i = 0;
                foreach ($div[1] as $value) {
                    	if(strpos($value,"megavideo")) {
                        preg_match("/load_source_new\((.*)\,/U", $value, $id);
                        $megavideo_id = file_get_contents(substr($episodeLink,0,strrpos($episodeLink,"/")) . "/play_source.php?id=".$id[1]);
                        preg_match("/megavideo.com\/\?v\\=(.*)\"/U", $megavideo_id, $megavideo_id);
                        if( $megavideo_id ) {
                            $megavideo_id = $megavideo_id[1];
                        if( COOKIE_STATE_ACTIVATED ) {
                                $array = VideoUtil::generateMegavideoPremiumLink($megavideo_id);
                                if( $array && $array[2]) {
                                    $template->addMediaItem(
                                            "[Megavideo " . $i . "]",
                                            $array[0],
                                            $array[1],
                                            "" . $megavideo_id,
                                            $array[2]
                                    );
                                    ++$i;
                                }
                            }
                        }
                    }
                    if($i > 1) {
                        break;
                    }
                }
            }
        }
        $template->generateView(TenstarmoviesTemplate::VIEW_PLAY, $episodeName );
    }
}

//------------------------------------------------------------------------------
//------------------------------------------------------------------------------

function fetchSeason($season) {
    $template = new TenstarmoviesTemplate();
    //Recover from session
    if(isset($_GET["PHPSESID"])) {
        session_id($_GET["PHPSESID"]);
        session_start();
        $backgroundImage = $_SESSION["backgroundImage"];
        $coverImage = $_SESSION["coverImage"];
        $description = $_SESSION["description"];
        $headerImage = $_SESSION["headerImage"];
        $title = $_SESSION["title"];
        $serie = unserialize( $_SESSION["serie"] );

        //Set data to template
        $template->setEpisode($serie[$season]);
        $template->setSelectedSeason($season);
        $template->setBackgroundImage($backgroundImage);
        $template->setCoverImage($coverImage);
        $template->setDescription($description);
        $template->setHeaderImage($headerImage);
        $template->setTitle($title);
        $template->setSerie($serie);

        //Show template view
        $template->generateView(TenstarmoviesTemplate::VIEW_EPISODE);
    }
}

//------------------------------------------------------------------------------
//------------------------------------------------------------------------------

function fetchSerie($serieLink, $serieTitle) {
    $template = new TenstarmoviesTemplate();
    //GET HEADER IMAGE AND DESCRIPTION
    $content = file_get_contents($serieLink . "about.html");
    $newlines = array("\t","\n","\r","\x20\x20","\0","\x0B");
    $input = str_replace($newlines, "", utf8_decode( $content) );

    //Get header image, description and cover
    preg_match("/<div class\=\"header\-middle\" style\=\"background:url\((.*)\)\;(.*)<img src\=\"(.*)\"(.*)>(.*)<div style\=\"margin\-bottom\:10px\;\">(.*)<\/div>/U", $input, $div);
    if($div) {
        $headerImage = $div[1];
        $coverImage = $div[3];
        $description = $div[6];
    }

    //--------------------------------------------------------------------------
    // GET SEASONS AND EPISODES
    $content = file_get_contents($serieLink. "sitemap.xml");
    $newlines = array("\t", "\n", "\r", "\x20\x20", "\0", "\x0B");
    $input = str_replace($newlines, "", utf8_decode($content));
    //$input = strstr($input, "<td valign=\"top\" width=\"33%\">");
    preg_match_all("/<loc>(.*)<\/loc>/siU", $input, $div);
    $serie = array();
    if ($div) {
        $div = $div[1];
        $links = array();
        for ($i = count($div); $i >= 0; --$i) {
            $value = $div[$i];
            if (strpos($value, "Episode_")) {
                preg_match_all("/(.*)_Online_Season_(.*)_Episode_(.*)_(.*)\.html/siU", $value, $links);
                $seasonNum = $links[2];
                $episodeNum = $links[3];
                $episodeName = $links[4];
                if (!array_key_exists($seasonNum[0], $serie)) {
                    $serie[$seasonNum[0]] = array($episodeNum[0] => array( str_replace("_", " ", $episodeName[0]), $value ) );
                } else {
                    $season = $serie[$seasonNum[0]];
                    $season[$episodeNum[0]] = array( str_replace("_", " ", $episodeName[0]), $value );
                    $serie[$seasonNum[0]] = $season;
                }
            }
        }

        //Save all in session
        if(isset($_GET["PHPSESID"])) {
            session_id($_GET["PHPSESID"]);
            session_start();
            $_SESSION["backgroundImage"] = $backgroundImage;
            $_SESSION["coverImage"] = $coverImage;
            $_SESSION["description"] = $description;
            $_SESSION["headerImage"] = $headerImage;
            $_SESSION["title"] = $serieTitle;
            $_SESSION["serie"] = serialize($serie);
        }
        $template->setBackgroundImage($backgroundImage);
        $template->setCoverImage($coverImage);
        $template->setDescription($description);
        $template->setHeaderImage($headerImage);
        $template->setTitle($serieTitle);
        $template->setSerie($serie);
        $template->generateView(TenstarmoviesTemplate::VIEW_SEASON);
    }
}

//------------------------------------------------------------------------------
//------------------------------------------------------------------------------

function fetchSeries() {
    $template = new TenstarmoviesTemplate();
    $seriesLoaded = false;
    //Start session
    if(isset($_GET["PHPSESID"])) {
        session_id($_GET["PHPSESID"]);
    }
    session_start();

    //Check for loaded series on session
    if(isset($_SESSION["tenstarSeries"])) {
        $div = unserialize($_SESSION["tenstarSeries"]);
        $seriesLoaded = true;

    }else {
        //Get principal page and parse category list
        $content = file_get_contents("http://10starmovies.com/Tv-Shows/");
        $newlines = array("\t","\n","\r","\x20\x20","\0","\x0B");
        $input = str_replace($newlines, "", utf8_decode( $content) );
        $input = strstr($input, "<td valign=\"top\" width=\"33%\">");
        preg_match_all("/<div><a href\=\"(.*)\"(.*)<span class\=\\\'description\\\'>(.*)<\/span>(.*)\">(.*)<\/a><\/div>/U", $input, $div, PREG_SET_ORDER);
    }

    if($div) {
        foreach ($div as $value) {
            $serieName = html_entity_decode($value[5]);
            $description = $value[3];
            $link = $value[1];
            $serieLink = SCRAPER_URL . "index.php?serie=" . base64_encode($link) . URL_AMP . "title=" . base64_encode($serieName). URL_AMP . "PHPSESID=" . session_id();
            $template->addItem(
                    $serieName,
                    $description,
                    $serieLink,
                    ""
            );
        }
    }
    //If series has been loaded from page, save to session
    if(!$seriesLoaded){
        $_SESSION["tenstarSeries"] = serialize($div);
    }

    $template->generateView(TenstarmoviesTemplate::VIEW_SERIE, "10StarMovies TV-Series" );
}

?>
