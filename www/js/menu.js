document.addEventListener("DOMContentLoaded", function () {

    var logo = document.getElementById("menu_logo");
    var menu = document.getElementById("menu");

    if (logo && menu) {

        logo.addEventListener("click", function () {
            menu.classList.toggle("menu-hidden");
        });

    }

});