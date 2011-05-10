<?php
/*-------------------------
 *    Developed by Maicros
 *      GNU/GPL Licensed
 * ------------------------*/


class InitTemplate implements Template {

    private $title = null;
    private $favouriteMovieWebsite = null;
    private $favouriteSerieWebsite = null;
    private $favouriteDocumentaryWebsite = null;
    private $favouriteAnimeWebsite = null;

    public function  __construct($title=null) {
        $this->title = $title;
        $this->favouriteMovieWebsite = array("----","");
        $this->favouriteSerieWebsite = array("----","");
        $this->favouriteDocumentaryWebsite = array("----","");
        $this->favouriteAnimeWebsite = array("----","");
    }

    public function setFavouriteMovieWebsite(array $favouriteMovieWebsite) {
        $this->favouriteMovieWebsite = $favouriteMovieWebsite;
    }

    public function setFavouriteSerieWebsite(array $favouriteSerieWebsite) {
        $this->favouriteSerieWebsite = $favouriteSerieWebsite;
    }

    public function setFavouriteDocumentaryWebsite(array $favouriteDocumentaryWebsite) {
        $this->favouriteDocumentaryWebsite = $favouriteDocumentaryWebsite;
    }

    public function setFavouriteAnimeWebsite(array $favouriteAnimeWebsite) {
        $this->favouriteAnimeWebsite = $favouriteAnimeWebsite;
    }

    /**
     * Show template.
     */
    public function showTemplate() {
        header("Content-type: text/xml");
        echo '<?xml version="1.0" encoding="UTF-8" ?>'."\n";
        echo '<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:media="http://purl.org/dc/elements/1.1/">'."\n";

        $this->showHeader();

        echo '  <channel>'."\n";
        echo '      <title>' . $this->title . '</title>' . "\n";

        echo $this->getWebsitesLink(0);

        echo $this->getBookmarksLink(1);

        echo $this->getPlaylistLink(2);

        echo $this->getSetupLink(3);

        echo $this->getAboutLink(4);

        echo '  </channel>'."\n";
        echo '</rss>';
    }

