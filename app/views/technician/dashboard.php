<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="container">
    <h1>Panel técnico</h1>

    <?php if (!empty($_SESSION['error'])): ?>
        <div style="color:red; margin-bottom: 10px;">
            <?= $_SESSION['error']; unset($_SESSION['error']); ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($technician)): ?>
        <p><strong>Técnico:</strong> <?= htmlspecialchars($technician['nombre_completo']) ?></p>
    <?php endif; ?>

    <h2>Agenda de trabajo</h2>

    <?php if (!empty($incidents)): ?>
        <table border="1" cellpadding="8" cellspacing="0">
            <thead>
                <tr>
                    <th>Localizador</th>
                    <th>Cliente</th>
                    <th>Servicio</th>
                    <th>Descripción</th>
                    <th>Dirección</th>
                    <th>Fecha</th>
                    <th>Urgencia</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($incidents as $incident): ?>
                    <tr>
                        <td><?= htmlspecialchars($incident['localizador']) ?></td>
                        <td><?= htmlspecialchars($incident['cliente_nombre']) ?></td>
                        <td><?= htmlspecialchars($incident['nombre_especialidad']) ?></td>
                        <td><?= htmlspecialchars($incident['descripcion']) ?></td>
                        <td><?= htmlspecialchars($incident['direccion']) ?></td>
                        <td><?= htmlspecialchars($incident['fecha_servicio']) ?></td>
                        <td><?= htmlspecialchars($incident['tipo_urgencia']) ?></td>
                        <td><?= htmlspecialchars($incident['estado']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No tienes incidencias asignadas.</p>
    <?php endif; ?>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>