<?php
/*-------------------------
 *    Developed by Maicros
 *      GNU/GPL Licensed
 * ------------------------*/

class PlaylistTemplate implements Template {

    private $title = null;
    private $description = null;
    private $playlist = null;

    public function  __construct($title=null,Playlist $playlist=null) {
        $this->title = $title;
        $this->playlist = $playlist;
    }

    public function setPlaylist(Playlist $playlist) {
        $this->playlist = $playlist;
        $this->title = $playlist->getName();
        $this->description = $playlist->getDescription();
    }

    public function setTitle($title) {
        $this->title = $title;
    }

    public function getTitle() {
        return $this->title;
    }

    public function getPlaylist() {
        return $this->playlist;
    }

    /**
     * Show template.
     */
    public function showTemplate() {
        header("Content-type: text/xml");
        echo '<?xml version="1.0" encoding="UTF-8" ?>'."\n";
        echo '<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:media="http://purl.org/dc/elements/1.1/">'."\n";

        echo '
        <onEnter>
        	setRefreshTime(2000);
        		hola = 1;
        		
        </onEnter>
        <onRefresh>
        	hola = 1 + hola;
        	redraw();
        </onRefresh>
        ';
        
        $this->showHeader();

        echo '  <channel>'."\n";
        echo '      <title>' . $this->title . '</title>' . "\n";
        echo '      <description>' . $this->description . '</description>' . "\n";

        $itemid = 0;
        foreach ($this->playlist->getPlaylistLinks() as $key => $link) {
            echo $this->getPlaylistLinkItem($link,$itemid);
            ++$itemid;
        }

        echo '  </channel>'."\n";
        echo '</rss>';
    }

    private function showHeader() {
        ?>
<script>
    SwitchViewer(0);
    SwitchViewer(7);
</script>
<mediaDisplay name="photoView" 
              showHeader="no" rowCount="2" columnCount="4" drawItemText="no"
              sideColorBottom="-1:-1:-1" sideColorTop="-1:-1:-1"
              itemOffsetXPC="8" itemOffsetYPC="16.10" itemWidthPC="10.12" itemHeightPC="24"
              itemGapXPC="0.5" itemGapYPC="0.1" itemBorderColor="-1:-1:-1"
              forceFocusOnItem="yes"
              itemCornerRounding="yes"
              itemImageWidthPC="10.12" itemImageHeightPC="24"
              backgroundColor="0:0:0" sliding="yes"
              idleImageXPC="90" idleImageYPC="5" idleImageWidthPC="5" idleImageHeightPC="8"
              bottomYPC="100" sideTopHeightPC="0" >
                          <?php xVoDLoader(); ?>

    <text redraw="yes" backgroundColor="10:10:10" 
          offsetXPC="50.5" offsetYPC="17" widthPC="44" heightPC="47.5">
    </text>
                          
    <!-- ACTUAL SELECTED ITEM AND NUMBER -->
    <text redraw="yes"
          backgroundColor="10:10:10" foregroundColor="255:255:255" direction="vertical"
          offsetXPC="51" offsetYPC="61" widthPC="6" heightPC="3" fontSize="12" lines="1">
        <script>
            "" + (1+getFocusItemIndex()) + " / <?php echo (count($this->playlist->getPlaylistLinks())); ?>";
        </script>
    </text>

    <!-- PLAYLIST TITLE -->
    <text redraw="no"
          backgroundColor="-1:-1:-1" foregroundColor="0:154:205"
          offsetXPC="6.55" offsetYPC="10.48" widthPC="90" heightPC="4.28" fontSize="14" lines="1">
        <![CDATA[<?php echo strtoupper($this->title); ?>]]>
    </text>

    <!-- SELECTED ITEM INFO -->
    <image redraw="yes" offsetXPC="51.5" offsetYPC="18.10" widthPC="14.18" heightPC="34">
        <script>
            getItemInfo(-1,"image");
        </script>
    </image>
    <text redraw="yes"
          backgroundColor="10:10:10" foregroundColor="0:154:205"
          offsetXPC="51" offsetYPC="53" widthPC="15.18" heightPC="3" fontSize="10" lines="1">
        <script>
            getItemInfo(-1,"type");
        </script>
    </text>
    <text redraw="yes"
          backgroundColor="10:10:10" foregroundColor="0:154:205"
          offsetXPC="51" offsetYPC="56" widthPC="15.18" heightPC="3" fontSize="10" lines="1">
        <script>
            getItemInfo(-1,"format");
        </script>
    </text>

    <text redraw="yes"
          backgroundColor="10:10:10" foregroundColor="255:255:0"
          offsetXPC="66.5" offsetYPC="18.10" widthPC="28" heightPC="5" fontSize="12" lines="1">
        <script>
            getItemInfo(-1,"name");
        </script>
    </text>
    <text redraw="yes"
          backgroundColor="10:10:10" foregroundColor="255:255:255"
          offsetXPC="66.5" offsetYPC="24.10" widthPC="28" heightPC="38" fontSize="11" lines="13">
        <script>
            getItemInfo(-1,"description");
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
        <text redraw="yes"
          backgroundColor="10:10:10" foregroundColor="255:255:255"
          offsetXPC="66.5" offsetYPC="24.10" widthPC="28" heightPC="38" fontSize="11" lines="1">
        <script>
            hola;
        </script>
    </text>
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
     * Get playlist entry rss link.
     */
    private function getPlaylistLinkItem(PlaylistLink $link, $itemid) {
        $itemLink = SERVER_HOST_AND_PATH . 'php/index.php?action=' . ViewPlaylistPageAction::getActionName() . URL_AMP .
                'subaction=' . ViewPlaylistPageAction::SUBACTION_PLAYLIST_LINK . URL_AMP .
                'link=' . base64_encode($link->getKey()) . URL_AMP .
                'PHPSESID=' . session_id();
        $itemTitle = ( ($link->getTitle()!=null) ? $link->getTitle() : $link->getFilename())  . " (" . $link->getType() . ")" ;
        return
                '<item>' . "\n" .
                '   <title><![CDATA[' . $itemTitle . ']]></title>' . "\n" .
                '   <description><![CDATA[' . $link->getDescription() . ']]></description>' . "\n" .
                '   <link>' . $itemLink . '</link>' . "\n" .
                '   <media:thumbnail url="' . $link->getThumbnail() . '" />' . "\n" .
                '   <image>' . $link->getThumbnail() . '</image>' . "\n" .
                '   <itemid>' . $itemid . '</itemid>' . "\n" .
                '   <name>' . strtoupper($link->getTitle() != null ? $link->getTitle() : $link->getFilename()) . '</name>' . "\n" .
                '   <type>' . $link->getTypeDescription() . '</type>' . "\n" .
                '   <format>' . $link->getFormat() . '</format>' . "\n" .
                '</item>' . "\n";
    }

}

?>