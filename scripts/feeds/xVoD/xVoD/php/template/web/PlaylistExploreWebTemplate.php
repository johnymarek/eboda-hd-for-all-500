<?php
/*-------------------------
 *    Developed by Maicros
 *      GNU/GPL Licensed
 * ------------------------*/

class PlaylistExploreWebTemplate extends WebTemplate {

    private $title = null;
    private $items = array();
    private $baseFolder = null;
    private $message = null;

    public function  __construct($title=null) {
        $this->title = $title;
    }

    public function setItems(array $items) {
        $this->items = $items;
    }

    public function setBaseFolder($baseFolder) {
        $this->baseFolder = $baseFolder;
    }

    public function setMessage($message) {
        $this->message = $message;
    }

    public function showBodyContent() {
        $newFolderLink = 'index.php?web&action=' . ViewPlaylistWebPageAction::getActionName() .
                '&subaction=' . ViewPlaylistWebPageAction::SUBACTION_FOLDER_ADD . '&PHPSESID=' . session_id();
        $newPlaylistLink = 'index.php?web&action=' . ViewPlaylistWebPageAction::getActionName() .
                '&subaction=' . ViewPlaylistWebPageAction::SUBACTION_PLAYLIST_ADD . '&PHPSESID=' . session_id();
        $uploadPlaylistLink = 'index.php?web&action=' . ViewPlaylistWebPageAction::getActionName() .
                '&subaction=' . ViewPlaylistWebPageAction::SUBACTION_PLAYLIST_UPLOAD. '&PHPSESID=' . session_id();

        echo '<h3>Playlist Folder Explorer</h3>' . "\n";

        echo '<table class="linkTable">
                <tr>
                    <td><img width="22px" height="22px" src="../resources/playlist/folder_new.png" /></td>
                    <td width="33%"><a href="' . $newFolderLink . '" onclick="folder = prompt(\'Input new folder name:\', \'\'); this.href = this.href + \'&folder=\' + folder; return (folder != \'\' && folder != null);">Add New Folder</a></td>
                    <td><img width="22px" height="22px" src="../resources/playlist/video_add.png" /></td>
                    <td width="33%"><a href="' . $newPlaylistLink . '">Add New Playlist</a></td>
                    <td><img width="22px" height="22px" src="../resources/playlist/video_upload.png" /></td>
                    <td width="34%"><a href="' . $uploadPlaylistLink . '">Upload Playlist</a></td>
                </tr>
              </table>' . "\n";
        if( $this->message ) {
            echo '<p style="font-weight:bold;">' . htmlentities($this->message) . '</p>' . "\n";
        }
        echo '<table class="playlistTable">' . "\n";
        echo '  <thead>' . "\n";
        echo '      <tr>' . "\n";
        echo '          <th width="24px"></th>' . "\n";
        echo '          <th align="left">Folder: ' . htmlentities(utf8_decode($this->title)) . '</th>' . "\n";
        echo '          <th colspan="4">Actions</th>' . "\n";
        echo '      </tr>' . "\n";
        echo '  </thead>' . "\n";

        echo '  <tbody>' . "\n";
        foreach ($this->items as $item) {
            echo '  <tr>' . "\n";
            if( @get_class($item) == "Playlist" ) {
                echo $this->showPlaylistItem($item);
            }else {
                echo $this->showPlaylistFolder($item);
            }
            echo '  </tr>' . "\n";
        }
        echo '      </tbody>' . "\n";

        echo '      <tfoot>' . "\n";
        echo '          <tr><th colspan="6" align="right">' . count($this->items) . ' elements found.</th></tr>' . "\n";
        echo '      </tfoot>' . "\n";

        echo '</table>' . "\n";
    }

