<?php
/*-------------------------
 *    Developed by Maicros
 *      GNU/GPL Licensed
 * ------------------------*/

class FavouriteWebTemplate extends WebTemplate {

    private $favourites = array();

    public function setFavourites($favourites){
        $this->favourites = $favourites;
    }

    public function showBodyContent() {
        $linkCookieManually = "index.php?web&action=" . ViewFavouritePageAction::getActionName() .
                "&PHPSESID=" . session_id();


        echo '<h3>Bookmarks List</h3>' . "\n";

        echo '<table class="playlistTable">' . "\n";
        echo '  <thead>' . "\n";
        echo '      <tr>' . "\n";
        echo '          <th></th>' . "\n";
        echo '          <th>Name</th>' . "\n";
        echo '          <th>Description</th>' . "\n";
        echo '          <th>Link</th>' . "\n";
        echo '          <th></th>' . "\n";
        echo '      </tr>' . "\n";
        echo '  </thead>' . "\n";

        echo '  <tbody>' . "\n";
        foreach ($this->favourites as $favourite) {
            $deleteLink = "index.php?web&action=" . ViewFavouritePageAction::getActionName() .
                    "&subaction=" . ViewFavouritePageAction::SUBACTION_FAVOURITE_DELETE .
                    "&id=" . $favourite->getId() .
                    "&PHPSEDID=" . session_id();

            echo '          <tr>' . "\n";
            echo '              <td align="center" width="84px"><img src="' . $favourite->getImage() . '" alt="Image" title="Image" width="42px" height="56px" onmouseover="this.width=\'84\';this.height=\'112\'" onmouseout="this.width=\'42\';this.height=\'56\'" /></td>' . "\n";
            echo '              <td>' . $favourite->getName() . '</td>' . "\n";
            echo '              <td>' . $favourite->getDescription() . '</td>' . "\n";
            echo '              <td width="45px"><a target="_blank" href="../' . $favourite->getLink() . '">LINK</a></td>' . "\n";
            echo '              <td width="24px"><a href="' . $deleteLink . '"><img width="22px" height="22px" src="../resources/img/remove.png" style="border:0px;" alt="Remove Scraper" title="Remove Favourite" onclick="return confirm(\'WARNING!! Are you sure to delete favorite ' . $favourite->getName() . '?\');" /></a></td>' . "\n";
            echo '          </tr>' . "\n";
        }
        echo '      </tbody>' . "\n";

        echo '      <tfoot>' . "\n";
        echo '          <tr><th colspan="5" align="right">' . count($this->favourites) . ' elements found.</th></tr>' . "\n";
        echo '      </tfoot>' . "\n";
        echo '</table>' . "\n";

    }


}

?>