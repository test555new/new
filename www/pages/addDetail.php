<?php

session_start();

$pageTitle = 'Добавление запчасти';

$pageScripts = [
    '../js/menu.js',
    '../js/loader.js'
];

include '../templates/header.php';

/* =========================
   FLASH DATA
========================= */

$success = $_SESSION['success_part'] ?? false;

$errors = $_SESSION['errors'] ?? [];
$old = $_SESSION['old'] ?? [];
$partData = $_SESSION['part_data'] ?? null;

unset($_SESSION['success_part']);
unset($_SESSION['errors']);
unset($_SESSION['old']);
unset($_SESSION['part_data']);

?>

<?php include '../templates/menu.php'; ?>

<div id="content">

    <h1>Добавление запчасти</h1>

    <div class="category_buttons">
        <a class="category_buttons" href="catalog.php">Назад в каталог</a>
    </div>

    <div class="add_part_card">

        <img src="../img/icon.png" class="add_part_img" alt="Запчасть">

        <form class="add_part_form"
              action="../controllers/autoPartController.php"
              method="post"
              enctype="multipart/form-data">

            <input type="hidden" name="action" value="save_part">

            <!-- NAME -->
            <label>Название *</label>
            <input type="text"
                   name="name"
                   placeholder="Название запчасти"
                   value="<?php echo htmlspecialchars($old['name'] ?? ''); ?>"
                   class="<?php if(isset($errors['name'])) echo 'input_error'; ?>">

            <?php if(isset($errors['name'])): ?>
                <div class="error_message"><?php echo $errors['name']; ?></div>
            <?php endif; ?>

            <!-- CATEGORY -->
            <label>Категория *</label>
            <select name="category"
                    class="part_select <?php if(isset($errors['category'])) echo 'input_error'; ?>">

                <option value="">Выберите категорию</option>

                <option <?php if(($old['category'] ?? '') == 'Машина') echo 'selected'; ?>>Машина</option>
                <option <?php if(($old['category'] ?? '') == 'Мотоцикл') echo 'selected'; ?>>Мотоцикл</option>
                <option <?php if(($old['category'] ?? '') == 'Грузовик') echo 'selected'; ?>>Грузовик</option>
                <option <?php if(($old['category'] ?? '') == 'Автобус') echo 'selected'; ?>>Автобус</option>
                <option <?php if(($old['category'] ?? '') == 'Электромобиль') echo 'selected'; ?>>Электромобиль</option>

            </select>

            <?php if(isset($errors['category'])): ?>
                <div class="error_message"><?php echo $errors['category']; ?></div>
            <?php endif; ?>

            <!-- PART TYPE -->
            <label>Тип запчасти *</label>
            <select name="partType"
                    class="part_select <?php if(isset($errors['partType'])) echo 'input_error'; ?>">

                <option value="">Выберите тип запчасти</option>

                <option <?php if(($old['partType'] ?? '') == 'Двигатель') echo 'selected'; ?>>Двигатель</option>
                <option <?php if(($old['partType'] ?? '') == 'Резина') echo 'selected'; ?>>Резина</option>
                <option <?php if(($old['partType'] ?? '') == 'Карбюратор') echo 'selected'; ?>>Карбюратор</option>

            </select>

            <?php if(isset($errors['partType'])): ?>
                <div class="error_message"><?php echo $errors['partType']; ?></div>
            <?php endif; ?>

            <!-- PRODUCER -->
            <label>Производитель *</label>
            <input type="text"
                   name="producer"
                   placeholder="Например: Bosch"
                   value="<?php echo htmlspecialchars($old['producer'] ?? ''); ?>"
                   class="<?php if(isset($errors['producer'])) echo 'input_error'; ?>">

            <?php if(isset($errors['producer'])): ?>
                <div class="error_message"><?php echo $errors['producer']; ?></div>
            <?php endif; ?>

            <!-- WARRANTY -->
            <label>Гарантия *</label>
            <input type="text"
                   name="warranty"
                   placeholder="Например: 12 месяцев"
                   value="<?php echo htmlspecialchars($old['warranty'] ?? ''); ?>"
                   class="<?php if(isset($errors['warranty'])) echo 'input_error'; ?>">

            <?php if(isset($errors['warranty'])): ?>
                <div class="error_message"><?php echo $errors['warranty']; ?></div>
            <?php endif; ?>

            <!-- DELIVERY -->
            <label>Срок доставки *</label>
            <input type="text"
                   name="deliveryTime"
                   placeholder="Например: 3 дня"
                   value="<?php echo htmlspecialchars($old['deliveryTime'] ?? ''); ?>"
                   class="<?php if(isset($errors['deliveryTime'])) echo 'input_error'; ?>">

            <?php if(isset($errors['deliveryTime'])): ?>
                <div class="error_message"><?php echo $errors['deliveryTime']; ?></div>
            <?php endif; ?>

            <!-- PRICE -->
            <label>Цена *</label>
            <input type="text"
                   name="price"
                   placeholder="Цена"
                   value="<?php echo htmlspecialchars($old['price'] ?? ''); ?>"
                   class="<?php if(isset($errors['price'])) echo 'input_error'; ?>">

            <?php if(isset($errors['price'])): ?>
                <div class="error_message"><?php echo $errors['price']; ?></div>
            <?php endif; ?>

            <!-- COUNT -->
            <label>Количество *</label>
            <input type="text"
                   name="count"
                   placeholder="Количество"
                   value="<?php echo htmlspecialchars($old['count'] ?? ''); ?>"
                   class="<?php if(isset($errors['count'])) echo 'input_error'; ?>">

            <?php if(isset($errors['count'])): ?>
                <div class="error_message"><?php echo $errors['count']; ?></div>
            <?php endif; ?>

            <!-- DESCRIPTION -->
            <label>Описание</label>
            <textarea name="description"
                      class="<?php if(isset($errors['description'])) echo 'input_error'; ?>"><?php
                echo htmlspecialchars($old['description'] ?? '');
            ?></textarea>

            <?php if(isset($errors['description'])): ?>
                <div class="error_message"><?php echo $errors['description']; ?></div>
            <?php endif; ?>

            <!-- IMAGE -->
            <label>Фото *</label>
            <input type="file"
                   name="image"
                   accept="image/*"
                   class="<?php if(isset($errors['image'])) echo 'input_error'; ?>">

            <?php if(isset($errors['image'])): ?>
                <div class="error_message"><?php echo $errors['image']; ?></div>
            <?php endif; ?>

            <button type="submit">Добавить</button>

        </form>

    </div>

</div>

<?php if ($success && $partData): ?>
<script>
    alert(
        "Запчасть успешно добавлена!\n\n" +
        "Название: <?php echo addslashes($partData['name']); ?>\n" +
        "Категория: <?php echo addslashes($partData['category']); ?>\n" +
        "Тип детали: <?php echo addslashes($partData['partType']); ?>\n" +
        "Производитель: <?php echo addslashes($partData['producer']); ?>\n" +
        "Гарантия: <?php echo addslashes($partData['warranty']); ?>\n" +
        "Доставка: <?php echo addslashes($partData['deliveryTime']); ?>\n" +
        "Цена: <?php echo addslashes($partData['price']); ?> ₽\n" +
        "Количество: <?php echo addslashes($partData['count']); ?>\n" +
        "Описание: <?php echo addslashes($partData['description']); ?>"
    );
</script>
<?php elseif ($success): ?>
<script>
    alert("Запчасть успешно добавлена!");
</script>
<?php endif; ?>

<?php include '../templates/footer.php'; ?>