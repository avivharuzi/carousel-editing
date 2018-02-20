<?php

require_once("connection/db.php");
require_once("handlers/db-handler.php");
require_once("handlers/validation-handler.php");

date_default_timezone_set("Israel");

if (isset($_REQUEST["controller"]) && isset($_REQUEST["action"])) {
    $controller = $_REQUEST["controller"];
    $action     = $_REQUEST["action"];
} else {
    $controller = "carouseles";
    $action     = "get_images";
}

require_once("routes.php");

?>
