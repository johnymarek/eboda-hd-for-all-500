<?php
/*-------------------------
 *    Developed by Maicros
 *      GNU/GPL Licensed
 * ------------------------*/

class ViewBookmarksPageAction extends Action {

    public function dispatch() {
        $connection = ConnectionFactory::getDataConnection();
        $bookmarks = $connection->getBookmarks();
        $template = new BookmarksTemplate($bookmarks,"Bookmarks");
        $template->showTemplate();
    }

    public static function getActionName() {
        return "viewBookmarksPage";
    }

}


?>
