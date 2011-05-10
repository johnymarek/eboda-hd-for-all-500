<?php
/*-------------------------
 *    Developed by Maicros
 *      GNU/GPL Licensed
 * ------------------------*/
include_once '../../config/config.php';
include_once 'KinotoTemplate.php';
include_once "../../util/VideoUtil.php";
include_once "../../util/RssScriptUtil.php";
include_once '../../action/Action.php';
include_once '../../action/rss/SaveBookmarkAction.php';
include_once '../../action/rss/DeleteBookmarkAction.php';
define("SCRAPER_URL", SERVER_HOST_AND_PATH . "php/scraper/kinoto/");

if(isset ($_GET["params"])) {
    $title = base64_decode($_GET["title"]);
    $params = base64_decode($_GET["params"]);
    $host = base64_decode($_GET["host"]);
    $image = base64_decode($_GET["image"]);

    $template = new KinotoTemplate();
    $template->setMovieTitle($title);
    $template->setImage($image);

    $url = "http://kino.to/aGET/Mirror/" . str_replace("&amp;", "&", $params);

    switch($host) {
        case "Megavideo.com";
            addMegavideoLink($template,$url);
            break;
        case "Bitload.com (Flash)";
            addBitloadLink($template,$url);
            break;
        case "Bitload.com (DivX)";
            addBitloadDivxLink($template,$url);
            break;
        case "Various (Flash)":
            addNovamovLink($template,$url);
            break;
        case "Archiv.to (Flash)":
            addArchivToFlash($template,$url);
            break;
        case "Archiv.to (DivX)":
            addArchivToDivx($template,$url);
            break;
    }
    $template->generateView(KinotoTemplate::VIEW_PLAY);

}


function addMegavideoLink($template,$url) {
    // ADD  &PartNo=1
    $content = file_get_contents($url,false,getExplorerContext( getSiteHash() ) );
    $content = str_replace( "\\", "", $content);

    //Get movie files
    preg_match_all("/PartNo=(.*)\"/U", $content, $parts, PREG_SET_ORDER);
    if($parts) {
        foreach ($parts as $part) {
            $content = file_get_contents($url."&PartNo=".$part[1],false,getExplorerContext(getSiteHash()));
            $content = str_replace( "\\", "", $content);
            preg_match("|www.megavideo.com\/v\/(.*)\"|U", $content, $links);
            if($links) {
                $megavideo_id = $links[1];
                if( COOKIE_STATE_ACTIVATED && $megavideo_id ) {
                    $array = VideoUtil::generateMegavideoPremiumLink($megavideo_id);
                    if($array) {
                        $template->addMediaItem(
                                $array[0],
                                "",
                                $array[1],
                                "",
                                $array[2]
                        );
                    }
                }
            }

        }

    }else {
        preg_match("|www.megavideo.com\/v\/(.*)\"|U", $content, $links);
        if($links) {
            $megavideo_id = $links[1];
            if( COOKIE_STATE_ACTIVATED && $megavideo_id ) {
                $array = VideoUtil::generateMegavideoPremiumLink($megavideo_id);
                if($array) {
                    $template->addMediaItem(
                            $array[0],
                            "",
                            $array[1],
                            "",
                            $array[2]
                    );
                }
            }
        }
    }
}



function addNovamovLink($template,$url) {
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
            $template->addMediaItem(
                    substr($newLink, strrpos($newLink,"/")+1),
                    "",
                    $newLink,
                    "",
                    VideoUtil::getEnclosureMimetype($newLink)
            );
        }
    }
}

function addArchivToFlash($template,$url) {
    $content = file_get_contents($url,false,getExplorerContext(getSiteHash()));
    $content = str_replace( "\\", "", $content);

    //Get mirror links
       if (preg_match_all("/http\:\/\/archiv\.to\/GET\/(.*)\"/U", $content, $parts2, PREG_SET_ORDER)){
      foreach ($parts2 as $part2) {
        $content = file_get_contents("http://archiv.to/GET/".$part2[1]);
        //$content = strstr($content,"</object>");

        //Get final file link
        preg_match("/value=\"file=(.*)\&(.*)\"/U", $content, $link);

        if($link) {
        $link = $link[1];
                    $template->addMediaItem(
                    substr($link, strrpos($link,"/")+1),
                    "",
                    $link,
                    "",
                    VideoUtil::getEnclosureMimetype($link)
            );
        }
     }
  }
     else{
     preg_match_all("/http\:\/\/archiv\.to\/view\/flv\/(.*)\"/U", $content, $parts, PREG_SET_ORDER);
        foreach ($parts as $part) {
        $content = file_get_contents("http://archiv.to/view/flv/".$part[1]);
        //$content = strstr($content,"</object>");

        //Get final file link
        preg_match("/value=\"file=(.*)\&(.*)\"/U", $content, $link);
        if($link) {
        $link = $link[1];
                    $template->addMediaItem(
                    substr($link, strrpos($link,"/")+1),
                    "",
                    $link,
                    "",
                    VideoUtil::getEnclosureMimetype($link)
            );
        }
    }
  }
}

