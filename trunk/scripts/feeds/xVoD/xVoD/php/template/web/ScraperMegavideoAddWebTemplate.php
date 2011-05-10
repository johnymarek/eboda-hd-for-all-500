<?php
/*-------------------------
 *    Developed by Maicros
 *      GNU/GPL Licensed
 * ------------------------*/

class ScraperMegavideoAddWebTemplate extends WebTemplate {

    private $message = "";
    private $megavideoLinks = array();

    public function setMegavideoLinks($links) {
	$this->megavideoLinks = $links;
    }

    public function setMessage($message){
	$this->message = $message;
    }

    public function showBodyContent() {
        $megavideoScraper = "index.php?web&action=" . ViewScraperMegavideoPageAction::getActionName() . "&PHPSEDID=" . session_id();

        echo '<h3 style="margin-bottom:10px;">Add Megavideo Link</h3>' . "\n";

        echo '<table class="linkTable">
                <tr>
                    <td width="22px"><img width="22px" height="22px" src="../resources/playlist/undo.png" /></td>
                    <td width="50%" align="left"> <a href="' . $megavideoScraper . '">Return to Link List</a></td>
                    <td width="22px"></td>
                    <td width="50%"></td>
                </tr>
              </table>' . "\n";

	echo $this->message . "\n";

	echo '
	    <script>
		function showAddDiv(div){
		    divSingle   = document.getElementById("singleId");
		    divMultiple = document.getElementById("multipleIds");
		    if( div == 1){
			divSingle.style.display = "block";
			divMultiple.style.display = "none";
		    }else{
			divSingle.style.display = "none";
			divMultiple.style.display = "block";
		    }


		}
	    </script>' . "\n";

	echo '
		<div align="center" style="padding:10px">
		    <input type="button" name="btnSingleId" value="INSERT SINGLE MEGAVIDEO LINK" onclick="showAddDiv(1)" style="cursor:hand;cursor:pointer;" />
		    &nbsp;&nbsp;&nbsp;
		    <input type="button" name="btnMultipleIds" value="INSERT MULTIPLE MEGAVIDEO LINKS" onclick="showAddDiv(2)" style="cursor:hand;cursor:pointer;" />
		</div>' . "\n";
	echo '<div id="singleId">' . "\n";
        echo '<form action="index.php">' . "\n";
        echo '<table class="playlistTable">' . "\n";
        echo '  <thead>' . "\n";
        echo '      <tr>' . "\n";
        echo '          <th width="24px">Insert single Megavideo ID</th>' . "\n";
        echo '      </tr>' . "\n";
        echo '  </thead>' . "\n";

        echo '  <tbody>' . "\n";
        echo '      <tr>' . "\n";
        echo '          <td>' . "\n";
	echo '              <p>Fill Title, Description and Image fields to override Megavideo info. If you leave it in blank, this fields will be filled with Megavideo values.</p>' . "\n";
        ?>

        <table border="0" width="100%" cellpadding="0" cellspacing="0">
            <tr>
                <td>Megavideo ID (*): </td>
                <td><input type="text" id="key" name="key" value="" size="20" /></td>
            </tr>
            <tr>
                <td>Title: </td>
                <td><input type="text" id="title" name="title" value="" size="40" /></td>
            </tr>
            <tr>
                <td>Description: </td>
                <td><textarea id="description" name="description" rows="8" cols="40"></textarea></td>
            </tr>
	    <tr>
                <td>Image: </td>
                <td><input type="text" id="image" name="image" value="" size="40" /></td>
            </tr>
	    <tr>
                <td>Add another one: </td>
                <td><input type="checkbox" id="addother" name="addother" checked="true" value="ON" /></td>
            </tr>
        </table>
        <input type="hidden" name="web" value="" />
        <input type="hidden" name="action" value="<?php echo ViewScraperMegavideoPageAction::getActionName(); ?>" />
        <input type="hidden" name="subaction" value="<?php echo ViewScraperMegavideoPageAction::SUBACTION_SAVE_LINK; ?>" />
	<input type="hidden" name="typeadd" value="single" />
        <input type="hidden" name="PHPSESID" value="<?php echo session_id(); ?>" />

        <?php
        echo '          </td>' . "\n";
        echo '      </tr>' . "\n";
        echo '  </tbody>' . "\n";

        echo '  <tfoot>' . "\n";
        echo '      <tr><th align="right"><input type="submit" value="SAVE LINK" name="save" style="cursor:hand;height: 20px; font-size: 10px;" /> <input type="reset" value="CLEAR FIELDS" style="cursor:hand;height: 20px; font-size: 10px;" /></th></tr>' . "\n";
        echo '  </tfoot>' . "\n";

        echo '</table>' . "\n";
        echo '</form>' . "\n";
	echo '</div>' . "\n";


	//Multiple IDs
	echo '<div id="multipleIds" style="display:none;">' . "\n";
	echo '<form action="index.php">' . "\n";
        echo '<table class="playlistTable">' . "\n";
        echo '  <thead>' . "\n";
        echo '      <tr>' . "\n";
        echo '          <th width="24px">Multiple Megavideo IDs insert</th>' . "\n";
        echo '      </tr>' . "\n";
        echo '  </thead>' . "\n";

        echo '  <tbody>' . "\n";
        echo '      <tr>' . "\n";
        echo '          <td>' . "\n";
	echo '              <p>Fill Title, Description and Image fields to override Megavideo info. If you leave it in blank, this fields will be filled with Megavideo values.</p><p>Enter a Megavideo ID for each line.</p>' . "\n";
        ?>

        <table border="0" width="100%" cellpadding="0" cellspacing="0">
            <tr>
                <td>Megavideo ID: </td>
                <td><textarea id="key" name="key" rows="6" cols="50"></textarea></td>
            </tr>
            <tr>
                <td>Title (suffix count +1): </td>
                <td><input type="text" id="title" name="title" value="" size="40" /></td>
            </tr>
            <tr>
                <td>Description: </td>
                <td><textarea id="description" name="description" rows="8" cols="40"></textarea></td>
            </tr>
	    <tr>
                <td>Image: </td>
                <td><input type="text" id="image" name="image" value="" size="40" /></td>
            </tr>
        </table>
        <input type="hidden" name="web" value="" />
        <input type="hidden" name="action" value="<?php echo ViewScraperMegavideoPageAction::getActionName(); ?>" />
        <input type="hidden" name="subaction" value="<?php echo ViewScraperMegavideoPageAction::SUBACTION_SAVE_LINK; ?>" />
	<input type="hidden" name="typeadd" value="multiple" />
        <input type="hidden" name="PHPSESID" value="<?php echo session_id(); ?>" />

        <?php
        echo '          </td>' . "\n";
        echo '      </tr>' . "\n";
        echo '  </tbody>' . "\n";

        echo '  <tfoot>' . "\n";
        echo '      <tr><th align="right"><input type="submit" value="SAVE LINKS" name="save" style="cursor:hand;height: 20px; font-size: 10px;" /> <input type="reset" value="CLEAR FIELDS" style="cursor:hand;height: 20px; font-size: 10px;" /></th></tr>' . "\n";
        echo '  </tfoot>' . "\n";

        echo '</table>' . "\n";
        echo '</form>' . "\n";
	echo '</div>' . "\n";

    }

}

?>