<?php
/*-------------------------
 *    Developed by Maicros
 *      GNU/GPL Licensed
 * ------------------------*/

class MegavideoTemplate {

    const VIEW_HOME = 1;
    const VIEW_LINK_LIST = 2;
    const VIEW_LINK = 3;
    const VIEW_LINK_SAVE = 4;

    private $items = array();

    private $megavideoLinks = array();

    private $megavideoLink = null;

    private $title = null;

    public function setMegavideoLinks($megavideoLinks) {
        $this->megavideoLinks = $megavideoLinks;
    }

    public function setMegavideoLink(MegavideoLinkBean $megavideoLink) {
        $this->megavideoLink = $megavideoLink;
    }

    public function addItem($title, $description, $link, $thumbnail) {
        $item = array("link",$title, $description, $link, $thumbnail);
        array_push($this->items, $item);
    }

    public function addMediaItem($title, $description, $link, $thumbnail, $enclosureType) {
        $mediaItem = array("media",$title, $description, $link, $thumbnail, $enclosureType);
        array_push($this->items, $mediaItem);
    }

    public function addSearchItem($title, $description, $link, $thumbnail) {
        $searchItem = array("search",$title, $description, $link, $thumbnail);
        array_push($this->items, $searchItem);
    }

    public function generateView($typeView,$title = null) {
        $this->title = $title;
        header("Content-type: text/xml");
        echo '<?xml version="1.0" encoding="UTF-8" ?>'."\n";
        echo '<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:media="http://purl.org/dc/elements/1.1/">'."\n";
        switch($typeView) {
            case MegavideoTemplate::VIEW_HOME:
                $this->showHomeHeader();
                break;
            case MegavideoTemplate::VIEW_LINK_LIST:
                $this->showLinkListHeader();
                break;
            case MegavideoTemplate::VIEW_LINK:
                $this->showViewHeader();
                break;
            case MegavideoTemplate::VIEW_LINK_SAVE:
                break;
        }
        echo '  <channel>'."\n";
        echo '      <title><![CDATA[' . utf8_encode($title) . ']]></title>' . "\n";

        $i=0;
        foreach ($this->items as $value) {
            switch($value[0]) {
                case "link":
                    $this->printLink($value,$i);
                    break;
                case "media":
                    $this->printMediaLink($value,$i);
                    break;
                case "search":
                    $this->printSearchLink($value,$i);
                    break;
            }
            ++$i;
        }

        if(($typeView == MegavideoTemplate::VIEW_LINK_LIST) && $this->megavideoLinks) {
            foreach( $this->megavideoLinks as $key => $link ) {
                $this->printMegavideoLink( $link , $i );
                ++$i;
            }
        }

        echo '  </channel>' . "\n";
        echo '</rss>';
    }