    /**
     * Generate rss page config header.
     */
    private function showHeader() {
        ?>

<mediaDisplay name="photoView"
              rowCount="1" columnCount="5" drawItemText="no" showHeader="no" showDefaultInfo="no"
              menuBorderColor="255:255:255" sideColorBottom="-1:-1:-1"  sideColorTop="-1:-1:-1"
              itemOffsetXPC="71.5" itemOffsetYPC="69.5" itemWidthPC="4.7" itemHeightPC="8"
              backgroundColor="-1:-1:-1" itemBackgroundColor="-1:-1:-1" sliding="no" itemGap="0"
              idleImageXPC="90" idleImageYPC="5" idleImageWidthPC="5" idleImageHeightPC="8"
              imageUnFocus="null" imageParentFocus="null" imageBorderPC="0" forceFocusOnItem="yes" cornerRounding="yes"
              itemBorderColor="-1:-1:-1" focusBorderColor="-1:-1:-1" unFocusBorderColor="-1:-1:-1">
                          <?php xVoDLoader(); ?>

    <!-- PUZZLE IMAGE -->
    <image redraw="yes" offsetXPC="43.9" offsetYPC="71.6" widthPC="29.05" heightPC="6.09" backgroundColor="-1:-1:-1" >
                <? echo XTREAMER_IMAGE_PATH; ?>background/home_title.jpg
    </image>

    <!-- SELECTED MENU ITEM TITLE -->
    <text redraw="yes" backgroundColor="-1:-1:-1" foregroundColor="0:0:0"
          offsetXPC="49" offsetYPC="67.4" widthPC="25" heightPC="14" fontSize="20" lines="1">
        <script>
            getItemInfo("subtitle");
        </script>
    </text>

    <!-- FAVOURITES KEYS TITLES -->
    <text redraw="no" backgroundColor="-1:-1:-1" foregroundColor="0:0:0"
          offsetXPC="74.65" offsetYPC="41.9" widthPC="23" heightPC="2.85" fontSize="14" lines="1">
        <![CDATA[<?php echo resourceString("home_screen_favourite_websites"); ?>]]>
    </text>
    <text redraw="no" backgroundColor="-1:-1:-1" foregroundColor="255:255:255"
          offsetXPC="76.65" offsetYPC="47.62" widthPC="20.83" heightPC="2.85" fontSize="10" lines="1">
        <![CDATA[<?php echo resourceString("header_menu_movies") . " (" . $this->favouriteMovieWebsite[0] . ")"; ?>]]>
    </text>
    <text redraw="no" backgroundColor="-1:-1:-1" foregroundColor="255:255:255"
          offsetXPC="76.65" offsetYPC="53.34" widthPC="20.83" heightPC="2.85" fontSize="10" lines="1">
        <![CDATA[<?php echo resourceString("header_menu_series") . " (" . $this->favouriteSerieWebsite[0] . ")"; ?>]]>
    </text>
    <text redraw="no" backgroundColor="-1:-1:-1" foregroundColor="255:255:255"
          offsetXPC="76.65" offsetYPC="59.06" widthPC="20.83" heightPC="2.85" fontSize="10" lines="1">
        <![CDATA[<?php echo resourceString("header_menu_documentaries") . " (" . $this->favouriteDocumentaryWebsite[0] . ")"; ?>]]>
    </text>
    <text redraw="no" backgroundColor="-1:-1:-1" foregroundColor="255:255:255"
          offsetXPC="76.65" offsetYPC="64.78" widthPC="20.83" heightPC="2.85" fontSize="10" lines="1">
        <![CDATA[<?php echo resourceString("header_menu_anime") . " (" . $this->favouriteAnimeWebsite[0] . ")"; ?>]]>
    </text>

    <itemDisplay>
        <image redraw="yes" offsetXPC="0" offsetYPC="0" widthPC="100" heightPC="100" >
            <script>
                if( getFocusItemIndex() == getItemInfo(-1,"itemid") )
                    getItemInfo(-1,"imageover");
                else
                    getItemInfo(-1,"image");
            </script>
        </image>
    </itemDisplay>

    <onUserInput>
        <script>
            userInput = currentUserInput();
            if( userInput == "one" ){
                jumpToLink("favouriteMovieWebsite");
                redrawDisplay();
            }
            if(userInput == "two"){
                showIdle();
                jumpToLink("favouriteSerieWebsite");
                redrawDisplay();
            }
            if(userInput == "three"){
                showIdle();
                jumpToLink("favouriteDocumentaryWebsite");
                redrawDisplay();
            }
            if(userInput == "video_search"){
                showIdle();
                jumpToLink("favouriteAnimeWebsite");
                redrawDisplay();
            }
        </script>
    </onUserInput>

    <backgroundDisplay>
        <image  offsetXPC="0" offsetYPC="0" widthPC="100" heightPC="100">
                    <? echo XTREAMER_IMAGE_PATH; ?>background/home.jpg
        </image>
    </backgroundDisplay>
</mediaDisplay>

<favouriteMovieWebsite>
    <link>
            <?php echo $this->favouriteMovieWebsite[1] . "\n"; ?>
    </link>
</favouriteMovieWebsite>

<favouriteSerieWebsite>
    <link>
            <?php echo $this->favouriteSerieWebsite[1] . "\n"; ?>
    </link>
</favouriteSerieWebsite>

<favouriteDocumentaryWebsite>
    <link>
            <?php echo $this->favouriteDocumentaryWebsite[1] . "\n"; ?>
    </link>
</favouriteDocumentaryWebsite>

<favouriteAnimeWebsite>
    <link>
            <?php echo $this->favouriteAnimeWebsite[1] . "\n"; ?>
    </link>
</favouriteAnimeWebsite>

        <?php
    }

    /**
     * Get scraper rss link.
     */
    private function getWebsitesLink($itemid) {
        $name = resourceString("websites");
        $image = SERVER_HOST_AND_PATH . "image/img/websites.png";
        $imageover = SERVER_HOST_AND_PATH . "image/img/websites_over.png";
        $url = SERVER_HOST_AND_PATH . "php/index.php?action=" . ViewWebsitesPageAction::getActionName() . URL_AMP . "PHPSESID=" . session_id();
        return
                '<item>'."\n".
                '   <title><![CDATA[' . $name . ']]></title>'."\n".
                '   <subtitle>' . strtoupper($name) . '</subtitle>'."\n".
                '   <description><![CDATA[' . resourceString("show") . " " . $name . ']]></description>'."\n".
                '   <link>' . $url . '</link>'."\n".
                '   <media:thumbnail url="' . $image . '" />'."\n".
                '   <image>' . $image . '</image>'."\n".
                '   <imageover>' . $imageover . '</imageover>'."\n".
                '   <itemid>' . $itemid . '</itemid>'."\n".
                '</item>'."\n";
    }

