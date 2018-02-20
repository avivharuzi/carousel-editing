<?php

class CarouselHandler {
    private function __construct() {
    }
    
    public static function checkCategory($name) {
        $category = DatabaseHandler::whereOne("category", "Name", $name);

        if ($category) {
            return $category->Id;
        } else {
            return false;
        }
    }

    public static function checkSubCategory($name) {
        $subCategory = DatabaseHandler::whereOne("subcategory", "Name", $name);

        if ($subCategory) {
            return $subCategory->Id;
        } else {
            return false;
        }
    }

    public static function getSubCategoriesById($categoryId) {
        $subCategories = DatabaseHandler::full(
            "SELECT carousel.Id as Id,
            category.Name as CategoryName,
            subcategory.Name as SubCategoryName,
            CategoryId,
            SubCategoryId
            FROM carousel
            LEFT JOIN category ON CategoryId = category.Id
            LEFT JOIN subcategory ON SubCategoryId = subcategory.Id
            WHERE CategoryId = $categoryId GROUP BY SubCategoryId"
        );

        foreach ($subCategories as $subCategory) {
            $result[] = ["Id"=>$subCategory->SubCategoryId, "Name"=>$subCategory->SubCategoryName];
        }

        return $result;
    }
}

?>
