document.addEventListener("DOMContentLoaded", function () {

    const loader = document.getElementById("loader");

    // блокируем прокрутку
    document.body.style.overflow = "hidden";

    setTimeout(() => {
        loader.style.display = "none";
        document.body.style.overflow = "auto";
    }, 3000);

});