<?php

$pageTitle = 'Профиль';

$pageScripts = [
    '../js/search.js',
    '../js/history.js',
    '../js/menu.js',
    '../js/deleteCard.js'
];

include '../templates/header.php';
?>

<?php include '../templates/menu.php'; ?>
<div id="content">
    <!--карточки продаж-->
    <h1>История продаж</h1>

    <div class="search_block">

        <input type="text" placeholder="Поиск товара">

        <button id="search_btn">Поиск</button>

    </div>

    <button id="add_order_btn">Добавить</button>
    <div class="cards">

    <div class="card"
            data-price="120 000 ₽"
            data-tech="Автомобиль"
            data-warranty="24 месяца"
            data-producer="BMW"
            data-count="5 шт"
            data-delivery="1 день"
    >

        <img src="../img/engine1.png" alt="Товар">

        <h3>Двигатель V8</h3>

        <p>
            Категория: <b>Двигатели</b><br>
            Цена: <b>120 000 ₽</b><br>
            Количество: <b>2 шт</b><br>
            Тип доставки: <b>Курьер</b><br>
            Адрес доставки: <b>Москва, Ленина 15</b><br>
            Покупатель: <b>Иван Петров</b><br>
            Почта: <b>ivan@mail.ru</b><br>
            Телефон: <b>+7 999 111 22 33</b>
        </p>

        
    </div>

    <div class="card"

    data-price="34 000 ₽"
            data-tech="Автомобиль"
            data-warranty="12 месяцев"
            data-producer="Michelin"
            data-count="12 шт"
            data-delivery="2 дня"
    >

        <img src="../img/rubber1.png" alt="Товар">

        <h3>Зимняя резина</h3>

        <p>
            Категория: <b>Резина</b><br>
            Цена: <b>34 000 ₽</b><br>
            Количество: <b>4 шт</b><br>
            Тип доставки: <b>Самовывоз</b><br>
            Адрес доставки: <b>Склад AutoParts</b><br>
            Покупатель: <b>Алексей Смирнов</b><br>
            Почта: <b>alex@mail.ru</b><br>
            Телефон: <b>+7 999 555 44 11</b>
        </p>

    </div>

    <div class="card"
    data-price="9 500 ₽"
            data-tech="Мотоцикл"
            data-warranty="6 месяцев"
            data-producer="K65"
            data-count="9 шт"
            data-delivery="4 дня"
    >

        <img src="../img/carburetor2.png" alt="Товар">

        <h3>Карбюратор ИЖ Урал</h3>

        <p>
            Категория: <b>Карбюраторы</b><br>
            Цена: <b>18 500 ₽</b><br>
            Количество: <b>1 шт</b><br>
            Тип доставки: <b>Почта</b><br>
            Адрес доставки: <b>Казань, Гагарина 7</b><br>
            Покупатель: <b>Дмитрий Волков</b><br>
            Почта: <b>dima@mail.ru</b><br>
            Телефон: <b>+7 999 777 66 55</b>
        </p>

    </div>

</div>

</div>

<!-- Модальное окно поиска -->
<div id="search_modal_bg">

    <div id="search_modal_box">

        <img id="modal_img" src="" alt="Товар">

        <h2 id="modal_title"></h2>

        <p id="modal_price"></p>
        <p id="modal_tech"></p>
        <p id="modal_warranty"></p>
        <p id="modal_producer"></p>
        <p id="modal_count"></p>
        <p id="modal_delivery"></p>

        <button id="modal_close">Закрыть</button>

    </div>

</div>

<!-- Модальное окно добавления продажи -->
<div id="add_modal_bg">

    <div id="add_modal_box">

        <h2>Добавление продажи</h2>

        <form id="add_form">

            <label>Наименование товара *</label>
            <input type="text">

            <label>Категория *</label>

            <select class="part_select" >

                <option value="">Выберите категорию</option>
                <option>Машина</option>
                <option>Мотоцикл</option>
                <option>Грузовик</option>
                <option>Автобус</option>
                <option>Электромобиль</option>

            </select>

            <label>Цена *</label>
            <input type="number">

            <label>Количество *</label>
            <input type="number">

            <label>Тип дотсавки *</label>
            <select class="part_select" >

                <option value="">Выберите тип доставки</option>
                <option>Самовывоз</option>
                <option>Курьером</option>
                <option>Почта</option>

            </select>

            <label>Адрес доставки *</label>
            <input type="text">

            <label>Имя покупателя *</label>
            <input type="text">

            <label>Почта покупателя *</label>
            <input type="text">

            <label>Номер покупателя *</label>
            <input type="text">

            <label>Фото товара</label>
            <input type="file" accept="image/*">

            <div class="modal_buttons">

                <button type="submit" class="blue_btn">Добавить</button>
                <button type="button" class="blue_btn">Закрыть</button>

            </div>

        </form>

    </div>

</div>

<?php include '../templates/footer.php'; ?>