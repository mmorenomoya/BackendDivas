<?php

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel del Cliente - ReparaYA</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/global.css">
</head>
<body>

    <?php require_once __DIR__ . '/../layouts/header.php'; ?>

    <div class="container">
        <h1>Panel del Cliente</h1>
        <p>Bienvenido al sistema ReparaYa.</p>

        <h2>Opciones disponibles</h2>
        <ul>
            <li><a href="<?= BASE_URL ?>/client/create">Crear nueva incidencia</a></li>
            <li><a href="<?= BASE_URL ?>/client/incidents">Ver incidencias abiertas</a></li>
        </ul>
    </div>

    <?php require_once __DIR__ . '/../layouts/footer.php'; ?>

</body>
</html>