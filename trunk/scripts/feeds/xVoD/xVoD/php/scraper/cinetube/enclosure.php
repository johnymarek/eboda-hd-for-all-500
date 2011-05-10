<?php
/*-------------------------
 *    Developed by Maicros
 *     GNU/GPL v2 Licensed
 * ------------------------*/

include_once "../../config/config.php";
include_once "../../util/VideoUtil.php";

if(isset($_GET["type"])) {

    switch( $_GET["type"] ) {
        case "doc":
            break;

        case "mov":
            if(isset($_GET["item"])) {
                $item = base64_decode($_GET["item"]);
                printMovieAutoLink("http://www.cinetube.es" . $item);
            }
            break;

        case "ser":
            if(isset($_GET["episode"])) {
                $episodeLink = base64_decode($_GET["episode"]);
                printSerieEspisodeLink($episodeLink);
            }
            break;

        default:
            echo "ERROR";
            break;
    }

}

/**
 * Prints first available movie link.
 */
function printMovieAutoLink($url) {
    $content = file_get_contents( $url );
    $newlines = array("\t","\n","\r","\x20\x20","\0","\x0B");
    $content = str_replace($newlines, "", html_entity_decode($content));

    preg_match_all("/<div class\=\"tit_opts\"><a(.*)href\=\"(.*)\"(.*)><p\>(.*)<\/p><p\><span\>(.*)<\/span><\/p>(.*)<\/div>/siU", $content, $divs, PREG_SET_ORDER);
    if($divs) {
        foreach ($divs as $value) {
            $content = file_get_contents("http://www.cinetube.es" .  $value[2]);
            //Add video
            if( strpos($content, "www.megavideo.com/?v=" ) ) {
                preg_match_all("|www\.megavideo\.com\/\?v\=(.*)\"|U", $content, $links);
                if($links && $links[1]) {
                    $links = $links[1];
                    $links = array_unique( $links );
                    foreach($links as $megavideo_id ) {
                        if( COOKIE_STATE_ACTIVATED ) {
                            $array = VideoUtil::generateMegavideoPremiumLink($megavideo_id);
                            echo $array[1];
                            return;
                        }
                    }
                }
            }
        }
    }
    echo "ERROR";
}

/**
 * Prints first available episode link.
 */
function printSerieEspisodeLink($episodeLink) {
    //Get page content
    $content = file_get_contents( "http://www.cinetube.es" . $episodeLink );
    $newlines = array("\t","\n","\r","\x20\x20","\0","\x0B");
    $content = str_replace($newlines, "", html_entity_decode($content));

    //Get links
    preg_match_all("/<div class\=\"tit_opts\"><a(.*)href\=\"(.*)\"(.*)><p>(.*)<span(.*)span><\/p><p><span\>(.*)<\/span><\/p>(.*)<\/div>/siU", $content, $divs, PREG_SET_ORDER);
    //Get mirrors
    if($divs) {
        foreach ($divs as $value) {
            $content = file_get_contents("http://www.cinetube.es" .  $value[2]);
            //Add video
            if( strpos($content, "www.megavideo.com/?v=" ) ) {
                preg_match_all("|www\.megavideo\.com\/\?v\=(.*)\"|U", $content, $links);
                if($links && $links[1]) {
                    $links = $links[1];
                    $links = array_unique( $links );
                    foreach($links as $megavideo_id ) {
                        if( COOKIE_STATE_ACTIVATED ) {
                            $array = VideoUtil::generateMegavideoPremiumLink($megavideo_id);
                            echo $array[1];
                            return;
                        }
                    }
                }
            }
        }
    }
    echo "ERROR";
}

?>
