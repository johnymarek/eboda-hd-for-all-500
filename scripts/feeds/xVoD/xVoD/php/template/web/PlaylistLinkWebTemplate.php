<?php
/*-------------------------
 *    Developed by Maicros
 *      GNU/GPL Licensed
 * ------------------------*/

class PlaylistLinkWebTemplate extends WebTemplate {

    private $title = null;
    private $playlistLink = null;
    private $playlist = null;

    public function  __construct($title=null) {
        $this->title = $title;
    }

    public function setPlaylist(Playlist $playlist) {
        $this->playlist = $playlist;
    }

    public function setPlaylistLink(PlaylistLink $playlistLink) {
        $this->playlistLink = $playlistLink;
    }

    public function getPlaylistLink() {
        return $this->playlistLink;
    }

    public function showBodyContent() {
        $playlistLink = SERVER_PATH . 'php/index.php?web&action=' . ViewPlaylistWebPageAction::getActionName() . URL_AMP .
                'subaction=' . ViewPlaylistWebPageAction::SUBACTION_PLAYLIST_OPEN . URL_AMP .
                'playlist=' . base64_encode($this->playlist->getFilename()) . URL_AMP .
                'PHPSESID=' . session_id();

        echo '<h3>Link: ' . htmlentities($this->title) . '</h3>' . "\n";

        echo '<table class="linkTable">
                <tr>
                    <td width="22px"><img width="22px" height="22px" src="../resources/playlist/undo.png" /></td>
                    <td width="100%" align="left"><a href="' . $playlistLink . '">Return to Playlist</a></td>
                </tr>
              </table>' . "\n";

        echo '<table class="playlistTable">' . "\n";
        echo '  <thead>' . "\n";
        echo '      <tr>' . "\n";
        echo '          <th width="24px">&nbsp;</th>' . "\n";
        echo '      </tr>' . "\n";
        echo '  </thead>' . "\n";

        echo '  <tbody>' . "\n";
        echo '      <tr>' . "\n";
        echo '          <td>' . "\n";
        $this->showPlaylistLink();
        echo '          </td>' . "\n";
        echo '      </tr>' . "\n";
        echo '  </tbody>' . "\n";

        echo '  <tfoot>' . "\n";
        echo '      <tr><th align="right">&nbsp;</th></tr>' . "\n";
        echo '  </tfoot>' . "\n";

        echo '</table>' . "\n";


    }

    /**
     * Show link details and check links.
     */
    private function showPlaylistLink() {
        echo '  <table width="100%" cellpadding="0" cellspacing="0" border="0">' . "\n";
        echo '      <tr>' . "\n";
        echo '          <td style="vertical-align:top;">' . "\n";
        echo '              <img width="134px" height="193px" src="' . $this->playlistLink->getThumbnail() . '" style="border:0px;" />' . "\n";
        echo '              <p>' . htmlentities($this->playlistLink->getFormat()) . '</p>' . "\n";
        echo '              <p>' . htmlentities($this->playlistLink->getLanguage()) . '</p>' . "\n";
        echo '              <p>' . htmlentities($this->playlistLink->getTypeDescription()) . '</p>' . "\n";
        echo '          </td>' . "\n";
        echo '          <td style="vertical-align:top;">' . "\n";
        echo '              <p style="font-weight:bold;">' .  htmlentities($this->playlistLink->getTitle()) . '</p>' . "\n";
        echo '              <p style="text-align:justify;">' .  htmlentities($this->playlistLink->getDescription()) . '</p>' . "\n";
        echo '          </td>' . "\n";
        echo '      </tr>' . "\n";

        $itemid = 1;
        switch( $this->playlistLink->getType() ) {
            case PlaylistLink::TYPE_MEGAUPLOAD: //------------------------------
                foreach ($this->playlistLink->getIds() as $order => $id ) {
                    $arrayValue = VideoUtil::generateMegauploadPremiumLink($id);
                    echo '      <tr>' . "\n";
                    echo '          <td align="top" colspan="2">' . "\n";
                    if($arrayValue) {
                        echo '              Link ' .$itemid . ': <a href="' . $arrayValue[1] . '">' . $arrayValue[0] . '</a>. Source: <a target="_blank" href="http://www.megaupload.com/?d=' . $id . '"><img width="22px" height="22px" src="../resources/playlist/view.png" style="border:0px;" /></a>' . "\n";
                    }else{
                        echo '              Link error: <a href="http://www.megaupload.com/?d=' . $id . '">http://www.megaupload.com/?d=' . $id . '</a>' . "\n";
                    }
                    echo '          </td>' . "\n";
                    echo '      </tr>' . "\n";
                    ++$itemid;
                }
                break;

            case PlaylistLink::TYPE_MEGAVIDEO: //-------------------------------
                foreach ($this->playlistLink->getIds() as $order => $id ) {
                    $arrayValue = VideoUtil::generateMegavideoPremiumLink($id);
                    echo '      <tr>' . "\n";
                    echo '          <td align="top" colspan="2">' . "\n";
                    if($arrayValue) {
                        echo '              Link ' .$itemid . ': <a href="' . $arrayValue[1] . '">' . $arrayValue[0] . '</a>. Source: <a target="_blank" href="http://www.megavideo.com/?v=' . $id . '"><img width="22px" height="22px" src="../resources/playlist/view.png" style="border:0px;" /></a>' . "\n";
                    }else{
                        echo '              Link error: <a href="http://www.megavideo.com/?v=' . $id . '">http://www.megavideo.com/?v=' . $id . '</a>' . "\n";
                    }
                    echo '          </td>' . "\n";
                    echo '      </tr>' . "\n";
                    ++$itemid;
                }
                break;

            default: //---------------------------------------------------------
                break;

        }


        echo '  </table>' . "\n";
    }

}

?>
