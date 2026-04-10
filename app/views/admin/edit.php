<h1>Editar aviso</h1>

<form method="POST" action="<?= BASE_URL ?>/admin/edit">
    <input type="hidden" name="id" value="<?= $incidencia['id'] ?>">

    <div>
        <label for="cliente_id">Cliente:</label>
        <select name="cliente_id" id="cliente_id" required>
            <?php foreach ($clientes as $cliente): ?>
                <option value="<?= $cliente['id'] ?>" <?= $cliente['id'] == $incidencia['cliente_id'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($cliente['nombre']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div>
        <label for="especialidad_id">Tipo de servicio:</label>
        <select name="especialidad_id" id="especialidad_id" required>
            <?php foreach ($especialidades as $esp): ?>
                <option value="<?= $esp['id'] ?>" <?= $esp['id'] == $incidencia['especialidad_id'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($esp['nombre_especialidad']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div>
        <label for="descripcion">Descripción:</label>
        <textarea name="descripcion" id="descripcion" required><?= htmlspecialchars($incidencia['descripcion']) ?></textarea>
    </div>

    <div>
        <label for="direccion">Dirección:</label>
        <input type="text" name="direccion" id="direccion" value="<?= htmlspecialchars($incidencia['direccion']) ?>" required>
    </div>

    <div>
        <label for="fecha_servicio">Fecha y hora:</label>
        <input
            type="datetime-local"
            name="fecha_servicio"
            id="fecha_servicio"
            value="<?= date('Y-m-d\TH:i', strtotime($incidencia['fecha_servicio'])) ?>"
            required
        >
    </div>

    <div>
        <label for="tipo_urgencia">Urgencia:</label>
        <select name="tipo_urgencia" id="tipo_urgencia" required>
            <option value="Estándar" <?= $incidencia['tipo_urgencia'] === 'Estándar' ? 'selected' : '' ?>>Estándar</option>
            <option value="Urgente" <?= $incidencia['tipo_urgencia'] === 'Urgente' ? 'selected' : '' ?>>Urgente</option>
        </select>
    </div>

    <button type="submit">Guardar cambios</button>
</form>

<p><a href="<?= BASE_URL ?>/admin">Volver</a></p>