<?php
/*-------------------------
 *    Developed by Maicros
 *      GNU/GPL Licensed
 * ------------------------*/

class ViewAboutPageAction extends Action {

    public function dispatch() {
        $template = new AboutTemplate();
        $template->showTemplate();

    }
    public static function getActionName() {
        return "viewAboutPage";
    }

}

?>
