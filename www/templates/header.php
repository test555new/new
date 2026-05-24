<?php
$pageTitle = $pageTitle ?? 'AutoParts';
$pageScripts = $pageScripts ?? [];
?>

<!DOCTYPE HTML>
<html>

<head>
    <title><?= htmlspecialchars($pageTitle) ?></title>

    <meta charset="UTF-8">

    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <link rel="icon" href="../img/icon.png">

    <?php foreach ($pageScripts as $script): ?>
        <script src="<?= $script ?>" defer></script>
    <?php endforeach; ?>

</head>

<body>