<?php
/*-------------------------
 *    Developed by Maicros
 *      GNU/GPL Licensed
 * ------------------------*/

class MegavideoDatabase {

    private $database = null;

    public function  __construct($database="xvod.megavideo.db") {
        if(class_exists("SQLite3")) {
            $this->database = new SQLite3($database);
        }
    }

    // -------------------------------------------------------------------------
    // -------------------------------------------------------------------------

    /**
     * Get megavideo link list.
     */
    public function getMegavideoLinks() {
        $query = "select * from xvod_megavideo_link ORDER BY name ASC;";
        $results = $this->database->query($query);
        $links = array();
        while ($row = $results->fetchArray()) {
            $links[$row["id"]] = new MegavideoLinkBean(
                    $row["id"],
                    $row["name"],
                    $row["description"],
                    $row["user"],
                    $row["views"],
                    $row["dateAdded"],
                    $row["image"]
            );
        }
        return $links;
    }

    /**
     * Add new megavideo link.
     */
    public function addMegavideoLink($id, $title, $description, $user, $views, $dateAdded, $image) {
        if(!$this->getMegavideoLinkById($id)) {
            $query = "INSERT INTO xvod_megavideo_link (id,name,description,user,views,dateAdded,image) VALUES (
                        '$id',
                        '" . str_replace("'", "`", $title) . "',
                        '" . str_replace("'", "`", $description) . "',
                        '$user',
                        '$views',
                        '$dateAdded',
                        '$image'
                        );";
            if( !$this->database->exec($query) ) {
                //echo "<p>Error executing query: " . $query . "</p>";
            }
        }
    }

    /**
     * Get megavideo link with given link.
     */
    public function getMegavideoLinkById($id) {
        $query = "select * from xvod_megavideo_link WHERE id = '$id';";
        $results = $this->database->query($query);
        $link = null;
        if ($row = $results->fetchArray()) {
            $link = new MegavideoLinkBean(
                    $row["id"],
                    $row["name"],
                    $row["description"],
                    $row["user"],
                    $row["views"],
                    $row["dateAdded"],
                    $row["image"]
            );
        }
        return $link;
    }

    /**
     * Delete megavideo link by id.
     */
    public function deleteMegavideoLink($id) {
        $query = "DELETE FROM xvod_megavideo_link WHERE id = '$id';";
        if(!$this->database->exec($query)) {
            //echo "<p>Error deleting Bookmark on query: " . $query . "</p>";
            return false;
        }else {
            return true;
        }
    }

    public function createDatabase() {
        //check for table megavideo links and create it, if proceed
        if(!$this->existsTable("xvod_megavideo_link")) {
            $querys = array(
                    "CREATE TABLE xvod_megavideo_link (
                        id TEXT NOT NULL PRIMARY KEY,
                        name TEXT NOT NULL,
                        description TEXT,
                        user TEXT NOT NULL,
                        views TEXT NOT NULL,
                        dateAdded TEXT NOT NULL,
                        image TEXT
                        );",
                    "INSERT INTO xvod_megavideo_link VALUES (
                        '6EFNNYI5',
                        'XTREAMER PRO PROMO',
                        'XTREAMER PRO PROMO - XTREAMER.NET - 720P',
                        'MAICROS',
                        '-',
                        '2010-09-29',
                        'http://img3.megavideo.com/8/5/0412b0e90354ba03785dba9a330140.jpg'
                        );",
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
