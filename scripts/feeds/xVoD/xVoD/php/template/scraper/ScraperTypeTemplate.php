<?php
/*-------------------------
 *    Developed by Maicros
 *      GNU/GPL Licensed
 * ------------------------*/

class ScraperTypeTemplate implements Template {

    private $title = null;
    private $homePageLink = null;
    private $stringHeaderBarGoHome = null;
    private $stringHeaderBarAddBookmark = null;
    private $items = array();

    /**
     * -------------------------------------------------------------------------
     */
    public function  __construct($title) {
        $this->title = $title;
        $this->homePageLink = SERVER_HOST_AND_PATH."php/index.php";
        $this->stringHeaderBarGoHome = resourceString("header_menu_home");
        $this->stringHeaderBarAddBookmark = resourceString("header_menu_add_bookmark");
    }

    /**
     * -------------------------------------------------------------------------
     */
    public function configureOptions($homePageLink,$stringHeaderBarGoHome,$stringHeaderBarAddBookmark){
        if($homePageLink){
            $this->homePageLink = $homePageLink;
        }
        if($stringHeaderBarGoHome){
            $this->stringHeaderBarGoHome = $stringHeaderBarGoHome;
        }
        if($stringHeaderBarAddBookmark){
            $this->stringHeaderBarAddBookmark = $stringHeaderBarAddBookmark;
        }
    }

    /**
     * -------------------------------------------------------------------------
     */
    public function addItem($title, $description, $link, $thumbnail) {
        $item = array($title, $description, $link, $thumbnail);
        array_push($this->items, $item);
    }

    /**
     * -------------------------------------------------------------------------
     */
    public function showTemplate() {
        header("Content-type: text/xml");
        echo '<?xml version="1.0" encoding="UTF-8" ?>'."\n";
        echo '<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:media="http://purl.org/dc/elements/1.1/">'."\n";

        $this->showHeader();

        echo '  <channel>'."\n";
        echo '      <title>' . $this->title . '</title>' . "\n";

        $i=0;
        foreach ($this->items as $value) {
            $this->showLink($value,$i) . "\n";
            ++$i;
        }

        echo '  </channel>'."\n";
        echo '</rss>';
    }

    /**
     * -------------------------------------------------------------------------
     */
    private function showHeader() {
        ?>
<mediaDisplay name="photoView"
              showHeader="yes" rowCount="5" columnCount="1" drawItemText="no" showDefaultInfo="no"
              itemImageXPC="100" itemImageYPC="100" itemOffsetXPC="20" itemOffsetYPC="20" sliding="yes"
              itemWidthPC="40" itemHeightPC="12" itemBorderColor="-1:-1:-1"
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
          offsetXPC="5.4" offsetYPC="3.1" widthPC="10" heightPC="3" fontSize="10" lines="1">
        <![CDATA[<?php echo $this->stringHeaderBarGoHome; ?>]]>
    </text>
    <text redraw="no"
          backgroundColor="-1:-1:-1" foregroundColor="255:255:255"
          offsetXPC="83" offsetYPC="3.1" widthPC="18" heightPC="3" fontSize="10" lines="1">
        <![CDATA[<?php echo $this->stringHeaderBarAddBookmark; ?>]]>
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
            <?php echo $this->homePageLink; ?>
    </link>
</homePageLink>
        <?php
    }

    /**
     * -------------------------------------------------------------------------
     */
    private function showLink($item,$itemId = null) {
        echo "          <item>\n";
        echo "              <title><![CDATA[".utf8_encode($item[0])."]]></title>\n";
        if($item[1]) {
            echo "              <description><![CDATA[".utf8_encode($item[1])."]]></description>\n";
        }
        echo "              <link>" . utf8_encode($item[2]) . "</link>\n";
        echo "              <image>" . utf8_encode($item[3]) . "</image>\n";
        echo "              <itemid>" . $itemId . "</itemid>\n";
        if($item[3]) {
            echo "              <media:thumbnail url=\"" . utf8_encode($item[3]) . "\"/>\n";
        }
        echo "          </item>\n";
    }

}

?>
