<?php
/* -------------------------
 *    Developed by Maicros
 *      GNU/GPL Licensed
 * ------------------------ */

class TenStarMoviesTemplate {
    const VIEW_SERIE = 1;
    const VIEW_SEASON = 2;
    const VIEW_EPISODE = 3;
    const VIEW_PLAY = 4;

    private $serie = null;
    private $episode = null;
    private $episodeName = null;
    private $selectedSeason = null;
    private $title = null;
    private $description = null;
    private $headerImage = null;
    private $coverImage = null;
    private $items = array();
    private $mediaItems = array();
    private $backgroundImage = null;

    public function setSerie($serie) {
        $this->serie = $serie;
    }

    public function setSelectedSeason($selectedSeason) {
        $this->selectedSeason = $selectedSeason;
    }

    public function setEpisode($episode) {
        $this->episode = $episode;
    }

    public function setEpisodeName($episodeName) {
        $this->episodeName = $episodeName;
    }

    public function setTitle($title) {
        $this->title = $title;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    public function setHeaderImage($headerImage) {
        $this->headerImage = $headerImage;
    }

    public function setCoverImage($coverImage) {
        $this->coverImage = $coverImage;
    }

    public function setBackgroundImage($backgroundImage) {
        $this->backgroundImage = $backgroundImage;
    }


    public function addItem($title, $description, $link, $thumbnail) {
        $item = array($title, $description, $link, $thumbnail);
        array_push($this->items, $item);
    }

    public function addMediaItem($title, $description, $link, $thumbnail, $enclosureType) {
        $mediaItem = array($title, $description, $link, $thumbnail, $enclosureType);
        array_push($this->mediaItems, $mediaItem);
    }

    public function generateView($category, $title = null, $bgImage = null) {
        header("Content-type: text/xml");
        echo '<?xml version="1.0" encoding="UTF-8" ?>' . "\n";
        echo '<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:media="http://purl.org/dc/elements/1.1/">' . "\n";

        if ($bgImage) {
            $this->backgroundImage = $bgImage;
        }

        switch ($category) {
            case TenStarMoviesTemplate::VIEW_SERIE;
                $this->getSerieHeader();
                break;
            case TenStarMoviesTemplate::VIEW_SEASON;
                $this->getSeasonHeader();
                break;
            case TenStarMoviesTemplate::VIEW_EPISODE;
                $this->getEpisodeHeader();
                break;
            case TenStarMoviesTemplate::VIEW_PLAY;
                $this->getPlayHeader();
                break;
        }

        echo '  <channel>' . "\n";
        echo '      <title>' . $title . '</title>' . "\n";

        if ($category == TenStarMoviesTemplate::VIEW_SEASON) {
            foreach ($this->serie as $season => $episodes) {
                if($season) {
                    $this->addSeasonItem($season, $episodes);
                }
            }

        }else if($category == TenStarMoviesTemplate::VIEW_EPISODE ) {
            foreach ($this->episode as $episodeNumber => $episodeName) {
                $this->addEpisodeItem($episodeNumber,$episodeName[0]);
            }

        }else {

            foreach ($this->mediaItems as $value) {
                $this->getMediaLink($value) . "\n";
            }
            $i=0;
            foreach ($this->items as $value) {
                $this->getLink($value,$i) . "\n";
                ++$i;
            }
        }

        echo '  </channel>' . "\n";
        echo '</rss>';
    }

    /**
     * -------------------------------------------------------------------------
     */
    private function getSerieHeader() {
        ?>
<mediaDisplay name="photoView"
              showHeader="no" rowCount="9" columnCount="3" drawItemText="no" showDefaultInfo="no"
              itemImageXPC="100" itemImageYPC="100" itemOffsetXPC="4" itemOffsetYPC="12" sliding="yes"
              itemWidthPC="30" itemHeightPC="6" itemBorderColor="-1:-1:-1"
              idleImageXPC="90" idleImageYPC="5" idleImageWidthPC="5" idleImageHeightPC="8"
              bottomYPC="88" sideTopHeightPC="14" itemBackgroundColor="0:0:0"
              backgroundColor="-1:-1:-1" sideColorBottom="-1:-1:-1" sideColorTop="-1:-1:-1"
              fontSize="15">';
                          <?php xVoDLoader(); ?>

    <!-- TOP MENU TITLES -->
    <text redraw="no"
          backgroundColor="0:0:0" foregroundColor="255:255:255"
          offsetXPC="15" offsetYPC="2" widthPC="37" heightPC="5" fontSize="10" lines="1">

    </text>
    <text redraw="no"
          backgroundColor="0:0:0" foregroundColor="255:255:255"
          offsetXPC="67" offsetYPC="2" widthPC="7" heightPC="5" fontSize="10" lines="1">
    </text>
    <text redraw="no"
          backgroundColor="-1:-1:-1" foregroundColor="255:255:255"
          offsetXPC="5.4" offsetYPC="3.1" widthPC="14" heightPC="3" fontSize="10" lines="1">
        <![CDATA[<?php echo resourceString("header_menu_home"); ?>]]>
    </text>
    <text redraw="no"
          backgroundColor="-1:-1:-1" foregroundColor="255:255:255"
          offsetXPC="83" offsetYPC="3.1" widthPC="18" heightPC="3" fontSize="10" lines="1">
        <![CDATA[<?php echo resourceString("header_menu_add_bookmark"); ?>]]>
    </text>

    <!-- ACTUAL SELECTED ITEM AND NUMBER -->
    <text redraw="yes"
          backgroundColor="0:0:0" foregroundColor="255:255:255"
          offsetXPC="90" offsetYPC="93" widthPC="10" heightPC="5" fontSize="16" lines="1">
        <script>
            getFocusItemIndex() + " / <?php echo count($this->items); ?>";
        </script>
    </text>

    <!-- SERIE TITLE -->
    <text redraw="yes"
          backgroundColor="0:0:0" foregroundColor="255:255:255"
          offsetXPC="30" offsetYPC="93" widthPC="60" heightPC="5" fontSize="16" lines="1">
        <script>
            getItemInfo("title");
        </script>
    </text>

    <!-- SERIE DESCRIPTION -->
    <text redraw="yes"
          backgroundColor="0:0:0" foregroundColor="0:154:205"
          offsetXPC="30" offsetYPC="76" widthPC="68" heightPC="16" fontSize="12" lines="4">
        <script>
            getItemInfo("description");
        </script>
    </text>

    <itemDisplay>
        <image redraw="no" offsetXPC="1" offsetYPC="1" widthPC="98" heightPC="98" >
            <script>
                getItemInfo(-1,"image");
            </script>
        </image>
        <image redraw="no" offsetXPC="0" offsetYPC="0" widthPC="100" heightPC="100" >
            <script>
                if( getFocusItemIndex() == getItemInfo(-1,"itemid") )
                    "<? echo XTREAMER_IMAGE_PATH; ?>background/top-bar-focus_300.png";
                else
                    "<? echo XTREAMER_IMAGE_PATH; ?>background/top-bar-unfocus_300.png";
            </script>
        </image>
        <text redraw="yes"
              backgroundColor="-1:-1:-1" foregroundColor="255:255:255"
              offsetXPC="5" offsetYPC="10" widthPC="90" heightPC="80" fontSize="15" lines="1">
            <script>
                getItemInfo(-1,"title");
            </script>
        </text>
    </itemDisplay>

    <onUserInput>
        <script>
        <?php RssScriptUtil::showAddBookmarkScript(); ?>
                if(userInput == "0"){
                    showIdle();
                    jumpToLink("homePageLink");
                    redrawDisplay();
                }
        </script>
    </onUserInput>

    <backgroundDisplay>
        <image  offsetXPC="0" offsetYPC="0" widthPC="100" heightPC="100">
                    <? echo XTREAMER_IMAGE_PATH; ?>background/movies-black.jpg
        </image>
    </backgroundDisplay>

</mediaDisplay>

<homePageLink>
    <link>
            <?php echo SERVER_HOST_AND_PATH."php/index.php"; ?>
    </link>
</homePageLink>
        <?php
    }

    /**
     * -------------------------------------------------------------------------
     */
    private function getSeasonHeader() {
        echo "<script> \n";
        foreach ($this->serie as $season => $episodes) {
            if($season) {
                $epsNames = "";
                foreach ($episodes as $episode => $episodeName) {
                    $epsNames .= sprintf("%02d",$episode) . "&#32;&#32;&#32;&#32;";
                }

                echo "      arraySeason = pushBackStringArray( arraySeason, \"" . $epsNames . "\");\n";
            }
        }
        echo "</script> \n";
        ?>
<mediaDisplay name="threePartsView"
              drawItemText="no" showHeader="no" showDefaultInfo="no" fontSize="10"
              itemWidthPC="7.5" itemHeightPC="4"
              itemImageWidthPC="0" itemImageHeightPC="0" itemImageXPC="74.5" itemImageYPC="57.8"
              itemXPC="75" itemYPC="58" itemGap="0" itemPerPage="10"
              imageBorderPC="0"
              imageFocus="null" imageUnFocus="null" imageParentFocus="null"
              focusFontColor="0:154:205" unFocusFontColor="255:255:255"
              itemBorderColor="-1:-1:-1"
              itemBackgroundColor="-1:-1:-1" backgroundColor="0:0:0"
              sideColorBottom="-1:-1:-1" sideColorTop="-1:-1:-1" foregroundColor="0:154:205"
              idleImageXPC="90" idleImageYPC="5" idleImageWidthPC="5" idleImageHeightPC="8">
                          <?php xVoDLoader(); ?>

    <!-- HEADER IMAGE -->
    <image redraw="no" offsetXPC="0" offsetYPC="0" widthPC="100" heightPC="44" backgroundColor="-1:-1:-1" >
                <?php echo $this->headerImage . "\n"; ?>
    </image>

    <!-- BACKGROUND IMAGE -->
    <image redraw="no" offsetXPC="0" offsetYPC="0" widthPC="100" heightPC="51.11">
                <? echo XTREAMER_IMAGE_PATH; ?>background/movie-detail_1.png
    </image>

    <!-- RSS PUZZLE, EPISODES PART -->
    <image redraw="yes" offsetXPC="83.5" offsetYPC="57" widthPC="16.5" heightPC="43" backgroundColor="-1:-1:-1" >
                <? echo XTREAMER_IMAGE_PATH; ?>background/movie-detail-puzzle.bmp
    </image>

    <!-- COVER SERIE IMAGE -->
    <image redraw="no" offsetXPC="4.8" offsetYPC="36.5" widthPC="20.8" heightPC="52.5" backgroundColor="-1:-1:-1" >
                <?php echo $this->coverImage . "\n"; ?>
    </image>

    <!-- TOP MENU TITLES -->
    <text redraw="no"
          backgroundColor="-1:-1:-1" foregroundColor="255:255:255"
          offsetXPC="6.4" offsetYPC="3.1" widthPC="14" heightPC="3" fontSize="10" lines="1">
        <![CDATA[<?php echo resourceString("header_menu_series"); ?>]]>
    </text>

    <text redraw="yes"
          backgroundColor="-1:-1:-1" foregroundColor="255:255:255"
          offsetXPC="85" offsetYPC="68" widthPC="16" heightPC="32.5" fontSize="11" lines="8">
        <script>
            item = getFocusItemIndex();
            selected = getStringArrayAt(arraySeason , item);
            selected;
        </script>
    </text>

    <!-- SEASON LIST TITLE -->
    <text redraw="yes"
          backgroundColor="-1:-1:-1" foregroundColor="255:255:255"
          offsetXPC="83.5" offsetYPC="60.7" widthPC="15" heightPC="6" fontSize="11" lines="1">
        <script>
            "<?php echo resourceString("screen_string_chapters_list"); ?>";
        </script>
    </text>

    <!-- SEASON TITLE, OR NUMBER -->
    <text redraw="yes"
          backgroundColor="-1:-1:-1" foregroundColor="255:255:255"
          offsetXPC="83.5" offsetYPC="56.5" widthPC="15" heightPC="6" fontSize="12" lines="1">
        <script>
            selectedTitle = getItemInfo("title");
            selectedTitle;
        </script>
    </text>

    <!-- SERIE TITLE -->
    <text redraw="no"
          backgroundColor="-1:-1:-1" foregroundColor="0:154:205"
          offsetXPC="28" offsetYPC="50" widthPC="50" heightPC="10" fontSize="18" lines="1">
        <![CDATA[<?php echo strtoupper($this->title); ?>]]>
    </text>

    <!-- SERIE DESCRIPTION -->
    <text redraw="no"
          backgroundColor="-1:-1:-1" foregroundColor="255:255:255"
          offsetXPC="28" offsetYPC="58.5" widthPC="35" heightPC="40" fontSize="10" lines="12">
        <![CDATA[<?php echo strtoupper($this->description); ?>]]>
    </text>


    <onUserInput>
        <script>
            userInput = currentUserInput();
            if(userInput == "0"){
                showIdle();
                jumpToLink("homePageLink");
                redrawDisplay();
            }
        </script>
    </onUserInput>

    <backgroundDisplay>
        <image offsetXPC="0" offsetYPC="51.25" widthPC="100" heightPC="48.75">
                    <?php echo XTREAMER_IMAGE_PATH; ?>background/movie-detail_2.bmp
        </image>
    </backgroundDisplay>

</mediaDisplay>

<homePageLink>
    <link>
            <?php echo SCRAPER_URL."index.php"; ?>
    </link>
</homePageLink>
        <?php
    }

    /**
     * -------------------------------------------------------------------------
     */
    private function getEpisodeHeader() {
        ?>
<script>
    SwitchViewer(0);
    SwitchViewer(7);
</script>
<mediaDisplay name="photoView"
              showHeader="no" showDefaultInfo="no" drawItemText="yes"
              itemImageXPC="0" itemImageYPC="0" itemOffsetXPC="84" itemOffsetYPC="65" sliding="yes"
              itemWidthPC="3" itemHeightPC="2.9" rowCount="1" fontSize="11"
              backgroundColor="0:0:0" sideColorBottom="-1:-1:-1" sideColorTop="-1:-1:-1"
              idleImageXPC="90" idleImageYPC="5" idleImageWidthPC="5" idleImageHeightPC="8">
                          <?php xVoDLoader(); ?>

    <!-- HEADER SERIE IMAGE -->
    <image redraw="no" offsetXPC="0" offsetYPC="0" widthPC="100" heightPC="44" backgroundColor="-1:-1:-1" >
                <?php echo $this->headerImage . "\n"; ?>
    </image>

    <!-- BACKGROUND IMAGE -->
    <image redraw="no" offsetXPC="0" offsetYPC="0" widthPC="100" heightPC="51.11">
                <? echo XTREAMER_IMAGE_PATH; ?>background/movie-detail_1.png
    </image>

    <!-- COVER SERIE IMAGE -->
    <image redraw="no" offsetXPC="4.8" offsetYPC="36.5" widthPC="20.8" heightPC="52.5" backgroundColor="-1:-1:-1" >
                <?php echo $this->coverImage . "\n"; ?>
    </image>

    <!-- RSS PUZZLE, EPISODES PART -->
    <image redraw="yes" offsetXPC="83.5" offsetYPC="57" widthPC="16.5" heightPC="43" backgroundColor="-1:-1:-1" >
                <? echo XTREAMER_IMAGE_PATH; ?>background/movie-detail-puzzle.bmp
    </image>

    <!-- TOP MENU TITLES -->
    <text redraw="no"
          backgroundColor="-1:-1:-1" foregroundColor="255:255:255"
          offsetXPC="6.4" offsetYPC="3.1" widthPC="14" heightPC="3" fontSize="10" lines="1">
        <![CDATA[<?php echo resourceString("header_menu_series"); ?>]]>
    </text>

    <!-- SHOW PLAY BUTTON ON HEADER -->
    <image redraw="no" offsetXPC="15.6" offsetYPC="2.8" widthPC="1.88" heightPC="3.34" backgroundColor="-1:-1:-1" >
                <? echo XTREAMER_IMAGE_PATH; ?>background/play_btn.png
    </image>
    <text redraw="no"
          backgroundColor="-1:-1:-1" foregroundColor="255:255:255"
          offsetXPC="18" offsetYPC="3.2" widthPC="18" heightPC="3" fontSize="10" lines="1">
        <![CDATA[<?php echo resourceString("header_menu_play"); ?>]]>
    </text>

    <!-- SERIE TITLE -->
    <text redraw="yes"
          backgroundColor="-1:-1:-1" foregroundColor="0:154:205"
          offsetXPC="28" offsetYPC="50" widthPC="50" heightPC="10" fontSize="18" lines="1">
        <![CDATA[<?php echo strtoupper($this->title); ?>]]>
    </text>

    <!-- SEASON LIST -->
            <?php
            $offy = 57.8;
            $offset = $this->selectedSeason - 6;
            if($offset < 0 ) {
                $offset = 0;
            }
            for($i=0;($i<12);++$i) {
                $val = array_slice($this->serie, $offset+$i, 1);
                if($val) {
                    $val = $val[0];
                    $val = array_keys($this->serie, $val);
                    $val = $val[0];
                    ?>
    <text redraw="no"
          backgroundColor="-1:-1:-1" foregroundColor="<?php echo ($val == $this->selectedSeason) ? "0:154:205" : "255:255:255"; ?>"
          offsetXPC="74.8" offsetYPC="<?php echo $offy; ?>" widthPC="12" heightPC="4" fontSize="10" lines="1">
        <![CDATA[<?php echo "SEASON " . $val; ?>]]>
    </text>
                    <?php
                    $offy += 4;
                }
            }
            ?>

    <!-- EPISODE NUMBER LIST -->
            <?php
            $offx = 85.4;
            $offy = 68;
            $i = 0;
            foreach($this->episode as $episodeNumber => $value) {
                $episodeName = $value[0];
                ?>
    <text redraw="yes"
          backgroundColor="-1:-1:-1" 
          offsetXPC="<?php echo $offx; ?>" offsetYPC="<?php echo $offy; ?>"
          widthPC="3.6" heightPC="4" fontSize="11" lines="1">
                          <?php echo sprintf("%02d", $episodeNumber ); ?>
        <foregroundColor>
            <script>
                if( <?php echo $i; ?> == getFocusItemIndex() ){
                    "0:154:205";
                }else{
                    "255:255:255";
                }
            </script>
        </foregroundColor>
    </text>
                <?php
                ++$i;
                $offx += 3.6;
                if($offx > 97 ) {
                    $offx = 85.4;
                    $offy += 4;
                }
            }
            ?>
    <!-- SEASON NUMBER -->
    <text redraw="yes"
          backgroundColor="-1:-1:-1" foregroundColor="0:154:205"
          offsetXPC="83.5" offsetYPC="56.5" widthPC="15" heightPC="6" fontSize="12" lines="1">
        <script>
            "<?php echo resourceString("screen_string_season") . " " . $this->selectedSeason; ?>";
        </script>
    </text>

    <!-- SEASON LIST TITLE -->
    <text redraw="yes"
          backgroundColor="-1:-1:-1" foregroundColor="255:255:255"
          offsetXPC="83.5" offsetYPC="60.7" widthPC="15" heightPC="6" fontSize="11" lines="1">
        <script>
            "<?php echo resourceString("screen_string_chapters_list"); ?>";
        </script>
    </text>

    <!-- EPISODE NAME -->
    <text redraw="yes" itemAlignt="right"
          backgroundColor="0:0:0" foregroundColor="0:154:205"
          offsetXPC="27.5" offsetYPC="45" widthPC="60" heightPC="5" fontSize="15" lines="1">
        <script>
            "<?php echo resourceString("screen_string_season") . " " . $this->selectedSeason . ". " . resourceString("screen_string_episode"); ?> " + getItemInfo("title") + ": " + getItemInfo("description");
        </script>
    </text>

    <!-- SERIE DESCRIPTION -->
    <text redraw="no"
          backgroundColor="-1:-1:-1" foregroundColor="255:255:255"
          offsetXPC="28" offsetYPC="58.5" widthPC="35" heightPC="40" fontSize="10" lines="12">
        <![CDATA[<?php echo strtoupper($this->description); ?>]]>
    </text>

    <onUserInput>
        <script>
            userInput = currentUserInput();
	    if(userInput == "U"){
                if( getFocusItemIndex() &gt; 3 ){
                    setFocusItemIndex(-4+getFocusItemIndex());
		    redrawDisplay();
		    "true";
                }

            }else if(userInput == "D"){
                if( getFocusItemIndex() &lt; <?php echo (count($this->episode)-4); ?> ){
                    setFocusItemIndex(4+getFocusItemIndex());
		    redrawDisplay();
		    "true";
                }

            }else if ( userInput == "0" )      {
                showIdle();
                jumpToLink("homePageLink");
                redrawDisplay();

            }else if(userInput == "video_play"){
                showIdle();
                playUrl = getURL("<?php echo SCRAPER_URL . "enclosure.php?link="; ?>" + getItemInfo("link"));
                if(playUrl == "ERROR"){
                    cancelIdle();
                    redrawDisplay();
                }else{
                    playItemURL(playUrl,0);
                }
            }
        </script>
    </onUserInput>

    <backgroundDisplay>
        <image offsetXPC="0" offsetYPC="51.25" widthPC="100" heightPC="48.75">
                    <? echo XTREAMER_IMAGE_PATH; ?>background/movie-detail_2.bmp
        </image>
    </backgroundDisplay>
</mediaDisplay>

<homePageLink>
    <link>
            <?php echo SCRAPER_URL."index.php"; ?>
    </link>
</homePageLink>
        <?php
    }

    /**
     * -------------------------------------------------------------------------
     */
    private function getPlayHeader() {
        ?>
<script>
    SwitchViewer(0);
    SwitchViewer(7);
</script>
<mediaDisplay name="threePartsView" showDefaultInfo="no" bottomYPC="0" itemGap="0" itemPerPage="10"
              showHeader="no" 
              itemImageXPC="0" itemImageHeightPC="0" itemImageWidthPC="0"
              itemXPC="72" itemYPC="20" itemWidthPC="26" itemHeightPC="8" capWidthPC="58"
              unFocusFontColor="101:101:101" focusFontColor="255:255:255"
              idleImageXPC="90" idleImageYPC="5" idleImageWidthPC="5" idleImageHeightPC="8"
              backgroundColor="0:0:0" drawItemText="yes">
                          <?php xVoDLoader(); ?>

    <!-- RSS PUZZLE, MOVIE PART -->
    <image redraw="no" offsetXPC="0" offsetYPC="0" widthPC="71.65" heightPC="100" backgroundColor="-1:-1:-1" >
                <? echo XTREAMER_IMAGE_PATH; ?>background/movies-inlist-noright2.jpg
    </image>

    <text redraw="no"
          backgroundColor="-1:-1:-1" foregroundColor="255:255:255"
          offsetXPC="5.5" offsetYPC="3.4" widthPC="14" heightPC="3" fontSize="10" lines="1">
        SERIES
    </text>

    <text redraw="no"
          backgroundColor="-1:-1:-1" foregroundColor="255:255:255"
          offsetXPC="20.5" offsetYPC="3.4" widthPC="14" heightPC="3" fontSize="10" lines="1">
        PRESS 2 DOWNLOAD VIDEO
    </text>

    <!-- COVER SERIE IMAGE -->
    <image redraw="no" offsetXPC="2.8" offsetYPC="23.8" widthPC="18.9" heightPC="48.1" backgroundColor="-1:-1:-1" >
                <?php echo $this->coverImage . "\n"; ?>
    </image>

    <!-- SERIE TITLE -->
    <text redraw="no"
          backgroundColor="-1:-1:-1" foregroundColor="0:154:205"
          offsetXPC="23" offsetYPC="23.5" widthPC="50" heightPC="5" fontSize="16" lines="1">
        <![CDATA[<?php echo strtoupper($this->title); ?>]]>
    </text>

    <!-- EPISODE TITLE -->
    <text redraw="no"
          backgroundColor="-1:-1:-1" foregroundColor="255:255:255"
          offsetXPC="23" offsetYPC="30" widthPC="35" heightPC="6" fontSize="12" lines="1">
        <![CDATA[<?php echo strtoupper($this->episodeName); ?>]]>
    </text>

    <!-- EPISODE DESCRIPTION -->
    <text redraw="no"
          backgroundColor="-1:-1:-1" foregroundColor="160:160:160"
          offsetXPC="23" offsetYPC="38" widthPC="41" heightPC="30" fontSize="10" lines="10">
        <![CDATA[<?php echo strtoupper($this->description); ?>]]>
    </text>

    <onUserInput>
        <script>
            userInput = currentUserInput();
            if ( userInput == "0" )      {
                showIdle();
                jumpToLink("homePageLink");
                redrawDisplay();
            }
            if ( userInput == "two" )      {
               index = getFocusItemIndex();
               itemLink = getItemInfo(index, "link");
               rss = "rss_file://../rss/downloadDialog.rss";
               ret = doModalRss(rss);           
               if (ret == "Confirm")    {
                  writeStringToFile("/tmp/xvod_links.txt", itemLink);
                  startDownloadUrl = "<?php echo SCRAPER_URL . "index.php?download"; ?>";
                  dummy = getURL( startDownloadUrl );
              }
           "false";
            }
        </script>
    </onUserInput>
</mediaDisplay>

<homePageLink>
    <link>
            <?php echo SCRAPER_URL."index.php"; ?>
    </link>
</homePageLink>
        <?
    }

    /**
     * -------------------------------------------------------------------------
     */
    private function addSeasonItem($season, $seasonArray) {
        $data = $season;
        $link = SCRAPER_URL . "index.php?season=" . $data . URL_AMP . "PHPSESID=" . session_id();
        echo "          <item>\n";
        echo "              <title><![CDATA[SEASON $season]]></title>\n";
        echo "              <link>" . utf8_encode($link) . "</link>\n";
        echo "          </item>\n";
    }

    /**
     * -------------------------------------------------------------------------
     */
    private function addEpisodeItem($episodeNumber,$episodeName) {
        $link = SCRAPER_URL . "index.php?episodeName=" . base64_encode($episodeName) . URL_AMP . "episode=" . $episodeNumber . URL_AMP . "seasonNum=" . $this->selectedSeason . URL_AMP . "PHPSESID=" . session_id();
        echo "          <item>\n";
        echo "              <title><![CDATA[". sprintf("%02d",$episodeNumber) . "]]></title>\n";
        echo "              <description><![CDATA[". strtoupper($episodeName) . "]]></description>\n";
        echo "              <link>" . utf8_encode($link) . "</link>\n";
        echo "          </item>\n";
    }

    /**
     * -------------------------------------------------------------------------
     */
    private function getLink($item,$itemId = null) {
        $data = base64_encode($item[0]) . "-" . base64_encode($item[2]) . "-" . base64_encode($item[3]);
        echo "          <item>\n";
        echo "              <title><![CDATA[$item[0]]]></title>\n";
        if ($item[1]) {
            echo "              <description><![CDATA[$item[1]]]></description>\n";
        }
        echo "              <link>" . utf8_encode($item[2]) . "</link>\n";
        echo "              <data>" . $data . "</data>\n";
        echo "              <itemid>" . $itemId . "</itemid>\n";
        if ($item[3]) {
            echo "              <media:thumbnail url=\"" . utf8_encode($item[3]) . "\"/>\n";
        }
        echo "          </item>\n";
    }

    //-------------------------------------------------------------------------
    //-------------------------------------------------------------------------
    private function getMediaLink($item) {
        echo "          <item>\n";
        echo "              <title><![CDATA[" . $item[0] . "]]></title>\n";
        if ($item[1]) {
            echo "              <description><![CDATA[$item[1]]]></description>\n";
        }
        echo "              <link>" . utf8_encode($item[2]) . "</link>\n";
        if ($item[3]) {
            echo "              <media:thumbnail url=\"" . utf8_encode($item[3]) . "\"/>\n";
        }
        echo "              <enclosure type=\"" . utf8_encode($item[4]) . "\" url=\"" . utf8_encode($item[2]) . "\"/>\n";
        echo "          </item>\n";
    }


}
?>
