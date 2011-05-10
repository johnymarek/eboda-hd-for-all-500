<?php
/*-------------------------
 *    Developed by Maicros
 *      GNU/GPL Licensed
 * ------------------------*/

class ScraperMegavideoWebTemplate extends WebTemplate {

    private $message = "";
    private $megavideoLinks = array();

    public function setMegavideoLinks($links) {
	$this->megavideoLinks = $links;
    }

    public function setMessage($message){
	$this->message = $message;
    }

    public function showBodyContent() {
	$newLink = "index.php?web&action=" . ViewScraperMegavideoPageAction::getActionName() .
                    "&subaction=" . ViewScraperMegavideoPageAction::SUBACTION_VIEW_ADD_LINK .
                    "&PHPSEDID=" . session_id();

	echo '<h3>xVoD Megavideo Scraper link list</h3>' . "\n";

	echo '<table class="linkTable">' . "\n";
        echo '  <tr>' . "\n";
        echo '      <td><img width="22px" height="22px" src="../resources/img/edit_add.png" /></td>' . "\n";
        echo '      <td width="100%"><a href="' . $newLink . '">Add New Link</a></td>' . "\n";
        echo '  </tr>' . "\n";
        echo '</table>' . "\n\n";

	echo $this->message . "\n";

	echo '<table class="playlistTable">' . "\n";
        echo '  <thead>' . "\n";
        echo '      <tr>' . "\n";
        echo '          <th></th>' . "\n";
        echo '          <th>Name</th>' . "\n";
        echo '          <th>Description</th>' . "\n";
	echo '          <th>Added</th>' . "\n";
        echo '          <th></th>' . "\n";
	echo '          <th></th>' . "\n";
        echo '      </tr>' . "\n";
        echo '  </thead>' . "\n";

	echo '  <tbody>' . "\n";
        foreach ($this->megavideoLinks as $link) {
            $deleteLink = "index.php?web&action=" . ViewScraperMegavideoPageAction::getActionName() .
                    "&subaction=" . ViewScraperMegavideoPageAction::SUBACTION_DELETE_LINK .
                    "&id=" . $link->getId() .
                    "&PHPSEDID=" . session_id();

            echo '          <tr>' . "\n";
            echo '              <td align="center" width="84px"><a target="_blank" href="' . $link->getImage() . '"><img src="' . $link->getImage() . '" alt="Image" title="Image" width="42px" height="32px" style="border:0px" onmouseover="this.width=\'84\';this.height=\'64\'" onmouseout="this.width=\'42\';this.height=\'32\'" /></a></td>' . "\n";
            echo '              <td>' . $link->getTitle() . '</td>' . "\n";
            echo '              <td>' . $link->getDescription() . '</td>' . "\n";
	    echo '              <td>' . $link->getDateAdded() . '</td>' . "\n";
            echo '              <td width="24px"><a target="_blank" href="http://www.megavideo.com/?v=' . $link->getId() . '"><img width="22px" height="22px" src="../resources/playlist/view.png" style="border:0px;" alt="View Link" title="View Link" /></a></td>' . "\n";
            echo '              <td width="24px"><a href="' . $deleteLink . '"><img width="22px" height="22px" src="../resources/img/remove.png" style="border:0px;" alt="Remove Scraper" title="Remove Scraper" onclick="return confirm(\'WARNING!! Are you sure to delete bookmark ' . $link->getTitle() . '?\');" /></a></td>' . "\n";
            echo '          </tr>' . "\n";
        }
        echo '      </tbody>' . "\n";

        echo '      <tfoot>' . "\n";
        echo '          <tr><th colspan="6" align="right">' . count($this->megavideoLinks) . ' elements found.</th></tr>' . "\n";
        echo '      </tfoot>' . "\n";
        echo '</table>' . "\n";

    }

}

?>
