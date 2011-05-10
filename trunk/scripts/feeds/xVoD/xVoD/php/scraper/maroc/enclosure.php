<?php
/*-------------------------
 *    Developed by Maicros
 *     GNU/GPL v2 Licensed
 * ------------------------*/

include_once "../../config/config.php";
include_once "../../util/VideoUtil.php";

if(isset($_GET["item"])) {
    $item = base64_decode($_GET["item"]);
    fetchMovie($item);
}

/**
 * Prints first available movie link.
 */
function fetchMovie($movie) {
    $content = file_get_contents($movie);
    $newlines = array("\t","\n","\r","\x20\x20","\0","\x0B");
    $content = str_replace($newlines, "", html_entity_decode( $content,ENT_QUOTES,"UTF-8") );

    //Get megavideo id and link
    preg_match("/wwwstatic.megavideo.com\/mv_player.swf(.*)&v=(.*)\"/siU", $content, $links);
    if($links && $links[2]) {
        $megavideo_id = $links[2];
        if( COOKIE_STATE_ACTIVATED && $megavideo_id ) {
            $array = VideoUtil::generateMegavideoPremiumLink($megavideo_id);
            if($array) {
                echo $array[1];
		return;
            }
        }

    }

    echo "ERROR";
}


?>
