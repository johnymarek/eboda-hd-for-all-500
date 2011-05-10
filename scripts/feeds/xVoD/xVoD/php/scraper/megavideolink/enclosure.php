<?php
/*-------------------------
 *    Developed by Maicros
 *     GNU/GPL v2 Licensed
 * ------------------------*/

include_once "../../config/config.php";
include_once "../../util/VideoUtil.php";

if(isset($_GET["type"])) {

    switch( $_GET["type"] ) {
        case "mov":
            if(isset($_GET["item"])) {
                $item = base64_decode($_GET["item"]);
                printMovieAutoLink($item);
            }
            break;

        case "ser":
            if(isset($_GET["episode"])) {
                $episodeLink = base64_decode($_GET["episode"]);
                printSerieEpisodeLink($episodeLink);
            }
            break;

        default:
            echo "ERROR";
            break;
    }

}else{
    echo "ERROR";
}

/**
 * Prints first available movie link.
 */
function printMovieAutoLink($url) {
    $content = file_get_contents($url);
    $newlines = array("\t","\n","\r","\x20\x20","\0","\x0B");
    $content = str_replace($newlines, "", utf8_decode( $content) );

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
                    $megavideo_id = substr($value, 0, -32);
                }else {
                    $megavideo_id = $value;
                }
                if( COOKIE_STATE_ACTIVATED && $megavideo_id ) {
                    $array = VideoUtil::generateMegavideoPremiumLink($megavideo_id);
                    if($array) {
                        echo $array[1];
                        return;
                    }
                }
            }
        }

    }

    //Get megaupload links
    if( strpos($content, "www.megaupload.com/?d=" ) ) {
        preg_match_all("|www\.megaupload\.com\/\?d\=(.*)\s?\" class\=\"Stylehopbleu\"|U", $content, $links);
        if($links && $links[1]) {
            $links = $links[1];
            $links = array_unique( $links );

            foreach($links as $megaupload_id ) {
                if( COOKIE_STATE_ACTIVATED ) {
                    $array = VideoUtil::generateMegauploadPremiumLink($megaupload_id);
                    if($array) {
                        echo $array[1];
                        return;
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
function printSerieEpisodeLink($episodeLink) {
    //Get page content
    $content = file_get_contents( $episodeLink );
    $newlines = array("\t","\n","\r","\x20\x20","\0","\x0B");
    $content = str_replace($newlines, "", html_entity_decode(utf8_decode($content),ENT_QUOTES));

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
                    $megavideo_id = substr($value, 0, -32);
                }else {
                    $megavideo_id = $value;
                }
                //Show real link
                if( COOKIE_STATE_ACTIVATED && $megavideo_id ) {
                    $array = VideoUtil::generateMegavideoPremiumLink($megavideo_id);
                    if($array) {
                        echo $array[1];
                        return;
                    }
                }
            }
        }

    }
    echo "ERROR";
}

?>
