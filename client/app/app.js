"use strict";

const CAROUSEL_SLIDES = $("#carouselSlides");
const CAROUSEL_ITEMS = $("#carouselItems");
const UPLOAD_MESSAGE = $("#uploadMessage");

$(function () {
    $("#upload").on("click", function () {
        setImages(function (data) {
            if (messageTemplate(data, UPLOAD_MESSAGE)) {
                resetInputs();
                getCategoriesAndUpdate();
                $("#home").click();
            }
        });
    });

    $("#home").on("click", function () {
        getLastImagesAndUpdate();
        resetInputs();
    });

    $("body").on("click", ".sub-categories", function () {
        let categoryId = $(this).parent().prev().attr("data-id"); 
        let subCategoryId = $(this).attr("data-id");

        let categoryName = $(this).parent().prev().attr("data-name"); 
        let subCategoryName = $(this).attr("data-name");

        let finalCategory = `#${categoryName}#${subCategoryName}`;
        $("#category").val(finalCategory);
        
        getImagesByCategoryIdAndUpdate(categoryId, subCategoryId);
    });

    $("#toggleCarouselForm").on("click", function () {
        $("#carouselForm").slideToggle();

        if ($(this).text() == "Show") {
            $(this).text("Hide");
        } else {
            $(this).text("Show");
        }
    });

    $(".carousel").carousel({
        interval: 4000
    });

    getCategoriesAndUpdate();
    getLastImagesAndUpdate();
});

function getImages() {
    return $.ajax({
        method: "GET",
        url: "http://localhost/carousel-editing/server/index.php?controller=carouseles&action=get_images",
        dataType: "JSON",
    });
}

function setImages(callback) {
    let file = $("#file").prop("files")[0];
    let formData = new FormData();
    formData.append("file", file);
    formData.append("description", $("#description").val());
    formData.append("category", $("#category").val());

    $.ajax({
        url: "http://localhost/carousel-editing/server/index.php?controller=carouseles&action=set_images",
        contentType: false,
        processData: false,
        data: formData,
        method: "POST",
        dataType: "JSON",
        success: function(data) {
            callback(data);
        }
    });
}

function getCategories() {
    return $.ajax({
        url: "http://localhost/carousel-editing/server/index.php?controller=carouseles&action=get_categories",
        method: "GET",
        dataType: "JSON"
    });
}

function getImagesByCategoryId(categoryId, subCategoryId) {
    return $.ajax({
        url: "http://localhost/carousel-editing/server/index.php?controller=carouseles&action=get_images_by_category_id",
        method: "GET",
        dataType: "JSON",
        data: {
            categoryId: categoryId,
            subCategoryId: subCategoryId
        }
    });
}

async function getCategoriesAndUpdate() {
    let categories = await getCategories();
    categoriesTemplate(categories);
}

async function getImagesByCategoryIdAndUpdate(categoryId, subCategoryId) {
    let images = await getImagesByCategoryId(categoryId, subCategoryId);
    carouselTemplate(images);
}

async function getLastImagesAndUpdate() {
    let images = await getImages();
    carouselTemplate(images);
}

function resetInputs() {
    $("#description").val("");
    $("#category").val("");
    $("#file").val("");
}

String.prototype.capitalize = function () {
    return this.toLocaleLowerCase().charAt(0).toUpperCase() + this.slice(1);
}
