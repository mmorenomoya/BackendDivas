<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="container">
    <h1>Panel de administración</h1>
    <p>Desde este panel el administrador puede gestionar incidencias, técnicos, servicios y calendario.</p>

    <h2>Listado de incidencias</h2>

    <table border="1" cellpadding="8" cellspacing="0">
        <tr>
            <th>ID</th>
            <th>Localizador</th>
            <th>Cliente</th>
            <th>Técnico</th>
            <th>Especialidad</th>
            <th>Descripción</th>
            <th>Fecha</th>
            <th>Urgencia</th>
            <th>Estado</th>
            <th>Acciones</th>
        </tr>

        <?php if (!empty($incidencias)): ?>
            <?php foreach ($incidencias as $i): ?>
                <tr>
                    <td><?= htmlspecialchars($i['id']) ?></td>
                    <td><?= htmlspecialchars($i['localizador']) ?></td>
                    <td><?= htmlspecialchars($i['cliente_nombre']) ?></td>
                    <td><?= htmlspecialchars($i['tecnico_nombre'] ?? 'Sin asignar') ?></td>
                    <td><?= htmlspecialchars($i['nombre_especialidad']) ?></td>
                    <td><?= htmlspecialchars($i['descripcion']) ?></td>
                    <td><?= htmlspecialchars($i['fecha_servicio']) ?></td>
                    <td><?= htmlspecialchars($i['tipo_urgencia']) ?></td>
                    <td><?= htmlspecialchars($i['estado']) ?></td>
                    <td>
                        <a href="<?= BASE_URL ?>admin/edit?id=<?= $i['id'] ?>">Editar</a>

                        <?php if ($i['estado'] !== 'Cancelada'): ?>
                            | <a href="<?= BASE_URL ?>admin/cancel?id=<?= $i['id'] ?>">Cancelar</a>

                            <?php if (empty($i['tecnico_nombre'])): ?>
                                | <a href="<?= BASE_URL ?>admin/assign?id=<?= $i['id'] ?>">Asignar técnico</a>
                            <?php endif; ?>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="10">No hay incidencias registradas.</td>
            </tr>
        <?php endif; ?>
    </table>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>