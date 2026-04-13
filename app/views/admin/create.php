<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="container">
    <p>
        <a href="<?= BASE_URL ?>admin">← Volver al panel admin</a>
    </p>

    <h1>Crear aviso</h1>
    <p>Panel de administración</p>

    <form method="POST" action="<?= BASE_URL ?>admin/create">
        <div>
            <label for="cliente_id">Cliente:</label><br>
            <select name="cliente_id" id="cliente_id" required>
                <option value="">Selecciona un cliente</option>
                <?php foreach ($clientes as $cliente): ?>
                    <option value="<?= $cliente['id'] ?>">
                        <?= htmlspecialchars($cliente['nombre']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div>
            <label for="especialidad_id">Tipo de servicio:</label><br>
            <select name="especialidad_id" id="especialidad_id" required>
                <option value="">Selecciona una especialidad</option>
                <?php foreach ($especialidades as $esp): ?>
                    <option value="<?= $esp['id'] ?>">
                        <?= htmlspecialchars($esp['nombre_especialidad']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div>
            <label for="descripcion">Descripción:</label><br>
            <textarea name="descripcion" id="descripcion" required></textarea>
        </div>

        <div>
            <label for="direccion">Dirección:</label><br>
            <input type="text" name="direccion" id="direccion" required>
        </div>

        <div>
            <label for="fecha_servicio">Fecha y hora:</label><br>
            <input type="datetime-local" name="fecha_servicio" id="fecha_servicio" required>
        </div>

        <div>
            <label for="tipo_urgencia">Urgencia:</label><br>
            <select name="tipo_urgencia" id="tipo_urgencia" required>
                <option value="Estándar">Estándar</option>
                <option value="Urgente">Urgente</option>
            </select>
        </div>

        <br>
        <button type="submit">Guardar</button>
    </form>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>