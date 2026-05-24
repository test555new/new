<?php

$pageTitle = 'Профиль';

$pageScripts = [
    '../js/orders.js',
    '../js/menu.js'
];

include '../templates/header.php';
?>

<?php include '../templates/menu.php'; ?>

<!--таблица -->
<div id="content">

    <h1>Список заказов</h1>
    
    <button id="add_order_btn">Добавить заказ</button>

    <div class="table_block">

        <table class="orders_table">

            <tr>
                <th>Номер заказа</th>
                <th>Почта заказчика</th>
                <th>Запчасть</th>
                <th>Стоимость</th>
                <th>Способ оплаты</th>
                <th>Способ доставки</th>
                <th>Дата доставки</th>
            </tr>

            <tr>
                <td>1</td>
                <td>ivan@mail.com</td>
                <td>Двигатель V8</td>
                <td>120000 ₽</td>
                <td>Карта</td>
                <td>Курьер</td>
                <td>12.05.2026</td>
            </tr>

            <tr>
                <td>2</td>
                <td>alex@mail.com</td>
                <td>Зимняя резина</td>
                <td>34000 ₽</td>
                <td>Наличные</td>
                <td>Самовывоз</td>
                <td>15.05.2026</td>
            </tr>

            <tr>
                <td>3</td>
                <td>nikita@mail.com</td>
                <td>карбюратор на ИЖ Урал Минск Восход Днепр</td>
                <td>18500 ₽</td>
                <td>Карта</td>
                <td>Курьер</td>
                <td>17.05.2026</td>
            </tr>

            <tr>
                <td>4</td>
                <td>maria@mail.com</td>
                <td>Аккумулятор</td>
                <td>9200 ₽</td>
                <td>Онлайн</td>
                <td>Почта</td>
                <td>18.05.2026</td>
            </tr>

            <tr>
                <td>5</td>
                <td>oleg@mail.com</td>
                <td>Моторное масло</td>
                <td>4500 ₽</td>
                <td>Карта</td>
                <td>Курьер</td>
                <td>20.05.2026</td>
            </tr>

        </table>

    </div>

</div>

<?php include '../templates/footer.php'; ?>