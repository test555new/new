<?php

session_start();

$pageTitle = 'Резина';

$pageScripts = [
    '../js/search.js',
    '../js/menu.js'
];

include '../templates/header.php';

$jsonFile = __DIR__ . '/../DB/autoPartJSON.json';

$parts = [];

// Загружаем JSON
if (file_exists($jsonFile)) {

    $json = file_get_contents($jsonFile);
    $data = json_decode($json, true);

    if (is_array($data)) {
        $parts = $data;
    }
}

// Фильтруем только резину
$parts = array_filter($parts, function ($part) {
    return isset($part['partType']) && $part['partType'] === 'Резина';
});

?>

<?php include '../templates/menu.php'; ?>

<div id="content">

    <h1>Резина</h1>

    <div class="search_block">

        <input type="text" placeholder="Поиск товара">

        <button id="search_btn">Поиск</button>

    </div>

    <?php
    $showBackButton = true;
    include '../templates/catalogBack.php';
    ?>

    <div class="cards">

        <?php if (empty($parts)): ?>

            <h2>Резина отсутствует</h2>

        <?php else: ?>

            <?php foreach ($parts as $part): ?>

                <div class="card"

                    data-id="<?= htmlspecialchars($part['id']) ?>"
                    data-price="<?= htmlspecialchars($part['price']) ?>"
                    data-tech="<?= htmlspecialchars($part['category']) ?>"
                    data-part-type="<?= htmlspecialchars($part['partType']) ?>"
                    data-warranty="<?= htmlspecialchars($part['warranty']) ?>"
                    data-producer="<?= htmlspecialchars($part['producer']) ?>"
                    data-count="<?= htmlspecialchars($part['count']) ?>"
                    data-delivery="<?= htmlspecialchars($part['deliveryTime']) ?>">

                    <img
                        src="../imgDB/autoPart/<?= htmlspecialchars(basename($part['image'])) ?>"
                        alt="<?= htmlspecialchars($part['name']) ?>">

                    <h3>
                        <?= htmlspecialchars($part['name']) ?>
                    </h3>

                    <p>
                        <?= htmlspecialchars($part['description']) ?>
                    </p>

                    <form action="../controllers/autoPartController.php" method="post">

                        <input type="hidden" name="action" value="delete_part">
                        <input type="hidden" name="id" value="<?= htmlspecialchars($part['id']) ?>">
                        <input type="hidden" name="return" value="/www/pages/rubber.php">

                        <button type="submit" class="delete_btn">
                            Удалить
                        </button>

                    </form>

                </div>

            <?php endforeach; ?>

        <?php endif; ?>

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
        <p id="modal_part_type"></p>
        <p id="modal_producer"></p>
        <p id="modal_count"></p>
        <p id="modal_delivery"></p>

        <button id="modal_close">Закрыть</button>

    </div>

</div>

<?php if (!empty($_SESSION['success_delete'])): ?>

<script>
    alert(
        "Запчасть удалена\n" +
        "ID: <?php echo $_SESSION['success_delete']['id']; ?>\n" +
        "Название: <?php echo $_SESSION['success_delete']['name']; ?>\n" +
        "Тип: <?php echo $_SESSION['success_delete']['partType']; ?>"
    );
</script>

<?php unset($_SESSION['success_delete']); ?>
<?php endif; ?>

<?php include '../templates/footer.php'; ?>