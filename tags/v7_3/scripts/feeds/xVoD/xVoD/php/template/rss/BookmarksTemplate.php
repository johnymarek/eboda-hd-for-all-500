<?php
/* -------------------------
 *    Developed by Maicros
 *      GNU/GPL Licensed
 * ------------------------ */

class BookmarksTemplate implements Template {

    private $title = null;
    private $bookmarks = null;

    public function __construct(array $bookmarks, $title=null) {
        $this->bookmarks = $bookmarks;
        $this->title = $title;
    }

    /**
     * Show template.
     */
    public function showTemplate() {
        header("Content-type: text/xml");
        echo '<?xml version="1.0" encoding="UTF-8" ?>' . "\n";
        echo '<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:media="http://purl.org/dc/elements/1.1/">' . "\n";

        $this->showHeader();

        echo '  <channel>' . "\n";
        echo '      <title>' . $this->title . '</title>' . "\n";

        $i = 0;
        foreach ($this->bookmarks as $bookmark) {
            echo $this->getLink($bookmark,(ceil(($i+1)/15))-1);
            ++$i;
        }

        echo '  </channel>' . "\n";
        echo '</rss>';
    }

    private function showHeader() {
        echo "  <script>\n";
        foreach ($this->bookmarks as $bookmark) {
            echo '      titleArray  = pushBackStringArray( titleArray,  "' . utf8_encode($bookmark->getName()) . '" );' . "\n";
        }
        echo "  </script>\n";
        ?>

<mediaDisplay  name="photoView"
               rowCount="5" columnCount="3" drawItemText="no" showHeader="no" showDefaultInfo="no"
               menuBorderColor="0:0:0" sideColorBottom="-1:-1:-1" sideColorTop="-1:-1:-1"
               itemWidthPC="0" itemHeightPC="0" itemOffsetXPC="100" itemOffsetYPC="100"
               itemImageWidthPC="0" itemImageHeightPC="0" itemImageXPC="100"
               backgroundColor="-1:-1:-1" sliding="no" itemGap="1" slidingItemText="yes"
               imageUnFocus="null" imageParentFocus="null" imageBorderPC="0"
               idleImageXPC="90" idleImageYPC="5" idleImageWidthPC="5" idleImageHeightPC="8">
                           <?php xVoDLoader(); ?>

    <image redraw="yes" offsetXPC="43.9" offsetYPC="71.6" widthPC="56.1" heightPC="6" backgroundColor="-1:-1:-1" >
                <? echo XTREAMER_IMAGE_PATH; ?>background/websites_title.jpg
    </image>

    <image redraw="yes" offsetXPC="29.88" offsetYPC="28.95" widthPC="70.13" heightPC="34.86">
                <?php echo XTREAMER_IMAGE_PATH; ?>background/bookmarks_items.jpg
    </image>

    <text redraw="yes" backgroundColor="-1:-1:-1" foregroundColor="0:0:0"
          offsetXPC="46" offsetYPC="65.4" widthPC="50" heightPC="18" fontSize="20" lines="1">
        <script>
            getItemInfo(-1,"title");
        </script>
    </text>

    <image redraw="yes" offsetXPC="6.55" offsetYPC="11.43" widthPC="17.86" heightPC="41.62" backgroundColor="-1:-1:-1" >
        <script>
            getItemInfo(-1,"image");
        </script>
    </image>

    <!-- HEADER BUTTON TITLES -->
    <text redraw="no" backgroundColor="-1:-1:-1" foregroundColor="255:255:255"
          offsetXPC="5.95" offsetYPC="2.6" widthPC="12" heightPC="2.4" fontSize="12" lines="1">
                      <?php echo resourceString("header_menu_home") . "\n"; ?>
    </text>
    <text redraw="no" backgroundColor="-1:-1:-1" foregroundColor="255:255:255"
          offsetXPC="20" offsetYPC="2.6" widthPC="30" heightPC="2.4" fontSize="12" lines="1">
                      <?php echo resourceString("header_menu_remove_bookmark") . "\n"; ?>
    </text>

            <?php
            $y = 0;
            $x = 0;
            for($i=0;$i<15;++$i) {
                $script = "
                        temp = " . $i . " + (15 * getItemInfo(\"pagenum\"));
                        title = getStringArrayAt(titleArray, temp);
                        title;";
                $this->showScreenDisplayText($script, 30+($x*23), 30+($y*6), 23, 10);
                if( ($y>0) && (($y+1)%5)== 0) {
                    ++$x;
                    $y = 0;
                }else {
                    ++$y;
                }
            }
            ?>

    <onUserInput>
        <script>
        <?php RssScriptUtil::showDeleteBookmarkScript(); ?>
            if( userInput == "three" ){
                jumpToLink("bookmarksLink");
                redrawDisplay();
            }
            if(userInput == "zero"){
                showIdle();
                jumpToLink("homePageLink");
                redrawDisplay();
            }
        </script>
    </onUserInput>

    <backgroundDisplay>        
        <image offsetXPC="0" offsetYPC="0" widthPC="100" heightPC="100">
                    <? echo XTREAMER_IMAGE_PATH; ?>background/bookmarks.jpg
        </image>
    </backgroundDisplay>
</mediaDisplay>

<homePageLink>
    <link>
            <?php echo SERVER_HOST_AND_PATH."php/index.php"; ?>
    </link>
</homePageLink>

<bookmarksLink>
    <link>
            <?php echo SERVER_HOST_AND_PATH . "php/index.php?action=" . ViewBookmarksPageAction::getActionName(); ?>
    </link>
</bookmarksLink>
        <?php
    }

    /**
     * Get bookmark rss link.
     */
    private function getLink(BookmarkBean $bookmark,$page) {
        if (!$bookmark->getImage()) {
            $image = XTREAMER_IMAGE_PATH . "background/nocover.jpg";
        } else {
            $image = $bookmark->getImage();
        }
        return
                '<item>' . "\n" .
                '   <title><![CDATA[' . $bookmark->getName() . ']]></title>' . "\n" .
                '   <description><![CDATA[' . $bookmark->getDescription() . ']]></description>' . "\n" .
                '   <link>' . SERVER_HOST_AND_PATH . $bookmark->getLink() . '</link>' . "\n" .
                '   <media:thumbnail url="" />' . "\n" .
                '   <data>' . $bookmark->getId() . '</data>' . "\n" .
                '   <image>' . $image . '</image>' . "\n" .
                '   <pagenum>' . $page . '</pagenum>' . "\n" .
                '</item>' . "\n";
    }

    /**
     */
    private function showScreenDisplayText($script,$offx, $offy,$width,$height) {
        ?>
<text redraw="yes" backgroundColor="-1:-1:-1" fontSize="13" lines="1"
      offsetXPC="<?php echo $offx; ?>" offsetYPC="<?php echo $offy; ?>"
      widthPC="<?php echo  $width; ?>" heightPC="<?php echo $height; ?>">
    <script>
        <?php echo $script; ?>
    </script>
    <foregroundColor>
        <script>
            if (temp == getFocusItemIndex() ){
                "255:0:0";
            }else{
                "255:255:255";
            }
        </script>

    </foregroundColor>

</text>
        <?php
    }

}
?>
