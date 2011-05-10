<?php

if( isset($_GET['action']) ) {
    $changeValue = $_GET['action'];
    if( ($changeValue == 'SHOW_MEGAUPLOAD_LINKS' ) ||
            ($changeValue == 'SHOW_MEGAVIDEO_LINKS' ) ||
            ($changeValue == 'SHOW_MEGAVIDEO_LINKS_IN_HIGH_RESOLUTION' ) ||
            ($changeValue == 'SHOW_MEGAVIDEO_LINKS_IN_LOW_RESOLUTION' ) ) {
        changeBooleanParameter($changeValue);

    }else if( $changeValue == 'MODIFY_USER' ) {
        $user = $_GET['user'];
        changeMegauploadUser($user);

    }else if( $changeValue == 'MODIFY_COOKIE' ) {
        $cookie = getMegauploadCookie($_GET['user'],$_GET['pass']);
        //check for valid cookie
        $content = @file_get_contents("http://www.megavideo.com/xml/player_login.php?u=" . $cookie . "&v=");
        if( strpos($content, 'type="premium"') ) {
            changeCookieValue($cookie);
        }else {
            changeCookieValue("");
        }

    }else if( $changeValue == 'DELETE_COOKIE' ) {
        changeCookieValue("");
    }

}

include "config.php";

//Show setup menu to configure options
showSetupMenu();


//------------------------------------------------------------------------------
// Show setup menu
function showSetupMenu() {
    //Init header page and rss
    header("Content-type: text/xml");
    echo '<?xml version="1.0" encoding="UTF-16" ?>'."\n";
    echo '<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:media="http://purl.org/dc/elements/1.1/">'."\n";
    printHeader();
    echo '  <channel>'."\n";
    echo '  <title>xMegafilm - ' . resourceString("configure") . '</title>'."\n";

    $link = SERVER_HOST_AND_PATH . "php/config/setup.php?action=";
    showMenuLink(
            resourceString("title_return_menu"),
            SERVER_HOST_AND_PATH . "php/index.php",
            "",
            0
    );
    showMenuLink(
            resourceString("title_remove_cookie"),
            $link . 'DELETE_COOKIE',
            XTREAMER_IMAGE_PATH . "img/cookie_delete.jpg",
            1
    );
    showMenuChangeCookieLink(
            resourceString("title_modify_user") . " (Username: " . (MEGAUPLOAD_USER ? MEGAUPLOAD_USER : "------") . ")",
            SERVER_HOST_AND_PATH . "php/config/setup.php?user=%s".URL_AMP."action=MODIFY_USER",
            XTREAMER_IMAGE_PATH . "img/cookie_edit.jpg",
            2
    );
    showMenuChangeCookieLink(
            resourceString("title_modify_cookie") . " (Cookie: " . (MEGAUPLOAD_COOKIE ? MEGAUPLOAD_COOKIE : "------") . ")",
            SERVER_HOST_AND_PATH . "php/config/setup.php?pass=%s".URL_AMP."user=".MEGAUPLOAD_USER.URL_AMP."action=MODIFY_COOKIE",
            XTREAMER_IMAGE_PATH . "img/cookie_edit.jpg",
            3
    );
    //End rss file
    echo '  </channel>'."\n";
    echo '</rss>';
}

//------------------------------------------------------------------------------
// Show menu item
function showMenuLink($title,$link,$image,$itemid) {
    ?>
<item>
    <title><![CDATA[<? echo $title; ?>]]></title>
    <link><? echo $link; ?></link>
    <itemid><?php echo $itemid; ?></itemid>
    <media:thumbnail url="<? echo $image; ?>" />
</item>
    <?php
}

//------------------------------------------------------------------------------
// Show menu item
function showMenuChangeCookieLink($title,$link,$image,$itemid) {
    ?>
<item>
    <title><![CDATA[<? echo $title; ?>]]></title>
    <link>rss_command://search</link>
    <search url="<?php echo $link; ?>" />
    <itemid><?php echo $itemid; ?></itemid>
    <media:thumbnail url="<? echo $image; ?>" />
</item>
    <?php
}

/**
 * Change boolean value, given his name
 */
function changeBooleanParameter($name) {
    $lines = file("config.php");
    $out = "";
    foreach ($lines as $line) {
        if( strpos($line,$name) ) {
            $change = strstr($line,"true") ? true : false;
            $line = str_replace( $change?"true":"false", !$change?"true":"false", $line);
        }
        $out .= $line;
    }
    $f = fopen("config.php", "w");
    fwrite($f, $out);
    fclose($f);
}

