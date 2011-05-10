<?php
/*-------------------------
 *    Developed by Maicros
 *      GNU/GPL Licensed
 * ------------------------*/


class ViewInformationPageAction extends Action {


    public function dispatch() {
        $template = new InfoXvodWebTemplate();
        $template->show();
    }

    public static function getActionName() {
        return "viewWebInformationPage";
    }

}

?>