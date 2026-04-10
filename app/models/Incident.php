<?php

require_once __DIR__ . '/../core/Model.php';

class Incident extends Model
{
    public function getAllIncidents(): array // Obtiene todas las incidencias con información de cliente, técnico y especialidad
    {
        $this->db->query("
            SELECT 
                i.id,
                i.localizador,
                i.descripcion,
                i.direccion,
                i.fecha_servicio,
                i.tipo_urgencia,
                i.estado,
                u.nombre AS cliente_nombre,
                t.nombre_completo AS tecnico_nombre,
                e.nombre_especialidad
            FROM incidencias i
            INNER JOIN usuarios u ON i.cliente_id = u.id
            LEFT JOIN tecnicos t ON i.tecnico_id = t.id
            INNER JOIN especialidades e ON i.especialidad_id = e.id
            ORDER BY i.fecha_servicio ASC
        ");
         $this->db->execute();
        return $this->db->results();
    }

    public function cancelIncident(int $id): bool // Cambia el estado de una incidencia a Cancelada
    {
        $this->db->query("UPDATE incidencias SET estado = 'Cancelada' WHERE id = :id");
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }

    public function assignTechnician(int $incidentId, int $technicianId): bool // Asigna un técnico a una incidencia y actualiza su estado
    {
        $this->db->query("
            UPDATE incidencias
            SET tecnico_id = :technician_id, estado = 'Asignada'
            WHERE id = :incident_id
        ");
        $this->db->bind(':technician_id', $technicianId);
        $this->db->bind(':incident_id', $incidentId);
        return $this->db->execute();
    }

    public function createIncident( // Inserta una nueva incidencia en la base de datos
        string $localizador,
        int $clienteId,
        int $especialidadId,
        string $descripcion,
        string $direccion,
        string $fechaServicio,
        string $tipoUrgencia
    ): bool
    {
        $this->db->query("
            INSERT INTO incidencias 
            (localizador, cliente_id, especialidad_id, descripcion, direccion, fecha_servicio, tipo_urgencia, estado)
            VALUES
            (:localizador, :cliente_id, :especialidad_id, :descripcion, :direccion, :fecha_servicio, :tipo_urgencia, 'Pendiente')
        ");

        $this->db->bind(':localizador', $localizador);
        $this->db->bind(':cliente_id', $clienteId);
        $this->db->bind(':especialidad_id', $especialidadId);
        $this->db->bind(':descripcion', $descripcion);
        $this->db->bind(':direccion', $direccion);
        $this->db->bind(':fecha_servicio', $fechaServicio);
        $this->db->bind(':tipo_urgencia', $tipoUrgencia);

        return $this->db->execute();
    }

    public function generateLocalizador(): string // Genera un localizador para un nuevo aviso
    {
        return 'AV' . str_pad((string)rand(1, 9999), 4, '0', STR_PAD_LEFT);
    }

    public function getIncidentById(int $id): array|false
    {
        $this->db->query("
            SELECT *
            FROM incidencias
            WHERE id = :id
        ");
        $this->db->bind(':id', $id);
        $this->db->execute();
        return $this->db->result();
    }

    public function updateIncident(  // Actualiza los datos principales de una incidencia
        int $id,
        int $clienteId,
        int $especialidadId,
        string $descripcion,
        string $direccion,
        string $fechaServicio,
        string $tipoUrgencia
    ): bool
    {
        $this->db->query("
            UPDATE incidencias
            SET cliente_id = :cliente_id,
                especialidad_id = :especialidad_id,
                descripcion = :descripcion,
                direccion = :direccion,
                fecha_servicio = :fecha_servicio,
                tipo_urgencia = :tipo_urgencia
            WHERE id = :id
        ");

        $this->db->bind(':id', $id);
        $this->db->bind(':cliente_id', $clienteId);
        $this->db->bind(':especialidad_id', $especialidadId);
        $this->db->bind(':descripcion', $descripcion);
        $this->db->bind(':direccion', $direccion);  
        $this->db->bind(':fecha_servicio', $fechaServicio);
        $this->db->bind(':tipo_urgencia', $tipoUrgencia);

        return $this->db->execute();
    }

    public function getCalendarEvents(): array // Obtiene las incidencias en formato de eventos para el calendario
    {
        $this->db->query("
            SELECT 
                i.id,
                i.localizador,
                i.descripcion,
                i.fecha_servicio,
                i.tipo_urgencia,
                i.estado,
                u.nombre AS cliente_nombre,
                t.nombre_completo AS tecnico_nombre
            FROM incidencias i
            INNER JOIN usuarios u ON i.cliente_id = u.id
            LEFT JOIN tecnicos t ON i.tecnico_id = t.id
            ORDER BY i.fecha_servicio ASC
        ");

        $this->db->execute();
        return $this->db->results();
    }
}