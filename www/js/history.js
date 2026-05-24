document.addEventListener("DOMContentLoaded", function () {

    var addBtn = document.getElementById("add_order_btn");
    var addModalBg = document.getElementById("add_modal_bg");
    var addForm = document.getElementById("add_form");
    var cardsBlock = document.querySelector(".cards");
    // кнопка закрытия
    var closeBtn = addForm.querySelector('button[type="button"]');
    //модалка
    addBtn.addEventListener("click", function () {

        addModalBg.style.display = "block";

    });

    //закрытие
    closeBtn.addEventListener("click", function () {

        addModalBg.style.display = "none";

        clearErrors(addForm);

    });

    //отправка формы
    addForm.addEventListener("submit", function (e) {

        e.preventDefault();

        clearErrors(this);

        var inputs = this.querySelectorAll("input");
        var selects = this.querySelectorAll("select");

        var title = inputs[0];
        var price = inputs[1];
        var count = inputs[2];
        var address = inputs[3];
        var buyer = inputs[4];
        var email = inputs[5];
        var phone = inputs[6];
        var photo = inputs[7];

        var category = selects[0];
        var delivery = selects[1];

        var hasError = false;

        //валидации

        if (title.value.trim().length < 2) {
            setError(title, "Введите название товара");
            hasError = true;

        }

       if (category.value == "") {
        setError(category, "Выберите категорию");
        hasError = true;
    }

        if (
            price.value.trim() == "" ||
            isNaN(price.value) ||
            Number(price.value) <= 0
        ) {

            setError(price, "Введите корректную цену");

            hasError = true;

        }

        if (
            count.value.trim() == "" ||
            isNaN(count.value) ||
            Number(count.value) <= 0
        ) {

            setError(count, "Введите количество");
            hasError = true;

        }

        if (delivery.value == "") {
            setError(delivery, "Выберите тип доставки");
            hasError = true;
        }

        if (address.value.trim().length < 5) {
            setError(address, "Введите адрес");
            hasError = true;

        }

        if (buyer.value.trim().length < 2) {
            setError(buyer, "Введите имя покупателя");
            hasError = true;

        }

        if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email.value)) {
            setError(email, "Некорректный Email");
            hasError = true;

        }

        if (!/^\+?[0-9\s\-\(\)]{10,20}$/.test(phone.value)) {
            setError(phone, "Некорректный номер");
            hasError = true;

        }

        if (photo.files.length == 0) {
            setError(photo, "Выберите фото товара");
            hasError = true;

        }

        if (!hasError) {
            // создание карточки
            var newCard = document.createElement("div");
            newCard.className = "card";
            // ссылка на фото
            var photoUrl = URL.createObjectURL(photo.files[0]);
            // содержимое карточки
            newCard.innerHTML = `

                <img src="${photoUrl}" alt="Товар">

                <h3>${title.value}</h3>

                <p>
                    Категория: <b>${category.value}</b><br>
                    Цена: <b>${price.value} ₽</b><br>
                    Количество: <b>${count.value} шт</b><br>
                    Тип доставки: <b>${delivery.value}</b><br>
                    Адрес доставки: <b>${address.value}</b><br>
                    Покупатель: <b>${buyer.value}</b><br>
                    Почта: <b>${email.value}</b><br>
                    Телефон: <b>${phone.value}</b>
                </p>

            `;

            // добавление карточки
            cardsBlock.appendChild(newCard);
            alert("Продажа успешно добавлена");
            this.reset();
            // закрытие модалки
            addModalBg.style.display = "none";

        }

    });

    //ошибки

    function setError(input, text) {
        input.classList.add("input_error");
        var error = document.createElement("div");
        error.className = "error_message";
        error.textContent = text;
        input.parentNode.insertBefore(error, input.nextSibling);

    }

    //очистка

    function clearErrors(form) {

        var errors = form.querySelectorAll(".error_message");

        for (var i = 0; i < errors.length; i++) {
            errors[i].remove();
        }

        var fields = form.querySelectorAll("input, textarea, select");

        for (var j = 0; j < fields.length; j++) {
            fields[j].classList.remove("input_error");
        }
    }

});