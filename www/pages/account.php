<?php

session_start();

$pageTitle = 'Профиль';

$pageScripts = [
    '../js/account.js',
    '../js/menu.js'
];

include '../templates/header.php';

/* =========================
   FLASH DATA
========================= */

$success = $_SESSION["success_account"] ?? false;
$account = $_SESSION["account_data"] ?? null;

$errors = $_SESSION["errors"] ?? [];
$old = $_SESSION["old"] ?? [];

unset($_SESSION["success_account"]);
unset($_SESSION["account_data"]);
unset($_SESSION["errors"]);
unset($_SESSION["old"]);

/* =========================
   LOAD ACCOUNTS (JSON)
========================= */

$dataFile = '../DB/accountJSON.json';

function loadJson(string $file): array
{
    if (!file_exists($file)) return [];

    $json = file_get_contents($file);
    $data = json_decode($json, true);

    return is_array($data) ? $data : [];
}

$accountsList = loadJson($dataFile);

?>

<?php include '../templates/menu.php'; ?>

<div id="content">

    <h1>Личный кабинет</h1>

    <div class="profile_block">

        <!-- ================= LEFT ================= -->
        <div class="profile_left">

            <img src="../img/logo1.png" alt="Аватар" class="profile_avatar">

            <h2>
                <?php echo htmlspecialchars($old["username"] ?? "Иван Иванов"); ?>
            </h2>

            <p class="profile_text">
                Покупатель автозапчастей AutoParts
            </p>

        </div>

        <!-- ================= RIGHT FORM ================= -->
        <div class="profile_right">

            <form class="profile_form"
                  action="../controllers/accountController.php"
                  method="post"
                  enctype="multipart/form-data">

                <input type="hidden" name="action" value="save_account">

                <!-- EMAIL -->
                <label>Email *</label>
                <input type="text" name="email"
                       value="<?php echo htmlspecialchars($old["email"] ?? ""); ?>"
                       class="<?php if(isset($errors["email"])) echo 'input_error'; ?>">

                <?php if(isset($errors["email"])): ?>
                    <div class="error_message"><?php echo $errors["email"]; ?></div>
                <?php endif; ?>

                <!-- USERNAME -->
                <label>Имя пользователя *</label>
                <input type="text" name="username"
                       value="<?php echo htmlspecialchars($old["username"] ?? ""); ?>"
                       class="<?php if(isset($errors["username"])) echo 'input_error'; ?>">

                <?php if(isset($errors["username"])): ?>
                    <div class="error_message"><?php echo $errors["username"]; ?></div>
                <?php endif; ?>

                <!-- PHONE -->
                <label>Телефон *</label>
                <input type="text" name="phone"
                       value="<?php echo htmlspecialchars($old["phone"] ?? ""); ?>"
                       class="<?php if(isset($errors["phone"])) echo 'input_error'; ?>">

                <?php if(isset($errors["phone"])): ?>
                    <div class="error_message"><?php echo $errors["phone"]; ?></div>
                <?php endif; ?>

                <!-- PASSWORD -->
                <label>Пароль *</label>
                <input type="password" name="password"
                       class="<?php if(isset($errors["password"])) echo 'input_error'; ?>">

                <?php if(isset($errors["password"])): ?>
                    <div class="error_message"><?php echo $errors["password"]; ?></div>
                <?php endif; ?>

                <!-- ADDRESS -->
                <label>Адрес доставки *</label>
                <textarea name="address"
                          class="<?php if(isset($errors["address"])) echo 'input_error'; ?>"><?php
                    echo htmlspecialchars($old["address"] ?? "");
                ?></textarea>

                <?php if(isset($errors["address"])): ?>
                    <div class="error_message"><?php echo $errors["address"]; ?></div>
                <?php endif; ?>

                <!-- AVATAR -->
                <label>Аватар</label>
                <input type="file" name="avatar"
                       class="<?php if(isset($errors["avatar"])) echo 'input_error'; ?>">

                <?php if(isset($errors["avatar"])): ?>
                    <div class="error_message"><?php echo $errors["avatar"]; ?></div>
                <?php endif; ?>

                <button type="submit">Сохранить профиль</button>

            </form>

            <!-- ================= ACCOUNTS LIST ================= -->

            <h2 style="margin-top:40px;">Список аккаунтов</h2>

            <div class="accounts_table">

                <div class="accounts_row accounts_header">
                    <div>ID</div>
                    <div>Аватар</div>
                    <div>Имя</div>
                    <div>Почта</div>
                    <div>Действие</div>
                </div>

                <?php foreach ($accountsList as $acc): ?>

                    <div class="accounts_row">

                        <div>
                            <?php echo htmlspecialchars($acc['id']); ?>
                        </div>

                        <div>
                            <img src="<?php echo htmlspecialchars($acc['avatar']); ?>"
                                 alt="avatar"
                                 style="width:45px;height:45px;border-radius:50%;">
                        </div>

                        <div>
                            <?php echo htmlspecialchars($acc['username']); ?>
                        </div>

                        <div>
                            <?php echo htmlspecialchars($acc['email']); ?>
                        </div>

                        <div>
                            <form action="../controllers/accountController.php" method="post" style="display:inline;">
    
                            <input type="hidden" name="action" value="delete_account">
                            <input type="hidden" name="id" value="<?php echo htmlspecialchars($acc['id']); ?>">

                            <button type="submit" class="btn_delete">
                                Удалить
                            </button>

                        </form>
                        </div>

                    </div>

                <?php endforeach; ?>

            </div>

        </div>

    </div>

</div>

<!-- ================= SUCCESS MODAL ================= -->

<?php if ($success && $account): ?>
<div class="modal_overlay" id="welcome_modal">
    <div class="modal_window">

        <h2>
            Добро пожаловать, <?php echo htmlspecialchars($account["username"]); ?>!
        </h2>

        <img src="<?php echo htmlspecialchars($account["avatar"]); ?>"
             alt="avatar"
             class="modal_avatar">

        <p><b>Ваши данные:</b></p>

        <p>Email: <?php echo htmlspecialchars($account["email"]); ?></p>
        <p>Телефон: <?php echo htmlspecialchars($account["phone"]); ?></p>
        <p>Адрес: <?php echo htmlspecialchars($account["address"]); ?></p>

        <button class="modal_btn">OK</button>

    </div>
</div>
<?php endif; ?>

<?php if (!empty($_SESSION['success_delete'])): ?>

<script>
    alert(
        "Аккаунт удалён\n" +
        "ID: <?php echo $_SESSION['success_delete']['id']; ?>\n" +
        "Email: <?php echo $_SESSION['success_delete']['email']; ?>\n" +
        "Имя: <?php echo $_SESSION['success_delete']['name']; ?>"
    );
</script>

<?php unset($_SESSION['success_delete']); ?>
<?php endif; ?>

<?php include '../templates/footer.php'; ?>