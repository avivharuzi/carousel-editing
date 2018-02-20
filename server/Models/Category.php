<?php 

class Category {
    public $Id;
    public $Name;

    public function __construct() {
        if (func_num_args() > 0) {
            $this->Id   = func_get_arg(0);
            $this->Name = func_get_arg(1);
        }
    }

    public function setCategory() {
        $sql = "INSERT INTO category (Name) VALUES ('$this->Name')";
        return DatabaseHandler::insert($sql);
    }
}

?>
