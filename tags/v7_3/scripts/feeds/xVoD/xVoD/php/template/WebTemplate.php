<?php
/*-------------------------
 *    Developed by Maicros
 *      GNU/GPL Licensed
 * ------------------------*/

abstract class WebTemplate {

    private $pageTitle = "xVoD - Xtreamer Video On Demand";

    /**
     * Sets title html tag content on page.
     * @param String $pageTitle
     */
    public function setPageTitle($pageTitle){
        $this->pageTitle = $pageTitle;
    }

    /**
     * Print out html page.
     */
    public function show() {
        echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">' . "\n";
        echo '<html xmlns="http://www.w3.org/1999/xhtml">' . "\n";
        echo "  <head>\n";
        $this->showHead();
        echo "  </head>\n";
        echo "  <body>\n";
        $this->showBody();
        echo "  </body>\n";
        echo "</html>\n";
    }

    /**
     * Show html head tag content.
     */
    private function showHead() {
        ?>
        <title><?php echo $this->pageTitle; ?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta http-equiv="cache-control" content="no-cache">
        <meta http-equiv="expires" content="1">

        <link rel="stylesheet" type="text/css" href="<?php echo SERVER_PATH; ?>resources/css/red_template.css">

        <?php
    }

    /**
     * Show html body tag content.
     */
    private function showBody() {
        $homeLink = "index.php?web&PHPSESID=" . session_id();

        echo '      <div id="container">'."\n";
        echo '          <div id="header" style="cursor:pointer;cursor:hand;" onclick="window.location = \'' . $homeLink . '\';">'."\n";
        $this->showBodyHeader();
        echo '          </div>'."\n";
        echo '          <div id="body-content">'."\n";
        echo '              <div id="body-content-left">'."\n";
        $this->showBodyLeftMenu();
        echo '              </div>'."\n";
        echo '              <div id="body-content-right">'."\n";
        echo '                 <div class="box">'."\n";
        echo '                    <div class="top">'."\n";
        echo '                      <div class="bot">'."\n";
        echo '                         <div class="inner">'."\n";
        $this->showBodyContent();
        echo '                         </div>'."\n";
        echo '                      </div>'."\n";
        echo '                  </div>'."\n";
        echo '              </div>'."\n";

        echo '              </div>'."\n";
        echo '          </div>'."\n";
        echo '          <div id="footer">'."\n";
        $this->showBodyFooter();
        echo '          </div>'."\n";
        echo '      </div>'."\n";
    }

    private function showBodyHeader() {
		?>
		<div id="headerbackground">&nbsp;</div>
		<?php
    }

    /**
     * Show page left menu.
     */
    private function showBodyLeftMenu() {
        $explorePlaylist = "index.php?web&action=" . ViewPlaylistWebPageAction::getActionName() . "&PHPSEDID=" . session_id();
        $addPlaylist = "index.php?web&action=" . ViewPlaylistWebPageAction::getActionName() . "&subaction=" . ViewPlaylistWebPageAction::SUBACTION_PLAYLIST_ADD . "&PHPSEDID=" . session_id();
	$megavideoScraper = "index.php?web&action=" . ViewScraperMegavideoPageAction::getActionName() . "&PHPSEDID=" . session_id();
	$megavideoScraperAdd = "index.php?web&action=" . ViewScraperMegavideoPageAction::getActionName() . "&subaction=" . ViewScraperMegavideoPageAction::SUBACTION_VIEW_ADD_LINK . "&PHPSEDID=" . session_id();
        $scrapers = "index.php?web&action=" . ViewScraperPageAction::getActionName() . "&PHPSEDID=" . session_id();
        $cookieSetup = "index.php?web&action=" . ViewCookiePageAction::getActionName() . "&PHPSEDID=" . session_id();
	$information = "index.php?web&action=" . ViewInformationPageAction::getActionName() . "&PHPSEDID=" . session_id();
        $favourites = "index.php?web&action=" . ViewFavouritePageAction::getActionName() . "&PHPSEDID=" . session_id();

        ?>
        <p style="text-align:left; color: #FFFFFF; font-size: 18px; margin-bottom: 12px; text-indent: 18px;">xVoD Menu</p>
        <div id="square-box">
            <div id="square-box-head">Playlist</div>
            <ul class="menu">
                <li><a href="<?php echo $explorePlaylist; ?>">Explore System</a></li>
                <li><a href="<?php echo $addPlaylist; ?>">Add Playlist</a></li>
            </ul>
        </div>

        <div id="square-box">
            <div id="square-box-head">xVoD Setup</div>
            <ul class="menu">
                <li><a href="<?php echo $information; ?>">Information</a></li>
                <li><a href="<?php echo $cookieSetup; ?>">Cookie MU/MV</a></li>
                <li><a href="<?php echo $favourites; ?>">Favourites</a></li>
                <li><a href="<?php echo $scrapers; ?>">Scrapers</a></li>
            </ul>
        </div>

        <div id="square-box">
            <div id="square-box-head">Megavideo Scraper</div>
            <ul class="menu">
		<li><a href="<?php echo $megavideoScraperAdd; ?>">Add link</a></li>
                <li><a href="<?php echo $megavideoScraper; ?>">Link list</a></li>
            </ul>
        </div>
        <?php
    }

    /**
     * Show body content.
     */
    public abstract function showBodyContent();

    /**
     * Show page footer.
     */
    private function showBodyFooter() {
	    ?>
	    <div id="footer-content">
	    xVoD has been developed by MaicroS ::: 
	    <a href="http://forum.xtreamer.net/forum/451-xvod/" target="_blank">xVoD at Forum</a> ::: 
	    Template resources: <a href="http://www.freetemplatesonline.com/" target="_blank">Free Templates Online</a>
	    </div>
	    
	    
	  <?php

    }
}

?>
