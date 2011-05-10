<?php
/*-------------------------
 *    Developed by Maicros
 *     GNU/GPL v2 Licensed
 * ------------------------*/

include_once "../../config/config.php";
include_once "../../util/VideoUtil.php";

if(isset($_GET["seasonNum"]) && isset($_GET["episode"])) {
    $season = $_GET["seasonNum"];
    $episode = $_GET["episode"];
    fetchEpisode($season,$episode);
}

/**
 * Prints first available movie link.
 */
function fetchEpisode($season,$episode) {
    if(isset($_GET["PHPSESID"])) {
        session_id($_GET["PHPSESID"]);
        session_start();
        $serie = unserialize( $_SESSION["serie"] );
        $link = $serie[$season];
        $link = $link[$episode];
        $episodeLink = $link[1];

        $content = file_get_contents($episodeLink);
        $newlines = array("\t","\n","\r","\x20\x20","\0","\x0B");
        $input = str_replace($newlines, "", utf8_decode( $content) );
        preg_match("/<h5>Available Sources<\/h5>(.*)<\/div>/U", $input, $div);

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
                                if($array) {
                                    echo $array[1];
                                    return;
                                }
                            }
                        }
                    }
                }
            }
        }

    }
    echo "ERROR";
}



?>
