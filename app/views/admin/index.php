<h1>Panel de administración</h1>

<p>
    <a href="<?= BASE_URL ?>/admin/create">Crear aviso</a> |
    <a href="<?= BASE_URL ?>/admin/calendar">Ver calendario</a>
</p>

<table border="1" cellpadding="8">
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

    <?php foreach ($incidencias as $i): ?>
        <tr>
            <td><?= $i['id'] ?></td>
            <td><?= $i['localizador'] ?></td>
            <td><?= $i['cliente_nombre'] ?></td>
            <td><?= $i['tecnico_nombre'] ?? 'Sin asignar' ?></td>
            <td><?= $i['nombre_especialidad'] ?></td>
            <td><?= $i['descripcion'] ?></td>
            <td><?= $i['fecha_servicio'] ?></td>
            <td><?= $i['tipo_urgencia'] ?></td>
            <td><?= $i['estado'] ?></td>
            <td>
                <a href="<?= BASE_URL ?>/admin/edit?id=<?= $i['id'] ?>">Editar</a>

                <?php if ($i['estado'] !== 'Cancelada'): ?>
                    | <a href="<?= BASE_URL ?>/admin/cancel?id=<?= $i['id'] ?>">Cancelar</a>

                    <?php if (empty($i['tecnico_nombre'])): ?>
                        | <a href="<?= BASE_URL ?>/admin/assign?id=<?= $i['id'] ?>">Asignar técnico</a>
                    <?php endif; ?>
                <?php endif; ?>
            </td>
        </tr>
    <?php endforeach; ?>
</table>