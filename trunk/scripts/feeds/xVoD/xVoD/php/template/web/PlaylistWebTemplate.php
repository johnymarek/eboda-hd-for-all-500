<?php
/*-------------------------
 *    Developed by Maicros
 *      GNU/GPL Licensed
 * ------------------------*/

class PlaylistWebTemplate extends WebTemplate {

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

    public function showBodyContent() {
        $playlistName = ( ($this->playlist->getName()!=null) ? $this->playlist->getName() . " (" . utf8_decode($this->playlist->getFilename()) . ")" : utf8_decode($this->playlist->getFilename()) );
        echo '<h3>Playlist: ' . htmlentities($playlistName) . '</h3>' . "\n";

        echo '<table class="linkTable">
                <tr>
                    <td width="22px"><img width="22px" height="22px" src="../resources/playlist/undo.png" /></td>
                    <td width="50%"><a href="index.php?web&action=' . ViewPlaylistWebPageAction::getActionName() . '&PHPSESID=' . session_id() . '">Return to explorer</a></td>
                    <td width="22px"><img width="22px" height="22px" src="../resources/playlist/db_add.png" /></td>
                    <td width="50%"><a href="index.php?web&action=' . ViewPlaylistWebPageAction::getActionName() . "&subaction=" . ViewPlaylistWebPageAction::SUBACTION_PLAYLIST_LINK_ADD . '&PHPSESID=' . session_id() . '">Add link</a></td>
                </tr>
              </table>' . "\n";

        echo '<table class="playlistTable">' . "\n";
        echo '  <thead>' . "\n";
        echo '      <tr>' . "\n";
        echo '          <th width="24px"></th>' . "\n";
        echo '          <th align="left">Playlist: ' . htmlentities($playlistName) . '</th>' . "\n";
        echo '          <th colspan="3">Actions</th>' . "\n";
        echo '      </tr>' . "\n";
        echo '  </thead>' . "\n";

        echo '  <tbody>' . "\n";
        foreach ($this->playlist->getPlaylistLinks() as $key => $link) {
            echo '  <tr>' . "\n";
            $this->showPlaylistLinkItem($link);
            echo '  </tr>' . "\n";
        }
        echo '      </tbody>' . "\n";

        echo '      <tfoot>' . "\n";
        echo '          <tr><th colspan="5" align="right">' . count($this->playlist->getPlaylistLinks()) . ' links found.</th></tr>' . "\n";
        echo '      </tfoot>' . "\n";

        echo '</table>' . "\n";


    }

    /**
     * Get playlist entry rss link.
     */
    private function showPlaylistLinkItem(PlaylistLink $link) {
        $itemLink = 'index.php?action=' . ViewPlaylistWebPageAction::getActionName() . URL_AMP .
                'subaction=' . ViewPlaylistWebPageAction::SUBACTION_PLAYLIST_LINK . URL_AMP .
                'link=' . base64_encode($link->getKey()) . URL_AMP .
                'PHPSESID=' . session_id();
	$deleteLink = 'index.php?action=' . ViewPlaylistWebPageAction::getActionName() . URL_AMP .
                'subaction=' . ViewPlaylistWebPageAction::SUBACTION_PLAYLIST_LINK_DELETE . URL_AMP .
                'link=' . base64_encode($link->getKey()) . URL_AMP .
                'PHPSESID=' . session_id();

        echo '      <td width="42px"><img width="42px" height="56px" src="' . $link->getThumbnail() . '" style="border:0px;" /></td>' . "\n";
        echo '      <td><p><a href="' . $itemLink . '">' . htmlentities($link->getTitle()) . '</a></p><p>' . htmlentities(utf8_decode($link->getLanguage())) . ', ' . htmlentities(utf8_decode($link->getFormat())) . ', ' . htmlentities(utf8_decode($link->getTypeDescription())) . '</p></td>' . "\n";
        echo '      <td width="24px"><a href="' . $itemLink . '"><img width="22px" height="22px" src="../resources/playlist/view.png" style="border:0px;" /></a></td>' . "\n";
        echo '      <td width="24px"><img width="22px" height="22px" src="../resources/playlist/edit.png" style="border:0px;" /></td>' . "\n";
        echo '      <td width="24px"><a href="' . $deleteLink . '" onclick="return confirm(\'Are you sure to delete link ' . htmlentities(utf8_decode($link->getTitle())) . '?\');"><img width="22px" height="22px" src="../resources/playlist/remove.png" style="border:0px;" /></a></td>' . "\n";
    }

}

?>
