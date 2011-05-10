<?php

/* -------------------------
 *    Developed by Maicros
 *    GNU/GPL v2  Licensed
 * ------------------------ */

if (isset($_GET["type"])) {
    $type = $_GET["type"];
    switch ($type) {
        case "bookmark";
            $index = $_GET["index"];
            echo ceil(($index+1) / 12 );
            break;
    }
}
?>