function addArchivToDivx($template,$url) {
    $content = file_get_contents($url,false,getExplorerContext(getSiteHash()));
    $content = str_replace( "\\", "", $content);

   	 if (preg_match_all("/http\:\/\/archiv\.to\/GET\/(.*)\"/U", $content, $parts2, PREG_SET_ORDER)){
      foreach ($parts2 as $part2) {
        $content = file_get_contents("http://archiv.to/GET/".$part2[1]);
        //$content = strstr($content,"</object>");

        //Get final file link
        preg_match("/value=\"(.*)\" name=\"src\"/U", $content, $link);

        if($link) {
        $link = $link[1];
                    $template->addMediaItem(
                    substr($link, strrpos($link,"/")+1),
                    "",
                    $link,
                    "",
                    VideoUtil::getEnclosureMimetype($link)
            );
        }
     }
  }
    else {
    //Get mirror links
    preg_match_all("/http\:\/\/archiv\.to\/view\/divx\/(.*)\"/U", $content, $parts, PREG_SET_ORDER);
        foreach ($parts as $part) {
        $content = file_get_contents("http://archiv.to/view/divx/".$part[1]);
        //$content = strstr($content,"</object>");

        //Get final file link
        preg_match("/value=\"(.*)\" name=\"src\"/U", $content, $link);
        if($link) {
        $link = $link[1];
                    $template->addMediaItem(
                    substr($link, strrpos($link,"/")+1),
                    "",
                    $link,
                    "",
                    VideoUtil::getEnclosureMimetype($link)
            );
        }
	  }
    }
}