function changeMegauploadUser($user) {
    $lines = file("config.php");
    $out = "";
    foreach ($lines as $line) {
        //Check for correct line
        if( strpos($line,'efine("MEGAUPLOAD_USER"') == 1 ) {
            $line = 'define("MEGAUPLOAD_USER", "' . $user . '");' . "\n";
        }
        $out .= $line;
    }
    $f = fopen("config.php", "w");
    fwrite($f, $out);
    fclose($f);
}

/**
 * Change cookie value
 * @var $value New cookie value to change.
 */
function changeCookieValue($value) {
    $lines = file("config.php");
    $out = "";
    foreach ($lines as $line) {
        //Check for correct line
        if( strpos($line,'efine("MEGAUPLOAD_COOKIE"') == 1 ) {
            $line = 'define("MEGAUPLOAD_COOKIE", "' . $value . '");' . "\n";
        }
        $out .= $line;
    }
    $f = fopen("config.php", "w");
    fwrite($f, $out);
    fclose($f);
}

/**
 * Login to megaupload and retrieve cookie.
 * @var string $username
 * @var string @password
 * @return string Megaupload cookie
 */
function getMegauploadCookie($username, $password) {
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

    foreach ( $http_response_header as $value) {
        if( stripos($value, "cookie") ) {
            $content = substr( $value, strpos($value,"=")+1);
            $content = substr( $content, 0, strpos($content,";") );
        }
    }
    return $content;

}

function printHeader() {
    ?>
<mediaDisplay name="photoView"
              showHeader="no" rowCount="5" columnCount="1" drawItemText="no" showDefaultInfo="no"
              itemImageXPC="100" itemImageYPC="100" itemOffsetXPC="18" itemOffsetYPC="10" sliding="yes"
              itemWidthPC="80" itemHeightPC="8" itemBorderColor="-1:-1:-1"
              idleImageXPC="90" idleImageYPC="5" idleImageWidthPC="5" idleImageHeightPC="8"
              bottomYPC="88" sideTopHeightPC="20" itemBackgroundColor="-1:-1:-1"
              backgroundColor="-1:-1:-1" sideColorBottom="-1:-1:-1" sideColorTop="-1:-1:-1"
              fontSize="18" imageBorderPC="0">
                      <?php xVoDLoader(); ?>

        <?php if( COOKIE_STATE_ACTIVATED ) { ?>
    <image redraw="no" offsetXPC="1" offsetYPC="20" widthPC="18" heightPC="32.5" >
                <? echo XTREAMER_IMAGE_PATH; ?>img/megaupload-act.png
    </image>
    <text redraw="no"
          backgroundColor="-1:-1:-1" foregroundColor="255:255:255"
          offsetXPC="4" offsetYPC="54" widthPC="14" heightPC="4" fontSize="16" lines="1">
                      <?php echo resourceString("title_cookie_on"); ?>
    </text>

            <?php }else { ?>
    <image redraw="no" offsetXPC="1" offsetYPC="20" widthPC="18" heightPC="32.5" >
                <? echo XTREAMER_IMAGE_PATH; ?>img/megaupload-des.png
    </image>
    <text redraw="no"
          backgroundColor="-1:-1:-1" foregroundColor="255:255:255"
          offsetXPC="2" offsetYPC="54" widthPC="16" heightPC="4" fontSize="16" lines="1">
                      <?php echo resourceString("title_cookie_off"); ?>
    </text>

            <?php } ?>

    <text redraw="no"
          backgroundColor="-1:-1:-1" foregroundColor="255:102:19"
          offsetXPC="25" offsetYPC="50" widthPC="80" heightPC="16" fontSize="14" lines="4">
                  <![CDATA[<?php echo resourceString("title_modify_cookie_help"); ?>]]>
    </text>

    <itemDisplay>
        <text redraw="yes"
              backgroundColor="-1:-1:-1"
              offsetXPC="0" offsetYPC="10" widthPC="100" heightPC="80" fontSize="16" lines="1">
            <script>
                getItemInfo(-1,"title");
            </script>
            <foregroundColor>
            	<script>
            		if( getFocusItemIndex() == getItemInfo(-1,"itemid") )
            			"0:154:205";
            		else
            			"255:255:255";
            	</script>
            </foregroundColor>
        </text>
    </itemDisplay>

    <backgroundDisplay>
        <image  offsetXPC="0" offsetYPC="0" widthPC="100" heightPC="100">
                <? echo XTREAMER_IMAGE_PATH; ?>background/setup.jpg
        </image>
    </backgroundDisplay>
</mediaDisplay>
    <?php
}

?>
