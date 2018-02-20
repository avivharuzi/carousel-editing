<?php

class PagesController {
    public function error() {
        $error["message"] = "No action or controller requested";
        $error["response"] = false;
        echo json_encode($error);
    }
}

?>
