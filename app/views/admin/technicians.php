<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="container">
    <p>
        <a href="<?= BASE_URL ?>admin">← Volver al panel admin</a> |
        <a href="<?= BASE_URL ?>admin/services">Servicios</a> |
        <a href="<?= BASE_URL ?>admin/calendar">Calendario</a>
    </p>

    <h1>Gestión de técnicos</h1>
    <p>Panel de administración</p>

    <?php if (!empty($_SESSION['error'])): ?>
        <div style="color:red; margin-bottom: 10px;">
            <?= $_SESSION['error']; unset($_SESSION['error']); ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($_SESSION['success'])): ?>
        <div style="color:green; margin-bottom: 10px;">
            <?= $_SESSION['success']; unset($_SESSION['success']); ?>
        </div>
    <?php endif; ?>

    <h2>Nuevo técnico</h2>

    <form method="POST" action="<?= BASE_URL ?>admin/technicians/create">
        <div>
            <label for="nombre_completo">Nombre completo</label><br>
            <input type="text" name="nombre_completo" id="nombre_completo" required>
        </div>

        <div>
            <label for="especialidad_id">Especialidad</label><br>
            <select name="especialidad_id" id="especialidad_id" required>
                <option value="">Selecciona una especialidad</option>
                <?php foreach ($services as $service): ?>
                    <option value="<?= $service['id'] ?>">
                        <?= htmlspecialchars($service['nombre_especialidad']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div>
            <label for="usuario_id">Usuario técnico vinculado (opcional)</label><br>
            <select name="usuario_id" id="usuario_id">
                <option value="">Sin vincular</option>
                <?php foreach ($technicianUsers as $user): ?>
                    <option value="<?= $user['id'] ?>">
                        <?= htmlspecialchars($user['nombre']) ?> (<?= htmlspecialchars($user['email']) ?>)
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <br>
        <button type="submit">Guardar técnico</button>
    </form>

    <hr>

    <h2>Listado de técnicos</h2>

    <?php if (!empty($technicians)): ?>
        <table border="1" cellpadding="8" cellspacing="0">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Especialidad</th>
                    <th>Email vinculado</th>
                    <th>Estado</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($technicians as $technician): ?>
                    <tr>
                        <td><?= htmlspecialchars($technician['nombre_completo']) ?></td>
                        <td><?= htmlspecialchars($technician['nombre_especialidad'] ?? 'Sin especialidad') ?></td>
                        <td><?= htmlspecialchars($technician['email'] ?? 'Sin usuario') ?></td>
                        <td><?= (int)$technician['disponible'] === 1 ? 'Activo' : 'Baja' ?></td>
                        <td>
                            <?php if ((int)$technician['disponible'] === 1): ?>
                                <a href="<?= BASE_URL ?>admin/technicians/delete?id=<?= $technician['id'] ?>"
                                   onclick="return confirm('¿Dar de baja este técnico?')">
                                    Dar de baja
                                </a>
                            <?php else: ?>
                                -
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No hay técnicos registrados.</p>
    <?php endif; ?>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>