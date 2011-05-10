<?php
/*-------------------------
 *    Developed by Maicros
 *      GNU/GPL Licensed
 * ------------------------*/

class PlaylistLinkAddWebTemplate extends WebTemplate {

    private $playlist = null;

    public function setPlaylist($playlist) {
        $this->playlist = $playlist;
    }

    public function showBodyContent() {
        $playlistLink = 'index.php?web&action=' . ViewPlaylistWebPageAction::getActionName() .
                '&subaction=' . ViewPlaylistWebPageAction::SUBACTION_PLAYLIST_OPEN .
                '&playlist=' . base64_encode($this->playlist->getFilename()) .
                '&PHPSESID=' . session_id();

        echo '<h3 style="margin-bottom:10px;">Add Link to Playlist</h3>' . "\n";

        echo '<table class="linkTable">
                <tr>
                    <td width="22px"><img width="22px" height="22px" src="../resources/playlist/undo.png" /></td>
                    <td width="50%" align="left"> <a href="' . $playlistLink . '">Return to Playlist</a></td>
                    <td width="22px"><img width="22px" height="22px" src="../resources/playlist/undo.png" /></td>
                    <td width="50%"><a href="index.php?web&action=' . ViewPlaylistWebPageAction::getActionName() . '&PHPSESID=' . session_id() . '">Return to explorer</a></td>
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
                <td>Title (*): </td>
                <td><input type="text" id="title" name="title" value="" size="40" /></td>
            </tr>
            <tr>
                <td>Description: </td>
                <td><textarea id="description" name="description" rows="8" cols="40"></textarea></td>
            </tr>
            <tr>
                <td>Thumbnail: </td>
                <td><input type="text" id="thumbnail" name="thumbnail" value="" size="40" /> (Http link or Xtreamer file path)</td>
            </tr>
            <tr>
                <td>Format: </td>
                <td><input type="text" id="format" name="format" value="" size="50" /></td>
            </tr>
            <tr>
                <td>Language: </td>
                <td>
		    <select id="language" name="language">
			<option label="Arabic" value="ar">Arabic</option>
			<option label="Catalonia" value="ca">Catalonia</option>
			<option label="Deutch" value="de">Deutch</option>
			<option label="English" value="en">English</option>
			<option label="Estonian" value="et">Estonian</option>
			<option label="Finnish" value="fi">Finnish</option>
			<option label="French" value="fr">French</option>
			<option label="Greek" value="gr">Greek</option>
			<option label="Hebrew" value="he">Hebrew</option>
			<option label="Hungary" value="hu">Hungary</option>
			<option label="Italian" value="it">Italian</option>
			<option label="Korean" value="kr">Korean</option>
			<option label="Polish" value="pl">Polish</option>
			<option label="Portugal-BR" value="pr-b">Portugal-BR</option>
			<option label="Romanian" value="ro">Romanian</option>
			<option label="Russian" value="ru">Russian</option>
			<option label="Simplified Chinese" value="zh_CN">Simplified Chinese</option>
			<option label="Slovenian" value="sl">Slovenian</option>
			<option label="Spanish" value="es">Spanish</option>
			<option label="Swahili" value="sw">Swahili</option>
			<option label="Traditional Chinese" value="cn">Traditional Chinese</option>
		    </select>
		</td>
            </tr>
            <tr>
                <td>Link/IDs (*): </td>
                <td><input type="text" id="link" name="link" value="" size="50" />
		    <br/>Megavideo/Megaupload IDs space separated, or direct http link to file

		</td>
            </tr>
	    <tr>
                <td>Type (*): </td>
                <td>
		    <select id="type" name="type">
			<option value="MV">Megavideo</option>
			<option value="MU">Megaupload</option>
			<option value="HTTP">HTTP File</option>
		    </select>
		</td>
            </tr>

        </table>
        <input type="hidden" name="web" value="" />
        <input type="hidden" name="action" value="<?php echo ViewPlaylistWebPageAction::getActionName(); ?>" />
        <input type="hidden" name="subaction" value="<?php echo ViewPlaylistWebPageAction::SUBACTION_PLAYLIST_LINK_SAVE; ?>" />
        <input type="hidden" name="PHPSESID" value="<?php echo session_id(); ?>" />

        <?php
        echo '          </td>' . "\n";
        echo '      </tr>' . "\n";
        echo '  </tbody>' . "\n";

        echo '  <tfoot>' . "\n";
        echo '      <tr><th align="right"><input type="submit" value="CREATE LINK" name="save" style="cursor:hand;height: 20px; font-size: 10px;" /> <input type="reset" value="CLEAR FIELDS" style="cursor:hand;height: 20px; font-size: 10px;" /></th></tr>' . "\n";
        echo '  </tfoot>' . "\n";

        echo '</table>' . "\n";
        echo '</form>' . "\n";


    }

}

?>
