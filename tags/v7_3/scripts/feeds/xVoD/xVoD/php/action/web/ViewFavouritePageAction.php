<?php
/*-------------------------
 *    Developed by Maicros
 *      GNU/GPL Licensed
 * ------------------------*/


class ViewFavouritePageAction extends Action {

    const SUBACTION_FAVOURITE_DELETE = 1;

    public function dispatch() {
	$subaction = $_GET["subaction"];
	switch( $subaction ) {
	    case ViewFavouritePageAction::SUBACTION_FAVOURITE_DELETE: //--------------------------------
		if( isset( $_GET["id"] ) ) {
		    $connection = ConnectionFactory::getDataConnection();
		    $connection->deleteBookmark($_GET["id"]);
		}
		break;
	}

	//Show default template
	$template = new FavouriteWebTemplate();
	$connection = ConnectionFactory::getDataConnection();
	$bookmarks = $connection->getBookmarks();
	$template->setFavourites($bookmarks);
	$template->show();

    }

    public static function getActionName() {
	return "viewWebFavouritePage";
    }

}

?>