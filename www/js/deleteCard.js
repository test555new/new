document.addEventListener("DOMContentLoaded", function () {
    // все карточки
    var cards = document.querySelectorAll(".card");

    // перебор карточек
    for (var i = 0; i < cards.length; i++) {

        // создание кнопки
        var deleteBtn = document.createElement("button");

        deleteBtn.textContent = "Удалить";
        deleteBtn.className = "delete_btn";

        cards[i].appendChild(deleteBtn);

        // удаление карточки
        deleteBtn.addEventListener("click", function (e) {

            e.stopPropagation();

            this.parentElement.remove();

        });

    }

});