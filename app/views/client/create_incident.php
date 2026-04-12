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

    <form>
        <label>Fecha solicitada:</label><br>
        <input type="date"><br><br>

        <label>Franja horaria:</label><br>
        <select>
            <option>Mañana</option>
            <option>Tarde</option>
        </select><br><br>

        <label>Descripción de la avería:</label><br>
        <textarea rows="4" cols="40"></textarea><br><br>

        <label>Dirección:</label><br>
        <input type="text"><br><br>

        <label>Número de contacto:</label><br>
        <input type="text"><br><br>

        <label>Tipo de servicio:</label><br>
        <select>
            <option>Fontanería</option>
            <option>Electricidad</option>
            <option>Urgente</option>
            <option>Estándar</option>
        </select><br><br>

        <button type="submit">Enviar solicitud</button>
    </form>
</body>
</html>