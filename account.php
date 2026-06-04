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

<style>
    /* ================= GENERAL ================= */
    #content {
        min-height: 100vh;
        padding: 40px 20px 80px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
        background-attachment: fixed;
        font-family: 'Segoe UI', Tahoma, sans-serif;
        color: #2d2d44;
    }

    #content h1 {
        text-align: center;
        font-size: 42px;
        font-weight: 800;
        color: #ffffff;
        letter-spacing: 1px;
        margin-bottom: 40px;
        text-shadow: 0 4px 20px rgba(0,0,0,0.25);
    }

    /* ================= LAYOUT ================= */
    .profile_block {
        display: grid;
        grid-template-columns: 320px 1fr;
        gap: 30px;
        max-width: 1200px;
        margin: 0 auto;
    }

    @media (max-width: 900px) {
        .profile_block { grid-template-columns: 1fr; }
    }

    /* ================= LEFT CARD ================= */
    .profile_left {
        background: rgba(255,255,255,0.95);
        backdrop-filter: blur(12px);
        border-radius: 24px;
        padding: 35px 25px;
        text-align: center;
        box-shadow: 0 20px 60px rgba(31, 38, 135, 0.25);
        border: 1px solid rgba(255,255,255,0.4);
        height: fit-content;
        position: sticky;
        top: 20px;
        transition: transform 0.35s ease;
    }

    .profile_left:hover { transform: translateY(-4px); }

    .profile_avatar {
        width: 160px;
        height: 160px;
        border-radius: 50%;
        object-fit: cover;
        border: 5px solid #fff;
        box-shadow: 0 10px 30px rgba(118, 75, 162, 0.45);
        background: #f5f5fa;
        padding: 6px;
    }

    .profile_left h2 {
        margin: 20px 0 8px;
        font-size: 24px;
        color: #2d2d44;
        font-weight: 700;
    }

    .profile_text {
        color: #6b6b8a;
        font-size: 14px;
        background: linear-gradient(135deg, #f3e7ff, #e0f2fe);
        padding: 8px 14px;
        border-radius: 20px;
        display: inline-block;
        margin-top: 6px;
    }

    /* ================= RIGHT CARD ================= */
    .profile_right {
        background: rgba(255,255,255,0.95);
        backdrop-filter: blur(12px);
        border-radius: 24px;
        padding: 40px;
        box-shadow: 0 20px 60px rgba(31, 38, 135, 0.25);
        border: 1px solid rgba(255,255,255,0.4);
    }

    /* ================= FORM ================= */
    .profile_form label {
        display: block;
        margin: 18px 0 8px;
        font-weight: 600;
        color: #4a4a6a;
        font-size: 14px;
        letter-spacing: 0.3px;
    }

    .profile_form input[type="text"],
    .profile_form input[type="password"],
    .profile_form input[type="file"],
    .profile_form textarea {
        width: 100%;
        padding: 12px 16px;
        border: 2px solid #e6e6f0;
        border-radius: 12px;
        font-size: 15px;
        background: #fafaff;
        color: #2d2d44;
        transition: border-color 0.25s, box-shadow 0.25s, background 0.25s;
        box-sizing: border-box;
        font-family: inherit;
    }

    .profile_form textarea {
        resize: vertical;
        min-height: 90px;
    }

    .profile_form input:focus,
    .profile_form textarea:focus {
        outline: none;
        border-color: #764ba2;
        background: #fff;
        box-shadow: 0 0 0 4px rgba(118, 75, 162, 0.15);
    }

    .profile_form input.input_error,
    .profile_form textarea.input_error {
        border-color: #ff5e7c;
        background: #fff5f7;
    }

    .error_message {
        color: #ff3e63;
        font-size: 13px;
        margin-top: 6px;
        padding-left: 4px;
        font-weight: 500;
    }

    .profile_form button[type="submit"] {
        margin-top: 28px;
        width: 100%;
        padding: 14px;
        border: none;
        border-radius: 12px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: #fff;
        font-size: 16px;
        font-weight: 700;
        letter-spacing: 0.5px;
        cursor: pointer;
        box-shadow: 0 8px 20px rgba(118, 75, 162, 0.35);
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .profile_form button[type="submit"]:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 28px rgba(118, 75, 162, 0.5);
    }

    .profile_form button[type="submit"]:active { transform: translateY(0); }

    .profile_right h2 {
        font-size: 22px;
        color: #2d2d44;
        font-weight: 700;
        padding-bottom: 12px;
        border-bottom: 2px solid #f0f0f8;
    }

    /* ================= ACCOUNTS TABLE ================= */
    .accounts_table {
        margin-top: 18px;
        border-radius: 14px;
        overflow: hidden;
        box-shadow: 0 4px 16px rgba(0,0,0,0.06);
    }

    .accounts_row {
        display: grid;
        grid-template-columns: 60px 80px 1fr 1.4fr 110px;
        align-items: center;
        gap: 12px;
        padding: 14px 16px;
        background: #fff;
        border-bottom: 1px solid #f0f0f8;
        font-size: 14px;
        color: #3d3d5c;
        transition: background 0.2s;
    }

    .accounts_row:last-child { border-bottom: none; }

    .accounts_row:not(.accounts_header):hover { background: #faf7ff; }

    .accounts_header {
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: #fff;
        font-weight: 700;
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .accounts_header > div { color: #fff; }

    .btn_delete {
        padding: 8px 14px;
        border: none;
        border-radius: 8px;
        background: linear-gradient(135deg, #ff5e7c, #ff3e63);
        color: #fff;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        box-shadow: 0 4px 12px rgba(255, 62, 99, 0.3);
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .btn_delete:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 16px rgba(255, 62, 99, 0.45);
    }

    /* ================= MODAL ================= */
    .modal_overlay {
        position: fixed;
        inset: 0;
        background: rgba(20, 20, 40, 0.55);
        backdrop-filter: blur(6px);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 9999;
        animation: fadeIn 0.3s ease;
    }

    .modal_window {
        background: #fff;
        border-radius: 22px;
        padding: 36px;
        max-width: 420px;
        width: 90%;
        text-align: center;
        box-shadow: 0 30px 70px rgba(0,0,0,0.35);
        animation: popIn 0.35s cubic-bezier(0.34, 1.56, 0.64, 1);
    }

    .modal_window h2 {
        color: #2d2d44;
        margin-bottom: 18px;
        font-size: 22px;
    }

    .modal_avatar {
        width: 110px;
        height: 110px;
        border-radius: 50%;
        border: 4px solid #764ba2;
        object-fit: cover;
        margin: 8px auto 16px;
    }

    .modal_window p {
        color: #4a4a6a;
        margin: 6px 0;
        font-size: 14px;
    }

    .modal_btn {
        margin-top: 22px;
        padding: 12px 38px;
        border: none;
        border-radius: 12px;
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: #fff;
        font-size: 15px;
        font-weight: 700;
        cursor: pointer;
        box-shadow: 0 8px 20px rgba(118, 75, 162, 0.35);
        transition: transform 0.2s;
    }

    .modal_btn:hover { transform: translateY(-2px); }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    @keyframes popIn {
        from { opacity: 0; transform: scale(0.85); }
        to { opacity: 1; transform: scale(1); }
    }
</style>

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