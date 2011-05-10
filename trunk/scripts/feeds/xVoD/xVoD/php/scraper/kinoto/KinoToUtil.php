<?php
/*-------------------------
 *    Developed by Maicros
 *      GNU/GPL Licensed
 * ------------------------*/

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
        $content = file_get_contents("http://kino.to",false,getHashContext(false));
        preg_match("/src=\"(.*)\"/U", $content, $js);
        preg_match("/scf\(\'(.*)\'\,\'\/\'\)/U", $content, $scf);

        $content = file_get_contents("http://kino.to".$js[1],false,getHashContext(true));
        preg_match("/escape\(hsh \+ \"(.*)\"\)/U", $content, $hsh);

        $hash = $scf[1] . $hsh[1];
    }

    $_SESSION["hash"] = $hash;
    return $hash;
}

function getHashContext($referer) {
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
