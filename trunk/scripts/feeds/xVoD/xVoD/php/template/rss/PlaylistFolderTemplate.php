<?php
/*-------------------------
 *    Developed by Maicros
 *      GNU/GPL Licensed
 * ------------------------*/

class PlaylistFolderTemplate implements Template {

    private $title = null;
    private $items = array();
    private $baseFolder = null;

    public function  __construct($title=null) {
        if($title) {
            $this->title = $title;
        }
    }

    public function setItems(array $items) {
        $this->items = $items;
    }

    public function setBaseFolder($baseFolder) {
        $this->baseFolder = $baseFolder;
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
        echo '      <description>' . $this->baseFolder . '</description>' . "\n";
        $itemid = 0;
        foreach ($this->items as $item) {
            if( @get_class($item) == "Playlist" ) {
                echo $this->getPlaylistItem($item,$itemid);
            }else {
                echo $this->getPlaylistFolder($item,$itemid);
            }
            ++$itemid;
        }

        echo '  </channel>'."\n";
        echo '</rss>';
    }

    /**
     *
     */
    private function showHeader() {
        ?>
<script>
    SwitchViewer(0);
    SwitchViewer(7);
</script>
<mediaDisplay name="threePartsView"
              showDefaultInfo="no" bottomYPC="0" itemGap="0" itemPerPage="8"
              showHeader="no" fontSize="14" itemBorderColor="-1:-1:-1" menuBorderColor="-1:-1:-1"
              itemImageXPC="10" itemImageYPC="18.10" itemImageHeightPC="0" itemImageWidthPC="80"
              itemXPC="10" itemYPC="18.10" itemWidthPC="80" itemHeightPC="5.65" capWidthPC="0"
              unFocusFontColor="101:101:101" focusFontColor="255:255:255"
              idleImageXPC="90" idleImageYPC="5" idleImageWidthPC="5" idleImageHeightPC="8"
              backgroundColor="0:0:0" drawItemText="no" imageBorderPC="0">
                          <?php xVoDLoader(); ?>

    <text redraw="no"
          backgroundColor="-1:-1:-1" foregroundColor="0:154:205"
          offsetXPC="6.55" offsetYPC="10.48" widthPC="90" heightPC="4.28" fontSize="14" lines="1">
        <![CDATA[<?php echo strtoupper($this->title); ?>]]>
    </text>

    <itemDisplay>
        <image redraw="no" offsetXPC="0" offsetYPC="0" widthPC="4" heightPC="100" >
            <script>
                getItemInfo(-1,"image");
            </script>
        </image>
        <text redraw="yes" offsetXPC="4" offsetYPC="12" widthPC="95" heightPC="100" fontSize="14" lines="1">
            <script>
                getItemInfo(-1,"title");
            </script>
            <foregroundColor>
                <script>
                    if( getFocusItemIndex() == getItemInfo(-1,"itemid") )
                        "255:255:0";
                    else
                        "255:255:255";
                </script>
            </foregroundColor>
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
    <backgroundDisplay>
        <image  offsetXPC="0" offsetYPC="0" widthPC="100" heightPC="100">
                    <? echo XTREAMER_IMAGE_PATH; ?>background/playlist.png
        </image>
    </backgroundDisplay>
</mediaDisplay>

<homePageLink>
    <link>
            <?php echo SERVER_HOST_AND_PATH."php/index.php?PHPSESID=" . session_id(); ?>
    </link>
</homePageLink>

        <?php
    }

    /**
     * Get bookmark rss link.
     */
    private function getPlaylistItem(Playlist $link,$itemid) {
        $itemLink = SERVER_HOST_AND_PATH . 'php/index.php?action=' . ViewPlaylistPageAction::getActionName() . URL_AMP .
                'subaction=' . ViewPlaylistPageAction::SUBACTION_PLAYLIST_OPEN . URL_AMP .
                'playlist=' . base64_encode($link->getFilename()) . URL_AMP .
                'PHPSESID=' . session_id();
        $itemName = ( ($link->getName()!=null) ? $link->getName() . " (" . $link->getFilename() . ")" : $link->getFilename());
        return
                '<item>' . "\n" .
                '   <title><![CDATA[' . $itemName . ']]></title>' . "\n" .
                '   <description><![CDATA[' . $link->getDescription() . ']]></description>' . "\n" .
                '   <link>' . $itemLink . '</link>' . "\n" .
                '   <image>' . XTREAMER_IMAGE_PATH . 'playlist/video.png</image>' . "\n" .
                '   <itemid>' . $itemid . '</itemid>' . "\n" .
                '</item>' . "\n";
    }

    /**
     * Get bookmark rss link.
     */
    private function getPlaylistFolder($folder,$itemid) {
        $itemLink = SERVER_HOST_AND_PATH . 'php/index.php?action=' . ViewPlaylistPageAction::getActionName() . URL_AMP .
                'subaction=' . ViewPlaylistPageAction::SUBACTION_PLAYLIST_FOLDER_OPEN . URL_AMP .
                'folder=' . base64_encode($folder) . URL_AMP .
                'PHPSESID=' . session_id();
        return
                '<item>' . "\n" .
                '   <title><![CDATA[' . $folder . ']]></title>' . "\n" .
                '   <link>' . $itemLink . '</link>' . "\n" .
                '   <image>' . XTREAMER_IMAGE_PATH . 'playlist/folder_blue.png</image>' . "\n" .
                '   <itemid>' . $itemid . '</itemid>' . "\n" .
                '</item>' . "\n";
    }

}

?>