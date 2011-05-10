<?php
/* -------------------------
 *    Developed by Maicros
 *      GNU/GPL Licensed
 * ------------------------ */

class SupertelafilmesTemplate {

    const VIEW_HOME = 1;
    const VIEW_CATEGORY = 2;

    const VIEW_MOVIE = 3;
    const VIEW_MOVIE_DETAIL = 4;

    const VIEW_SERIE = 5;
    const VIEW_SEASON = 6;
    const VIEW_EPISODE = 7;

    private $items = array();
    private $mediaItems = array();


    public function addItem($title, $description, $link, $thumbnail) {
        $item = array($title, $description, $link, $thumbnail);
        array_push($this->items, $item);
    }

    public function addMediaItem($title, $description, $link, $thumbnail, $enclosureType) {
        $mediaItem = array($title, $description, $link, $thumbnail, $enclosureType);
        array_push($this->mediaItems, $mediaItem);
    }

    public function generateView($category, $title = null) {
        header("Content-type: text/xml");
        echo '<?xml version="1.0" encoding="UTF-8" ?>' . "\n";
        echo '<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:media="http://purl.org/dc/elements/1.1/">' . "\n";

        switch ($category) {
            case SupertelafilmesTemplate::VIEW_HOME;
                $this->getHomeHeader();
                break;
            case SupertelafilmesTemplate::VIEW_CATEGORY;
                $this->getCategoryHeader();
                break;

            case SupertelafilmesTemplate::VIEW_MOVIE;
                $this->getMovieHeader();
                break;
            case SupertelafilmesTemplate::VIEW_MOVIE_DETAIL;
                $this->getMovieDetailHeader();
                break;
            
            case SupertelafilmesTemplate::VIEW_SERIE;
                $this->getSerieHeader();
                break;
            case SupertelafilmesTemplate::VIEW_SEASON;
                $this->getSeasonHeader();
                break;
            case SupertelafilmesTemplate::VIEW_EPISODE;
                $this->getEpisodeHeader();
                break;
        }

        echo '  <channel>' . "\n";
        echo '      <title><![CDATA[' . $title . ']]></title>' . "\n";

        if ($category == SupertelafilmesTemplate::VIEW_SEASON) {
            foreach ($this->serie as $season => $episodes) {
                if($season) {
                    $this->addSeasonItem($season, $episodes);
                }
            }

        }else if($category == SupertelafilmesTemplate::VIEW_EPISODE ) {
            foreach ($this->episode as $episodeNumber => $episodeName) {
                $this->addEpisodeItem($episodeNumber,$episodeName[0]);
            }

        }else {

            foreach ($this->mediaItems as $value) {
                $this->getMediaLink($value) . "\n";
            }
            $i=0;
            foreach ($this->items as $value) {
                $this->getLink($value,$i) . "\n";
                ++$i;
            }
        }

        echo '  </channel>' . "\n";
        echo '</rss>';
    }


    private function getHomeHeader(){
        
    }

    private function getCategoryHeader(){

    }

    private function getMovieHeader(){

    }

    private function getMovieDetailHeader(){
        
    }

    /**
     * -------------------------------------------------------------------------
     */
    private function addSeasonItem($season, $seasonArray) {
        $data = $season;
        $link = SCRAPER_URL . "index.php?season=" . $data . URL_AMP . "PHPSESID=" . session_id();
        echo "          <item>\n";
        echo "              <title><![CDATA[SEASON $season]]></title>\n";
        echo "              <link>" . utf8_encode($link) . "</link>\n";
        echo "          </item>\n";
    }

    /**
     * -------------------------------------------------------------------------
     */
    private function addEpisodeItem($episodeNumber,$episodeName) {
        $link = SCRAPER_URL . "index.php?episodeName=" . base64_encode($episodeName) . URL_AMP . "episode=" . $episodeNumber . URL_AMP . "seasonNum=" . $this->selectedSeason . URL_AMP . "PHPSESID=" . session_id();
        echo "          <item>\n";
        echo "              <title><![CDATA[". sprintf("%02d",$episodeNumber) . "]]></title>\n";
        echo "              <description><![CDATA[". strtoupper($episodeName) . "]]></description>\n";
        echo "              <link>" . utf8_encode($link) . "</link>\n";
        echo "          </item>\n";
    }

    /**
     * -------------------------------------------------------------------------
     */
    private function getLink($item,$itemId = null) {
        $data = base64_encode($item[0]) . "-" . base64_encode($item[2]) . "-" . base64_encode($item[3]);
        echo "          <item>\n";
        echo "              <title><![CDATA[" . utf8_encode($item[0]) . "]]></title>\n";
        if ($item[1]) {
            echo "              <description><![CDATA[" . utf8_encode($item[1]) . "]]></description>\n";
        }
        echo "              <link>" . utf8_encode($item[2]) . "</link>\n";
        echo "              <data>" . $data . "</data>\n";
        echo "              <itemid>" . $itemId . "</itemid>\n";
        if ($item[3]) {
            echo "              <media:thumbnail url=\"" . utf8_encode($item[3]) . "\"/>\n";
        }
        echo "          </item>\n";
    }

    /**
     * -------------------------------------------------------------------------
     */
    private function getMediaLink($item) {
        echo "          <item>\n";
        echo "              <title><![CDATA[" . $item[0] . "]]></title>\n";
        if ($item[1]) {
            echo "              <description><![CDATA[$item[1]]]></description>\n";
        }
        echo "              <link>" . utf8_encode($item[2]) . "</link>\n";
        if ($item[3]) {
            echo "              <media:thumbnail url=\"" . utf8_encode($item[3]) . "\"/>\n";
        }
        echo "              <enclosure type=\"" . utf8_encode($item[4]) . "\" url=\"" . utf8_encode($item[2]) . "\"/>\n";
        echo "          </item>\n";
    }

}

?>
