<?php
/*-------------------------
 *    Developed by Maicros
 *      GNU/GPL Licensed
 * ------------------------*/

class WebsitesTemplate implements Template {

    private $scrapers = null;
    private $title = null;
    private $showType = null;

    public function  __construct(array $scrapers, $title=null) {
        $this->scrapers = $scrapers;
        $this->title = $title;
        $this->showType = "all";
    }

    public function setShowType($showType) {
        $this->showType = $showType;
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

        $scraper = new ScraperBean(
                0,
                "MEGAVIDEO.COM",
                "Play and save manually megavideo IDs.",
                "--",
                "logo/megavideo.jpg",
                "/megavideo/index.php",
                "mixed"
        );

        echo $this->getLink($scraper,0);

        $i = 1;
        foreach ($this->scrapers as $scraper) {
            //Check for website type filter
            if(($this->showType == "all") || ($scraper->getType() == $this->showType)) {
                echo $this->getLink($scraper,$i);
                ++$i;
            }
        }

        echo '  </channel>'."\n";
        echo '</rss>';
    }

    /**
     * Generate rss page config header.
     */
    private function showHeader() {
        //Set change types
        switch( $this->showType ) {
            case "all":
                $nextType = "movie";
                $previousType = "mixed";
                break;
            case "movie":
                $nextType = "serie";
                $previousType = "all";
                break;
            case "serie":
                $nextType = "documentary";
                $previousType = "movie";
                break;
            case "documentary":
                $nextType = "anime";
                $previousType = "serie";
                break;
            case "anime":
                $nextType = "mixed";
                $previousType = "documentary";
                break;
            case "mixed":
                $nextType = "all";
                $previousType = "anime";
                break;
        }
        ?>

<mediaDisplay name="photoView"
              rowCount="7" columnCount="3" drawItemText="no" showHeader="no" showDefaultInfo="no"
              menuBorderColor="0:0:0" sideColorBottom="-1:-1:-1" sideColorTop="-1:-1:-1"
              itemOffsetXPC="14" itemOffsetYPC="22.9" itemWidthPC="26" itemHeightPC="3.8"
              sliding="no" backgroundColor="-1:-1:-1" itemBorderColor="-1:-1:-1" imageBorderPC="0"
              idleImageXPC="90" idleImageYPC="5" idleImageWidthPC="5" idleImageHeightPC="8">
                          <?php xVoDLoader(); ?>
    <!-- IMAGE PUZZLE -->
    <image redraw="yes" offsetXPC="43.9" offsetYPC="71.6" widthPC="56.1" heightPC="6" backgroundColor="-1:-1:-1" >
                <? echo XTREAMER_IMAGE_PATH; ?>background/websites_title.jpg
    </image>

    <!-- SELECTED ITEM LOGO -->
    <image redraw="yes" offsetXPC="1" offsetYPC="22.9" widthPC="10" heightPC="13" >
        <script>
            getItemInfo("thumbnailover");
        </script>
    </image>

    <!-- SELECTED WEBSITE ICON CONTENT TYPE -->
    <image redraw="yes" offsetXPC="47" offsetYPC="71.68" widthPC="3.8" heightPC="6" backgroundColor="-1:-1:-1" >
        <script>
            getItemInfo("image");
        </script>
    </image>
    <!-- SELECTED WEBSITE DESCRIPTION -->
    <text redraw="yes" backgroundColor="0:0:0" foregroundColor="0:154:205"
          offsetXPC="14.6" offsetYPC="59" widthPC="80" heightPC="7.6" fontSize="12" lines="2">
        <script>
            getItemInfo("description");
        </script>
    </text>
    <!-- SELECTED WEBSITE BOTTOM BAR TITLE -->
    <text redraw="yes" backgroundColor="-1:-1:-1" foregroundColor="0:0:0"
          offsetXPC="50" offsetYPC="67.4" widthPC="50" heightPC="14" fontSize="20" lines="1">
        <script>
            getItemInfo("subtitle");
        </script>
    </text>
    <!-- LOGO ICON HISTORY -->
    <image redraw="no" offsetXPC="5" offsetYPC="11.5" widthPC="2.25" heightPC="4" backgroundColor="-1:-1:-1" >
                <?php echo XTREAMER_IMAGE_PATH; ?>background/pgup_btn.png
    </image>

    <image redraw="no" offsetXPC="10" offsetYPC="11" widthPC="2.75" heightPC="5" backgroundColor="-1:-1:-1" >
                <?php echo XTREAMER_IMAGE_PATH; ?>img/all.png
    </image>
    <text redraw="no" backgroundColor="-1:-1:-1"
          foregroundColor="<?php echo ($this->showType == "all") ? "255:102:19" : "230:230:255"; ?>"
          offsetXPC="13" offsetYPC="11" widthPC="9" heightPC="5" fontSize="10" lines="1">
                      <?php echo resourceString("header_menu_all") . "\n"; ?>
    </text>

    <image redraw="no" offsetXPC="22" offsetYPC="11" widthPC="2.75" heightPC="5" backgroundColor="-1:-1:-1" >
                <?php echo XTREAMER_IMAGE_PATH; ?>img/movie.png
    </image>
    <text redraw="no" backgroundColor="-1:-1:-1"
          foregroundColor="<?php echo ($this->showType == "movie") ? "255:102:19" : "230:230:255"; ?>"
          offsetXPC="25" offsetYPC="11" widthPC="10" heightPC="5" fontSize="10" lines="1">
                      <?php echo resourceString("header_menu_movies") . "\n"; ?>
    </text>

    <image redraw="no" offsetXPC="35" offsetYPC="11" widthPC="2.75" heightPC="5" backgroundColor="-1:-1:-1" >
                <?php echo XTREAMER_IMAGE_PATH; ?>img/serie.png
    </image>
    <text redraw="no" backgroundColor="-1:-1:-1"
          foregroundColor="<?php echo ($this->showType == "serie") ? "255:102:19" : "230:230:255"; ?>"
          offsetXPC="38" offsetYPC="11" widthPC="9" heightPC="5" fontSize="10" lines="1">
                      <?php echo resourceString("header_menu_series") . "\n"; ?>
    </text>

    <image redraw="no" offsetXPC="47" offsetYPC="11" widthPC="2.75" heightPC="5" backgroundColor="-1:-1:-1" >
                <?php echo XTREAMER_IMAGE_PATH; ?>img/documentary.png
    </image>
    <text redraw="no" backgroundColor="-1:-1:-1"
          foregroundColor="<?php echo ($this->showType == "documentary") ? "255:102:19" : "230:230:255"; ?>"
          offsetXPC="50" offsetYPC="11" widthPC="12" heightPC="5" fontSize="10" lines="1">
                      <?php echo resourceString("header_menu_documentaries") . "\n"; ?>
    </text>

    <image redraw="no" offsetXPC="62" offsetYPC="11" widthPC="2.75" heightPC="5" backgroundColor="-1:-1:-1" >
                <?php echo XTREAMER_IMAGE_PATH; ?>img/anime.png
    </image>
    <text redraw="no" backgroundColor="-1:-1:-1"
          foregroundColor="<?php echo ($this->showType == "anime") ? "255:102:19" : "230:230:255"; ?>"
          offsetXPC="65" offsetYPC="11" widthPC="10" heightPC="5" fontSize="10" lines="1">
                      <?php echo resourceString("header_menu_anime") . "\n"; ?>
    </text>

    <image redraw="no" offsetXPC="75" offsetYPC="11" widthPC="2.75" heightPC="5" backgroundColor="-1:-1:-1" >
                <?php echo XTREAMER_IMAGE_PATH; ?>img/mixed.png
    </image>
    <text redraw="no" backgroundColor="-1:-1:-1"
          foregroundColor="<?php echo ($this->showType == "mixed") ? "255:102:19" : "230:230:255"; ?>"
          offsetXPC="78" offsetYPC="11" widthPC="10" heightPC="5" fontSize="10" lines="1">
                      <?php echo resourceString("header_menu_mixed") . "\n"; ?>
    </text>

    <image redraw="no" offsetXPC="92.5" offsetYPC="11.5" widthPC="2.25" heightPC="4" backgroundColor="-1:-1:-1" >
                <?php echo XTREAMER_IMAGE_PATH; ?>background/pgdn_btn.png
    </image>

    <!-- HEADER BUTTON TITLES -->
    <text redraw="no" backgroundColor="-1:-1:-1" foregroundColor="255:255:255"
          offsetXPC="5.95" offsetYPC="2.6" widthPC="12" heightPC="2.4" fontSize="12" lines="1">
                      <?php echo resourceString("header_menu_home") . "\n"; ?>
    </text>
    <text redraw="no" backgroundColor="-1:-1:-1" foregroundColor="255:255:255"
          offsetXPC="20" offsetYPC="2.6" widthPC="30" heightPC="2.4" fontSize="12" lines="1">
                      <?php echo resourceString("header_menu_websites_mark_favourite") . "\n"; ?>
    </text>

    <itemDisplay>
        <text redraw="yes" offsetXPC="1" offsetYPC="1" widthPC="98" heightPC="98">
            <backgroundColor>
                <script>
                    focusidx = getFocusItemIndex();
                    if ( focusidx == getItemInfo(-1,"itemid") ){
                        "255:192:192";
                    }else{
                        "32:32:32";
                    }
                </script>
            </backgroundColor>
        </text>
        <text redraw="yes" offsetXPC="1" offsetYPC="1" widthPC="1" heightPC="6" backgroundColor="0:0:0">
        </text>
        <text redraw="yes" offsetXPC="98" offsetYPC="1" widthPC="1" heightPC="6" backgroundColor="0:0:0">
        </text>
        <text redraw="yes" offsetXPC="1" offsetYPC="93" widthPC="1" heightPC="6" backgroundColor="0:0:0">
        </text>
        <text redraw="yes" offsetXPC="98" offsetYPC="93" widthPC="1" heightPC="6" backgroundColor="0:0:0">
        </text>
        <text redraw="yes" offsetXPC="36" offsetYPC="0" widthPC="60" heightPC="100" fontSize="12" lines="1"
              backgroundColor="-1:-1:-1" foregroundColor="255:255:255">
            <script>
                getItemInfo(-1,"title");
            </script>
            <foregroundColor>
                <script>
                    if ( focusidx == getItemInfo(-1,"itemid") ){
                        "0:0:0";
                    }else{
                        "255:255:255";
                    }
                </script>
            </foregroundColor>
        </text>
        <!-- ITEM FAVOURITE ICON -->
                <?php
                $connection = ConnectionFactory::getDataConnection();
                $websites = $connection->getWebsiteFavourites();
                foreach ($websites as $id=>$favourite) {
                    switch($favourite->getType()) {
                        case "movie": $movie = $id;
                            break;
                        case "serie": $serie = $id;
                            break;
                        case "documentary": $documentary = $id;
                            break;
                        case "anime": $anime = $id;
                            break;
                    }
                }
                $condition = '( getItemInfo(-1,"scraperid") == "' . $movie . '" ) || ' .
                        '( getItemInfo(-1,"scraperid") == "' . $serie . '" ) || ' .
                        '( getItemInfo(-1,"scraperid") == "' . $documentary . '" ) || ' .
                        '( getItemInfo(-1,"scraperid") == "' . $anime . '" )';
                ?>
        <image redraw="no" offsetXPC="2" offsetYPC="4" widthPC="8" heightPC="92">
            <script>
                if( <?php echo $condition; ?> )
                "<? echo XTREAMER_IMAGE_PATH; ?>img/star.png";
                else
                    "";
            </script>
        </image>
        <!-- ITEM CONTENT TYPE ICON -->
        <image redraw="no" offsetXPC="12" offsetYPC="0" widthPC="10" heightPC="100">
            <script>
                getItemInfo(-1,"image");
            </script>
        </image>
        <!-- ITEM CONTENT LANGUAGE FLAG ICON -->
        <text redraw="no" offsetXPC="24" offsetYPC="2" widthPC="10" heightPC="96" fontSize="12">
            <script>
                getItemInfo(-1,"scraperlanguage");
            </script>
            <foregroundColor>
                <script>
                    if ( focusidx == getItemInfo(-1,"itemid") ){
                        "0:0:0";
                    }else{
                        "255:255:255";
                    }
                </script>
            </foregroundColor>
            <backgroundColor>
                <script>
                    if ( focusidx == getItemInfo(-1,"itemid") ){
                        "192:192:255";
                    }else{
                        "64:64:255";
                    }
                </script>
            </backgroundColor>
        </text>
    </itemDisplay>

    <onUserInput>
        <script>
            userInput = currentUserInput();
            if( userInput == "one" ){
                showIdle();
                result = getURL("<?php echo SERVER_HOST_AND_PATH . "php/index.php?action=" . SaveFavouriteWebsiteAction::getActionName() . URL_AMP . "id="; ?>" + getItemInfo("scraperid"));
                jumpToLink("websitesPageLink");
                redrawDisplay();
            }
            if(userInput == "zero"){
                showIdle();
                jumpToLink("homePageLink");
                redrawDisplay();
            }
            if(userInput == "pageup"){
                showIdle();
                changeType = "<?php echo $previousType; ?>";
                jumpToLink("websitesChangeTypeLink");
                redrawDisplay();
            }
            if(userInput == "pagedown"){
                showIdle();
                changeType = "<?php echo $nextType; ?>";
                jumpToLink("websitesChangeTypeLink");
                redrawDisplay();
            }
        </script>
    </onUserInput>

    <backgroundDisplay>
        <image offsetXPC="0" offsetYPC="0" widthPC="100" heightPC="100">
                    <? echo XTREAMER_IMAGE_PATH; ?>background/websites.jpg
        </image>
    </backgroundDisplay>

</mediaDisplay>

<websitesPageLink>
    <link>
            <?php echo SERVER_HOST_AND_PATH."php/index.php?action=" . ViewWebsitesPageAction::getActionName(); ?>
    </link>
</websitesPageLink>

<websitesChangeTypeLink>
    <link>
    <script>
        "<?php echo SERVER_HOST_AND_PATH."php/index.php?action=" . ViewWebsitesPageAction::getActionName() .URL_AMP . "type="; ?>" + changeType;
    </script>
    </link>
</websitesChangeTypeLink>

<homePageLink>
    <link>
            <?php echo SERVER_HOST_AND_PATH."php/index.php"; ?>
    </link>
</homePageLink>

        <?php
    }

