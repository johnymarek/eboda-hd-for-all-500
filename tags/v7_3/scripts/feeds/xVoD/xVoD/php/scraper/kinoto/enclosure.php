<?php
/*-------------------------
 *    Developed by Maicros
 *     GNU/GPL v2 Licensed
 * ------------------------*/

include_once "../../config/config.php";
include_once "../../util/VideoUtil.php";

if(isset($_GET["item"])) {
    $url = base64_decode($_GET["item"]);
    fetchMovie($url);

}else if(isset($_GET["episode"])) {
    $episode = base64_decode($_GET["episode"]);
    fetchSerie($episode);

}else {
    echo "ERROR";
}

/**
 * Prints first available movie link.
 */
function fetchMovie($item) {
    //Parse movie page
    if(!strpos($item,"//kino.to")) {
        $item = "http://kino.to" . $item;
    }
    $content = file_get_contents($item,false,getExplorerContext(getSiteHash()));

    //Get Mirror list
    $mirrorList = strstr($content,"HosterList");
    $mirrorList = substr($mirrorList, 0, strpos($mirrorList, "</ul>"));
    preg_match_all("|rel\=\"(.*)\"(.*)<div class\=\"Named\">(.*)<\/div>|U", $mirrorList, $mirrors, PREG_SET_ORDER);

    foreach ($mirrors as $mirror) {
        $host = $mirror[3];
        $url = "http://kino.to/aGET/Mirror/" . str_replace("&amp;", "&", $mirror[1]);
        switch($host) {
            case "Megavideo.com";
                $link = addMegavideoLink($url);
                break;
            case "MyStream.to (Flash)";
                $link = addMyStreamToFlash($url);
                break;
            case "Various (Flash)":
                $link = addNovamovLink($url);
                break;
            case "Archiv.to (Flash)":
                $link = addArchivToFlash($url);
                break;
        }
        if($link) {
            echo $link;
            return;
        }
    }
    //
    echo "ERROR";
}

/**
 * Prints first available serie episode link.
 */
function fetchSerie($episode) {
    $content = file_get_contents( $episode, false, getExplorerContext(getSiteHash()) );
    preg_match_all("/rel=\"(.*)\"/siU", $content, $links, PREG_SET_ORDER);
    foreach ($links as $link) {
        $link = "http://kino.to/aGET/Mirror/" . html_entity_decode($link[1]);
        $content = file_get_contents( $link, false, getExplorerContext(getSiteHash()) );

        if( strpos($content, "Megavideo.com") ) {
            $fileLink = addMegavideoLink($link);
        }else if( strpos($content, "Bitload.com (Flash)") ) {
            $fileLink = addBitloadLink($link);
        }else if( strpos($content, "Various (Flash)") ) {
            $fileLink = addNovamovLink($link);
        }else if( strpos($content, "Archiv.to (Flash)") ) {
            $fileLink = addArchivToFlash($link);
        }
        if($fileLink) {
            echo $fileLink;
            return;
        }
    }
    //
    echo "ERROR";
}

function addMegavideoLink($url) {
    // ADD  &PartNo=1
    $content = file_get_contents($url,false,getExplorerContext( getSiteHash() ) );
    $content = str_replace( "\\", "", $content);

    //Get movie files
    preg_match("|www.megavideo.com\/v\/(.*)\"|U", $content, $links);
    if($links) {
        $megavideo_id = $links[1];
        if( COOKIE_STATE_ACTIVATED && $megavideo_id ) {
            $array = VideoUtil::generateMegavideoPremiumLink($megavideo_id);
            if($array) {
                return $array[1];
            }
        }
    }
}



function addNovamovLink($url) {
    $content = file_get_contents($url,false,getExplorerContext(getSiteHash()));
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
            return $newLink;
        }
    }
}

function addArchivToFlash($url) {
    $content = file_get_contents($url,false,getExplorerContext(getSiteHash()));
    $content = str_replace( "\\", "", $content);

    //Get mirror links
    preg_match_all("/http\:\/\/archiv\.to\/GET\/(.*)\"/U", $content, $parts, PREG_SET_ORDER);
    foreach ($parts as $part) {
        $content = file_get_contents("http://archiv.to/GET/".$part[1]);
        $content = strstr($content,"</object>");

        //Get final file link
        preg_match("|<a href=\"(.*)\"|U", $content, $link);
        if($link) {
            $link = $link[1];
            return $link;
        }
    }
}

