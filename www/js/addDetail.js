document.addEventListener("DOMContentLoaded", function () {

    var form = document.querySelector(".add_part_form");

    var modalBg = document.getElementById("search_modal_bg");
    var modalClose = document.getElementById("modal_close");
    var modalConfirm = document.getElementById("modal_confirm"); // кнопка подтверждения

    var modalImage = document.getElementById("modal_image");
    var modalTitle = document.getElementById("modal_title");
    var modalCategory = document.getElementById("modal_category");
    var modalPrice = document.getElementById("modal_price");
    var modalCount = document.getElementById("modal_count");
    var modalDescription = document.getElementById("modal_description");

    if (!form || !modalBg) return;

    form.addEventListener("submit", function (e) {
        e.preventDefault();

        var title = form.querySelector("[name='name']");
        var price = form.querySelector("[name='price']");
        var count = form.querySelector("[name='count']");
        var photo = form.querySelector("[name='image']");
        var category = form.querySelector("[name='category']");
        var description = form.querySelector("[name='description']");

        modalTitle.textContent = title.value;
        modalCategory.textContent = "Категория: " + category.value;
        modalPrice.textContent = "Цена: " + price.value + " ₽";
        modalCount.textContent = "Количество: " + count.value + " шт.";
        modalDescription.textContent = "Описание: " + description.value;

        if (photo.files.length > 0) {
            modalImage.src = URL.createObjectURL(photo.files[0]);
        }

        modalBg.style.display = "flex";
    });

    // ✅ подтверждение отправки
    if (modalConfirm) {
        modalConfirm.addEventListener("click", function () {
            form.submit(); // реальная отправка
        });
    }

    // ❌ закрытие модалки
    if (modalClose) {
        modalClose.addEventListener("click", function () {
            modalBg.style.display = "none";
        });
    }
});