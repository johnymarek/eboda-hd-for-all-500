<?php
/*-------------------------
 *    Developed by Maicros
 *      GNU/GPL Licensed
 * ------------------------*/


class ViewWebHomePageAction extends Action {

    public function dispatch() {
        $template = new HomeWebTemplate();
        $template->show();
    }

    public static function getActionName() {
        return "viewWebHomePage";
    }

}

?>
