"use strict";

function carouselTemplate(images) {
    let slides = "";
    let items = "";
    let i = 0;

    $.each(images, function (index, value) {
        let active = "";
        if (i === 0) {
            active = "active";
        }
        slides +=
        `<li data-target="#carouselExampleIndicators" data-slide-to="${i}" class="${active}"></li>`;
        items +=
        `<div class="carousel-item ${active}">
            <img class="d-block w-100" src="assets/images/${value.Image}" height="540">
            <div class="carousel-caption d-none d-md-block">
                <h3 class="padd-black">${value.Category.capitalize()}</h3>
                <br>
                <h5 class="padd-black">${value.SubCategory.capitalize()}</h5>
                <br>
                <p class="padd-black">${value.Description.capitalize()}</p>
            </div>
        </div>`;
        i++;
    });
    CAROUSEL_SLIDES.html(slides);
    CAROUSEL_ITEMS.html(items);
}
