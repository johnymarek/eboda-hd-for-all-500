<?php

/*-------------------------
 *    Developed by Maicros
 *    GNU/GPL v2  Licensed
 * ------------------------*/

class ConnectionFactory {

    const TYPE_XML = 1;
    const TYPE_SQLITE3 = 2;

    public static function getDataConnection($type=null) {
        $connection = false;
        if(!$type) {
            $type = class_exists("SQLite3") ? ConnectionFactory::TYPE_SQLITE3 : ConnectionFactory::TYPE_XML;
        }
        switch($type) {
            case ConnectionFactory::TYPE_SQLITE3:
                $connection = new Sqlite3Connection();
                break;
            default:
                $connection = new XmlConnection();
        }
        return $connection;
    }
    
}

?>
