<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="container">
    <p>
        <a href="<?= BASE_URL ?>admin">← Volver al panel admin</a>
    </p>

    <h1>Gestión de servicios</h1>
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

    <h2>Nuevo servicio</h2>
    <form method="POST" action="<?= BASE_URL ?>admin/services/create">
        <label for="nombre_especialidad">Nombre del servicio</label><br>
        <input type="text" name="nombre_especialidad" id="nombre_especialidad" required>
        <button type="submit">Guardar servicio</button>
    </form>

    <hr>

    <h2>Listado de servicios</h2>

    <?php if (!empty($services)): ?>
        <ul>
            <?php foreach ($services as $service): ?>
                <li><?= htmlspecialchars($service['nombre_especialidad']) ?></li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>No hay servicios registrados.</p>
    <?php endif; ?>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>