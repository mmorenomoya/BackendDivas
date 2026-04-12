<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nueva incidencia</title>
</head>
<body>
    <h1>Crear nueva incidencia</h1>

    <p><strong>Importante:</strong> los servicios estándar deben solicitarse con al menos 48 horas de antelación.</p>
    <p>Los servicios urgentes tendrán prioridad en la asignación.</p>

    <?php if (!empty($errors)): ?>
        <div style="color: red;">
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="<?= BASE_URL ?>/client/create" method="POST">
        <label>Fecha solicitada:</label><br>
        <input type="datetime-local" name="fecha_servicio" required><br><br>

        <label>Descripción de la avería:</label><br>
        <textarea name="descripcion" rows="4" cols="40" required></textarea><br><br>

        <label>Dirección:</label><br>
        <input type="text" name="direccion" required><br><br>

        <label>Tipo de urgencia:</label><br>
        <select name="tipo_urgencia" required>
            <option value="Estándar">Estándar</option>
            <option value="Urgente">Urgente</option>
        </select><br><br>

        <label>Tipo de servicio:</label><br>
        <select name="especialidad_id" required>
            <option value="">Selecciona un servicio</option>
            <?php if (!empty($services)): ?>
                <?php foreach ($services as $service): ?>
                    <option value="<?= htmlspecialchars($service['id']) ?>">
                        <?= htmlspecialchars($service['nombre_especialidad']) ?>
                    </option>
                <?php endforeach; ?>
            <?php endif; ?>
        </select><br><br>

        <button type="submit">Enviar solicitud</button>
    </form>
</body>
</html>