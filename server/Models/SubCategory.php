<?php 

class SubCategory {
    public $Id;
    public $Name;

    public function __construct() {
        if (func_num_args() > 0) {
            $this->Id   = func_get_arg(0);
            $this->Name = func_get_arg(1);
        }
    }

    public function setSubCategory() {
        $sql = "INSERT INTO subcategory (Name) VALUES ('$this->Name')";
        return DatabaseHandler::insert($sql);
    }
}

?>
