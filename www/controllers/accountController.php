<?php

require_once __DIR__ . '/../models/AccountModel.php';

session_start();

$action = $_POST['action'] ?? '';

$dataFile = __DIR__ . '/../DB/accountJSON.json';
$uploadDir = __DIR__ . '/../imgDB/';

if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

/* =========================
   HELPERS
========================= */

function loadJson(string $file): array
{
    if (!file_exists($file)) {
        return [];
    }

    $json = file_get_contents($file);
    $data = json_decode($json, true);

    return is_array($data) ? $data : [];
}

function saveJson(string $file, array $data): void
{
    file_put_contents(
        $file,
        json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT)
    );
}

function getNextId(array $items): int
{
    $max = 0;

    foreach ($items as $item) {
        if (isset($item['id']) && $item['id'] > $max) {
            $max = $item['id'];
        }
    }

    return $max + 1;
}

function redirect(string $url): void
{
    header("Location: $url");
    exit;
}

/* =========================
   LOAD DATA
========================= */

$accounts = loadJson($dataFile);

/* =========================
   SAVE ACCOUNT
========================= */

if ($action === 'save_account') {

    $errors = [];

    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $password = (string)($_POST['password'] ?? '');
    $address = trim($_POST['address'] ?? '');
    $role = trim($_POST['role'] ?? 'user');
    $avatarFile = $_FILES['avatar'] ?? null;

    if ($username === '' || mb_strlen($username) < 2) {
        $errors['username'] = 'Имя пользователя минимум 2 символа';
    }

    if ($email === '') {
        $errors['email'] = 'Введите email';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Некорректный email';
    } else {
        foreach ($accounts as $a) {
            if ($a['email'] === $email) {
                $errors['email'] = 'Email уже используется';
                break;
            }
        }
    }

    if ($phone === '' || !preg_match('/^\+?[0-9\s\-\(\)]{10,20}$/', $phone)) {
        $errors['phone'] = 'Некорректный телефон';
    }

    if ($password === '' || !preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/', $password)) {
        $errors['password'] = 'Пароль: 8+ символов, A-Z, a-z, цифра, спецсимвол';
    }

    if ($address === '' || mb_strlen($address) < 5) {
        $errors['address'] = 'Введите адрес (минимум 5 символов)';
    }

    if (!$avatarFile || $avatarFile['error'] !== UPLOAD_ERR_OK) {
        $errors['avatar'] = 'Загрузите изображение';
    }

    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        $_SESSION['old'] = $_POST;
        redirect('/www/pages/account.php');
    }

    $fileName = uniqid() . '_' . basename($avatarFile['name']);
    $fullPath = $uploadDir . $fileName;

    if (!move_uploaded_file($avatarFile['tmp_name'], $fullPath)) {
        $_SESSION['errors'] = ['avatar' => 'Ошибка загрузки файла'];
        redirect('/www/pages/account.php');
    }

    $avatarPath = '/www/imgDB/' . $fileName;

    $id = getNextId($accounts);
    $hash = password_hash($password, PASSWORD_DEFAULT);

    $account = new AccountModel(
        $id,
        $username,
        $email,
        $phone,
        $hash,
        $address,
        $avatarPath,
        $role
    );

    $accounts[] = [
        'id' => $account->id,
        'username' => $account->username,
        'email' => $account->email,
        'phone' => $account->phone,
        'passwordHash' => $account->passwordHash,
        'address' => $account->address,
        'avatar' => $account->avatar,
        'role' => $account->role
    ];

    saveJson($dataFile, $accounts);

    $_SESSION['success_account'] = true;

    $_SESSION['account_data'] = [
        'username' => $username,
        'email' => $email,
        'phone' => $phone,
        'address' => $address,
        'avatar' => $avatarPath
    ];

    redirect('/www/pages/account.php');
}

/* =========================
   DELETE ACCOUNT + ALERT
========================= */

if ($action === 'delete_account') {

    $id = (int)($_POST['id'] ?? 0);

    $result = [];
    $deleted = null;

    foreach ($accounts as $acc) {

        if (isset($acc['id']) && $acc['id'] === $id) {

            $deleted = $acc;

            if (!empty($acc['avatar'])) {
                $path = __DIR__ . '/../..' . $acc['avatar'];

                if (file_exists($path)) {
                    unlink($path);
                }
            }

            continue;
        }

        $result[] = $acc;
    }

    saveJson($dataFile, $result);

    // ===== FLASH MESSAGE FOR ALERT =====
    $_SESSION['success_delete'] = [
        'id' => $deleted['id'] ?? $id,
        'email' => $deleted['email'] ?? '',
        'name' => $deleted['username'] ?? ''
    ];

    redirect('/www/pages/account.php');
}

redirect('/www/pages/account.php');