<?php
/*-------------------------
 *    Developed by Maicros
 *      GNU/GPL Licensed
 * ------------------------*/

class PlaylistUploadWebTemplate extends WebTemplate {

    private $title = null;
    private $basePath = null;
    private $message = null;

    public function  __construct($title=null) {
        $this->title = $title;
    }

    public function setBasePath($basePath) {
        $this->basePath = $basePath;
    }

    public function setMessage($message) {
        $this->message = $message;
    }

    public function showBodyContent() {
        $playlistUploadLink = SERVER_PATH . 'php/index.php?web&action=' . ViewPlaylistWebPageAction::getActionName() .
                '&subaction=' . ViewPlaylistWebPageAction::SUBACTION_PLAYLIST_UPLOAD_SAVE .
                '&PHPSESID=' . session_id();
        $explorerLink = SERVER_PATH . 'php/index.php?web&action=' . ViewPlaylistWebPageAction::getActionName() .
                '&PHPSESID=' . session_id();

        ?>

<h3>Upload Playlist to <?php echo $this->basePath; ?></h3>

<table class="linkTable">
    <tr>
        <td width="22px"><img width="22px" height="22px" src="../resources/playlist/undo.png" /></td>
        <td width="100%" align="left"><a href="<?php echo $explorerLink; ?>">Return to Explorer</a></td>
    </tr>
</table>

        <?php
        if( $this->message && count($this->message) > 0 ) {
            echo "<ul> \n";
            foreach ($this->message as $value) {
                echo "  <li style=\"font-weight:bold;\">" . $value . "</li>\n";
            }
            echo "</ul> \n";
        }
        ?>

<form action="<?php echo $playlistUploadLink; ?>" method="POST" enctype="multipart/form-data">
    <table class="playlistTable">
        <thead>
            <tr>
                <th width="24px">Only upload files with XPLS extension</th>
            </tr>
        </thead>

        <tbody>
            <tr>
                <td>
		    Use Upload File to upload file from your computer to Xtreamer. Or fill Upload Web File with a valid HTTP url that contains a valid XPLS format.
                    <table border="0" width="100%" cellpadding="0" cellspacing="0">
                        <tr>
                            <td>Upload File: </td>
                            <td colspan="2">
                                <input type="file" name="uploadFile" value="" size="60" accept="xpls" />
                                <input type="hidden" name="MAX_FILE_SIZE" value="5000000">
                            </td>
                        </tr>
                        <tr>
                            <td rowspan="2">Upload web file (http): </td>
                            <td style="width:80px; border-bottom:0px;">Name:</td>
                            <td style="border-bottom:0px;"><input type="text" name="uploadFileWebName" value="" size="20" /></td>
                        </tr>
                        <tr>
                            <td style="width:80px;">Link (*):</td>
                            <td><input type="text" name="uploadFileWeb" value="http://" size="50" /></td>
                        </tr>
                        <tr>
                            <td>Return to Explorer: </td>
                            <td colspan="2"><input type="checkbox" name="returnExplorer" value="ON" /></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </tbody>

        <tfoot>
            <tr>
                <th align="right">
                    <input type="submit" value="UPLOAD DATA" name="save" style="cursor:hand;height: 20px; font-size: 10px;" />
                    <input type="reset" value="CLEAR FIELDS" style="cursor:hand;height: 20px; font-size: 10px;" />
                </th>
            </tr>
        </tfoot>
    </table>
</form>
        <?php

    }

}

?>