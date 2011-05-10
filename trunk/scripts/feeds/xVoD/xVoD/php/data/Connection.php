<?php

/*-------------------------
 *    Developed by Maicros
 *    GNU/GPL v2  Licensed
 * ------------------------*/

interface Connection {

    /**
     * Add new scraper to database.
     * @var Scraper $scraper
     * @return
     */
    public function addScraper(ScraperBean $scraper);

    /**
     * Delete scraper by id.
     * @var int $scraperId
     */
    public function deleteScraper($scraperId);

    /**
     * Get scraper arry list from database.
     */
    public function getScrapers($language=null);

    /**
     * Get scraper by id.
     */
    public function getScraperById($scraperId);

    // -------------------------------------------------------------------------
    // -------------------------------------------------------------------------

    /**
     * Add new Favourite.
     */
    public function addWebsiteFavourite($favId,$favType,$favName,$favLink);

     /**
     * Get Favourite list.
     */
    public function getWebsiteFavourites();

     /**
     * Get Favourite with given link.
     */
    public function getWebsiteFavouriteById($favId);

    /**
     * Delete Favourite by id.
     */
    public function deleteWebsiteFavourite($favouriteId);

    // -------------------------------------------------------------------------
    // -------------------------------------------------------------------------

    /**
     * Add new bookmark.
     */
    public function addBookmark($name,$description,$link,$image);

     /**
     * Get bookmark list.
     */
    public function getBookmarks();

     /**
     * Get bookmark with given link.
     */
    public function getBookmarkByLink($link);

    /**
     * Delete bookmark by id.
     */
    public function deleteBookmark($bookmarkId);

    // -------------------------------------------------------------------------
    // -------------------------------------------------------------------------

    /**
     * Check database for table exists and create.
     */
    public function createDatabase();
}

?>