    private function showPlaylistItem(Playlist $item) {
        $donwloadLink = 'index.php?web&action=' . ViewPlaylistWebPageAction::getActionName() .
                '&subaction=' . ViewPlaylistWebPageAction::SUBACTION_PLAYLIST_DOWNLOAD .
                '&download=' . base64_encode($item->getFilename()) .
                '&PHPSESID=' . session_id();

        $itemLink = 'index.php?web&action=' . ViewPlaylistWebPageAction::getActionName() .
                '&subaction=' . ViewPlaylistWebPageAction::SUBACTION_PLAYLIST_OPEN .
                '&playlist=' . base64_encode($item->getFilename()) .
                '&PHPSESID=' . session_id();

        $deleteLink = 'index.php?web&action=' . ViewPlaylistWebPageAction::getActionName() .
                '&subaction=' . ViewPlaylistWebPageAction::SUBACTION_PLAYLIST_DELETE .
                '&path=' . base64_encode($item->getFilename()) .
                '&PHPSESID=' . session_id();

        $itemName = ( ($item->getName()!=null) ? $item->getName() . " (" . utf8_decode($item->getFilename()) . ")" : utf8_decode($item->getFilename()));

        echo '      <td width="24px"><img width="22px" height="22px" src="../resources/playlist/video.png" style="border:0px;" /></td>' . "\n";
        echo '      <td><a href="' . $itemLink . '">' . htmlentities($itemName) . '</a></td>' . "\n";
        echo '      <td width="24px"><a href="' . $donwloadLink . '" target="_blank"><img width="22px" height="22px" src="../resources/playlist/video_down.png" style="border:0px;" alt="Donwload Playlist" title="Donwload Playlist" /></a></td>' . "\n";
        echo '      <td width="24px"><a href="' . $itemLink . '"><img width="22px" height="22px" src="../resources/playlist/view.png" style="border:0px;" alt="Open Playlist" title="Open Playlist" /></a></td>' . "\n";
        echo '      <td width="24px"><img width="22px" height="22px" src="../resources/playlist/edit.png" style="border:0px;" alt="Edit Playlist" title="Edit Playlist" /></td>' . "\n";
        echo '      <td width="24px"><a href="' . $deleteLink . '"><img width="22px" height="22px" src="../resources/playlist/remove.png" style="border:0px;" alt="Remove Playlist" title="Remove Playlist"
            onclick="return confirm(\'Are you sure to delete playlist ' . htmlentities(utf8_decode($item->getFilename())) . '?\');" /></a></td>' . "\n";
    }

    private function showPlaylistFolder($folder) {
        $donwloadLink = 'index.php?web&action=' . ViewPlaylistWebPageAction::getActionName() .
                '&subaction=' . ViewPlaylistWebPageAction::SUBACTION_FOLDER_DOWNLOAD .
                '&download=' . base64_encode($folder) .
                '&PHPSESID=' . session_id();

        $itemLink = 'index.php?web&action=' . ViewPlaylistWebPageAction::getActionName() .
                '&subaction=' . ViewPlaylistWebPageAction::SUBACTION_PLAYLIST_FOLDER_OPEN .
                '&folder=' . base64_encode($folder) .
                '&PHPSESID=' . session_id();

        $deleteLink = 'index.php?web&action=' . ViewPlaylistWebPageAction::getActionName() .
                '&subaction=' . ViewPlaylistWebPageAction::SUBACTION_FOLDER_DELETE .
                '&folder=' . base64_encode($folder) .
                '&PHPSESID=' . session_id();

        echo '      <td width="24px"><img width="22px" height="22px" src="../resources/playlist/folder_blue.png" /></td>' . "\n";
        echo '      <td style="font-weight:bold;"><a href="' . $itemLink . '">' . htmlentities(utf8_decode($folder)) . '</td>' . "\n";
        echo '      <td width="24px">' . ( ($folder != "..") ? '<a href="' . $donwloadLink . '" target="_blank"><img width="22px" height="22px" src="../resources/playlist/folder_down.png" style="border:0px;" alt="Donwload Folder" title="Donwload Folder" /></a>' : '' ) . '</td>' . "\n";
        echo '      <td width="24px"><a href="' . $itemLink . '"><img width="22px" height="22px" src="../resources/playlist/view.png" style="border:0px;" alt="Load folder" title="Load folder" /></a></td>' . "\n";
        echo '      <td width="24px">' . '</td>' . "\n";
        echo '      <td width="24px"><a href="' . $deleteLink . '"><img width="22px" height="22px" src="../resources/playlist/remove.png" style="border:0px;" alt="Remove folder" title="Remove folder"
            onclick="return confirm(\'Are you sure to delete folder ' . htmlentities(utf8_decode($folder)) . '?\');" /></a></td>' . "\n";
    }

}

?>