"use strict";

function categoriesTemplate(categories) {
    let output = ``;

    for (let category of categories) {
        output += `
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle categories" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
            data-id="${category.CategoryId}" data-name="${category.CategoryName}" aria-haspopup="true" aria-expanded="false">${category.CategoryName.capitalize()}</a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">`;

        for (let subCategory of category.SubCategories) {
            output += `
            <a class="dropdown-item sub-categories" data-id="${subCategory.Id}" data-name="${subCategory.Name}" href="#">${subCategory.Name.capitalize()}</a>
            `;
        }

        output += `
            </div>
        </li>`;
    }

    $("#categoriesItems").html(output);
}
