<?php
/*-------------------------
 *    Developed by Maicros
 *      GNU/GPL Licensed
 * ------------------------*/

/**
 * Method to print out general scripts
 */
class RssScriptUtil {

    /**
     * Print out script to add bookmark to database on user press 1 button.
     * <b>Use into "onUserInput" tags.</b>
     */
    public static function showAddBookmarkScript() {
        $urlLink = SERVER_HOST_AND_PATH . "php/index.php?action=" . SaveBookmarkAction::getActionName() . URL_AMP . "data=";
        ?>
    userInput = currentUserInput();
    if ( userInput == "one" ){
        showIdle();
        result = getURL("<?php echo $urlLink; ?>" + getItemInfo("data"));
        redrawDisplay();
        cancelIdle();
    }
        <?php
    }

    /**
     * Print out script to delete bookmark from database on user press 3 button.
     * <b>Use into "onUserInput" tags.</b>
     */
    public static function showDeleteBookmarkScript() {
        $urlLink = SERVER_HOST_AND_PATH . "php/index.php?action=" . DeleteBookmarkAction::getActionName() . URL_AMP . "data=";
        ?>
    userInput = currentUserInput();
    if ( userInput == "three" ){
        showIdle();
        result = getURL("<?php echo $urlLink; ?>" + getItemInfo("data"));
        redrawDisplay();
        cancelIdle();
    }
        <?php
    }

}

?>
