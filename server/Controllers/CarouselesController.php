<?php

class CarouselesController {
    public function get_images() {
        $images = DatabaseHandler::full("
        SELECT carousel.Id as Id, carousel.Image as Image,
        carousel.Description as Description,
        category.Name as Category,
        subcategory.Name as SubCategory
        FROM carousel
        LEFT JOIN category ON CategoryId = category.Id
        LEFT JOIN subcategory ON SubCategoryId = subcategory.Id
        ORDER BY Id DESC LIMIT 10");
        echo json_encode($images);
    }

    public function set_images() {
        $upload = new Upload();

        if (isset($_FILES["file"])) {
            if (!$upload->checkUpload($_FILES["file"])) {
                $message["errors"][] = $upload->getErrorMsg();
            }
        } else {
            $message["errors"][] = "Please select file to upload";
        }


        if (ValidationHandler::validateInputs($_POST["description"], "/^[A-Za-z ]{3,55}$/")) {
            $description = $_POST["description"];
        } else {
            $message["errors"][] = "This description is invalid";
        }

        if (ValidationHandler::validateInputs($_POST["category"], "/^[#]{1}[a-zA-Z0-9]{3,55}$/")) {
            $categories = preg_split("/[#]+/", $_POST["category"]);
            $category = strtolower($categories[1]);
            $subCategory = 1;
        } else if (ValidationHandler::validateInputs($_POST["category"], "/^[#]{1}[a-zA-Z0-9]{3,55}[#]{1}[a-zA-Z0-9]{3,55}$/")) {
            $categories = preg_split("/[#]+/", $_POST["category"]);
            $category = strtolower($categories[1]);
            $subCategory = strtolower($categories[2]);
        } else {
            $message["errors"][] = "This category is invalid";
        }

        if (empty($message["errors"])) {
            if (!($categoryId = CarouselHandler::checkCategory($category))) {
                $newCategory = new Category(null, $category);
                $categoryId = $newCategory->setCategory();
            }

            if ($subCategory !== 1) {
                if (!($subCategoryId = CarouselHandler::checkSubCategory($subCategory))) {
                    $newSubCategory = new SubCategory(null, $subCategory);
                    $subCategoryId = $newSubCategory->setSubCategory();
                }
            } else {
                $subCategoryId = 1;
            }

            $upload->fileUpload($_FILES["file"], "../client/assets/images/");
            $image = $upload->getFinallyName();

            $carousel = new Carousel(null, $image, $description, $subCategoryId, $categoryId);
            $carousel->setCarousel();
            $message["response"] = true;
            $message["success"] = "This image carousel added successfully";
        } else {
            $message["response"] = false;
        }
        echo json_encode($message);
    }

    public function get_categories() {
        $categories = DatabaseHandler::all("category");

        foreach ($categories as $category) {
            $subCategories = CarouselHandler::getSubCategoriesById($category->Id);

            $allCategories[] = ["CategoryId"=>$category->Id, "CategoryName"=>$category->Name, "SubCategories"=>$subCategories];
        }

        echo json_encode($allCategories);
    }

    public function get_images_by_category_id() {
        $categoryId = $_GET["categoryId"];
        $subCategoryId = $_GET["subCategoryId"];

        $images = DatabaseHandler::full("
        SELECT carousel.Id as Id, carousel.Image as Image,
        carousel.Description as Description,
        category.Name as Category,
        subcategory.Name as SubCategory
        FROM carousel
        LEFT JOIN category ON CategoryId = category.Id
        LEFT JOIN subcategory ON SubCategoryId = subcategory.Id
        WHERE carousel.CategoryId = $categoryId AND carousel.SubCategoryId = $subCategoryId;
        ");

        echo json_encode($images);
    }
}

?>
