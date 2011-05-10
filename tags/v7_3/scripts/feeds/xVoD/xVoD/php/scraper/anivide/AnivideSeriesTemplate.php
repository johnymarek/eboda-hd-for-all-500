<?php
/*-------------------------
 *    Developed by Maicros
 *      GNU/GPL Licensed
 * ------------------------*/

class AnivideSeriesTemplate {

    const VIEW_HOME = 1;

    const VIEW_CATEGORY = 2;
    const VIEW_PAGE_NUMBERS = 12;

    const VIEW_SERIE = 3;
    const VIEW_EPISODES = 4;
    const VIEW_EPISODE_DETAIL = 6;

    const VIEW_PLAY = 10;

    private $type = null;
    private $letter = null;
    private $title = null;
    private $description = null;

    private $actualPage = null;
    private $maxPages = null;

    private $movieTitle = null;
    private $search = null;
    private $items = array();
    private $mediaItems = array();
    private $image = null;
    private $headerImage = null;

    private $removed = null;
    private $removedMessage = null;

    public function  __construct() {
        $this->removedMessage = "THIS ANIME HAS BEEN REMOVED AS REQUESTED.";
    }

    public function setRemoved($removed) {
        $this->removed = $removed;
    }

    public function setRemovedMessage($removedMessage) {
        $this->removedMessage = $removedMessage;
    }

    public function setActualPage($actualPage) {
        $this->actualPage = $actualPage;
    }

    public function setMaxPages($maxPages) {
        $this->maxPages = $maxPages;
    }

    public function setLetter($letter) {
        $this->letter = $letter;
    }

