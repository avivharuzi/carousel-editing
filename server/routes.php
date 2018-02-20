<?php

function call($controller, $action) {
    require_once("Controllers/" . $controller . "Controller.php");

    switch ($controller) {
        case "carouseles":
            require_once("Models/Upload.php");
            require_once("Models/Carousel.php");
            require_once("Models/SubCategory.php");
            require_once("Models/Category.php");
            require_once("handlers/carousel-handler.php");
            $controller = new CarouselesController();
            break;
        case "pages":
            $controller = new PagesController();
            break;
    }
    $controller->{$action}();
}

$controllers = array(
    "carouseles" => ["get_images", "set_images", "get_categories", "get_images_by_category_id"]
);

if (array_key_exists($controller, $controllers)) {
    if (in_array($action, $controllers[$controller])) {
        call($controller, $action);
    } else {
        call("pages", "error");
    }
} else {
    call("pages", "error");
}

?>
