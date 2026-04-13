<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="container">
    <p>
        <a href="<?= BASE_URL ?>admin">← Volver al panel admin</a> 
    </p>

    <h1>Asignar técnico</h1>
    <p>Panel de administración</p>

    <form method="POST" action="<?= BASE_URL ?>admin/assign">
        <input type="hidden" name="incident_id" value="<?= $incidentId ?>">

        <div>
            <label for="technician_id">Técnico:</label><br>
            <select name="technician_id" id="technician_id" required>
                <option value="">Selecciona un técnico</option>
                <?php foreach ($technicians as $tech): ?>
                    <option value="<?= $tech['id'] ?>">
                        <?= htmlspecialchars($tech['nombre_completo']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <br>
        <button type="submit">Guardar</button>
    </form>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>