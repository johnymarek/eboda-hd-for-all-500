<?php

/*-------------------------
 *    Developed by Maicros
 *    GNU/GPL v2  Licensed
 * ------------------------*/

class XmlConnection implements Connection {

    private $linkBookmarksFilePath = null;
    private $siteBookmarksFilePath = null;
    private $scrapersFilePath = null;

    public function  __construct() {
        $this->linkBookmarksFilePath = "data/xml/bookmarksLinks.xml";
        $this->siteBookmarksFilePath = "data/xml/favouriteSites.xml";
        $this->scrapersFilePath = "data/xml/scrapers.xml";
	//Create if not exists
	if( !@file_exists($this->linkBookmarksFilePath) ){
	    $this->createEmptyLinkBookmarks();
	}
	if( !@file_exists($this->siteBookmarksFilePath) ){
	    $this->createEmptySiteBookmarks();
	}
	if( !@file_exists($this->scrapersFilePath) ){
	    $this->createEmptyScrapers();
	}
    }

    // -------------------------------------------------------------------------
    // -------------------------------------------------------------------------

    public function addBookmark($name, $description, $link, $image) {
        $bookmarks = $this->getBookmarks();
        $id = 0;
        foreach ($bookmarks as $newId => $bookmark ) {
            if( $newId > $id) {
                $id = $newId;
            }
        }
        ++$id;
        $bookmarks[$id] = new BookmarkBean($id, $name, $description, $image, $link);
        $this->saveBookmarks( $bookmarks );
    }

    public function deleteBookmark($bookmarkId) {
        $bookmarks = $this->getBookmarks();
        unset($bookmarks[$bookmarkId]);
        $this->saveBookmarks( $bookmarks );
    }

    public function getBookmarkById($bookmarkId) {
        $bookmarks = $this->getBookmarks();
        return $bookmarks[$bookmarkId];
    }

    public function getBookmarkByLink($link) {
        $bookmarks = $this->getBookmarks();
        foreach ($bookmarks as $id => $bookmark ) {
            if( $bookmark->getLink() == $link ) {
                return $bookmark;
            }
        }
        return false;
    }

    public function getBookmarks() {
        $bookmarks = array();
        try {
            $xml = simplexml_load_file($this->linkBookmarksFilePath,'SimpleXMLElement', LIBXML_NOCDATA);
            foreach ($xml->children() as $second_gen) {
                $attributes = $second_gen->attributes();
                $id = (Integer)$attributes->id;
                $image = (String)$attributes->image;
                $name = (String)$second_gen->name;
                $description = (String)$second_gen->description;
                $link = (String)$second_gen->link;
                $bookmarks["$id"] = new BookmarkBean(
                        $id,
                        $name,
                        $description,
                        $image,
                        urldecode($link)
                );
            }
        } catch (Exception $e) {
            //Ignored exception
        }

        return $bookmarks;
    }

    private function saveBookmarks(array $bookmarks) {
        //Save to xml
        $simpleXml = new SimpleXmlElement('<?xml version="1.0" encoding="UTF-8"?><bookmarks></bookmarks>');
        foreach ($bookmarks as $id => $bookmark) {
            $element = $simpleXml->addChild("bookmark");
            $element->addAttribute("id", $bookmark->getId());
            $element->addAttribute("image", $bookmark->getImage());
            $element->addChild("name", "<![CDATA[" . $bookmark->getName() . "]]>");
            $element->addChild("description", "<![CDATA[" . $bookmark->getDescription() . "]]>");
            $element->addChild("link", urlencode($bookmark->getLink()));
        }
        $fp = fopen($this->linkBookmarksFilePath, 'w');
        fwrite($fp, utf8_encode(html_entity_decode($simpleXml->asXML())) );
        fclose($fp);
    }

    // -------------------------------------------------------------------------
    // -------------------------------------------------------------------------

    /**
     * Add new Favourite.
     */
    public function addWebsiteFavourite($favId,$favType,$favName,$favLink) {
        $favourites = $this->getWebsiteFavourites();
        if($favType == "mixed") {
            $favType = "movie";
        }
        foreach ($favourites as $id => $favourite) {
            if( $favourite->getType() == $favType ){
                unset($favourites[$id]);
            }
        }
        $favourites[$favId] = new FavouriteWebsiteBean($favId,$favType,$favName,$favLink);
        //Save to xml
        $this->saveWebsiteFavourites($favourites);
    }

    /**
     * Get Favourite list.
     */
    public function getWebsiteFavourites() {
        $favourites = array();
        try {
            $xml = file_get_contents($this->siteBookmarksFilePath);
            $xml = new SimpleXMLElement($xml);
            foreach ($xml->children() as $second_gen) {
                $type = (String)$second_gen['type'];
                $id = (Integer)$second_gen['id'];
                $name = (String)$second_gen['name'];
                $link = (String)$second_gen;
                $favourites[$id] = new FavouriteWebsiteBean(
                        $id,
                        $type,
                        $name,
                        $link
                );
            }
        } catch (Exception $e) {
            //Ignored exception
        }
        return $favourites;
    }

