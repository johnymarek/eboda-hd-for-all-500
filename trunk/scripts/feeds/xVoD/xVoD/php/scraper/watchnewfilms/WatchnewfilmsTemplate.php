<?php
/*-------------------------
 *    Developed by Maicros
 *      GNU/GPL Licensed
 * ------------------------*/

class WatchnewfilmsTemplate {

    const VIEW_CATEGORY = 1;
    const VIEW_PAGE = 2;
    const VIEW_MOVIE = 3;
    const VIEW_MOVIE_GRID = 6;
    const VIEW_MOVIE_LIST = 7;
    const VIEW_PLAY = 4;

    private $image = null;
    private $url = null;
    private $title = null;
    private $items = array();
    private $mediaItems = array();

    public function setImage($image) {
        $this->image = $image;
    }

    public function setUrl($url) {
        $this->url = $url;
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
            case WatchnewfilmsTemplate::VIEW_CATEGORY;
                $this->getCategoryHeader();
                break;
            case WatchnewfilmsTemplate::VIEW_PAGE;
                $this->getPageHeader();
                break;
            case WatchnewfilmsTemplate::VIEW_MOVIE;
                $this->getMovieHeader();
                break;
            case WatchnewfilmsTemplate::VIEW_MOVIE_GRID;
                $this->getMovieGridHeader();
                break;
            case WatchnewfilmsTemplate::VIEW_MOVIE_LIST;
                $this->getMovieListHeader();
                break;
            case WatchnewfilmsTemplate::VIEW_PLAY;
                $this->getPlayHeader();
                break;
        }

        echo '  <channel>'."\n";
        echo '      <title>' . $title . '</title>' . "\n";
        $i=0;
        foreach ($this->mediaItems as $value) {
            $this->getMediaLink($value,$i) . "\n";
            ++$i;
        }
        if($category != WatchnewfilmsTemplate::VIEW_CATEGORY){
        	usort($this->items, "watchnewfilmsTemplateCmp");
    	}
        $i=0;
        foreach ($this->items as $value) {
            $this->getLink($value,$i) . "\n";
            ++$i;
        }
        if( $category == WatchnewfilmsTemplate::VIEW_CATEGORY) {
            $this->getSearchLink($i) . "\n";
        }

