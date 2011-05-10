<?php
/*-------------------------
 *    Developed by Maicros
 *     GNU/GPL v2 Licensed
 * ------------------------*/

include_once "../../config/config.php";
include_once "../../util/VideoUtil.php";

if(isset($_GET["movieId"])) {
    $movieId = base64_decode($_GET["movieId"]);
    fetchMovie($movieId);
}

/**
 * Prints first available movie link.
 */
function fetchMovie($movieId) {
    $content = file_get_contents( "http://www.watchnewfilms.com/" . $movieId );
    $newlines = array("\t","\n","\r","\x20\x20","\0","\x0B");
    $content = str_replace($newlines, "", html_entity_decode($content));
    //Get film avaible links
    //Get principal megavideo link
    if( strpos($content, "http://www.megavideo.com/v" ) ) {
        preg_match_all("|www.megavideo.com\/v\/(.*)\"|U", $content, $links);
        if($links && $links[1]) {
            $links = $links[1];
            $links = array_unique( $links );
            foreach ($links as $value) {
                //Get megavideo id
                $megavideo_id = substr($value, 0, -32);

                if( $megavideo_id ) {
                    //If megaupload cookie is defined, use it, in other case, use alternative method
                    if( COOKIE_STATE_ACTIVATED ) {
                        //generateMegavideoPremiumLink($tempTitle, $imageUrl, $counter, $megavideo_id);
                        $array = VideoUtil::generateMegavideoPremiumLink($megavideo_id);
                        if($array) {
                            echo $array[1];
                            return;
                        }
                    }
                }
            }
        }

    }

    //Get alternative megavideo links
    if( strpos($content, "http://www.megavideo.com/?v=" ) ) {
        preg_match_all("/www.megavideo.com\/\?v\\=(.*)\'/U", $content, $links);
        if($links && $links[1]) {
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
                            echo $array[1];
                            return;
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
        echo VideoUtil::generateYoutubeLink(substr($link, 0, strpos($link,"&")));
        return;
    }
    

}


?>
