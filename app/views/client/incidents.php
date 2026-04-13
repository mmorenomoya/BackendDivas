<?php

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mis avisos - ReparaYA</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/global.css">
</head>
<body>

    <?php require_once __DIR__ . '/../layouts/header.php'; ?>

    <div class="container">
        <h1>Mis avisos</h1>

        <p><strong>Nota:</strong> las incidencias estándar no podrán cancelarse si faltan menos de 48 horas para la cita.</p>

        <table border="1" cellpadding="8">
            <tr>
                <th>Código</th>
                <th>Servicio</th>
                <th>Fecha</th>
                <th>Estado</th>
            </tr>

            <?php if (!empty($incidents)): ?>
                <?php foreach ($incidents as $incident): ?>
                    <tr>
                        <td><?= htmlspecialchars($incident['localizador'] ?? '') ?></td>
                        <td><?= htmlspecialchars($incident['nombre_especialidad'] ?? '') ?></td>
                        <td><?= htmlspecialchars($incident['fecha_servicio'] ?? '') ?></td>
                        <td><?= htmlspecialchars($incident['estado'] ?? '') ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4">No tienes incidencias registradas.</td>
                </tr>
            <?php endif; ?>
        </table>
    </div>

    <?php require_once __DIR__ . '/../layouts/footer.php'; ?>

</body>
</html>