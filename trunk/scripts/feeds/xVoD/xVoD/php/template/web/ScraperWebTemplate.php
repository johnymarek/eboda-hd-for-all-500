<?php
/*-------------------------
 *    Developed by Maicros
 *      GNU/GPL Licensed
 * ------------------------*/

class ScraperWebTemplate extends WebTemplate {

    private $scrapers = array();
    private $favourites = array();
    private $showScrapersView = true;

    public function setShowScrapersView($showScrapersView) {
        $this->showScrapersView = $showScrapersView;
    }

    public function setScrapers($scrapers) {
        $this->scrapers = $scrapers;
    }

    public function setFavourites($favourites) {
        $this->favourites = $favourites;
    }

    public function showBodyContent() {
        if( $this->showScrapersView ) {
            $this->printScrapersList();
        }else {
            $this->printAddScraper();
        }

    }

    /**
     * Print html table with scrapers list
     */
    private function printScrapersList() {
        $newScraperLink = "index.php?web&action=" . ViewScraperPageAction::getActionName() .
                    "&subaction=" . ViewScraperPageAction::SUBACTION_SCRAPER_ADD .
                    "&PHPSEDID=" . session_id();

        echo '<h3>Scrapers List</h3>' . "\n";

        echo '<table class="linkTable">' . "\n";
        echo '  <tr>' . "\n";
        echo '      <td><img width="22px" height="22px" src="../resources/img/edit_add.png" /></td>' . "\n";
        echo '      <td width="100%"><a href="' . $newScraperLink . '">Add New Scraper</a></td>' . "\n";
        echo '  </tr>' . "\n";
        echo '</table>' . "\n\n";

        echo '<table class="playlistTable">' . "\n";
        echo '  <thead>' . "\n";
        echo '      <tr>' . "\n";
        echo '          <th colspan="3"></th>' . "\n";
        echo '          <th>Name</th>' . "\n";
        echo '          <th>Description</th>' . "\n";
        echo '          <th>Lang.</th>' . "\n";
        echo '          <th colspan="2">Actions</th>' . "\n";
        echo '      </tr>' . "\n";
        echo '  </thead>' . "\n";

        echo '  <tbody>' . "\n";
        foreach ($this->scrapers as $scraper) {
            $deleteLink = "index.php?web&action=" . ViewScraperPageAction::getActionName() .
                    "&subaction=" . ViewScraperPageAction::SUBACTION_SCRAPER_DELETE .
                    "&id=" . $scraper->getId() .
                    "&PHPSEDID=" . session_id();
            $addPreselectedLink = "index.php?web&action=" . ViewScraperPageAction::getActionName() .
                    "&subaction=" . ViewScraperPageAction::SUBACTION_SCRAPER_FAVOURITE .
                    "&id=" . $scraper->getId() .
                    "&PHPSEDID=" . session_id();

            echo '          <tr>' . "\n";
            echo '              <td>' . ( $this->isFavourite($scraper->getId()) ? '<img src="../image/img/star.png" alt="Added to Scraper Preselected" width="22px" height="22px" />' : '' ) . '</td>' . "\n";
            echo '              <td><img src="../image/img/' . $scraper->getType() . '.png" alt="' . $scraper->getType() . '" title="Type: ' . $scraper->getType() . '" width="22px" height="22px" /></td>' . "\n";
            echo '              <td><img src="../image/' . $scraper->getImage() . '" alt="Logo" title="Logo" width="32px" height="22px" /></td>' . "\n";
            echo '              <td>' . $scraper->getName() . '</td>' . "\n";
            echo '              <td>' . $scraper->getDescription() . '</td>' . "\n";
            echo '              <td>' . $scraper->getLanguage() . '</td>' . "\n";
            echo '              <td width="24px"><a href="' . $addPreselectedLink . '"><img width="22px" height="22px" src="../resources/img/bookmark_add.png" style="border:0px;" alt="Add Scraper to preselected list" title="Add Scraper to preselected list" /></a></td>' . "\n";
            echo '              <td width="24px"><a href="' . $deleteLink . '"><img width="22px" height="22px" src="../resources/img/remove.png" style="border:0px;" alt="Remove Scraper" title="Remove Scraper" onclick="return confirm(\'WARNING!! You cannot restore this data!! Are you sure to delete scraper ' . $scraper->getName() . '?\');" /></a></td>' . "\n";
            echo '          </tr>' . "\n";
        }
        echo '      </tbody>' . "\n";

        echo '      <tfoot>' . "\n";
        echo '          <tr><th colspan="8" align="right">' . count($this->scrapers) . ' elements found.</th></tr>' . "\n";
        echo '      </tfoot>' . "\n";
        echo '</table>' . "\n";

        echo '<table class="playlistTable" style="margin-top: -20px; border-bottom: 1px solid black; background: #DDDDDD;">' . "\n";
        echo '  <tr>' . "\n";
        echo '      <td><img src="../image/img/star.png" alt="" title="" width="22px" height="22px" /></td>' . "\n";
        echo '      <td>This icon means that the scraper is selected to show as shortcut on first xVoD screen (with 1, 2, 3 or 4 key depending of scraper type).</td>' . "\n";
        echo '  </tr>' . "\n";
        echo '  <tr>' . "\n";
        echo '      <td><img src="../image/img/anime.png" alt="Anime" title="Anime" width="22px" height="22px" /></td>' . "\n";
        echo '      <td>Scraper shows <b>Anime movies</b> and <b>series</b> contents.</td>' . "\n";
        echo '  </tr>' . "\n";
        echo '  <tr>' . "\n";
        echo '      <td><img src="../image/img/documentary.png" alt="Documentary" title="Documentary" width="22px" height="22px" /></td>' . "\n";
        echo '      <td>Scraper shows <b>Documentary</b> contents.</td>' . "\n";
        echo '  </tr>' . "\n";
        echo '  <tr>' . "\n";
        echo '      <td><img src="../image/img/mixed.png" alt="Mixed" title="Mixed" width="22px" height="22px" /></td>' . "\n";
        echo '      <td>Scraper shows <b>Mixed</b> content (series, movies, documentaries, tv-shows, other links,...).</td>' . "\n";
        echo '  </tr>' . "\n";
        echo '  <tr>' . "\n";
        echo '      <td><img src="../image/img/movie.png" alt="Movie" title="Movie" width="22px" height="22px" /></td>' . "\n";
        echo '      <td>Scraper shows <b>Movie</b> contents.</td>' . "\n";
        echo '  </tr>' . "\n";
        echo '  <tr>' . "\n";
        echo '      <td><img src="../image/img/serie.png" alt="Serie" title="Serie" width="22px" height="22px" /></td>' . "\n";
        echo '      <td>Scraper shows <b>TV-Show</b> or <b>Series</b> contents.</td>' . "\n";
        echo '  </tr>' . "\n";
        echo '</table>' . "\n";
    }