    public function setMovieTitle($movieTitle) {
        $this->movieTitle = $movieTitle;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    public function setImage($image) {
        $this->image = $image;
    }

    public function setHeaderImage($headerImage) {
        $this->headerImage = $headerImage;
    }

    public function setType($type) {
        $this->type = $type;
    }

    public function setSearch($search) {
        $this->search = $search;
    }

    public function addItem($title, $description, $link, $thumbnail) {
        $item = array($title, $description, $link, $thumbnail);
        array_push($this->items, $item);
    }

    public function addMediaItem($title, $description, $link, $thumbnail, $enclosureType) {
        $mediaItem = array($title, $description, $link, $thumbnail, $enclosureType);
        array_push($this->mediaItems, $mediaItem);
    }

    public function generateView($category, $title = null) {
        $this->title = $title;
        header("Content-type: text/xml");
        echo '<?xml version="1.0" encoding="UTF-8" ?>'."\n";
        echo '<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:media="http://purl.org/dc/elements/1.1/">'."\n";

        switch($category) {
            case AnivideSeriesTemplate::VIEW_CATEGORY;
                $this->getCategoryHeader();
                break;
            case AnivideSeriesTemplate::VIEW_PAGE_NUMBERS:
                $this->getPageNumbersHeader();
                break;

            case AnivideSeriesTemplate::VIEW_SERIE;
                $this->getSerieHeader();
                break;

            case AnivideSeriesTemplate::VIEW_EPISODES:
                $this->getEpisodesHeader();

            case AnivideSeriesTemplate::VIEW_EPISODE_DETAIL;
                $this->getEpisodeDetailHeader();
                break;

            case AnivideSeriesTemplate::VIEW_PLAY;
                $this->getPlayHeader();
                break;
        }

        echo '  <channel>'."\n";
        echo '      <title><![CDATA[' . utf8_encode($title) . ']]></title>' . "\n";

        foreach ($this->mediaItems as $value) {
            $this->getMediaLink($value) . "\n";
        }
        $i=0;
        if($this->search) {
            $this->getSearchLink($this->search,$i) . "\n";
            ++$i;
        }
        foreach ($this->items as $value) {
            $this->getLink($value,$i) . "\n";
            ++$i;
        }

        echo '  </channel>' . "\n";
        echo '</rss>';
    }

    /**
     * -------------------------------------------------------------------------
     */
    private function getPageNumbersHeader() {
        ?>
<mediaDisplay name="photoView"
              showHeader="no" rowCount="7" columnCount="15" drawItemText="no" showDefaultInfo="no"
              itemImageXPC="100" itemImageYPC="100" itemOffsetXPC="5" itemOffsetYPC="20" sliding="yes"
              itemWidthPC="5" itemHeightPC="6" itemBorderColor="-1:-1:-1"
              idleImageXPC="90" idleImageYPC="5" idleImageWidthPC="5" idleImageHeightPC="8"
              bottomYPC="88" sideTopHeightPC="20" itemBackgroundColor="0:0:0"
              backgroundColor="0:0:0" sideColorBottom="-1:-1:-1" sideColorTop="-1:-1:-1"
              fontSize="11">
                          <?php xVoDLoader(); ?>

    <!-- ACTUAL SELECTED ITEM AND NUMBER -->
    <text redraw="yes"
          backgroundColor="0:0:0" foregroundColor="255:255:255"
          offsetXPC="90" offsetYPC="93" widthPC="10" heightPC="5" fontSize="16" lines="1">
        <script>
            getFocusItemIndex() + " / <?php echo count($this->items); ?>";
        </script>
    </text>

    <!-- MOVIE TITLE -->
    <text redraw="yes"
          backgroundColor="0:0:0" foregroundColor="255:255:255"
          offsetXPC="30" offsetYPC="93" widthPC="60" heightPC="5" fontSize="16" lines="1">
        <script>
            getItemInfo("description");
        </script>
    </text>

    <!-- TOP MENU TITLES -->
    <text redraw="no"
          backgroundColor="0:0:0" foregroundColor="255:255:255"
          offsetXPC="0" offsetYPC="2" widthPC="50" heightPC="5" fontSize="10" lines="1">

    </text>
    <text redraw="no"
          backgroundColor="0:0:0" foregroundColor="255:255:255"
          offsetXPC="67" offsetYPC="2" widthPC="30" heightPC="5" fontSize="10" lines="1">
    </text>

    <itemDisplay>
        <image redraw="no" offsetXPC="0" offsetYPC="0" widthPC="100" heightPC="100" >
            <script>
                if( getFocusItemIndex() == getItemInfo(-1,"itemid") )
                    "<? echo XTREAMER_IMAGE_PATH; ?>background/top-bar-focus_150.png";
                else
                    "<? echo XTREAMER_IMAGE_PATH; ?>background/top-bar-unfocus_150.png";
            </script>
        </image>
        <text redraw="yes"
              backgroundColor="-1:-1:-1" foregroundColor="255:255:255"
              offsetXPC="20" offsetYPC="10" widthPC="60" heightPC="80" fontSize="16" lines="1">
            <script>
                getItemInfo(-1,"title");
            </script>
        </text>
    </itemDisplay>

    <backgroundDisplay>
        <image  offsetXPC="0" offsetYPC="0" widthPC="100" heightPC="100">
                    <? echo XTREAMER_IMAGE_PATH; ?>background/movies-black.jpg
        </image>
    </backgroundDisplay>
</mediaDisplay>
        <?php
    }


    /**
     * -------------------------------------------------------------------------
     */
    private function getCategoryHeader() {
        ?>
<mediaDisplay name="photoView"
              showHeader="yes" rowCount="6" columnCount="5" drawItemText="no" showDefaultInfo="no"
              itemImageXPC="100" itemImageYPC="100" itemOffsetXPC="4" itemOffsetYPC="14" sliding="yes"
              itemWidthPC="18" itemHeightPC="10" itemBorderColor="-1:-1:-1"
              idleImageXPC="90" idleImageYPC="5" idleImageWidthPC="5" idleImageHeightPC="8"
              bottomYPC="88" sideTopHeightPC="20" itemBackgroundColor="0:0:0" itemGap="0"
              backgroundColor="0:0:0" sideColorBottom="-1:-1:-1" sideColorTop="-1:-1:-1"
              fontSize="18">
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
          offsetXPC="5.4" offsetYPC="3.1" widthPC="10" heightPC="3" fontSize="10" lines="1">
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

    <!-- MOVIE TITLE -->
    <text redraw="yes"
          backgroundColor="0:0:0" foregroundColor="255:255:255"
          offsetXPC="30" offsetYPC="93" widthPC="60" heightPC="5" fontSize="16" lines="1">
        <script>
            getItemInfo("title");
        </script>
    </text>

    <itemDisplay>
        <image redraw="no" offsetXPC="1" offsetYPC="1" widthPC="98" heightPC="98" >
            <script>
                getItemInfo(-1,"image");
            </script>
        </image>
        <image redraw="yes" offsetXPC="0" offsetYPC="0" widthPC="100" heightPC="100" >
            <script>
                if( getFocusItemIndex() == getItemInfo(-1,"itemid") )
                    "<? echo XTREAMER_IMAGE_PATH; ?>background/top-bar-focus_300.png";
                else
                    "<? echo XTREAMER_IMAGE_PATH; ?>background/top-bar-unfocus_300.png";
            </script>
        </image>
        <text redraw="yes" backgroundColor="-1:-1:-1"
              offsetXPC="10" offsetYPC="10" widthPC="80" heightPC="80" fontSize="16" lines="1">
            <script>
                getItemInfo(-1,"title");
            </script>
            <foregroundColor>
                <script>
                    if( getItemInfo(-1,"itemid") &lt; 3 )
                        "0:154:205";
                    else
                        "255:255:255";
                </script>
            </foregroundColor>
        </text>
    </itemDisplay>

    <onUserInput>
        <script>
        <?php RssScriptUtil::showAddBookmarkScript(); ?>
            if(userInput == "zero"){
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
            <?php echo SERVER_HOST_AND_PATH."php/index.php" . URL_AMP . "PHPSESID=" . session_id(); ?>
    </link>
</homePageLink>
        <?php
    }


    /**
     * -------------------------------------------------------------------------
     */
    private function getSerieHeader() {
        ?>
<script>
    SwitchViewer(0);
    SwitchViewer(7);
</script>
<mediaDisplay name="photoView"
              showHeader="no" rowCount="5" columnCount="3" drawItemText="no"
              sideColorBottom="-1:-1:-1" sideColorTop="-1:-1:-1"
              itemOffsetXPC="2.1" itemOffsetYPC="14" itemWidthPC="31" itemHeightPC="13"
              itemGapXPC="0.5" itemGapYPC="0.5" itemBorderColor="-1:-1:-1"
              forceFocusOnItem="yes"
              itemCornerRounding="yes"
              itemImageWidthPC="31" itemImageHeightPC="13"
              backgroundColor="0:0:0" sliding="yes"
              idleImageXPC="90" idleImageYPC="5" idleImageWidthPC="5" idleImageHeightPC="8"
              bottomYPC="100" sideTopHeightPC="0" >
                          <?php xVoDLoader(); ?>

    <!-- ACTUAL SELECTED ITEM AND NUMBER -->
    <text redraw="yes"
          backgroundColor="0:0:0" foregroundColor="255:255:255"
          offsetXPC="90" offsetYPC="93" widthPC="10" heightPC="5" fontSize="16" lines="1">
        <script>
            getFocusItemIndex() + " / <?php echo count($this->items); ?>";
        </script>
    </text>

    <!-- MOVIE DESCRIPTION -->
    <text redraw="yes"
          backgroundColor="0:0:0" foregroundColor="0:154:205"
          offsetXPC="30" offsetYPC="86" widthPC="70" heightPC="7" fontSize="12" lines="2">
        <script>
            getItemInfo("description");
        </script>
    </text>

    <!-- MOVIE TITLE -->
    <text redraw="yes"
          backgroundColor="0:0:0" foregroundColor="255:255:255"
          offsetXPC="30" offsetYPC="93" widthPC="60" heightPC="5" fontSize="16" lines="1">
        <script>
            getItemInfo("title");
        </script>
    </text>

    <!-- MOVIE PAGES -->
    <text redraw="yes"
          backgroundColor="0:0:0" foregroundColor="255:255:255"
          offsetXPC="5" offsetYPC="9" widthPC="90" heightPC="3" fontSize="10" lines="1">
                      <?php
                      for($i=1;$i<=$this->maxPages;++$i) {
                          if($i==$this->actualPage) {
                              echo "- " . $i . " - &#32;&#32;&#32;";
                          }else {
                              echo $i . "&#32;&#32;&#32;";
                          }
                      }
                      ?>
    </text>

    <!-- TOP MENU TITLES -->
    <text redraw="no"
          backgroundColor="-1:-1:-1" foregroundColor="255:255:255"
          offsetXPC="5.4" offsetYPC="3.1" widthPC="10" heightPC="3" fontSize="10" lines="1">
        <![CDATA[<?php echo resourceString("header_menu_categories"); ?>]]>
    </text>
    <text redraw="no"
          backgroundColor="-1:-1:-1" foregroundColor="255:255:255"
          offsetXPC="19" offsetYPC="3.1" widthPC="18" heightPC="3" fontSize="10" lines="1">
        <![CDATA[<?php echo resourceString("header_menu_previous_page"); ?>]]>
    </text>
    <text redraw="no"
          backgroundColor="-1:-1:-1" foregroundColor="255:255:255"
          offsetXPC="34.5" offsetYPC="3.1" widthPC="18" heightPC="3" fontSize="10" lines="1">
        <![CDATA[<?php echo resourceString("header_menu_goto_page"); ?>]]>
    </text>
    <text redraw="no"
          backgroundColor="-1:-1:-1" foregroundColor="255:255:255"
          offsetXPC="50" offsetYPC="3.1" widthPC="18" heightPC="3" fontSize="10" lines="1">
        <![CDATA[<?php echo resourceString("header_menu_next_page"); ?>]]>
    </text>
            <?php if($this->type == "mov") { ?>
    <text redraw="no"
          backgroundColor="-1:-1:-1" foregroundColor="255:255:255"
          offsetXPC="70" offsetYPC="3.1" widthPC="18" heightPC="3" fontSize="10" lines="1">
        <![CDATA[<?php echo resourceString("header_menu_play"); ?>]]>
    </text>
                <?php }else { ?>
    <text redraw="no"
          backgroundColor="0:0:0" foregroundColor="255:255:255"
          offsetXPC="67" offsetYPC="2" widthPC="7" heightPC="5" fontSize="10" lines="1">
    </text>
                <?php } ?>
    <text redraw="no"
          backgroundColor="-1:-1:-1" foregroundColor="255:255:255"
          offsetXPC="83" offsetYPC="3.1" widthPC="18" heightPC="3" fontSize="10" lines="1">
        <![CDATA[<?php echo resourceString("header_menu_add_bookmark"); ?>]]>
    </text>

            <?php
            if($this->searchTerm) {
                $nextPageLink = SCRAPER_URL."series.php?type=" . base64_encode($this->type) . URL_AMP .
                        "search=" . $this->searchTerm . URL_AMP .
                        "title=" . base64_encode($this->title) . URL_AMP .
                        "page=" . (($this->actualPage>1) ? ($this->actualPage-1) : 1) . URL_AMP .
                        "pages=" . $this->maxPages;
                $lastPageLink = SCRAPER_URL."series.php?type=" . base64_encode($this->type) . URL_AMP .
                        "search=" . $this->searchTerm . URL_AMP .
                        "title=" . base64_encode($this->title) . URL_AMP .
                        "page=" . (($this->actualPage<$this->maxPages) ? ($this->actualPage+1) : $this->maxPages) . URL_AMP .
                        "pages=" . $this->maxPages;
                $gotoPagelink = SCRAPER_URL."series.php?type=" . base64_encode($this->type) . URL_AMP .
                        "search=" . $this->searchTerm . URL_AMP .
                        "pages=". $this->maxPages . URL_AMP .
                        "page=x";
            }else {
                $nextPageLink = SCRAPER_URL."series.php?type=" . base64_encode($this->type) . URL_AMP .
                        "letter=" . $this->letter . URL_AMP .
                        "title=" . base64_encode($this->title) . URL_AMP .
                        "page=" . (($this->actualPage>1) ? ($this->actualPage-1) : 1) . URL_AMP .
                        "pages=" . $this->maxPages;
                $lastPageLink = SCRAPER_URL."series.php?type=" . base64_encode($this->type) . URL_AMP .
                        "letter=" . $this->letter . URL_AMP .
                        "title=" . base64_encode($this->title) . URL_AMP .
                        "page=" . (($this->actualPage<$this->maxPages) ? ($this->actualPage+1) : $this->maxPages) . URL_AMP .
                        "pages=" . $this->maxPages;
                $gotoPagelink = SCRAPER_URL."series.php?type=" . base64_encode($this->type) . URL_AMP .
                        "letter=" . $this->letter . URL_AMP .
                        "pages=" . $this->maxPages . URL_AMP .
                        "page=x";
            }
            ?>

    <itemDisplay>
        <image redraw="no" offsetXPC="0" offsetYPC="0" widthPC="34" heightPC="100" >
            <script>
                getItemInfo(-1,"image");
            </script>
        </image>
        <text backgroundColor="0:0:0" foregroundColor="255:255:255"
              redraw="no" offsetXPC="35" offsetYPC="10" widthPC="64" heightPC="80" fontSize="12" lines="2">
            <script>
                getItemInfo(-1,"title");
            </script>
        </text>
        <image redraw="no" offsetXPC="0" offsetYPC="0" widthPC="100" heightPC="100" >
            <script>
                if( getFocusItemIndex() == getItemInfo(-1,"itemid") )
                    "<? echo XTREAMER_IMAGE_PATH; ?>background/cover-letter-focus_350.png";
                else
                    "<? echo XTREAMER_IMAGE_PATH; ?>background/cover-letter-unfocus_350.png";
            </script>
        </image>
    </itemDisplay>

    <onUserInput>
        <script>
        <?php RssScriptUtil::showAddBookmarkScript(); ?>
            if(userInput == "pageup"){
                showIdle();
                url = "<?php echo $nextPageLink; ?>";
                jumpToLink("gotoPageLink");
                redrawDisplay();
            }
            if(userInput == "pagedown"){
                showIdle();
                url = "<?php echo $lastPageLink; ?>";
                jumpToLink("gotoPageLink");
                redrawDisplay();
            }
            if(userInput == "zero"){
                showIdle();
                jumpToLink("homePageLink");
                redrawDisplay();
            }
            if(userInput == "video_search"){
                showIdle();
                url = "<?php echo $gotoPagelink; ?>";
                jumpToLink("gotoPageLink");
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

<gotoPageLink>
    <link>
    <script>
        url;
    </script>
    </link>
</gotoPageLink>

<homePageLink>
    <link>
            <?php echo SCRAPER_URL."series.php" . URL_AMP . "PHPSESID=" . session_id(); ?>
    </link>
</homePageLink>

        <?php
    }

    private function getEpisodesHeader() {
        ?>
<mediaDisplay name="threePartsView"
              showDefaultInfo="no" bottomYPC="0" itemGap="0" itemPerPage="14"
              showHeader="no" fontSize="14" itemBorderColor="-1:-1:-1" menuBorderColor="-1:-1:-1"
              itemImageXPC="72" itemImageHeightPC="0" itemImageWidthPC="0"
              imageFocus="null" imageUnFocus="null" imageParentFocus="null"
              itemXPC="72" itemYPC="5" itemWidthPC="26" itemHeightPC="6" capWidthPC="58"
              unFocusFontColor="101:101:101" focusFontColor="255:255:255"
              idleImageXPC="90" idleImageYPC="5" idleImageWidthPC="5" idleImageHeightPC="8"
              backgroundColor="0:0:0" drawItemText="no" imageBorderPC="0">
                          <?php xVoDLoader(); ?>

    <!-- RSS PUZZLE, MOVIE PART -->
    <image redraw="no" offsetXPC="0" offsetYPC="0" widthPC="71.65" heightPC="100" backgroundColor="-1:-1:-1" >
                <? echo XTREAMER_IMAGE_PATH; ?>background/movies-inlist-noright.jpg
    </image>

    <!-- TOP MENU TITLES -->
    <text redraw="no"
          backgroundColor="-1:-1:-1" foregroundColor="255:255:255"
          offsetXPC="5.5" offsetYPC="3.1" widthPC="10" heightPC="3" fontSize="10" lines="1">
        <![CDATA[<?php echo resourceString("header_menu_categories"); ?>]]>
    </text>

    <!-- COVER IMAGE -->
    <image redraw="no" offsetXPC="2.8" offsetYPC="23.8" widthPC="18.9" heightPC="48.1" backgroundColor="-1:-1:-1" >
                <?php echo $this->image; ?>
    </image>

    <!-- MOVIE ITEM TITLE -->
    <text redraw="yes"
          backgroundColor="0:0:0" foregroundColor="255:255:255"
          offsetXPC="23.6" offsetYPC="32.2" widthPC="20" heightPC="6" fontSize="12" lines="2">
        <script>
            getItemInfo("title") + "(of <?php echo count($this->items) ?>)";
        </script>
    </text>

    <!-- MOVIE DESCRIPTION -->
    <text redraw="no"
          backgroundColor="-1:-1:-1" foregroundColor="160:160:160"
          offsetXPC="23" offsetYPC="40" widthPC="48" heightPC="40" fontSize="13" lines="13">
        <![CDATA[<?php echo $this->description; ?>]]>
    </text>

    <!-- MOVIE TITLE -->
    <text redraw="no"
          backgroundColor="-1:-1:-1" foregroundColor="0:154:205"
          offsetXPC="23" offsetYPC="23.5" widthPC="50" heightPC="5" fontSize="16" lines="1">
                      <?php echo strtoupper($this->movieTitle); ?>
    </text>

    <!-- PAGE TITLE -->
    <text redraw="no"
          backgroundColor="-1:-1:-1" foregroundColor="0:154:205"
          offsetXPC="23" offsetYPC="27.8" widthPC="35" heightPC="5" fontSize="11" lines="1">
        <script>
            "<?php echo strtoupper($this->title); ?>";
        </script>
    </text>

            <?php
            if( $this->removed ) {
                ?>
    <!-- PAGE TITLE -->
    <text redraw="no"
          backgroundColor="-1:-1:-1" foregroundColor="255:0:0"
          offsetXPC="72" offsetYPC="20" widthPC="25" heightPC="30" fontSize="14" lines="6">
        <script>
            "<?php echo $this->removedMessage; ?>";
        </script>
    </text>
                <?php
            }
            ?>

    <itemDisplay>
        <image redraw="yes" offsetXPC="0" offsetYPC="0" widthPC="100" heightPC="100" >
            <script>
                if( getFocusItemIndex() == getItemInfo(-1,"itemid") )
                    "<? echo XTREAMER_IMAGE_PATH; ?>background/top-bar-focus_300.png";
                else
                    "<? echo XTREAMER_IMAGE_PATH; ?>background/top-bar-unfocus_300.png";
            </script>
        </image>
        <text redraw="no"
              backgroundColor="-1:-1:-1" foregroundColor="255:255:255"
              offsetXPC="3" offsetYPC="12" widthPC="94" heightPC="76" fontSize="12" lines="2">
            <script>
                getItemInfo(-1,"title");
            </script>
        </text>
    </itemDisplay>

    <onUserInput>
        <script>
            userInput = currentUserInput();
            if ( userInput == "zero" )      {
                showIdle();
                jumpToLink("homePageLink");
                redrawDisplay();
            }
        </script>
    </onUserInput>

</mediaDisplay>

<homePageLink>
    <link>
            <?php echo SCRAPER_URL."series.php" . URL_AMP . "PHPSESID=" . session_id(); ?>
    </link>
</homePageLink>
        <?php
    }

    /**
     * -------------------------------------------------------------------------
     */
    private function getEpisodeDetailHeader() {
        ?>
<mediaDisplay name="threePartsView"
              showDefaultInfo="no" bottomYPC="0" itemGap="0" itemPerPage="9"
              showHeader="no" fontSize="14" itemBorderColor="-1:-1:-1" menuBorderColor="-1:-1:-1"
              itemImageXPC="72" itemImageHeightPC="0" itemImageWidthPC="0"
              imageFocus="null" imageUnFocus="null" imageParentFocus="null"
              itemXPC="72" itemYPC="5" itemWidthPC="26" itemHeightPC="10" capWidthPC="58"
              unFocusFontColor="101:101:101" focusFontColor="255:255:255"
              idleImageXPC="90" idleImageYPC="5" idleImageWidthPC="5" idleImageHeightPC="8"
              backgroundColor="0:0:0" drawItemText="no" imageBorderPC="0">
                          <?php xVoDLoader(); ?>

    <!-- RSS PUZZLE, MOVIE PART -->
    <image redraw="no" offsetXPC="0" offsetYPC="0" widthPC="71.65" heightPC="100" backgroundColor="-1:-1:-1" >
                <? echo XTREAMER_IMAGE_PATH; ?>background/movies-inlist-noright.jpg
    </image>

    <!-- TOP MENU TITLES -->
    <text redraw="no"
          backgroundColor="-1:-1:-1" foregroundColor="255:255:255"
          offsetXPC="5.5" offsetYPC="3.1" widthPC="10" heightPC="3" fontSize="10" lines="1">
        <![CDATA[<?php echo resourceString("header_menu_categories"); ?>]]>
    </text>

    <!-- COVER IMAGE -->
    <image redraw="no" offsetXPC="2.8" offsetYPC="23.8" widthPC="18.9" heightPC="48.1" backgroundColor="-1:-1:-1" >
                <?php echo $this->image; ?>
    </image>

    <!-- MOVIE ITEM TITLE -->
    <text redraw="yes"
          backgroundColor="0:0:0" foregroundColor="255:255:255"
          offsetXPC="23.6" offsetYPC="32.2" widthPC="20" heightPC="6" fontSize="12" lines="2">
        <script>
            getItemInfo("title");
        </script>
    </text>

    <!-- MOVIE DESCRIPTION -->
    <text redraw="no"
          backgroundColor="-1:-1:-1" foregroundColor="160:160:160"
          offsetXPC="23" offsetYPC="40" widthPC="48" heightPC="40" fontSize="13" lines="13">
        <![CDATA[<?php echo $this->description; ?>]]>
    </text>

    <!-- MOVIE TITLE -->
    <text redraw="no"
          backgroundColor="-1:-1:-1" foregroundColor="0:154:205"
          offsetXPC="23" offsetYPC="23.5" widthPC="50" heightPC="5" fontSize="16" lines="1">
                      <?php echo strtoupper($this->movieTitle); ?>
    </text>

    <!-- PAGE TITLE -->
    <text redraw="no"
          backgroundColor="-1:-1:-1" foregroundColor="0:154:205"
          offsetXPC="23" offsetYPC="27.8" widthPC="35" heightPC="5" fontSize="11" lines="1">
        <script>
            "<?php echo strtoupper($this->title); ?>";
        </script>
    </text>

    <itemDisplay>
        <image redraw="yes" offsetXPC="0" offsetYPC="0" widthPC="100" heightPC="100" >
            <script>
                if( getFocusItemIndex() == getItemInfo(-1,"itemid") )
                    "<? echo XTREAMER_IMAGE_PATH; ?>background/top-bar-focus_300.png";
                else
                    "<? echo XTREAMER_IMAGE_PATH; ?>background/top-bar-unfocus_300.png";
            </script>
        </image>
        <text redraw="no"
              backgroundColor="-1:-1:-1" foregroundColor="255:255:255"
              offsetXPC="3" offsetYPC="12" widthPC="94" heightPC="76" fontSize="12" lines="2">
            <script>
                getItemInfo(-1,"title");
            </script>
        </text>
    </itemDisplay>

    <onUserInput>
        <script>
            userInput = currentUserInput();
            if ( userInput == "zero" )      {
                showIdle();
                jumpToLink("homePageLink");
                redrawDisplay();
            }
        </script>
    </onUserInput>

</mediaDisplay>

<homePageLink>
    <link>
            <?php echo SCRAPER_URL."series.php" . URL_AMP . "PHPSESID=" . session_id(); ?>
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
<mediaDisplay name="threePartsView"
              showDefaultInfo="no" bottomYPC="0" itemGap="0" itemPerPage="7"
              showHeader="no" fontSize="14" itemBorderColor="-1:-1:-1" menuBorderColor="-1:-1:-1"
              itemImageXPC="72" itemImageHeightPC="0" itemImageWidthPC="0"
              imageFocus="null" imageUnFocus="null" imageParentFocus="null"
              itemXPC="72" itemYPC="5" itemWidthPC="26" itemHeightPC="14" capWidthPC="58"
              unFocusFontColor="101:101:101" focusFontColor="255:255:255"
              idleImageXPC="90" idleImageYPC="5" idleImageWidthPC="5" idleImageHeightPC="8"
              backgroundColor="0:0:0" drawItemText="no" imageBorderPC="0">
                          <?php xVoDLoader(); ?>

    <!-- RSS PUZZLE, MOVIE PART -->
    <image redraw="no" offsetXPC="0" offsetYPC="0" widthPC="71.65" heightPC="100" backgroundColor="-1:-1:-1" >
                <? echo XTREAMER_IMAGE_PATH; ?>background/movies-inlist-noright.jpg
    </image>

    <!-- TOP MENU TITLES -->
    <text redraw="no"
          backgroundColor="-1:-1:-1" foregroundColor="255:255:255"
          offsetXPC="5.5" offsetYPC="3.1" widthPC="10" heightPC="3" fontSize="10" lines="1">
        <![CDATA[<?php echo resourceString("header_menu_categories"); ?>]]>
    </text>

    <!-- COVER IMAGE -->
    <image redraw="no" offsetXPC="2.8" offsetYPC="23.8" widthPC="18.9" heightPC="48.1" backgroundColor="-1:-1:-1" >
                <?php echo $this->image; ?>
    </image>

    <!-- MOVIE TITLE -->
    <text redraw="no"
          backgroundColor="-1:-1:-1" foregroundColor="0:154:205"
          offsetXPC="23" offsetYPC="23.5" widthPC="50" heightPC="5" fontSize="16" lines="1">
                      <?php echo strtoupper($this->movieTitle); ?>
    </text>

    <!-- MOVIE ITEM TITLE -->
    <text redraw="yes"
          backgroundColor="0:0:0" foregroundColor="255:255:255"
          offsetXPC="23.6" offsetYPC="33.2" widthPC="20" heightPC="10" fontSize="12" lines="3">
        <script>
            getItemInfo("title");
        </script>
    </text>

    <itemDisplay>
        <image redraw="yes" offsetXPC="0" offsetYPC="0" widthPC="100" heightPC="100" >
            <script>
                if( getFocusItemIndex() == getItemInfo(-1,"itemid") )
                    "<? echo XTREAMER_IMAGE_PATH; ?>background/top-bar-focus_300.png";
                else
                    "<? echo XTREAMER_IMAGE_PATH; ?>background/top-bar-unfocus_300.png";
            </script>
        </image>
        <text redraw="no"
              backgroundColor="-1:-1:-1" foregroundColor="255:255:255"
              offsetXPC="3" offsetYPC="12" widthPC="94" heightPC="76" fontSize="12" lines="3">
            <script>
                getItemInfo(-1,"title");
            </script>
        </text>
    </itemDisplay>

    <onUserInput>
        <script>
            userInput = currentUserInput();
            if ( userInput == "zero" )      {
                showIdle();
                jumpToLink("homePageLink");
                redrawDisplay();
            }
        </script>
    </onUserInput>

</mediaDisplay>

<homePageLink>
    <link>
            <?php echo SCRAPER_URL."series.php" . URL_AMP . "PHPSESID=" . session_id(); ?>
    </link>
</homePageLink>

        <?php
    }

    /**
     * -------------------------------------------------------------------------
     */
    private function getLink($item,$itemId = null) {
        $data = base64_encode($item[0]) . "-". base64_encode($item[2]) . "-" . base64_encode($item[3]);
        echo "          <item>\n";
        echo "              <title><![CDATA[".utf8_encode($item[0])."]]></title>\n";
        if($item[1]) {
            echo "              <description><![CDATA[".utf8_encode($item[1])."]]></description>\n";
        }
        echo "              <link>" . utf8_encode($item[2]) . "</link>\n";
        echo "              <image>" . utf8_encode($item[3]) . "</image>\n";
        echo "              <data>" . $data . "</data>\n";
        echo "              <itemid>" . $itemId . "</itemid>\n";
        if($item[3]) {
            echo "              <media:thumbnail url=\"" . utf8_encode($item[3]) . "\"/>\n";
        }
        echo "          </item>\n";
    }

    //-------------------------------------------------------------------------
    //-------------------------------------------------------------------------
    private function getMediaLink($item) {
        echo "          <item>\n";
        echo "              <title><![CDATA[" . utf8_encode($item[0]) . "]]></title>\n";
        if($item[1]) {
            echo "              <description><![CDATA[" . utf8_encode($item[1]) . "]]></description>\n";
        }
        echo "              <link>" . utf8_encode($item[2]) . "</link>\n";
        if($item[3]) {
            echo "              <media:thumbnail url=\"" . utf8_encode($item[3]) . "\"/>\n";
        }
        echo "              <enclosure type=\"" . utf8_encode($item[4]) . "\" url=\"" . utf8_encode($item[2]) . "\"/>\n";
        echo "          </item>\n";
    }

    //-------------------------------------------------------------------------
    //-------------------------------------------------------------------------
    private function getSearchLink($item,$itemid) {
        echo "          <item>\n";
        echo "              <title><![CDATA[" . $item[0] . "]]></title>\n";
        echo "              <description><![CDATA[$item[1]]]></description>\n";
        echo "              <link>" . $item[2] . "</link>\n";
        echo "              <search url=\"" . $item[3] . "\" />\n";
        echo "              <itemid>" . $itemid . "</itemid>\n";
        echo "              <media:thumbnail url=\""  . $item[4] . "\"/>\n";
        echo "          </item>\n";
    }


}

?>