    /**
     * Get setup rss link.
     */
    private function getSetupLink($itemid) {
        $name = resourceString("configure");
        $image = SERVER_HOST_AND_PATH . "image/img/config.png";
        $imageover = SERVER_HOST_AND_PATH . "image/img/config_over.png";
        $url = SERVER_HOST_AND_PATH . "php/config/setup.php?PHPSESID=" . session_id();
        return
                '<item>'."\n".
                '   <title><![CDATA[' . $name . ']]></title>'."\n".
                '   <subtitle>' . strtoupper($name) . '</subtitle>'."\n".
                '   <description><![CDATA[' . resourceString("show") . " " . $name . ']]></description>'."\n".
                '   <link>' . $url . '</link>'."\n".
                '   <itemid>' . $itemid . '</itemid>'."\n".
                '   <media:thumbnail url="' . $image . '" />'."\n".
                '   <image>' . $image . '</image>'."\n".
                '   <imageover>' . $imageover . '</imageover>'."\n".
                '</item>'."\n";
    }

    /**
     * Get bookmarks rss link.
     */
    private function getBookmarksLink($itemid) {
        $name = resourceString("boomarks");
        $image = SERVER_HOST_AND_PATH . "image/img/bookmarks.png";
        $imageover = SERVER_HOST_AND_PATH . "image/img/bookmarks_over.png";
        $url = SERVER_HOST_AND_PATH . "php/index.php?action=" . ViewBookmarksPageAction::getActionName() . URL_AMP . "PHPSESID=" . session_id();
        return
                '<item>'."\n".
                '   <title><![CDATA[' . $name . ']]></title>'."\n".
                '   <subtitle>' . strtoupper($name) . '</subtitle>'."\n".
                '   <description><![CDATA[' . resourceString("show") . " " . $name . ']]></description>'."\n".
                '   <link>' . $url . '</link>'."\n".
                '   <itemid>' . $itemid . '</itemid>'."\n".
                '   <media:thumbnail url="' . $image . '" />'."\n".
                '   <image>' . $image . '</image>'."\n".
                '   <imageover>' . $imageover . '</imageover>'."\n".
                '</item>'."\n";
    }

    /**
     *
     * @param Integer $itemid
     * @return String 
     */
    private function getPlaylistLink($itemid) {
        $name = resourceString("playlist");
        $image = SERVER_HOST_AND_PATH . "image/img/playlist.png";
        $imageover = SERVER_HOST_AND_PATH . "image/img/playlist_over.png";
        $url = SERVER_HOST_AND_PATH . "php/index.php?action=" . ViewPlaylistPageAction::getActionName() . URL_AMP . "PHPSESID=" . session_id();
        return
                '<item>'."\n".
                '   <title><![CDATA[' . $name . ']]></title>'."\n".
                '   <subtitle>' . strtoupper($name) . '</subtitle>'."\n".
                '   <description><![CDATA[' . resourceString("show") . " " . $name . ']]></description>'."\n".
                '   <link>' . $url . '</link>'."\n".
                '   <itemid>' . $itemid . '</itemid>'."\n".
                '   <media:thumbnail url="' . $image . '" />'."\n".
                '   <image>' . $image . '</image>'."\n".
                '   <imageover>' . $imageover . '</imageover>'."\n".
                '</item>'."\n";
    }

    private function getAboutLink($itemid) {
        $name = resourceString("about");
        $image = SERVER_HOST_AND_PATH . "image/img/group.png";
        $imageover = SERVER_HOST_AND_PATH . "image/img/group_over.png";
        $url = SERVER_HOST_AND_PATH . "php/index.php?action=" . ViewAboutPageAction::getActionName() . URL_AMP . "PHPSESID=" . session_id();
        return
                '<item>'."\n".
                '   <title><![CDATA[' . $name . ']]></title>'."\n".
                '   <subtitle>' . strtoupper($name) . '</subtitle>'."\n".
                '   <description><![CDATA[' . resourceString("show") . " " . $name . ']]></description>'."\n".
                '   <link>' . $url . '</link>'."\n".
                '   <itemid>' . $itemid . '</itemid>'."\n".
                '   <media:thumbnail url="' . $image . '" />'."\n".
                '   <image>' . $image . '</image>'."\n".
                '   <imageover>' . $imageover . '</imageover>'."\n".
                '</item>'."\n";
    }

}

?>
