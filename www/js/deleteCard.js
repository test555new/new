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

            var card = this.parentElement;
            var id = card.getAttribute("data-id");

            // если id нет — просто убираем карточку из DOM
            if (!id) {
                card.remove();
                return;
            }

            // форма для отправки на контроллер
            var form = document.createElement("form");

            form.method = "post";
            form.action = "../controllers/autoPartController.php";

            // action = delete_part
            var actionInput = document.createElement("input");
            actionInput.type = "hidden";
            actionInput.name = "action";
            actionInput.value = "delete_part";
            form.appendChild(actionInput);

            // id удаляемой запчасти
            var idInput = document.createElement("input");
            idInput.type = "hidden";
            idInput.name = "id";
            idInput.value = id;
            form.appendChild(idInput);

            // адрес возврата (текущая страница)
            var returnInput = document.createElement("input");
            returnInput.type = "hidden";
            returnInput.name = "return";
            returnInput.value = window.location.pathname;
            form.appendChild(returnInput);

            document.body.appendChild(form);

            form.submit();

        });

    }

});
