<?php
/*-------------------------
 *    Developed by Maicros
 *      GNU/GPL Licensed
 * ------------------------*/

class PlaylistAddWebTemplate extends WebTemplate {

    private $basepath = null;

    public function setBasepath($basepath){
        $this->basepath = $basepath;
    }

    public function showBodyContent() {
        $playlistLink = 'index.php?web&action=' . ViewPlaylistWebPageAction::getActionName() . '&PHPSESID=' . session_id();

        echo '<h3 style="margin-bottom:10px;">Add new Playlist</h3>' . "\n";

        echo '<table class="linkTable">
                <tr>
                    <td width="22px"><img width="22px" height="22px" src="../resources/playlist/undo.png" /></td>
                    <td width="100%" align="left"> <a href="' . $playlistLink . '">Return to Explorer</a></td>
                </tr>
              </table>' . "\n";

        echo '<form action="index.php">' . "\n";
        echo '<table class="playlistTable">' . "\n";
        echo '  <thead>' . "\n";
        echo '      <tr>' . "\n";
        echo '          <th width="24px">&nbsp;</th>' . "\n";
        echo '      </tr>' . "\n";
        echo '  </thead>' . "\n";

        echo '  <tbody>' . "\n";
        echo '      <tr>' . "\n";
        echo '          <td>' . "\n";
        ?>

            <table border="0" width="100%" cellpadding="0" cellspacing="0">
                    <tr>
                        <td>Name: </td>
                        <td><input type="text" id="name" name="name" value="" size="40" /></td>
                    </tr>
                    <tr>
                        <td>Description: </td>
                        <td><textarea id="description" name="description" rows="6" cols="40"></textarea></td>
                    </tr>
                    <tr>
                        <td>Filename (*): </td>
                        <td><input type="text" id="filename" name="filename" value="" size="40" /></td>
                    </tr>
                    <tr>
                        <td>Path: </td>
                        <td><input type="text" id="path" name="path" value="<?php echo $this->basepath; ?>" size="50" readonly="true" style="background-color:#DDDDDD;" /></td>
                    </tr>
            </table>
            <input type="hidden" name="web" value="" />
            <input type="hidden" name="action" value="<?php echo ViewPlaylistWebPageAction::getActionName(); ?>" />
            <input type="hidden" name="subaction" value="<?php echo ViewPlaylistWebPageAction::SUBACTION_PLAYLIST_ADD_SAVE; ?>" />
            <input type="hidden" name="PHPSESID" value="<?php echo session_id(); ?>" />

<?php
        echo '          </td>' . "\n";
        echo '      </tr>' . "\n";
        echo '  </tbody>' . "\n";

        echo '  <tfoot>' . "\n";
        echo '      <tr><th align="right"><input type="submit" value="CREATE PLAYLIST" name="save" style="cursor:hand;height: 20px; font-size: 10px;" /> <input type="reset" value="CLEAR FIELDS" style="cursor:hand;height: 20px; font-size: 10px;" /></th></tr>' . "\n";
        echo '  </tfoot>' . "\n";

        echo '</table>' . "\n";
        echo '</form>' . "\n";


    }

}

?>