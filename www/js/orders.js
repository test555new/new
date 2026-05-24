document.addEventListener("DOMContentLoaded", function () {

    var table = document.querySelector(".orders_table tbody");
    var addBtn = document.getElementById("add_order_btn");

    addBtn.addEventListener("click", function () {

        var rows = table.getElementsByTagName("tr");
        //нумерация строк
        var lastRow = rows[rows.length - 1];
        var lastNumber = parseInt(lastRow.cells[0].textContent);
        var newNumber = lastNumber + 1;

        var newRow = document.createElement("tr");
        //добавление строк
        newRow.innerHTML = `
            <td>${newNumber}</td>
            <td contenteditable="true"></td>
            <td contenteditable="true"></td>
            <td contenteditable="true"></td>
            <td contenteditable="true"></td>
            <td contenteditable="true"></td>
            <td contenteditable="true"></td>
        `;

        table.appendChild(newRow);
    });

});