    /**
     * -------------------------------------------------------------------------
     */
    private function showHomeHeader() {
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

    <!-- HEADER BUTTON TITLES -->
    <text redraw="no" backgroundColor="-1:-1:-1" foregroundColor="255:255:255"
          offsetXPC="5.95" offsetYPC="2.6" widthPC="12" heightPC="2.4" fontSize="12" lines="1">
                      <?php echo resourceString("header_menu_home") . "\n"; ?>
    </text>

    <!-- LEFT BUTTON IMAGE -->
    <image redraw="no" offsetXPC="37.5" offsetYPC="16.9" widthPC="4.06" heightPC="16.58" backgroundColor="-1:-1:-1">
        <script>
            "<? echo XTREAMER_IMAGE_PATH; ?>background/megavideo_btn_right.png";
        </script>
    </image>

    <!-- FIRST OPTION INSERT MEGAVIDEO ID TO PLAY -->
    <text redraw="yes"
          backgroundColor="-1:-1:-1" align="center"
          offsetXPC="9.82" offsetYPC="13" widthPC="26.31" heightPC="6.60" fontSize="14" lines="2">
        <script>
            "<?php echo resourceString("megavideo_scraper_btn_play"); ?>";
        </script>
        <foregroundColor>
            <script>
                if( getFocusItemIndex() == 0 )
                    "255:0:0";
                else
                    "255:255:255";
            </script>
        </foregroundColor>
    </text>

    <!-- SECOND OPTION INSERT AND SAVE MEGAVIDEO ID TO PLAY -->
    <text redraw="yes"
          backgroundColor="-1:-1:-1" align="center"
          offsetXPC="9.82" offsetYPC="28.5" widthPC="26.31" heightPC="6.60" fontSize="14" lines="2">
        <script>
            "<?php echo resourceString("megavideo_scraper_btn_play_save"); ?>";
        </script>
        <foregroundColor>
            <script>
                if( getFocusItemIndex() == 1 )
                    "255:0:0";
                else
                    "255:255:255";
            </script>
        </foregroundColor>
    </text>

    <!-- LIST MOVIES TITLE -->
    <text redraw="yes"
          backgroundColor="-1:-1:-1" foregroundColor="255:255:255"
          offsetXPC="44.05" offsetYPC="8" widthPC="40" heightPC="5" fontSize="12" lines="1">
        <script>
            "<?php echo resourceString("megavideo_scraper_list_title"); ?>";
        </script>
    </text>

            <?php
            $i = 0;
            foreach( $this->megavideoLinks as $key => $link ) {
                ?>

    <!-- MEGAVIDEO ITEM -->
    <image redraw="no" offsetXPC="42.86" offsetYPC="<?php echo 14.28+($i*6); ?>" widthPC="48.40" heightPC="6" backgroundColor="240:237:230">
        <script>
            "<? echo XTREAMER_IMAGE_PATH; ?>background/megavideo_bg_bar_off.jpg";
        </script>        
    </image>
    <text redraw="no" backgroundColor="-1:-1:-1" foregroundColor="0:0:0"
          offsetXPC="45" offsetYPC="<?php echo 14.52+($i*6); ?>" widthPC="44.11" heightPC="3" fontSize="12" lines="1">
        <script>
            "<?php echo $link->getTitle(); ?>";
        </script>
    </text>
    <text redraw="no" backgroundColor="-1:-1:-1" foregroundColor="26:115:204"
          offsetXPC="45" offsetYPC="<?php echo 14.52+($i*6)+3.5; ?>" widthPC="44.11" heightPC="1.8" fontSize="10" lines="1">
        <script>
            "<?php echo $link->getDescription(); ?>";
        </script>
    </text>
                <?php
                if($i == 9) {
                    break;
                }
                ++$i;
            }
            ?>

    <itemDisplay>
    </itemDisplay>

    <onUserInput>
        <script>
            userInput = currentUserInput();
            if(userInput == "R"){
                showIdle();
                jumpToLink("itemListPageview");
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
        <image  offsetXPC="0" offsetYPC="0" widthPC="100" heightPC="100">
                    <? echo XTREAMER_IMAGE_PATH; ?>background/megavideo_bg.jpg
        </image>
    </backgroundDisplay>

</mediaDisplay>

<itemListPageview>
    <link>
    <script>
        "<?php echo SCRAPER_URL . "index.php?type=list" . URL_AMP . "PHPSESID=" . session_id(); ?>";
    </script>
    </link>
</itemListPageview>
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
    private function showLinkListHeader() {
        ?>
<mediaDisplay name="threePartsView"
              showDefaultInfo="no" drawItemText="no" showHeader="no" bottomYPC="0" itemGap="0"
              itemPerPage="8" fontSize="14" itemBorderColor="-1:-1:-1" menuBorderColor="-1:-1:-1"
              itemImageXPC="42.86" itemImageYPC="14.28" itemImageWidthPC="48.40" itemImageHeightPC="6"
              itemXPC="42.86" itemYPC="14.28" itemWidthPC="48.40" itemHeightPC="6" capWidthPC="0"
              imageFocus="null" imageUnFocus="null" imageParentFocus="null"
              unFocusFontColor="101:101:101" focusFontColor="255:255:255" itemBackgroundColor="240:237:230" mainPartColor="240:237:230"
              idleImageXPC="90" idleImageYPC="5" idleImageWidthPC="5" idleImageHeightPC="8"
              backgroundColor="-1:-1:-1" imageBorderPC="0">
                          <?php xVoDLoader(); ?>

    <!-- HEADER BUTTON TITLES -->
    <text redraw="no" backgroundColor="-1:-1:-1" foregroundColor="255:255:255"
          offsetXPC="5.95" offsetYPC="2.6" widthPC="12" heightPC="2.4" fontSize="12" lines="1">
                      <?php echo resourceString("header_menu_home") . "\n"; ?>
    </text>

    <!-- FIRST OPTION INSERT MEGAVIDEO ID TO PLAY -->
    <text redraw="no"
          backgroundColor="-1:-1:-1" foregroundColor="255:255:255" align="center"
          offsetXPC="9.82" offsetYPC="13" widthPC="26.31" heightPC="6.60" fontSize="14" lines="2">
        <script>
            "<?php echo resourceString("megavideo_scraper_btn_play"); ?>";
        </script>
    </text>

    <!-- SECOND OPTION INSERT AND SAVE MEGAVIDEO ID TO PLAY -->
    <text redraw="no"
          backgroundColor="-1:-1:-1" foregroundColor="255:255:255" align="center"
          offsetXPC="9.82" offsetYPC="28.5" widthPC="26.31" heightPC="6.60" fontSize="14" lines="2">
        <script>
            "<?php echo resourceString("megavideo_scraper_btn_play_save"); ?>";
        </script>
    </text>

    <!-- LIST MOVIES TITLE -->
    <text redraw="yes"
          backgroundColor="-1:-1:-1" foregroundColor="255:255:255"
          offsetXPC="44.05" offsetYPC="8" widthPC="40" heightPC="5" fontSize="12" lines="1">
        <script>
            "<?php echo resourceString("megavideo_scraper_list_title"); ?>";
        </script>
    </text>

    <!-- SHOW DELETE BUTTON -->
    <image redraw="yes" offsetXPC="43.15" offsetYPC="62.38" widthPC="2.56" heightPC="2.76" backgroundColor="-1:-1:-1">
        <script>
            "<? echo XTREAMER_IMAGE_PATH; ?>background/btn_3.png";
        </script>
    </image>
    <text redraw="yes"
          backgroundColor="-1:-1:-1" foregroundColor="0:0:0"
          offsetXPC="46" offsetYPC="62.38" widthPC="40" heightPC="2.76" fontSize="12" lines="1">
        <script>
            "<?php echo resourceString("megavideo_scraper_delete_button"); ?>";
        </script>
    </text>

    <itemDisplay>
        <image redraw="yes" offsetXPC="0" offsetYPC="0" widthPC="100" heightPC="100" backgroundColor="240:237:230">
            <script>
                if( getFocusItemIndex() == getItemInfo(-1,"itemid") )
                    "<? echo XTREAMER_IMAGE_PATH; ?>background/megavideo_bg_bar.jpg";
                else
                    "<? echo XTREAMER_IMAGE_PATH; ?>background/megavideo_bg_bar_off.jpg";
            </script>
        </image>
        <text redraw="yes"
              backgroundColor="-1:-1:-1" foregroundColor="0:0:0"
              offsetXPC="5" offsetYPC="4" widthPC="90" heightPC="50" fontSize="12" lines="1">
            <script>
                getItemInfo(-1,"title");
            </script>
        </text>
        <text redraw="yes"
              backgroundColor="-1:-1:-1" foregroundColor="26:115:204"
              offsetXPC="5" offsetYPC="60" widthPC="90" heightPC="30" fontSize="10" lines="1">
            <script>
                getItemInfo(-1,"description");
            </script>
        </text>
    </itemDisplay>

    <backgroundDisplay>
        <image  offsetXPC="0" offsetYPC="0" widthPC="100" heightPC="100">
                    <? echo XTREAMER_IMAGE_PATH; ?>background/megavideo_bg.jpg
        </image>
    </backgroundDisplay>

    <onUserInput>
        <script>
            userInput = currentUserInput();
            if(userInput == "three"){
                showIdle();
                url = "<?php echo SCRAPER_URL . "index.php?type=iddelete" . URL_AMP . "PHPSESID=" . session_id() . URL_AMP . "itemId="; ?>" + getItemInfo(-1,"megavideoid");
                getURL( url );
                jumpToLink("listPageLink");
                redrawDisplay();
            }
            if(userInput == "zero"){
                showIdle();
                jumpToLink("homePageLink");
                redrawDisplay();
            }
        </script>
    </onUserInput>

</mediaDisplay>

<listPageLink>
    <link>
            <?php echo SCRAPER_URL."index.php?type=list" . URL_AMP . "PHPSESID" . session_id(); ?>
    </link>
</listPageLink>

<homePageLink>
    <link>
            <?php echo SCRAPER_URL."index.php?PHPSESID" . session_id(); ?>
    </link>
</homePageLink>
        <?php
    }


    /**
     * -------------------------------------------------------------------------
     */
    private function showViewHeader() {
        ?>
<mediaDisplay name="threePartsView"
              showDefaultInfo="no" drawItemText="no" showHeader="no" bottomYPC="0" itemGap="0"
              itemPerPage="8" fontSize="14" itemBorderColor="-1:-1:-1" menuBorderColor="-1:-1:-1"
              itemImageXPC="42.86" itemImageYPC="54" itemImageWidthPC="48.40" itemImageHeightPC="6"
              itemXPC="42.86" itemYPC="54" itemWidthPC="48.40" itemHeightPC="6" capWidthPC="0"
              imageFocus="null" imageUnFocus="null" imageParentFocus="null"
              unFocusFontColor="-1:-1:-1" focusFontColor="-1:-1:-1" itemBackgroundColor="-1:-1:-1" mainPartColor="-1:-1:-1"
              idleImageXPC="90" idleImageYPC="5" idleImageWidthPC="5" idleImageHeightPC="8"
              backgroundColor="-1:-1:-1" imageBorderPC="0">
                          <?php xVoDLoader(); ?>

    <!-- HEADER BUTTON TITLES -->
    <text redraw="no" backgroundColor="-1:-1:-1" foregroundColor="255:255:255"
          offsetXPC="5.95" offsetYPC="2.6" widthPC="12" heightPC="2.4" fontSize="12" lines="1">
                      <?php echo resourceString("header_menu_home") . "\n"; ?>
    </text>

    <!-- FIRST OPTION INSERT MEGAVIDEO ID TO PLAY -->
    <text redraw="no"
          backgroundColor="-1:-1:-1" foregroundColor="255:255:255" align="center"
          offsetXPC="9.82" offsetYPC="13" widthPC="26.31" heightPC="6.60" fontSize="14" lines="2">
        <script>
            "<?php echo resourceString("megavideo_scraper_btn_play"); ?>";
        </script>
    </text>

    <!-- SECOND OPTION INSERT AND SAVE MEGAVIDEO ID TO PLAY -->
    <text redraw="no"
          backgroundColor="-1:-1:-1" foregroundColor="255:255:255" align="center"
          offsetXPC="9.82" offsetYPC="28.5" widthPC="26.31" heightPC="6.60" fontSize="14" lines="2">
        <script>
            "<?php echo resourceString("megavideo_scraper_btn_play_save"); ?>";
        </script>
    </text>

            <?php
            if($this->megavideoLink) {
                ?>
    <!-- Show link info -->
    <text redraw="no" backgroundColor="-1:-1:-1" foregroundColor="26:115:204" align="right"
          offsetXPC="42.86" offsetYPC="15" widthPC="14" heightPC="3.5" fontSize="12" lines="1">
        <script>
            "<?php echo resourceString("megavideo_scraper_des_title"); ?>";
        </script>
    </text>
    <text redraw="no" backgroundColor="-1:-1:-1" foregroundColor="0:0:0"
          offsetXPC="58" offsetYPC="15" widthPC="35" heightPC="6" fontSize="12" lines="2">
        <script>
            "<?php echo $this->megavideoLink->getTitle(); ?>";
        </script>
    </text>

    <text redraw="no" backgroundColor="-1:-1:-1" foregroundColor="26:115:204" align="right"
          offsetXPC="42.86" offsetYPC="22" widthPC="14" heightPC="3.5" fontSize="12" lines="1">
        <script>
            "<?php echo resourceString("megavideo_scraper_des_description"); ?>";
        </script>
    </text>
    <text redraw="no" backgroundColor="-1:-1:-1" foregroundColor="0:0:0"
          offsetXPC="58" offsetYPC="22" widthPC="35" heightPC="12" fontSize="12" lines="4">
        <script>
            "<?php echo $this->megavideoLink->getDescription(); ?>";
        </script>
    </text>

    <text redraw="no" backgroundColor="-1:-1:-1" foregroundColor="26:115:204" align="right"
          offsetXPC="42.86" offsetYPC="34" widthPC="14" heightPC="5" fontSize="12" lines="1">
        <script>
            "<?php echo resourceString("megavideo_scraper_des_user"); ?>";
        </script>
    </text>
    <text redraw="no" backgroundColor="-1:-1:-1" foregroundColor="0:0:0"
          offsetXPC="58" offsetYPC="34" widthPC="30" heightPC="5" fontSize="12" lines="1">
        <script>
            "<?php echo $this->megavideoLink->getUser(); ?>";
        </script>
    </text>

    <text redraw="no" backgroundColor="-1:-1:-1" foregroundColor="26:115:204" align="right"
          offsetXPC="42.86" offsetYPC="40" widthPC="14" heightPC="5" fontSize="12" lines="1">
        <script>
            "<?php echo resourceString("megavideo_scraper_des_views"); ?>";
        </script>
    </text>
    <text redraw="no" backgroundColor="-1:-1:-1" foregroundColor="0:0:0"
          offsetXPC="58" offsetYPC="40" widthPC="30" heightPC="5" fontSize="12" lines="1">
        <script>
            "<?php echo $this->megavideoLink->getViews(); ?>";
        </script>
    </text>

    <text redraw="no" backgroundColor="-1:-1:-1" foregroundColor="26:115:204" align="right"
          offsetXPC="42.86" offsetYPC="46" widthPC="14" heightPC="5" fontSize="12" lines="1">
        <script>
            "<?php echo resourceString("megavideo_scraper_des_date"); ?>";
        </script>
    </text>
    <text redraw="no" backgroundColor="-1:-1:-1" foregroundColor="0:0:0"
          offsetXPC="58" offsetYPC="46" widthPC="30" heightPC="5" fontSize="12" lines="1">
        <script>
            "<?php echo $this->megavideoLink->getDateAdded(); ?>";
        </script>
    </text>

    <image redraw="no" offsetXPC="72" offsetYPC="35" widthPC="18" heightPC="17.72" backgroundColor="-1:-1:-1">
        <script>
            "<?php echo $this->megavideoLink->getImage(); ?>";
        </script>
    </image>
                <?php
            }
            ?>

    <!-- PLAY ITEM COMPONENTS -->
    <image redraw="yes" offsetXPC="42.86" offsetYPC="56" widthPC="48.40" heightPC="6" backgroundColor="240:237:230">
        <script>
            "<? echo XTREAMER_IMAGE_PATH; ?>background/megavideo_bg_bar.jpg";
        </script>
    </image>
    <text redraw="yes" backgroundColor="-1:-1:-1" foregroundColor="128:0:0"  align="center"
          offsetXPC="45" offsetYPC="56.24" widthPC="43.56" heightPC="3" fontSize="12" lines="1">
        <script>
            "<?php echo resourceString("megavideo_scraper_des_button"); ?>";
        </script>
    </text>
    <text redraw="yes" backgroundColor="-1:-1:-1" foregroundColor="0:0:0" align="center"
          offsetXPC="45" offsetYPC="59.24" widthPC="43.56" heightPC="1.8" fontSize="10" lines="1">
        <script>
            getItemInfo(-1,"title");
        </script>
    </text>

    <itemDisplay>
    </itemDisplay>

    <onUserInput>
        <script>
            userInput = currentUserInput();
            if(userInput == "zero"){
                showIdle();
                jumpToLink("homePageLink");
                redrawDisplay();
            }
        </script>
    </onUserInput>

    <backgroundDisplay>
        <image  offsetXPC="0" offsetYPC="0" widthPC="100" heightPC="100">
                    <? echo XTREAMER_IMAGE_PATH; ?>background/megavideo_bg.jpg
        </image>
    </backgroundDisplay>

</mediaDisplay>
<homePageLink>
    <link>
            <?php echo SCRAPER_URL."index.php?PHPSESID" . session_id(); ?>
    </link>
</homePageLink>
        <?
    }

    /**
     * -------------------------------------------------------------------------
     */
    private function printLink($item,$itemId = null) {
        echo "          <item>\n";
        echo "              <title><![CDATA[" . $item[1] . "]]></title>\n";
        echo "              <description><![CDATA[" . $item[2] . "]]></description>\n";
        echo "              <link>" . $item[3] . "</link>\n";
        if($item[4]) {
            echo "              <media:thumbnail url=\""  . $item[4] . "\"/>\n";
            echo "              <image>" . $item[4] . "</image>\n";
        }
        echo "              <itemid>" . $itemId . "</itemid>\n";
        echo "          </item>\n";
    }

    /**
     * -------------------------------------------------------------------------
     */
    private function printMediaLink($item,$itemId = null) {
        echo "          <item>\n";
        echo "              <title><![CDATA[" . $item[1] . "]]></title>\n";
        echo "              <description><![CDATA[" . $item[2] . "]]></description>\n";
        echo "              <link>" . $item[3] . "</link>\n";
        echo "              <enclosure type=\"" . $item[5] . "\" url=\"" . $item[3] . "\"/>\n";
        if($item[4]) {
            echo "              <image>" . $item[4] . "</image>\n";
            echo "              <media:thumbnail url=\"" . $item[4] . "\"/>\n";
        }
        echo "              <itemid>" . $itemId . "</itemid>\n";
        echo "          </item>\n";
    }

    /**
     * -------------------------------------------------------------------------
     */
    private function printMegavideoLink(MegavideoLinkBean $link,$itemId = null) {
        echo "          <item>\n";
        echo "              <title><![CDATA[" . $link->getTitle() . "]]></title>\n";
        echo "              <description><![CDATA[" . $link->getDescription() . "]]></description>\n";
        echo "              <link>" . SCRAPER_URL . "index.php?type=id" . URL_AMP . "id=" . $link->getId() . URL_AMP . "PHPSESID=" . session_id() . "</link>\n";
        if($item[4]) {
            echo "              <media:thumbnail url=\""  . $link->getImage() . "\"/>\n";
            echo "              <image>" . $link->getImage() . "</image>\n";
        }
        echo "              <itemid>" . $itemId . "</itemid>\n";
        echo "              <megavideoid>" . $link->getId() . "</megavideoid>\n";
        echo "          </item>\n";
    }

    /**
     * -------------------------------------------------------------------------
     */
    private function printSearchLink($item,$itemid = null) {
        echo "          <item>\n";
        echo "              <title><![CDATA[" . $item[1] . "]]></title>\n";
        echo "              <description><![CDATA[$item[2]]]></description>\n";
        echo "              <link>rss_command://search</link>\n";
        echo "              <search url=\"" . $item[3] . "\" />\n";
        if($item[4]) {
            echo "              <media:thumbnail url=\""  . $item[4] . "\"/>\n";
            echo "              <image>" . $item[4] . "</image>\n";
        }
        echo "              <itemid>" . $itemid . "</itemid>\n";
        echo "          </item>\n";
    }

}

?>
