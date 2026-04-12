<h1>Asignar técnico</h1>

<form method="POST" action="<?= BASE_URL ?>/admin/assign">
    <input type="hidden" name="incident_id" value="<?= $incidentId ?>">

    <label for="technician_id">Técnico:</label>
    <select name="technician_id" id="technician_id" required>
        <option value="">Selecciona un técnico</option>
        <?php foreach ($technicians as $tech): ?>
            <option value="<?= $tech['id'] ?>">
                <?= htmlspecialchars($tech['nombre_completo']) ?>
            </option>
        <?php endforeach; ?>
    </select>

    <button type="submit">Guardar</button>
</form>

<p><a href="<?= BASE_URL ?>/admin">Volver</a></p>