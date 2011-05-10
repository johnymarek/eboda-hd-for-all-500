<?php
/*-------------------------
 *    Developed by Maicros
 *      GNU/GPL Licensed
 * ------------------------*/

class ActionDispatcher {

    private $action = null;

    public function dispatchAction($action) {
        $this->action = $action;

        //----------------------------------------------------------------
        //------  VIEW RSS ACTIONS
        if( $action == ViewAboutPageAction::getActionName()) {
            $implAction = new ViewAboutPageAction();
            //
        }else if( $action == ViewBookmarksPageAction::getActionName()) {
            $implAction = new ViewBookmarksPageAction();
            //
        }else if( $action == ViewHomePageAction::getActionName()) {
            $implAction = new ViewHomePageAction();
            //
        }else if( $action == ViewPlaylistPageAction::getActionName()) {
            $implAction = new ViewPlaylistPageAction();
            //
        }else if( $action == ViewSetupPageAction::getActionName()) {
            $implAction = new ViewSetupPageAction();
            //
        }else if( $action == ViewWebsitesPageAction::getActionName()) {
            $implAction = new ViewWebsitesPageAction();
            //
            //
            //----- VIEW WEB ACTIONS --------------------------------------
        }else if( $action == ViewWebHomePageAction::getActionName()) {
            $implAction = new ViewWebHomePageAction();
            //
        }else if( $action == ViewPlaylistWebPageAction::getActionName()) {
            $implAction = new ViewPlaylistWebPageAction();
            //
        }else if( $action == ViewScraperMegavideoPageAction::getActionName()) {
            $implAction = new ViewScraperMegavideoPageAction();
            //
        }else if( $action == SetupXvodPageAction::getActionName()) {
            $implAction = new SetupXvodPageAction();
            //
        }else if( $action == ViewScraperPageAction::getActionName()) {
            $implAction = new ViewScraperPageAction();
            //
        }else if( $action == ViewCookiePageAction::getActionName()) {
            $implAction = new ViewCookiePageAction();
            //
        }else if( $action == ViewFavouritePageAction::getActionName()) {
            $implAction = new ViewFavouritePageAction();
            //
        }else if( $action == ViewInformationPageAction::getActionName()) {
            $implAction = new ViewInformationPageAction();
        }

        //----------------------------------------------------------------
        //------  NON VIEW RSS ACTIONS
        if( !$implAction ) {
            if( $action == SaveBookmarkAction::getActionName()) {
                $implAction = new SaveBookmarkAction();
                //
            }else if( $action == DeleteBookmarkAction::getActionName()) {
                $implAction = new DeleteBookmarkAction();
                //
            }else if( $action == SaveFavouriteWebsiteAction::getActionName()) {
                $implAction = new SaveFavouriteWebsiteAction();
            //
            }
        }

        //----------------------------------------------------------------
        //Execute action
        if($implAction) {
            $implAction->dispatch();
        }else {

        }
    }

}

?>