    /**
     * Print add scraper view.
     */
    private function printAddScraper() {
        $scrapersLink = 'index.php?web&action=' . ViewScraperPageAction::getActionName() .
                '&PHPSESID=' . session_id();

        echo '<h3 style="margin-bottom:10px;">Add new Scraper</h3>' . "\n";
        
        echo '<table width="100%" style="margin-bottom:10px;">
                <tr>
                    <td width="22px"><img width="22px" height="22px" src="../resources/playlist/undo.png" /></td>
                    <td width="100%" align="left"> <a href="' . $scrapersLink . '">Return to Scrapers List</a></td>
                </tr>
              </table>' . "\n";

        echo '<form action="index.php?web&action=' . ViewScraperPageAction::getActionName() . '&subaction=' . ViewScraperPageAction::SUBACTION_SCRAPER_SAVE . '&PHPSESID=' . session_id() . '" method="POST">' . "\n";
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
        <td>Name (*): </td>
        <td><input type="text" id="name" name="name" value="" size="40" /></td>
    </tr>
    <tr>
        <td>Description: </td>
        <td><textarea id="description" name="description" rows="6" cols="40"></textarea></td>
    </tr>
    <tr>
        <td>Image: </td>
        <td><input type="text" id="image" name="image" value="logo/" size="40" /> (relative to "/xVoD/php/image/")</td>
    </tr>
    <tr>
        <td>Link (*): </td>
        <td><input type="text" id="link" name="link" value="/" size="40" /> (relative to "/xVoD/php/scraper/")</td>
    </tr>
    <tr>
        <td>Language (*): </td>
        <td>
            <select id="language" name="language">
                <option value="AR">Arabic</option>
                <option value="EU">Basque</option>
                <option value="CA">Catalan</option>
                <option value="CN">Chinese</option>
                <option value="EN">English</option>
                <option value="FI">Finnish</option>
                <option value="FR">French</option>
                <option value="DE">German</option>
                <option value="HE">Hebrew</option>
                <option value="HU">Hungarian</option>
                <option value="IT">Italian</option>
                <option value="NL">Netherlands</option>
                <option value="KR">Korean</option>
                <option value="PT">Portuguese</option>
                <option value="RO">Romanian</option>
                <option value="RU">Russian</option>
                <option value="SL">Slovenian</option>
                <option value="ES">Spanish</option>
                <option value="SW">Swahili</option>
            </select>
        </td>
    </tr>
    <tr>
        <td>Content type (*): </td>
        <td>
            <select id="type" name="type">
                <option value="anime">Anime movies or series</option>
                <option value="documentary">Documentaries</option>
                <option value="mixed">Mixed content</option>
                <option value="movie">Movies</option>
                <option value="serie">TV-Shows and Series</option>
            </select>
        </td>
    </tr>
</table>

        <?php
        echo '          </td>' . "\n";
        echo '      </tr>' . "\n";
        echo '  </tbody>' . "\n";

        echo '  <tfoot>' . "\n";
        echo '      <tr><th align="right"><input type="submit" value="CREATE SCRAPER" name="save" style="cursor:hand;height: 20px; font-size: 10px;" /> <input type="reset" value="CLEAR FIELDS" style="cursor:hand;height: 20px; font-size: 10px;" /></th></tr>' . "\n";
        echo '  </tfoot>' . "\n";

        echo '</table>' . "\n";
        echo '</form>' . "\n";
    }

    /**
     * Check if scraper is marked as favourite.
     * @param int $id
     * @return boolean
     */
    private function isFavourite( $idScraper ) {
        foreach ($this->favourites as $id=>$favourite) {
            if( $id == $idScraper ) {
                return true;
            }
        }
        return false;
    }

}

?>