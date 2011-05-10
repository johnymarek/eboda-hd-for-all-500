<?php
/*-------------------------
 *    Developed by Maicros
 *      GNU/GPL Licensed
 * ------------------------*/


class ViewCookiePageAction extends Action {

    const SUBACTION_COOKIE = 0;
    const SUBACTION_COOKIE_REMOVE = 1;
    const SUBACTION_COOKIE_LOGIN = 2;
    const SUBACTION_COOKIE_MANUAL = 3;


    public function dispatch() {
	$template = new CookieMegavideoWebTemplate();
	$template->setUser( MEGAUPLOAD_USER );
        $template->setCookie( MEGAUPLOAD_COOKIE );
        $template->setActive(COOKIE_STATE_ACTIVATED);

        $subaction = $_GET["subaction"];
        switch( $subaction ) {
            case ViewCookiePageAction::SUBACTION_COOKIE: //--------------------------------
                break;

            case ViewCookiePageAction::SUBACTION_COOKIE_REMOVE: //-------------------------
                $this->changeCookieValue( "" );
                $this->changeMegauploadUser( "" );
                $template->setUser( "" );
        	$template->setCookie( "" );
		$template->setActive( false );
                break;

            case ViewCookiePageAction::SUBACTION_COOKIE_LOGIN: //--------------------------
                if( isset($_POST["user"]) && isset($_POST["pass"]) ){
                    $this->changeMegauploadUser($_POST["user"]);
                    $cookie = $this->getMegauploadCookie( $_POST["user"] , $_POST["pass"] );
                    $this->changeCookieValue( $cookie );
                    $template->setUser( $_POST["user"] );
                    $template->setCookie( $cookie );
                    $template->setActive( $this->checkCookie($cookie) );
                }
                break;

            case ViewCookiePageAction::SUBACTION_COOKIE_MANUAL: //-------------------------
                if( isset($_POST["cookie"]) ){
                    $this->changeCookieValue( $_POST["cookie"] );
                    $template->setCookie( $_POST["cookie"] );
                    $template->setActive( $this->checkCookie($_POST["cookie"]) );
                }
                break;

        }

        $template->show();

    }

    public static function getActionName() {
        return "viewWebCookiePage";
    }

    /**
     * Change boolean value, given his name
     */
    private function changeBooleanParameter($name) {
        $lines = file("config/config.php");
        $out = "";
        foreach ($lines as $line) {
            if( strpos($line,$name) ) {
                $change = strstr($line,"true") ? true : false;
                $line = str_replace( $change?"true":"false", !$change?"true":"false", $line);
            }
            $out .= $line;
        }
        $f = fopen("config/config.php", "w");
        fwrite($f, $out);
        fclose($f);
    }

    private function changeMegauploadUser($user) {
        $lines = file("config/config.php");
        $out = "";
        foreach ($lines as $line) {
            //Check for correct line
            if( strpos($line,'efine("MEGAUPLOAD_USER"') == 1 ) {
                $line = 'define("MEGAUPLOAD_USER", "' . $user . '");' . "\n";
            }
            $out .= $line;
        }
        $f = fopen("config/config.php", "w");
        fwrite($f, $out);
        fclose($f);
    }

    /**
     * Change cookie value
     * @var $value New cookie value to change.
     */
    private function changeCookieValue($value) {
        $lines = file("config/config.php");
        $out = "";
        foreach ($lines as $line) {
            //Check for correct line
            if( strpos($line,'efine("MEGAUPLOAD_COOKIE"') == 1 ) {
                $line = 'define("MEGAUPLOAD_COOKIE", "' . $value . '");' . "\n";
            }
            $out .= $line;
        }
        $f = fopen("config/config.php", "w");
        fwrite($f, $out);
        fclose($f);
    }

    /**
     * Login to megaupload and retrieve cookie.
     * @var string $username
     * @var string @password
     * @return string Megaupload cookie
     */
    private function getMegauploadCookie($username, $password) {
        $link = "http://www.megaupload.com";
        $postdata = http_build_query(
                array(
                'username' => $username,
                'password' => $password,
                'login' => '1',
                'redir' => '1'
                )
        );
        $opts = array('http' =>
                array(
                        'method'  => 'POST',
                        'header'  => 'Content-type: application/x-www-form-urlencoded',
                        'content' => $postdata
                )
        );
        $context  = stream_context_create($opts);
        $content = file_get_contents($link, false, $context);
	$megauploadCookie = "";

        foreach ( $http_response_header as $value) {
            if( stripos($value, "cookie") ) {
                $content = substr( $value, strpos($value,"=")+1);
                $megauploadCookie = substr( $content, 0, strpos($content,";") );
            }
        }
        return $megauploadCookie;

    }

    private function checkCookie($cookie){
        $content = @file_get_contents("http://www.megavideo.com/xml/player_login.php?u=" . $cookie . "&v=");
        if( strpos($content, 'type="premium"') ){
	        return true;
        }else{
	        return false;
        }
    }

}

?>