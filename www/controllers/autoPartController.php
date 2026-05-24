<?php

require_once __DIR__ . '/../models/AutoPartModel.php';

session_start();

$action = $_POST['action'] ?? '';

$dataFile = __DIR__ . '/../DB/autoPartJSON.json';
$uploadDir = __DIR__ . '/../imgDB/autoPart/';

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

$parts = loadJson($dataFile);

/* =========================
   SAVE PART
========================= */

if ($action === 'save_part') {

    $errors = [];

    $name = trim($_POST['name'] ?? '');
    $category = trim($_POST['category'] ?? '');
    $partType = trim($_POST['partType'] ?? '');

    $producer = trim($_POST['producer'] ?? '');
    $warranty = trim($_POST['warranty'] ?? '');
    $deliveryTime = trim($_POST['deliveryTime'] ?? '');

    $price = trim($_POST['price'] ?? '');
    $count = trim($_POST['count'] ?? '');
    $description = trim($_POST['description'] ?? '');

    $imageFile = $_FILES['image'] ?? null;

    /* ================= VALIDATION ================= */

    if ($name === '' || mb_strlen($name) < 2) {
        $errors['name'] = 'Название минимум 2 символа';
    }

    if ($category === '') {
        $errors['category'] = 'Выберите категорию';
    }

    if ($partType === '') {
        $errors['partType'] = 'Выберите тип запчасти';
    }

    if ($producer === '') {
        $errors['producer'] = 'Укажите производителя';
    }

    if ($warranty === '') {
        $errors['warranty'] = 'Укажите гарантию';
    }

    if ($deliveryTime === '') {
        $errors['deliveryTime'] = 'Укажите срок доставки';
    }

    if ($price === '' || !is_numeric($price) || (float)$price <= 0) {
        $errors['price'] = 'Цена должна быть числом больше 0';
    }

    if ($count === '' || !ctype_digit($count) || (int)$count < 0) {
        $errors['count'] = 'Количество должно быть целым числом';
    }

    if ($description !== '' && mb_strlen($description) < 5) {
        $errors['description'] = 'Описание минимум 5 символов';
    }

    if (!$imageFile || $imageFile['error'] !== UPLOAD_ERR_OK) {
        $errors['image'] = 'Загрузите изображение';
    }

    /* ================= IF ERRORS ================= */

    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        $_SESSION['old'] = $_POST;
        redirect('/www/pages/addDetail.php');
    }

    /* ================= FILE UPLOAD ================= */

    $ext = pathinfo($imageFile['name'], PATHINFO_EXTENSION);

    $allowed = ['jpg', 'jpeg', 'png', 'webp'];

    if (!in_array(strtolower($ext), $allowed)) {
        $_SESSION['errors'] = [
            'image' => 'Недопустимый формат изображения'
        ];
        redirect('/www/pages/addDetail.php');
    }

    $fileName = uniqid() . '.' . $ext;
    $fullPath = $uploadDir . $fileName;

    if (!move_uploaded_file($imageFile['tmp_name'], $fullPath)) {
        $_SESSION['errors'] = [
            'image' => 'Ошибка загрузки файла'
        ];
        redirect('/www/pages/addDetail.php');
    }

    $imagePath = '/www/imgDB/autoPart/' . $fileName;

    /* ================= CREATE MODEL ================= */

    $id = getNextId($parts);

    $part = new AutoPartModel(
        $id,
        $name,
        $category,
        $partType,
        (float)$price,
        (int)$count,
        $producer,
        $warranty,
        $description,
        $imagePath,
        $deliveryTime
    );

    /* ================= SAVE ================= */

    $parts[] = [
        'id' => $part->id,
        'name' => $part->name,
        'category' => $part->category,
        'partType' => $part->partType,

        'producer' => $part->producer,
        'warranty' => $part->warranty,
        'deliveryTime' => $part->deliveryTime,

        'price' => $part->price,
        'count' => $part->count,
        'description' => $part->description,
        'image' => $part->image
    ];

    saveJson($dataFile, $parts);

    /* ================= SUCCESS ================= */

    $_SESSION['success_part'] = true;

    $_SESSION['part_data'] = [
        'name' => $name,
        'category' => $category,
        'partType' => $partType,

        'producer' => $producer,
        'warranty' => $warranty,
        'deliveryTime' => $deliveryTime,

        'price' => $price,
        'count' => $count,
        'description' => $description,
        'image' => $imagePath
    ];

    redirect('/www/pages/addDetail.php');
}

/* fallback */
redirect('/www/pages/addDetail.php');