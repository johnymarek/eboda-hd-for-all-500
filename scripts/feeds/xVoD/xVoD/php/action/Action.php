<?php
/*-------------------------
 *    Developed by Maicros
 *      GNU/GPL Licensed
 * ------------------------*/

abstract class Action {


    public abstract function dispatch();

    public static abstract function getActionName();

}

?>