        echo '  </channel>' . "\n";
        echo '</rss>';
    }

    /**
     * -------------------------------------------------------------------------
     */
    private function getCategoryHeader() {
        ?>
<mediaDisplay name="photoView"
              showHeader="yes" rowCount="2" columnCount="2" drawItemText="no" showDefaultInfo="no"
              itemImageXPC="100" itemImageYPC="100" itemOffsetXPC="5" itemOffsetYPC="25" sliding="no"
              itemWidthPC="40" itemHeightPC="10" itemBorderColor="-1:-1:-1"
              idleImageXPC="90" idleImageYPC="5" idleImageWidthPC="5" idleImageHeightPC="8"
              bottomYPC="88" sideTopHeightPC="20" itemBackgroundColor="0:0:0"
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
          offsetXPC="5.4" offsetYPC="3.1" widthPC="14" heightPC="3" fontSize="10" lines="1">
        <![CDATA[<?php echo resourceString("header_menu_home"); ?>]]>
    </text>
    <text redraw="no"
          backgroundColor="-1:-1:-1" foregroundColor="255:255:255"
          offsetXPC="83" offsetYPC="3.1" widthPC="18" heightPC="3" fontSize="10" lines="1">
        <![CDATA[<?php echo resourceString("header_menu_add_bookmark"); ?>]]>
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
              offsetXPC="10" offsetYPC="10" widthPC="80" heightPC="80" fontSize="16" lines="1">
            <script>
                getItemInfo(-1,"title");
            </script>
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
            <?php echo SERVER_HOST_AND_PATH."php/index.php"; ?>
    </link>
</homePageLink>
        <?php
    }

    /**
     * -------------------------------------------------------------------------
     */
    private function getPageHeader() {
        ?>
<mediaDisplay name="photoView"
              showHeader="yes" rowCount="10" columnCount="3" drawItemText="no" showDefaultInfo="no"
              itemImageXPC="100" itemImageYPC="100" itemOffsetXPC="5" itemOffsetYPC="15" sliding="no"
              itemWidthPC="30" itemHeightPC="6" itemBorderColor="-1:-1:-1"
              idleImageXPC="90" idleImageYPC="5" idleImageWidthPC="5" idleImageHeightPC="8"
              bottomYPC="88" sideTopHeightPC="20" itemBackgroundColor="0:0:0"
              backgroundColor="-1:-1:-1" sideColorBottom="-1:-1:-1" sideColorTop="-1:-1:-1"
              fontSize="16">
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
              offsetXPC="10" offsetYPC="10" widthPC="80" heightPC="80" fontSize="16" lines="1">
            <script>
                getItemInfo(-1,"title");
            </script>
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
            <?php echo SERVER_HOST_AND_PATH."php/index.php"; ?>
    </link>
</homePageLink>
        <?php
    }

    /**
     * -------------------------------------------------------------------------
     */
    private function getMovieHeader() {
        ?>
<mediaDisplay name="photoFocusView"
              focusItem="5"
              backgroundColor="-1:-1:-1" sideColorTop="-1:-1:-1" sideTopHeightPC="0"
              rowCount="1" columnCount="9" drawItemText="no"
              itemOffsetXPC="1.6" itemOffsetYPC="62.1" itemWidthPC="9" itemHeightPC="24.5"
              itemBackgroundColor="-1:-1:-1" itemGapXPC="1.6"
              focusItemOffsetYPC="60.9" focusItemWidthPC="10" focusItemHeightPC="27" focusItemBackgroundWidthPC="31.5"
              focusItemBackgroundHeightPC="31.5"
              itemBorderColor="-1:-1:-1" showHeader="no" showDefaultInfo="no"
              idleImageXPC="90" idleImageYPC="5" idleImageWidthPC="5" idleImageHeightPC="8">
                          <?php xVoDLoader(); ?>

    <!-- RSS PUZZLE, MOVIE PART -->
    <image redraw="yes" offsetXPC="10.94" offsetYPC="18.6" widthPC="51.09" heightPC="31.53" backgroundColor="-1:-1:-1" >
                <? echo XTREAMER_IMAGE_PATH; ?>background/movies-inline-puzzle.jpg
    </image>

    <!-- MOVIE TITLE -->
    <text redraw="yes"
          backgroundColor="-1:-1:-1" foregroundColor="255:255:255"
          offsetXPC="11.5" offsetYPC="20.5" widthPC="41" heightPC="8" fontSize="16" lines="1">
        <script>
            title = getItemInfo("title");
            title;
        </script>
    </text>

    <!-- MOVIE DESCRIPTION -->
    <text redraw="yes"
          backgroundColor="-1:-1:-1" foregroundColor="255:255:255"
          offsetXPC="11.5" offsetYPC="28" widthPC="41" heightPC="20" fontSize="10" lines="8">
        <script>
            title = getItemInfo("description");
            title;
        </script>
    </text>

    <!-- PAGE TITLE -->
    <text redraw="no"
          backgroundColor="-1:-1:-1" foregroundColor="0:154:205"
          offsetXPC="11.7" offsetYPC="52" widthPC="40" heightPC="6" fontSize="14" lines="1">
        <script>
            "<?php echo strtoupper($this->title); ?>";
        </script>
    </text>

    <onUserInput>                
        <script>
        <?php RssScriptUtil::showAddBookmarkScript(); ?>
            if ( userInput == "two" )      {
                showIdle();
                jumpToLink("gridView");
                redrawDisplay();
            }
            if ( userInput == "three" ){
                showIdle();
                jumpToLink("listView");
                redrawDisplay();
            }
            if(userInput == "zero"){
                showIdle();
                jumpToLink("homePageLink");
                redrawDisplay();
            }
            if(userInput == "video_play"){
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
        <image  offsetXPC="0" offsetYPC="0" widthPC="100" heightPC="100">
                    <? echo XTREAMER_IMAGE_PATH; ?>background/movies-inline.jpg
        </image>
    </backgroundDisplay>

</mediaDisplay>

<gridView>
    <link><?php echo $this->url . URL_AMP . "view=grid"; ?></link>
</gridView>

<listView>
    <link><?php echo $this->url . URL_AMP . "view=list"; ?></link>
</listView>

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
    private function getMovieGridHeader() {
        ?>
<mediaDisplay name="photoView"
              showHeader="no" rowCount="2" columnCount="7" drawItemText="no"
              sideColorBottom="-1:-1:-1" sideColorTop="-1:-1:-1"
              itemOffsetXPC="2.1" itemOffsetYPC="12" itemWidthPC="13.5" itemHeightPC="36"
              itemGapXPC="0.5" itemGapYPC="0.5" itemBorderColor="-1:-1:-1"
              forceFocusOnItem="yes"
              itemCornerRounding="yes"
              itemImageWidthPC="13.5" itemImageHeightPC="36"
              backgroundColor="0:0:0" sliding="yes"
              idleImageXPC="90" idleImageYPC="5" idleImageWidthPC="5" idleImageHeightPC="8"
              bottomYPC="100" sideTopHeightPC="0" >
                          <?php xVoDLoader(); ?>

    <!-- TOP MENU TITLES -->
    <text redraw="no"
          backgroundColor="0:0:0" foregroundColor="255:255:255"
          offsetXPC="15" offsetYPC="2" widthPC="37" heightPC="5" fontSize="10" lines="1">

    </text>
    <text redraw="no"
          backgroundColor="-1:-1:-1" foregroundColor="255:255:255"
          offsetXPC="5.4" offsetYPC="3.1" widthPC="14" heightPC="3" fontSize="10" lines="1">
        <![CDATA[<?php echo resourceString("header_menu_categories"); ?>]]>
    </text>
    <text redraw="no"
          backgroundColor="-1:-1:-1" foregroundColor="255:255:255"
          offsetXPC="70" offsetYPC="3.1" widthPC="18" heightPC="3" fontSize="10" lines="1">
        <![CDATA[<?php echo resourceString("header_menu_play"); ?>]]>
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

    <!-- PAGE TITLE -->
    <text redraw="no"
          backgroundColor="-1:-1:-1" foregroundColor="0:154:205"
          offsetXPC="30" offsetYPC="89" widthPC="60" heightPC="4" fontSize="12" lines="1">
        <script>
            "<?php echo strtoupper($this->title); ?>";
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
                    "<? echo XTREAMER_IMAGE_PATH; ?>background/wall-2x7-focus.png";
                else
                    "<? echo XTREAMER_IMAGE_PATH; ?>background/wall-2x7-thumbnail.png";
            </script>
        </image>
    </itemDisplay>

    <onUserInput>                 
        <script>
        <?php RssScriptUtil::showAddBookmarkScript(); ?>
            if ( userInput == "two" )      {
                showIdle();
                jumpToLink("detailView");
                redrawDisplay();
            }
            if ( userInput == "three" ){
                showIdle();
                jumpToLink("listView");
                redrawDisplay();
            }
            if(userInput == "zero"){
                showIdle();
                jumpToLink("homePageLink");
                redrawDisplay();
            }
            if(userInput == "video_play"){
                showIdle();
                playUrl = getURL("<?php echo SCRAPER_URL . "enclosure.php?link="; ?>" + getItemInfo("link"));
                playItemURL(playUrl,0);
            }
        </script>
    </onUserInput>

    <backgroundDisplay>
        <image  offsetXPC="0" offsetYPC="0" widthPC="100" heightPC="100">
                    <? echo XTREAMER_IMAGE_PATH; ?>background/movies-black.jpg
        </image>
    </backgroundDisplay>

</mediaDisplay>

<detailView>
    <link><?php echo $this->url . URL_AMP . "view=detail"; ?></link>
</detailView>

<listView>
    <link><?php echo $this->url . URL_AMP . "view=list"; ?></link>
</listView>

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
    private function getMovieListHeader() {
        ?>
<script>
    SwitchViewer(0);
    SwitchViewer(7);
</script>
<mediaDisplay name="threePartsView"
              showDefaultInfo="no" bottomYPC="0" itemGap="0" itemPerPage="18"
              showHeader="no" fontSize="14"
              itemImageXPC="72" itemImageHeightPC="0" itemImageWidthPC="0"
              itemXPC="72" itemYPC="5" itemWidthPC="26" itemHeightPC="5" capWidthPC="58"
              unFocusFontColor="101:101:101" focusFontColor="255:255:255"
              idleImageXPC="90" idleImageYPC="5" idleImageWidthPC="5" idleImageHeightPC="8"
              backgroundColor="0:0:0" drawItemText="yes">
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

    <!-- COVER SERIE IMAGE -->
    <image redraw="yes" offsetXPC="2.8" offsetYPC="23.8" widthPC="18.9" heightPC="48.1" backgroundColor="-1:-1:-1" >
        <script>
            getItemInfo("image");
        </script>
    </image>    

    <!-- MOVIE TITLE -->
    <text redraw="yes"
          backgroundColor="0:0:0" foregroundColor="255:255:255"
          offsetXPC="23" offsetYPC="24" widthPC="35" heightPC="6" fontSize="16" lines="1">
        <script>
            getItemInfo("title");
        </script>
    </text>

    <!-- MOVIE DESCRIPTION -->
    <text redraw="yes"
          backgroundColor="-1:-1:-1" foregroundColor="160:160:160"
          offsetXPC="23" offsetYPC="47" widthPC="41" heightPC="25" fontSize="10" lines="8">
        <script>
            getItemInfo("description");
        </script>
    </text>

    <!-- PAGE TITLE -->
    <text redraw="yes"
          backgroundColor="-1:-1:-1" foregroundColor="0:154:205"
          offsetXPC="23" offsetYPC="32" widthPC="35" heightPC="5" fontSize="11" lines="1">
        <script>
            "<?php echo strtoupper($this->title); ?>";
        </script>
    </text>

    <onUserInput>
        <script>
        <?php RssScriptUtil::showAddBookmarkScript(); ?>
            if ( userInput == "two" )      {
                showIdle();
                jumpToLink("detailView");
                redrawDisplay();
            }
            if ( userInput == "three" ){
                showIdle();
                jumpToLink("gridView");
                redrawDisplay();
            }
            if(userInput == "zero"){
                showIdle();
                jumpToLink("homePageLink");
                redrawDisplay();
            }
            if(userInput == "video_play"){
                showIdle();
                playUrl = getURL("<?php echo SCRAPER_URL . "enclosure.php?link="; ?>" + getItemInfo("link"));
                if(playUrl == "ERROR"){
                    cancelIdle();
                }else{
                    playItemURL(playUrl,0);
                }
            }
        </script>
    </onUserInput>


</mediaDisplay>
<detailView>
    <link><?php echo $this->url . URL_AMP . "view=detail"; ?></link>
</detailView>

<gridView>
    <link><?php echo $this->url . URL_AMP . "view=grid"; ?></link>
</gridView>

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
<mediaDisplay name="threePartsView"
              showDefaultInfo="no" bottomYPC="0" itemGap="0" itemPerPage="18"
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
                <? echo XTREAMER_IMAGE_PATH; ?>background/movies-inlist-noright2.jpg
    </image>

    <!-- TOP MENU TITLES -->
    <text redraw="no"
          backgroundColor="-1:-1:-1" foregroundColor="255:255:255"
          offsetXPC="5.5" offsetYPC="3.1" widthPC="10" heightPC="3" fontSize="10" lines="1">
        <![CDATA[<?php echo resourceString("header_menu_categories"); ?>]]>
    </text>

    <text redraw="no"
          backgroundColor="-1:-1:-1" foregroundColor="255:255:255"
          offsetXPC="20.5" offsetYPC="3.4" widthPC="14" heightPC="3" fontSize="10" lines="1">
        DOWNLOAD VIDEO
    </text>

    <!-- COVER SERIE IMAGE -->
    <image redraw="no" offsetXPC="2.8" offsetYPC="23.8" widthPC="18.9" heightPC="48.1" backgroundColor="-1:-1:-1" >
                <?php echo $this->image; ?>
    </image>

    <!-- MOVIE CATEGORY, SUBCATEGORY AND TITLE -->
            <?php
            $names = explode(" - ", strtoupper($this->title) );
            ?>
    <text redraw="no"
          backgroundColor="-1:-1:-1" foregroundColor="0:154:205"
          offsetXPC="23" offsetYPC="23.5" widthPC="50" heightPC="3" fontSize="10" lines="1">
        <script>
            "<?php echo utf8_encode( $names[0] ); ?>";
        </script>
    </text>
    <text redraw="no"
          backgroundColor="-1:-1:-1" foregroundColor="57:206:255"
          offsetXPC="23" offsetYPC="27" widthPC="50" heightPC="3" fontSize="12" lines="1">
        <script>
            "<?php echo utf8_encode( $names[1] ); ?>";
        </script>
    </text>
    <text redraw="no"
          backgroundColor="-1:-1:-1" foregroundColor="115:220:255"
          offsetXPC="23" offsetYPC="31" widthPC="50" heightPC="3" fontSize="14" lines="1">
        <script>
            "<?php echo utf8_encode( $names[2] ); ?>";
        </script>
    </text>

    <!-- LINK NAME -->
    <text redraw="no"
          backgroundColor="-1:-1:-1" foregroundColor="255:255:255"
          offsetXPC="23" offsetYPC="38" widthPC="60" heightPC="3" fontSize="12" lines="1">
        <script>
            "<?php echo resourceString("screen_string_filename"); ?>:";
        </script>
    </text>
    <text redraw="yes"
          backgroundColor="0:0:0" foregroundColor="255:255:255"
          offsetXPC="24" offsetYPC="41" widthPC="45" heightPC="6" fontSize="13" lines="2">
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

        <?php
    }

    /**
     * -------------------------------------------------------------------------
     */
    private function getLink($item,$itemId = null) {
        $data = base64_encode($item[0]) . "-". base64_encode($item[2]) . "-" . base64_encode($item[3]);
        echo "          <item>\n";
        echo "              <title><![CDATA[$item[0]]]></title>\n";
        if($item[1]) {
            echo "              <description><![CDATA[$item[1]]]></description>\n";
        }
        echo "              <link>" . utf8_encode($item[2]) . "</link>\n";
        echo "              <data>" . $data . "</data>\n";
        echo "              <image>" . utf8_encode($item[3]) . "</image>\n";
        echo "              <itemid>" . $itemId . "</itemid>\n";
        if($item[3]) {
            echo "              <media:thumbnail url=\"" . utf8_encode($item[3]) . "\"/>\n";
        }
        echo "          </item>\n";
    }

    //-------------------------------------------------------------------------
    //-------------------------------------------------------------------------
    private function getMediaLink($item,$itemId = null) {
        echo "          <item>\n";
        echo "              <title><![CDATA[" . $item[0] . "]]></title>\n";
        if($item[1]) {
            echo "              <description><![CDATA[$item[1]]]></description>\n";
        }
        echo "              <link>" . utf8_encode($item[2]) . "</link>\n";
        echo "              <itemid>" . $itemId . "</itemid>\n";
        if($item[3]) {
            echo "              <media:thumbnail url=\"" . utf8_encode($item[3]) . "\"/>\n";
        }
        echo "              <enclosure type=\"" . utf8_encode($item[4]) . "\" url=\"" . utf8_encode($item[2]) . "\"/>\n";
        echo "          </item>\n";
    }

    //-------------------------------------------------------------------------
    //-------------------------------------------------------------------------
    private function getSearchLink($itemId) {
        echo "          <item>\n";
        echo "              <title><![CDATA[Search by...]]></title>\n";
        echo "              <link>rss_command://search</link>\n";
        echo "              <search url=\"" . SERVER_HOST_AND_PATH . "php/scraper/watchnewfilms/index.php?search=%s" . URL_AMP . "title=" . base64_encode("Search by") . "\" />\n";
        echo "              <itemid>" . $itemId . "</itemid>\n";
        echo "              <media:thumbnail url=\"\"/>\n";
        echo "          </item>\n";
    }


}

function watchnewfilmsTemplateCmp($a, $b) {
    if ($a[0] == $b[0]) {
        return 0;
    }
    return strcmp($a[0], $b[0]);
}

?>
