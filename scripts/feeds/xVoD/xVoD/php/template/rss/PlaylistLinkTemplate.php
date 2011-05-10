<?php
/*-------------------------
 *    Developed by Maicros
 *      GNU/GPL Licensed
 * ------------------------*/

class PlaylistLinkTemplate implements Template {

    private $title = null;
    private $playlistLink = null;

    public function  __construct($title=null) {
        $this->title = $title;
    }

    public function setPlaylistLink(PlaylistLink $playlistLink) {
        $this->playlistLink = $playlistLink;
    }

    public function getPlaylistLink() {
        return $this->playlistLink;
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

        $itemid = 0;
        switch( $this->playlistLink->getType() ) {
            case PlaylistLink::TYPE_MEGAUPLOAD: //------------------------------
                foreach ($this->playlistLink->getIds() as $order => $id ) {
                    $arrayValue = VideoUtil::generateMegauploadPremiumLink($id);
                    if($arrayValue){
	                    echo $this->getPlaylistItem(
	                    $arrayValue[0],
	                    $this->playlistLink->getDescription(),
	                    $this->playlistLink->getThumbnail(),
	                    $arrayValue[1],
	                    $arrayValue[2],
	                    $itemid
	                    );
	                    ++$itemid;
                	}
                }
                break;

            case PlaylistLink::TYPE_MEGAVIDEO: //-------------------------------
                foreach ($this->playlistLink->getIds() as $order => $id ) {
                    $arrayValue = VideoUtil::generateMegavideoPremiumLink($id);
                    if($arrayValue){
	                    echo $this->getPlaylistItem(
	                    $arrayValue[0],
	                    $this->playlistLink->getDescription(),
	                    $this->playlistLink->getThumbnail(),
	                    $arrayValue[1],
	                    $arrayValue[2],
	                    $itemid
	                    );
	                    ++$itemid;
                    }
                }
                break;

            default: //---------------------------------------------------------
                break;
            
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
<mediaDisplay name="threePartsView"
              showDefaultInfo="no" bottomYPC="0" itemGap="0" itemPerPage="4"
              showHeader="no" fontSize="14" itemBorderColor="-1:-1:-1" menuBorderColor="-1:-1:-1"
              itemImageXPC="8" itemImageYPC="18.10" itemImageHeightPC="0" itemImageWidthPC="25"
              itemXPC="8" itemYPC="18.10" itemWidthPC="25" itemHeightPC="11.12" capWidthPC="0"
              unFocusFontColor="101:101:101" focusFontColor="255:255:255"
              imageFocus="null" imageUnFocus="null" imageParentFocus="null"
              idleImageXPC="90" idleImageYPC="5" idleImageWidthPC="5" idleImageHeightPC="8"
              backgroundColor="0:0:0" drawItemText="no" imageBorderPC="0">
                          <?php xVoDLoader(); ?>

    <!-- PLAYLIST TITLE -->
    <text redraw="no"
          backgroundColor="-1:-1:-1" foregroundColor="0:154:205"
          offsetXPC="6.55" offsetYPC="10.48" widthPC="90" heightPC="4.28" fontSize="14" lines="1">
        <![CDATA[<?php echo strtoupper( ($this->playlistLink->getTitle()!=null) ? $this->playlistLink->getTitle() : $this->playlistLink->getFilename() ); ?>]]>
    </text>

    <!-- SELECTED ITEM INFO -->
    <image redraw="no" offsetXPC="35" offsetYPC="18.10" widthPC="15.18" heightPC="35">
                <?php echo $this->playlistLink->getThumbnail(); ?>
    </image>
    <text redraw="no"
          backgroundColor="0:0:0" foregroundColor="0:154:205"
          offsetXPC="35" offsetYPC="54" widthPC="15.18" heightPC="3" fontSize="10" lines="1">
        <![CDATA[<?php echo strtoupper( $this->playlistLink->getTypeDescription() ); ?>]]>
    </text>
    <text redraw="no"
          backgroundColor="0:0:0" foregroundColor="0:154:205"
          offsetXPC="35" offsetYPC="57" widthPC="15.18" heightPC="3" fontSize="10" lines="1">
        <script>
                <![CDATA[<?php echo strtoupper( $this->playlistLink->getFormat() ); ?>]]>
        </script>
    </text>
    <text redraw="no"
          backgroundColor="0:0:0" foregroundColor="255:255:255"
          offsetXPC="50.5" offsetYPC="18.10" widthPC="45" heightPC="50" fontSize="12" lines="16">
        <![CDATA[<?php echo strtoupper( $this->playlistLink->getDescription() ); ?>]]>
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
        <text redraw="no"
          backgroundColor="-1:-1:-1" foregroundColor="255:255:255"
          offsetXPC="5" offsetYPC="10" widthPC="90" heightPC="80" fontSize="12" lines="3">
            <script>
                getItemInfo(-1,"title");
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
     * Get bookmark rss link.
     */
    private function getPlaylistItem($title,$description,$thumbnail,$enclosureLink,$enclosureType,$itemid) {
        return
                '  <item>' . "\n" .
                '      <title><![CDATA[' . utf8_encode($title) . ']]></title>' . "\n" .
                '      <description><![CDATA[' .  $description . ']]></description>' . "\n" .
                '      <media:thumbnail url="' .  $thumbnail . '"/>' . "\n" .
                '      <enclosure type="' .  $enclosureType . '" url="' . utf8_encode($enclosureLink) . '"/>' . "\n" .
                '      <link>' .  utf8_encode($enclosureLink) . '</link>' . "\n" .
                '      <itemid>' .  $itemid . '</itemid>' . "\n" .
                '  </item>' . "\n";
    }

}

?>