function addBitloadLink($template,$url) {
    $content = file_get_contents($url,false,getExplorerContext(getSiteHash()));
    $content = str_replace( "\\", "", $content);
	if (preg_match_all("/http\:\/\/www\.mystream\.to\/file-(.*)-(.*)-(.*)\"/U", $content, $parts2, PREG_SET_ORDER)){
	foreach ($parts2 as $part2) {
        $content = getHeadersFlash('http://www.bitload.com/f/'.$part2[1]."/".$part2[2].'?m=def&c=free');

    preg_match("/Set-Cookie: PHPSESSID=(.*); path=\//", $headers[4], $sessionid);

    $content = file_get_contents("http://www.bitload.com/f/".$part2[1]."/".$part2[2]."?m=def&c=free&PHPSESSID=".$sessionid);

        //Get final file link
        preg_match_all("/autoPlay\":false,\"url\"\:\"(.*)\"/U", $content, $newLink);
        if($newLink) {
         $newLink = $newLink[1];
            $newLink = $newLink[0];
           			$template->addMediaItem(
                    substr($newLink, strrpos($newLink,"/")+1),
                    "",
                    $newLink,
                    "",
                    VideoUtil::getEnclosureMimetype($newLink)
         			);
        			}
        }
    }
   else {
   preg_match_all("/http\:\/\/www\.bitload\.com\/f\/(.*)\"/U", $content, $parts, PREG_SET_ORDER);

    foreach ($parts as $part) {

    $content = getHeadersFlash('http://www.bitload.com/f/'.$part[1].'?m=def&c=free');
    preg_match("/Set-Cookie: PHPSESSID=(.*); path=\//", $headers[4], $sessionid);
    $content = file_get_contents("http://www.bitload.com/f/".$part[1]."?m=def&c=free&PHPSESSID=".$sessionid);

        //Get final file link
        preg_match_all("/autoPlay\":false,\"url\"\:\"(.*)\"/U", $content, $newLink);

        if($newLink) {
         $newLink = $newLink[1];
            $newLink = $newLink[0];
           			$template->addMediaItem(
                    substr($newLink, strrpos($newLink,"/")+1),
                    "",
                    $newLink,
                    "",
                    VideoUtil::getEnclosureMimetype($newLink)
            		);
        			}
    	}
	}
}
function addBitloadDivxLink($template,$url) {
    $content = file_get_contents($url,false,getExplorerContext(getSiteHash()));
    $content = str_replace( "\\", "", $content);
	if (preg_match_all("/http\:\/\/www\.mystream\.to\/file-(.*)-(.*)-(.*)\"/U", $content, $parts2, PREG_SET_ORDER)){
	foreach ($parts2 as $part2) {

	 $content = getHeadersDivx('http://www.bitload.com/d/'.$part2[1]."/".$part2[2].'?m=def&c=free');

    preg_match("/Set-Cookie: PHPSESSID=(.*); path=\//", $headers[4], $sessionid);

    $content = file_get_contents("http://www.bitload.com/d/".$part2[1]."/".$part2[2]."?m=def&c=free&PHPSESSID=".$sessionid);

        //Get final file link
        preg_match_all("/var url = \'(.*)\'/U", $content, $newLink);
        if($newLink) {
         $newLink = $newLink[1];
            $newLink = $newLink[0];
           			$template->addMediaItem(
                    substr($newLink, strrpos($newLink,"/")+1),
                    "",
                    $newLink,
                    "",
                    VideoUtil::getEnclosureMimetype($newLink)
         			);
        			}
        }
    }
   else {
   preg_match_all("/http\:\/\/www\.bitload\.com\/d\/(.*)\"/U", $content, $parts, PREG_SET_ORDER);
    foreach ($parts as $part) {
     $content = getHeadersDivx('http://www.bitload.com/d/'.$part[1].'?m=def&c=free');

    preg_match("/Set-Cookie: PHPSESSID=(.*); path=\//", $headers[4], $sessionid);
    $content = file_get_contents("http://www.bitload.com/d/".$part[1]."?m=def&c=free&PHPSESSID=".$sessionid);
	//var_dump($content);
        //Get final file link
        preg_match_all("/var url = \'(.*)\'/U", $content, $newLink);
        //var_dump($newLink);

        if($newLink) {
         $newLink = $newLink[1];
            $newLink = $newLink[0];
           			$template->addMediaItem(
                    substr($newLink, strrpos($newLink,"/")+1),
                    "",
                    $newLink,
                    "",
                    VideoUtil::getEnclosureMimetype($newLink)
            		);
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
                            "Cookie: AutoLangTry=Y; PageLang=2; sitechrx=" . $hash . "; NewsHideInfoMsg=0; NewsListMode=genre; NewsGroupLimit=100; ListDisplayYears=Never; ListRating=Off; DataTables_RsltTable_genre2=%7B%22iStart%22%3A%200%2C%22iEnd%22%3A%2025%2C%22iLength%22%3A%2025%2C%22sFilter%22%3A%20%22%22%2C%22sFilterEsc%22%3A%20true%2C%22aaSorting%22%3A%20%5B%5D%2C%22aaSearchCols%22%3A%20%5B%20%5B''%2Ctrue%5D%2C%5B''%2Ctrue%5D%2C%5B''%2Ctrue%5D%2C%5B''%2Ctrue%5D%2C%5B''%2Ctrue%5D%2C%5B''%2Ctrue%5D%2C%5B''%2Ctrue%5D%5D%2C%22abVisCols%22%3A%20%5B%20true%2Ctrue%2Ctrue%2Ctrue%2Ctrue%2Ctrue%2Ctrue%5D%7D\r\n"
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

function getHeadersFlash($url)
{
	$path = parse_url($url);
	if (isset($path['query']))
	{
		$path['path'] .= '?' . $path['query'];
	}
	if (!isset($path['port']))
	{
		$path['port'] = 80;
	}

	$request	= "HEAD " . $path['path']. " HTTP/1.1\r\n";
	$request	.= "Host: " . $path['host'] . "\r\n";
	$request	.= "Content-type: application/x-www-form-urlencoded\r\n";
	$request	.= "Cache-Control: no-cache\r\n";
	$request	.= "User-Agent: MSIE\r\n";
	$request	.= "Connection: close\r\n";
	$request	.= "\r\n";

	$f = fsockopen($path['host'], $path['port'], $errno, $errstr);
	if ($f)
	{
	    fputs($f, $request);
	    while (!feof($f))
		{
			$headers[] = fgets($f);
		}

    preg_match("/Set-Cookie: PHPSESSID=(.*); path=\//", $headers[4], $sessionid);
    //var_dump(headers[4]);
    $content = file_get_contents($url."&PHPSESSID=".$sessionid);
	//var_dump($content);


	    fclose($f);
	}
	return $content;
	return $headers;
}

function getHeadersDivx($url)
{
	$path = parse_url($url);
	if (isset($path['query']))
	{
		$path['path'] .= '?' . $path['query'];
	}
	if (!isset($path['port']))
	{
		$path['port'] = 80;
	}

	$request	= "HEAD " . $path['path']. " HTTP/1.1\r\n";
	$request	.= "Host: " . $path['host'] . "\r\n";
	$request	.= "Content-type: application/x-www-form-urlencoded\r\n";
	$request	.= "Cache-Control: no-cache\r\n";
	$request	.= "User-Agent: MSIE\r\n";
	$request	.= "Connection: close\r\n";
	$request	.= "\r\n";

	$f = fsockopen($path['host'], $path['port'], $errno, $errstr);
	if ($f)
	{
	    fputs($f, $request);
	    while (!feof($f))
		{
			$headers[] = fgets($f);
		}

    preg_match("/Set-Cookie: PHPSESSID=(.*); path=\//", $headers[4], $sessionid);
    //var_dump(headers[4]);
    $content = file_get_contents($url."&PHPSESSID=".$sessionid);
	//var_dump($content);


	    fclose($f);
	}
	return $content;
	return $headers;
}









?>
