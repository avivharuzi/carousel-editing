<?php 

class Carousel {
    public $Id;
    public $Image;
    public $Description;
    public $SubCategoryId;
    public $CategoryId;

    public function __construct() {
        if (func_num_args() > 0) {
            $this->Id            = func_get_arg(0);
            $this->Image         = func_get_arg(1);
            $this->Description   = func_get_arg(2);
            $this->SubCategoryId = func_get_arg(3);
            $this->CategoryId    = func_get_arg(4);
        }
    }

    public function setCarousel() {
        $sql = "INSERT INTO carousel (Image, Description, SubCategoryId, CategoryId)
        VALUES ('$this->Image', '$this->Description', '$this->SubCategoryId', '$this->CategoryId')";
        return DatabaseHandler::insert($sql);
    }
}

?>
