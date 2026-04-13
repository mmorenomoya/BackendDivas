<?php

$futuras = [];
$pasadas = [];
$ahora = new DateTime();

if (!empty($incidents)) {
    foreach ($incidents as $incident) {
        $fechaServicio = new DateTime($incident['fecha_servicio']);

        if ($fechaServicio >= $ahora) {
            $futuras[] = $incident;
        } else {
            $pasadas[] = $incident;
        }
    }
}

function puedeCancelarIncidencia(array $incident): bool
{
    if (($incident['tipo_urgencia'] ?? '') !== 'Estándar') {
        return false;
    }

    if (($incident['estado'] ?? '') === 'Cancelada') {
        return false;
    }

    $fechaServicio = new DateTime($incident['fecha_servicio']);
    $ahora = new DateTime();
    $diffSegundos = $fechaServicio->getTimestamp() - $ahora->getTimestamp();

    return $diffSegundos >= 48 * 3600;
}
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

        <?php if (!empty($_SESSION['error'])): ?>
            <div style="color: red; margin-bottom: 10px;">
                <?= htmlspecialchars($_SESSION['error']) ?>
            </div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

        <?php if (!empty($_SESSION['success'])): ?>
            <div style="color: green; margin-bottom: 10px;">
                <?= htmlspecialchars($_SESSION['success']) ?>
            </div>
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>

        <h2>Próximas incidencias</h2>

        <table border="1" cellpadding="8">
            <tr>
                <th>Código</th>
                <th>Servicio</th>
                <th>Fecha</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>

            <?php if (!empty($futuras)): ?>
                <?php foreach ($futuras as $incident): ?>
                    <tr>
                        <td><?= htmlspecialchars($incident['localizador'] ?? '') ?></td>
                        <td><?= htmlspecialchars($incident['nombre_especialidad'] ?? '') ?></td>
                        <td><?= htmlspecialchars($incident['fecha_servicio'] ?? '') ?></td>
                        <td><?= htmlspecialchars($incident['estado'] ?? '') ?></td>
                        <td>
                            <?php if (puedeCancelarIncidencia($incident)): ?>
                                <a href="<?= BASE_URL ?>/client/cancel?id=<?= htmlspecialchars($incident['id']) ?>"
                                   onclick="return confirm('¿Seguro que quieres cancelar esta incidencia?');">
                                    Cancelar
                                </a>
                            <?php else: ?>
                                No disponible
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5">No tienes incidencias futuras registradas.</td>
                </tr>
            <?php endif; ?>
        </table>

        <br><br>

        <h2>Historial de incidencias</h2>

        <table border="1" cellpadding="8">
            <tr>
                <th>Código</th>
                <th>Servicio</th>
                <th>Fecha</th>
                <th>Estado</th>
            </tr>

            <?php if (!empty($pasadas)): ?>
                <?php foreach ($pasadas as $incident): ?>
                    <tr>
                        <td><?= htmlspecialchars($incident['localizador'] ?? '') ?></td>
                        <td><?= htmlspecialchars($incident['nombre_especialidad'] ?? '') ?></td>
                        <td><?= htmlspecialchars($incident['fecha_servicio'] ?? '') ?></td>
                        <td><?= htmlspecialchars($incident['estado'] ?? '') ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4">No tienes incidencias pasadas registradas.</td>
                </tr>
            <?php endif; ?>
        </table>
    </div>

    <?php require_once __DIR__ . '/../layouts/footer.php'; ?>

</body>
</html>