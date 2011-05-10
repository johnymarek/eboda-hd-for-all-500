<?php

/*-------------------------
 *    Developed by Maicros
 *    GNU/GPL v2  Licensed
 * ------------------------*/

class Sqlite3Connection implements Connection {

    private $database = null;

    public function  __construct() {
        if(class_exists("SQLite3")) {
            $this->database = new SQLite3("data/db/xvod.sqlite3.db");
	    //Create if not exists
	    $this->createDatabase();
        }
    }

    // -------------------------------------------------------------------------
    // -------------------------------------------------------------------------

    /**
     * Get scraper arry list from database.
     */
    public function getScrapers($language=null) {
        if($language) {
            $query = "select * from xvod_scraper WHERE language = '$language' ORDER BY name ASC;";
        }else {
            $query = "select * from xvod_scraper ORDER BY name ASC;";
        }
        $results = $this->database->query($query);
        $scrapers = array();
        while ($row = $results->fetchArray()) {
            $scrapers[$row["id"]] = new ScraperBean(
                    $row["id"],
                    $row["name"],
                    $row["description"],
                    $row["language"],
                    $row["image"],
                    $row["link"],
                    $row["type"]
            );
        }
        return $scrapers;
    }

    /**
     * Add new scraper to database.
     * @var Scraper $scraper
     * @return
     */
    public function addScraper(ScraperBean $scraper) {
        $query = "INSERT INTO xvod_scraper (name,description,language,image,link,type) VALUES (
                        '" . $scraper->getName() . "',
                        '" . $scraper->getDescription() . "',
                        '" . $scraper->getLanguage() . "',
                        '" . $scraper->getImage() . "',
                        '" . $scraper->getLink() . "',
                        '" . $scraper->getType() . "'
                        );";
        if(!$this->database->exec($query)) {
            //echo "<p>Error adding Scraper on query: " . $query . "</p>";
            return false;
        }else {
            return true;
        }
    }

    /**
     * Delete scraper by id.
     * @var int $scraperId
     */
    public function deleteScraper($scraperId) {
        $query = "DELETE FROM xvod_scraper WHERE id = $scraperId";
        if(!$this->database->exec($query)) {
            //echo "<p>Error deleting Scraper on query: " . $query . "</p>";
            return false;
        }else {
            return true;
        }
    }

    /**
     * Get scraper by id.
     */
    public function getScraperById($scraperId) {
        $query = "select * from xvod_scraper WHERE id = $scraperId;";
        $results = $this->database->query($query);
        $scraper = null;
        if ( $row = $results->fetchArray() ) {
            $scraper = new ScraperBean(
                    $row["id"],
                    $row["name"],
                    $row["description"],
                    $row["language"],
                    $row["image"],
                    $row["link"],
                    $row["type"]
            );
        }
        return $scraper;
    }

    // -------------------------------------------------------------------------
    // -------------------------------------------------------------------------

    /**
     * Add new Favourite.
     */
    public function addWebsiteFavourite($favId,$favType,$favName,$favLink) {
        $query = "select * from xvod_favourite_websites WHERE type = '$favType';";
        $results = $this->database->query($query);
        if($results->fetchArray()) {
            $query = "UPDATE xvod_favourite_websites SET
                        id = $favId,
                        name = '$favName',
                        link = '$favLink' 
                        WHERE type = '$favType';";
        }else {
            $query = "INSERT INTO xvod_favourite_websites (id,type,name,link) VALUES (
                    $favId,
                        '$favType',
                        '$favName',
                        '$favLink'
                        );";
        }
        if( !$this->database->exec($query) ) {
            //echo "<p>Error executing query: " . $query . "</p>";
        }
    }

    /**
     * Get Favourite list.
     */
    public function getWebsiteFavourites() {
        $query = "select * from xvod_favourite_websites ORDER BY type ASC;";
        $results = $this->database->query($query);
        $favourites = array();
        while ($row = $results->fetchArray()) {
            $favourites[$row["id"]] = new FavouriteWebsiteBean(
                    $row["id"],
                    $row["type"],
                    $row["name"],
                    $row["link"]
            );
        }
        return $favourites;
    }

    /**
     * Get Favourite with given link.
     */
    public function getWebsiteFavouriteById($favId) {
        $query = "select * from xvod_favourite_websites WHERE id = $favId;";
        $results = $this->database->query($query);
        $favourite = null;
        if ($row = $results->fetchArray()) {
            $favourite = new FavouriteWebsiteBean(
                    $row["id"],
                    $row["type"],
                    $row["name"],
                    $row["link"]
            );
        }
        return $favourite;
    }

    /**
     * Delete Favourite by id.
     */
    public function deleteWebsiteFavourite($favouriteId) {
        $query = "DELETE FROM xvod_favourite_websites WHERE id = $favouriteId";
        if(!$this->database->exec($query)) {
            //echo "<p>Error deleting Bookmark on query: " . $query . "</p>";
            return false;
        }else {
            return true;
        }
    }

    // -------------------------------------------------------------------------
    // -------------------------------------------------------------------------

    /**
     * Get bookmark list.
     */
    public function getBookmarks() {
        $query = "select * from xvod_bookmark ORDER BY name ASC;";
        $results = $this->database->query($query);
        $bookmarks = array();
        while ($row = $results->fetchArray()) {
            $bookmarks[$row["id"]] = new BookmarkBean(
                    $row["id"],
                    $row["name"],
                    $row["description"],
                    $row["image"],
                    $row["link"]
            );
        }
        return $bookmarks;
    }

    /**
     * Add new bookmark.
     */
    public function addBookmark($name,$description,$link,$image) {
        if(!$this->getBookmarkByLink($link)) {
            $query = "INSERT INTO xvod_bookmark (name,description,image,link) VALUES (
                        '$name',
                        '$description',
                        '$image',
                        '$link'
                        );";
            if( !$this->database->exec($query) ) {
                //echo "<p>Error executing query: " . $query . "</p>";
            }
        }
    }

    /**
     * Get bookmark with given link.
     */
    public function getBookmarkByLink($link) {
        $query = "select * from xvod_bookmark WHERE link = '$link';";
        $results = $this->database->query($query);
        $bookmark = null;
        if ($row = $results->fetchArray()) {
            $bookmark = new BookmarkBean(
                    $row["id"],
                    $row["name"],
                    $row["description"],
                    $row["image"],
                    $row["link"]
            );
        }
        return $bookmark;
    }

    /**
     * Delete bookmark by id.
     */
    public function deleteBookmark($bookmarkId) {
        $query = "DELETE FROM xvod_bookmark WHERE id = $bookmarkId";
        if(!$this->database->exec($query)) {
            //echo "<p>Error deleting Bookmark on query: " . $query . "</p>";
            return false;
        }else {
            return true;
        }
    }

    // -------------------------------------------------------------------------
    // -------------------------------------------------------------------------

    /**
     */
    public function getMaxTabletId($table) {
        $query = "SELECT max(id) FROM $table;";
        $rowId = $this->database->singleQuery($query);
        return $rowId;
    }

    /**
     */
    public function getLastInsertId($table) {
        $rowId = $this->database->lastInsertRowid();
        return $rowId;
    }

    //-------------------------------------------------------------------------
    //-------------------------------------------------------------------------

    /**
     * Check database for table exists and create.
     */
    public function createDatabase() {
        //Check for scraper table and create it, if proceed
        if(!$this->existsTable("xvod_scraper")) {
            $querys = array(
                    "CREATE TABLE xvod_scraper (
                        id INTEGER NOT NULL PRIMARY KEY,
                        name TEXT NOT NULL,
                        description TEXT NOT NULL,
                        language TEXT NOT NULL,
                        image TEXT NOT NULL,
                        link TEXT NOT NULL,
                        type TEXT NOT NULL
                        );",
                    "INSERT INTO xvod_scraper (name,description,language,image,link,type) VALUES (
                        '10StarMovies',
                        'Watch tv show online free and stream full length episode online. Download and Watch all popular TV Shows including action, adventure, animation and many more. 10STARMOVIES.COM',
                        'en',
                        'logo/10starmovies.jpg',
                        '/10starmovies/index.php',
                        'serie'
                        );",
                    "INSERT INTO xvod_scraper (name,description,language,image,link,type) VALUES (
                        'ADNstream.tv',
                        'ADNstream.com te permite disfrutar del cine y la televisión que te gusta gratis y en Internet. ADNSTREAM.TV',
                        'es',
                        'logo/adnstream.jpg',
                        '/adnstream/AdnStream.php',
                        'mixed'
                        );",
                    "INSERT INTO xvod_scraper (name,description,language,image,link,type) VALUES (
                        'Cinetube',
                        'Peliculas y estrenos de cine online, entra en CINETUBE.ES',
                        'es',
                        'logo/cinetube_movie.jpg',
                        '/cinetube/index.php?type=mov',
                        'movie'
                        );",
                    "INSERT INTO xvod_scraper (name,description,language,image,link,type) VALUES (
                        'Cinetube',
                        'Documentales online y en descarga directa, entra en CINETUBE.ES',
                        'es',
                        'logo/cinetube_documentary.jpg',
                        '/cinetube/index.php?type=doc',
                        'documentary'
                        );",
                    "INSERT INTO xvod_scraper (name,description,language,image,link,type) VALUES (
                        'Cinetube',
                        'Series online con descargas directas, entra en CINETUBE.ES',
                        'es',
                        'logo/cinetube_serie.jpg',
                        '/cinetube/index.php?type=ser',
                        'serie'
                        );",
                    "INSERT INTO xvod_scraper (name,description,language,image,link,type) VALUES (
                        'My VoD TV',
			                        'אתר סרטים לצפייה ישירה,צפייה ישירה בסרטים ובסדרות,צפייה ישירה באיכות מעולה,מאות סרטים לצפייה ישירה בחינם רק באתר MYVOD צפייה ישירה בחינם.',
                        'he',
                        'logo/myvodtv.jpg',
                        '/myvodtv/index.php?type=doc',
                        'movie'
                        );",
                    "INSERT INTO xvod_scraper (name,description,language,image,link,type) VALUES (
                        'WachNewFilms',
                        'Watch new movies for Free online. WATCHNEWFILMS.COM.',
                        'en',
                        'logo/watchnewfilms.jpg',
                        '/watchnewfilms/index.php',
                        'movie'
                        );",
                    "INSERT INTO xvod_scraper (name,description,language,image,link,type) VALUES (
                        '01Maroc',
                        'Retrouvez des film gratuit en ligne sur votre pc en streaming. 01MAROC.COM',
                        'fr',
                        'logo/maroc.jpg',
                        '/maroc/index.php',
                        'movie'
                        );",
                    "INSERT INTO xvod_scraper (name,description,language,image,link,type) VALUES (
                        'Megavideolink',
                        'Regarder toutes vos series TV preferes en streaming, series streaming , serien en streaming. MEGAVIDEOLINK.COM',
                        'fr',
                        'logo/megavideolink.jpg',
                        '/megavideolink/index.php?type=ser',
                        'serie'
                        );",
                    "INSERT INTO xvod_scraper (name,description,language,image,link,type) VALUES (
                        'Kino.to',
                        'Kino.to Dein Onlinekino. Auf Kino.to bekommst Filme online. Immer die neusten Streams in verschiedenen Formaten DivX, Flash und MP4. TÃ¤glich werden neue Filme eingepflegt. KINO.TO',
                        'de',
                        'logo/kinoto.jpg',
                        '/kinoto/movies.php',
                        'movie'
                        );",
                    "INSERT INTO xvod_scraper (name,description,language,image,link,type) VALUES (
                        'Kino.to',
                        'Kino.to Dein Onlinekino. Auf Kino.to bekommst Serien online. Immer die neusten Streams in verschiedenen Formaten DivX, Flash und MP4. TÃ¤glich werden neue Serienstreams eingepflegt. KINO.TO',
                        'de',
                        'logo/kinoto.jpg',
                        '/kinoto/series.php',
                        'serie'
                        );",
                    "INSERT INTO xvod_scraper (name,description,language,image,link,type) VALUES (
                        'Cinetube',
                        'Peliculas y Series Anime online con descargas directas, entra en CINETUBE.ES',
                        'es',
                        'logo/cinetube.jpg',
                        '/cinetube/anime.php',
                        'anime'
                        );",
                    "INSERT INTO xvod_scraper (name,description,language,image,link,type) VALUES (
                        'Anivide',
                        'Watch anime series online on ANIVIDE.COM',
                        'en',
                        'logo/anivide.jpg',
                        '/anivide/series.php',
                        'anime'
                        );",
                    "INSERT INTO xvod_scraper (name,description,language,image,link,type) VALUES (
                        'Anime44',
                        'Anime Movie list from ANIME44.COM',
                        'en',
                        'logo/anime44.jpg',
                        '/anime44/movies.php',
                        'anime'
                        );"
            );
            for( $i=0; $i<sizeof($querys); ++$i) {
                if( !$this->database->exec($querys[$i]) ) {
                    //echo "<p>Error executing query: " . $query . "</p>";
                }
            }
        }

        //check for table bookmark and create it, if proceed
        if(!$this->existsTable("xvod_bookmark")) {
            $querys = array(
                    "CREATE TABLE xvod_bookmark (
                        id INTEGER NOT NULL PRIMARY KEY,
                        name TEXT NOT NULL,
                        description TEXT NOT NULL,
                        image TEXT NOT NULL,
                        link TEXT NOT NULL
                        );"
            );
            for( $i=0; $i<sizeof($querys); ++$i) {
                if( !$this->database->exec($querys[$i]) ) {
                    // echo "<p>Error executing query: " . $query . "</p>";
                }
            }
        }
        //check for table favourites webistes and create it, if proceed
        if(!$this->existsTable("xvod_favourite_websites")) {
            $querys = array(
                    "CREATE TABLE xvod_favourite_websites (
                        id INTEGER NOT NULL PRIMARY KEY,
                        type TEXT NOT NULL,
                        name TEXT NOT NULL,                        
                        link TEXT NOT NULL
                        );"
            );
            for( $i=0; $i<sizeof($querys); ++$i) {
                if( !$this->database->exec($querys[$i]) ) {
                    // echo "<p>Error executing query: " . $query . "</p>";
                }
            }
        }

    }

    /**
     * Check if table with given name exists on database
     */
    private function existsTable($table) {
        $query = "SELECT name FROM sqlite_master WHERE name='$table'";
        $results = $this->database->query($query);
        $row = $results->fetchArray();
        return $row ? true : false;
    }
}

?>