    /**
     * Get scraper rss link.
     */
    private function getLink(ScraperBean $scraper,$itemid) {
        if(strpos($scraper->getLink(),"?")) {
            $link = SERVER_HOST_AND_PATH . 'php/scraper' . $scraper->getLink() . URL_AMP . "PHPSESID=" . session_id();
        }else {
            $link = SERVER_HOST_AND_PATH . 'php/scraper' . $scraper->getLink() . "?PHPSESID=" . session_id();
        }
        $icon = XTREAMER_IMAGE_PATH . "img/" . $scraper->getType() . ".png";
        $image = $scraper->getImage();
        $image = substr($image, 0, strrpos($image,".") ) . "_grey" . substr($image, strrpos($image,".") );
        return
                '<item>'."\n".
                '   <title><![CDATA[' . strtoupper($scraper->getName()) . ']]></title>'."\n".
                '   <subtitle><![CDATA[' . strtoupper($scraper->getName() . ' (' . $scraper->getLanguage() . ')') . ']]></subtitle>'."\n".
                '   <description><![CDATA[' . strtoupper($scraper->getDescription()) . ']]></description>'."\n".
                '   <link>' . $link . '</link>'."\n".
                '   <thumbnailover>' . XTREAMER_IMAGE_PATH . $scraper->getImage() . '</thumbnailover>'."\n".
                '   <thumbnailoff>' . XTREAMER_IMAGE_PATH . $image . '</thumbnailoff>'."\n".
                '   <image>' . $icon . '</image>'."\n".
                '   <itemid>' . $itemid . '</itemid>'."\n".
                '   <scraperid>' . $scraper->getId() . '</scraperid>'."\n".
                '   <scraperlanguage>' . strtoupper($scraper->getLanguage()) . '</scraperlanguage>'."\n".
                '</item>'."\n";
    }

}

?>
