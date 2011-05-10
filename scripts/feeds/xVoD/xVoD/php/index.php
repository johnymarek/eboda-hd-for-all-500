<?php

/*-------------------------
 *    Developed by Maicros
 *      GNU/GPL Licensed
 * ------------------------*/
 
//Initialize session
if(isset($_GET["PHPSESID"])) {
    session_id($_GET["PHPSESID"]);
}
session_start();

include_once "config/config.php";
include_once "util/VideoUtil.php";
include_once "util/RssScriptUtil.php";
include_once "util/FavouriteSitesUtil.php";
//Templates
include_once "template/Template.php";
include_once "template/WebTemplate.php";

include_once "template/rss/AboutTemplate.php";
include_once "template/rss/InitTemplate.php";
include_once "template/rss/SetupTemplate.php";
include_once "template/rss/WebsitesTemplate.php";
include_once "template/rss/BookmarksTemplate.php";
include_once "template/rss/PlaylistFolderTemplate.php";
include_once "template/rss/PlaylistLinkTemplate.php";
include_once "template/rss/PlaylistTemplate.php";

include_once "template/web/HomeWebTemplate.php";
include_once "template/web/PlaylistAddWebTemplate.php";
include_once "template/web/PlaylistExploreWebTemplate.php";
include_once "template/web/PlaylistWebTemplate.php";
include_once "template/web/PlaylistLinkWebTemplate.php";
include_once "template/web/PlaylistLinkAddWebTemplate.php";
include_once "template/web/CookieMegavideoWebTemplate.php";
include_once "template/web/InfoXvodWebTemplate.php";
include_once "template/web/ScraperMegavideoAddWebTemplate.php";
include_once "template/web/ScraperMegavideoWebTemplate.php";
include_once "template/web/ScraperWebTemplate.php";
include_once "template/web/PlaylistUploadWebTemplate.php";
include_once "template/web/FavouriteWebTemplate.php";

//Data connectors, beans and utils
include_once "data/Connection.php";
include_once "data/ConnectionFactory.php";
include_once "data/connector/XmlConnection.php";
include_once "data/connector/Sqlite3Connection.php";
include_once "data/entity/BookmarkBean.php";
include_once "data/entity/FavouriteWebsiteBean.php";
include_once "data/entity/ScraperBean.php";
//
include_once "playlist/PlaylistLink.php";
include_once "playlist/Playlist.php";
//Actions
include_once "action/Action.php";
include_once "action/ActionDispatcher.php";

include_once "action/rss/ViewHomePageAction.php";
include_once "action/rss/ViewAboutPageAction.php";
include_once "action/rss/ViewSetupPageAction.php";
include_once "action/rss/ViewWebsitesPageAction.php";
include_once "action/rss/ViewBookmarksPageAction.php";
include_once "action/rss/SaveBookmarkAction.php";
include_once "action/rss/DeleteBookmarkAction.php";
include_once "action/rss/SaveFavouriteWebsiteAction.php";
include_once "action/rss/ViewPlaylistPageAction.php";

include_once "action/web/ViewWebHomePageAction.php";
include_once "action/web/ViewPlaylistWebPageAction.php";
include_once "action/web/ViewScraperMegavideoPageAction.php";
include_once "action/web/SetupXvodPageAction.php";
include_once "action/web/ViewCookiePageAction.php";
include_once "action/web/ViewScraperPageAction.php";
include_once "action/web/ViewFavouritePageAction.php";
include_once "action/web/ViewInformationPageAction.php";

//Megavideo scraper
include_once "scraper/megavideo/MegavideoDatabase.php";
include_once "scraper/megavideo/MegavideoLinkBean.php";

//Update action, if needed
if( UPDATE_DB ){
    include_once "config/update.php";
}

//Get action and dispatch
if( isset($_GET["action"]) ) {
    $action = $_GET["action"];
}else if( isset($_GET["web"]) ) {
    $action = ViewWebHomePageAction::getActionName();
}else {
    $action = ViewHomePageAction::getActionName();
}
$actionDispatcher = new ActionDispatcher();
$actionDispatcher->dispatchAction($action);


?>