function addBitloadLink($url) {
    $content = file_get_contents($url,false,getExplorerContext(getSiteHash()));
    $content = str_replace( "\\", "", $content);
	if (preg_match_all("/http\:\/\/www\.mystream\.to\/file-(.*)-(.*)-(.*)\"/U", $content, $parts2, PREG_SET_ORDER)){
	foreach ($parts2 as $part2) {
    $content = file_get_contents("http://www.bitload.com/f/".$part2[1]."/".$part2[2]."?m=def&c=free");

        //Get final file link
        preg_match_all("/{\"url\"\:\"(.*)\"/U", $content, $newLink);
        if($newLink) {
            $newLink = $newLink[1];
            $newLink = $newLink[0];
            return $newLink;
        			}
        }
    }
   else {
   preg_match_all("/http\:\/\/www\.bitload\.com\/f\/(.*)\"/U", $content, $parts, PREG_SET_ORDER);
    foreach ($parts as $part) {
    $content = file_get_contents("http://www.bitload.com/f/".$part[1]."?m=def&c=free");

        //Get final file link
        preg_match_all("/{\"url\"\:\"(.*)\"/U", $content, $newLink);
         if($newLink) {
            $newLink = $newLink[1];
            $newLink = $newLink[0];
            return $newLink;
            }
    	}
	}
}

/**
 * Create connection context to file_get_contents.
 */
function getExplorerContext($hash) {
    $opts = array(
            'http'=>array(
                    'method'=>"GET",
                    'header'=> "Host: kino.to\r\n".
                            "User-Agent: Mozilla/5.0 (Windows; U; Windows NT 5.1; es-ES; rv:1.9.2.10) Gecko/20100914 Firefox/3.6.10 (.NET CLR 3.5.30729)\r\n".
                            "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8\r\n".
                            "Accept-Language: es-es,es;q=0.8,en-us;q=0.5,en;q=0.3\r\n".
                            "Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7\r\n".
                            "Keep-Alive: 115\r\n".
                            "Connection: keep-alive\r\n".
                            "Cookie: AutoLangTry=Y; sitechrx=" . $hash . "; NewsHideInfoMsg=0; NewsListMode=genre; NewsGroupLimit=100; ListDisplayYears=Never; ListRating=Off; DataTables_RsltTable_genre2=%7B%22iStart%22%3A%200%2C%22iEnd%22%3A%2025%2C%22iLength%22%3A%2025%2C%22sFilter%22%3A%20%22%22%2C%22sFilterEsc%22%3A%20true%2C%22aaSorting%22%3A%20%5B%5D%2C%22aaSearchCols%22%3A%20%5B%20%5B''%2Ctrue%5D%2C%5B''%2Ctrue%5D%2C%5B''%2Ctrue%5D%2C%5B''%2Ctrue%5D%2C%5B''%2Ctrue%5D%2C%5B''%2Ctrue%5D%2C%5B''%2Ctrue%5D%5D%2C%22abVisCols%22%3A%20%5B%20true%2Ctrue%2Ctrue%2Ctrue%2Ctrue%2Ctrue%2Ctrue%5D%7D\r\n"
            )
    );
    //"Cookie: sitechrx=" . $hash . ";Path=/;\r\n"
    $context = stream_context_create($opts);
    return $context;
}

function getSiteHash() {
    if( isset ($_SESSION["hash"])) {
        $hash = $_SESSION["hash"];

    }else {
        $content = file_get_contents("http://kino.to",false,hashContext(false));
        preg_match("/src=\"(.*)\"/U", $content, $js);
        preg_match("/scf\(\'(.*)\'\,\'\/\'\)/U", $content, $scf);

        $content = file_get_contents("http://kino.to".$js[1],false,hashContext(true));
        preg_match("/escape\(hsh \+ \"(.*)\"\)/U", $content, $hsh);

        $hash = $scf[1] . $hsh[1];
    }

    $_SESSION["hash"] = $hash;
    return $hash;
}

function hashContext($referer) {
    $opts = array(
            'http'=>array(
                    'method'=>"GET",
                    'header'=> "Host: kino.to\r\n".
                            "User-Agent: Mozilla/5.0 (Windows; U; Windows NT 6.1; es-ES; rv:1.9.2.9) Gecko/20100824 Firefox/3.6.9\r\n".
                            "Accept: */*\r\n".
                            "Accept-Language: es-es,es;q=0.8,en-us;q=0.5,en;q=0.3\r\n".
                            "Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7\r\n".
                            "Keep-Alive: 115\r\n".
                            ( $referer ? "Referer: http://kino.to/Genre.html\r\n" : "" ).
                            "Cookie: AutoLangTry=Y\r\n"
            )
    );
    $context = stream_context_create($opts);
    return $context;
}



?>