    /**
     * Get Favourite with given link.
     */
    public function getWebsiteFavouriteById($favId) {
        $favourites = $this->getWebsiteFavourites();
        return $favourites[$favId];
    }

    /**
     * Delete Favourite by id.
     */
    public function deleteWebsiteFavourite($favouriteId) {
        $favourites = $this->getWebsiteFavourites();
        if( $favourites[$favouriteId] ) {
            unset($favourites[$favouriteId]);
            saveWebsiteFavourites($favourites);
        }
    }

    private function saveWebsiteFavourites(array $favourites) {
        $simpleXml = new SimpleXmlElement('<?xml version="1.0" encoding="UTF-8"?><favourite></favourite>');
        foreach ($favourites as $id => $favourite) {
            $element = $simpleXml->addChild("website",$favourite->getLink());
            $element->addAttribute("id", $favourite->getId());
            $element->addAttribute("name", $favourite->getName());
            $element->addAttribute("type", $favourite->getType());
        }
        $fp = fopen($this->siteBookmarksFilePath, 'w');
        fwrite($fp, utf8_encode(html_entity_decode($simpleXml->asXML())) );
        fclose($fp);
    }

    // -------------------------------------------------------------------------
    // -------------------------------------------------------------------------

    public function addScraper(ScraperBean $scraper) {
        $scrapers = $this->getScrapers();
        $id = 0;
        foreach ($scrapers as $key => $value) {
            if( $key > $id ){
                $id = $key;
            }
        }
        ++$id;
        $scraper->setId($id);
        $scrapers[$id] = $scraper;
        $this->saveScrapers($scrapers);
    }

    public function deleteScraper($scraperId) {
        $scrapers = $this->getScrapers();
        unset($scrapers[$scraperId]);
        $this->saveScrapers($scrapers);
    }

    public function getScraperById($scraperId) {
        $scrapers = $this->getScrapers();
        return $scrapers[$scraperId];
    }

    public function getScrapers($language = null) {
        $scrapers = array();
        try {
            $xml = simplexml_load_file($this->scrapersFilePath,'SimpleXMLElement', LIBXML_NOCDATA);
            foreach ($xml->children() as $second_gen) {
                $attributes = $second_gen->attributes();
                $id = (Integer)$attributes['id'];
                $type = (String)$attributes['type'];
                $language = (String)$attributes['language'];
                $image = (String)$attributes['image'];
                $name = (String)$second_gen->name;
                $description = (String)$second_gen->description;
                $link = (String)$second_gen->link;
                $scrapers["$id"] = new ScraperBean( $id, $name, $description, $language, $image, $link, $type );
            }
        } catch (Exception $e) {
            //Ignored exception
        }
        return $scrapers;
    }

    private function saveScrapers(array $scrapers) {
        //Save to xml
        $simpleXml = new SimpleXmlElement('<?xml version="1.0" encoding="UTF-8"?><scrapers></scrapers>');
        foreach ($scrapers as $id => $scraper) {
            $element = $simpleXml->addChild("scraper");
            $element->addAttribute("id", $scraper->getId());
            $element->addAttribute("image", $scraper->getImage());
            $element->addAttribute("type", $scraper->getType());
            $element->addAttribute("language", $scraper->getLanguage());
            $element->addChild("name" , "<![CDATA[" . $scraper->getName() . "]]>");
            $element->addChild("description" , "<![CDATA[" . $scraper->getDescription() . "]]>");
            $element->addChild("link" , "<![CDATA[" . $scraper->getLink() . "]]>");
        }
        $fp = fopen($configFilePath, 'w');
        fwrite($fp, utf8_encode(html_entity_decode($simpleXml->asXML())) );
        fclose($fp);
    }

    // -------------------------------------------------------------------------
    // -------------------------------------------------------------------------

    public function createDatabase() {
    }

    private function createEmptyLinkBookmarks(){
	$simpleXml = new SimpleXmlElement('<?xml version="1.0" encoding="UTF-8"?><bookmarks></bookmarks>');
	$fp = fopen($this->linkBookmarksFilePath, 'w');
        fwrite($fp, utf8_encode(html_entity_decode($simpleXml->asXML())) );
        fclose($fp);
    }

    private function createEmptySiteBookmarks(){
	$simpleXml = new SimpleXmlElement('<?xml version="1.0" encoding="UTF-8"?><favourite></favourite>');
	$fp = fopen($this->siteBookmarksFilePath, 'w');
        fwrite($fp, utf8_encode(html_entity_decode($simpleXml->asXML())) );
        fclose($fp);
    }

    private function createEmptyScrapers(){
	 $simpleXml = new SimpleXmlElement('<?xml version="1.0" encoding="UTF-8"?><scrapers></scrapers>');
	 $fp = fopen($this->scrapersFilePath, 'w');
        fwrite($fp, utf8_encode(html_entity_decode($simpleXml->asXML())) );
        fclose($fp);
    }

}

?>
