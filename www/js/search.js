document.addEventListener("DOMContentLoaded", function () {

    var searchInput = document.querySelector(".search_block input");
    var searchBtn = document.getElementById("search_btn");

    // модалка
    var modalBg = document.getElementById("search_modal_bg");
    var modalClose = document.getElementById("modal_close");

    var modalImg = document.getElementById("modal_img");
    var modalTitle = document.getElementById("modal_title");

    var modalPrice = document.getElementById("modal_price");
    var modalTech = document.getElementById("modal_tech");
    var modalWarranty = document.getElementById("modal_warranty");
    var modalProducer = document.getElementById("modal_producer");
    var modalCount = document.getElementById("modal_count");
    var modalDelivery = document.getElementById("modal_delivery");

    // НОВОЕ: тип детали
    var modalPartType = document.getElementById("modal_part_type");

    // все карточки
    var cards = document.querySelectorAll(".card");

    // клик по карточке
    for (var i = 0; i < cards.length; i++) {
        cards[i].addEventListener("click", function () {
            openModal(this);
        });
    }

    // Enter
    searchInput.addEventListener("keydown", function (e) {
        if (e.key === "Enter") {
            e.preventDefault();
            searchElement();
        }
    });

    // кнопка поиска
    searchBtn.addEventListener("click", function () {
        searchElement();
    });

    // поиск
    function searchElement() {

        var searchText = searchInput.value.trim().toLowerCase();

        if (searchText.length === 0) {
            return;
        }

        var foundCard = null;

        for (var i = 0; i < cards.length; i++) {

            var title = cards[i]
                .querySelector("h3")
                .textContent
                .toLowerCase();

            if (title === searchText) {
                foundCard = cards[i];
                break;
            }
        }

        if (foundCard) {
            openModal(foundCard);
        } else {
            alert("Элемент не найден");
        }
    }

    // открыть модалку
    function openModal(card) {

        modalImg.src = card.querySelector("img").src;
        modalTitle.textContent = card.querySelector("h3").textContent;

        modalPrice.textContent =
            "Цена: " + card.dataset.price;

        modalTech.textContent =
            "Техника: " + card.dataset.tech;

        modalWarranty.textContent =
            "Гарантия: " + card.dataset.warranty;

        modalProducer.textContent =
            "Производитель: " + card.dataset.producer;

        modalCount.textContent =
            "На складе: " + card.dataset.count;

        modalDelivery.textContent =
            "Доставка: " + card.dataset.delivery;

        // НОВОЕ: тип детали
        modalPartType.textContent =
            "Тип детали: " + card.dataset.partType;

        modalBg.style.display = "block";
    }

    // закрытие модалки
    modalClose.onclick = function () {
        modalBg.style.display = "none";
    };

});