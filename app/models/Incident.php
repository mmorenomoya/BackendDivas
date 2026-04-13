<?php
require_once __DIR__ . '/../core/Model.php';

/**
 * @property Database $db
 */

class Incident extends Model 
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getAllIncidents(): array
    {
        return $this->getAll('incidencias');
    }

    public function getIncidentById(int $id): array | false
    {
        return $this->getById('incidencias', $id);
    }

    public function getIncidentByClientId(int $clientId): array | false
    {
        $this->db->query("SELECT i.*, e.nombre_especialidad
                            FROM incidencias i
                            JOIN especialidades e ON i.especialidad_id = e.id
                            WHERE i.cliente_id = :cliente_id
                            ORDER BY i.fecha_servicio DESC");
        $this->db->bind(':cliente_id', $clientId);
        $this->db->execute();
        return $this->db->results();
    }

    public function getIncidentByIdAndClientId(int $incidentId, int $clientId): array | false
    {
        $this->db->query("
            SELECT *
            FROM incidencias
            WHERE id = :id AND cliente_id = :cliente_id
        ");
        $this->db->bind(':id', $incidentId);
        $this->db->bind(':cliente_id', $clientId);
        $this->db->execute();
        return $this->db->result();
    }

    public function createIncident(array $data): bool
    {
        $this->db->query("INSERT INTO incidencias
                        (localizador, cliente_id, especialidad_id, descripcion, direccion, fecha_servicio, tipo_urgencia)
                        VALUES
                        (:localizador, :cliente_id, :especialidad_id, :descripcion, :direccion, :fecha_servicio, :tipo_urgencia)");
        
        $this->db->bind(':localizador', $data['localizador']);
        $this->db->bind(':cliente_id', $data['cliente_id']);
        $this->db->bind(':especialidad_id', $data['especialidad_id']);
        $this->db->bind(':descripcion', $data['descripcion']);
        $this->db->bind(':direccion', $data['direccion']);
        $this->db->bind(':fecha_servicio', $data['fecha_servicio']);
        $this->db->bind(':tipo_urgencia', $data['tipo_urgencia']);

        return $this->db->execute();
    }

    public function updateIncident(int $id, array $data): bool
    {
        $this->db->query("UPDATE incidencias
                        SET especialidad_id = :especialidad_id,
                            descripcion = :descripcion,
                            direccion = :direccion,
                            fecha_servicio = :fecha_servicio,
                            tipo_urgencia = :tipo_urgencia
                        WHERE id = :id");
        
        $this->db->bind(':especialidad_id', $data['especialidad_id']);
        $this->db->bind(':descripcion', $data['descripcion']);
        $this->db->bind(':direccion', $data['direccion']);
        $this->db->bind(':fecha_servicio', $data['fecha_servicio']);
        $this->db->bind(':tipo_urgencia', $data['tipo_urgencia']);
        $this->db->bind(':id', $id);

        return $this->db->execute();
    }

    public function cancelIncident(int $id): bool
    {
        $this->db->query("UPDATE incidencias SET estado = 'Cancelada' WHERE id = :id");
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }

    public function canBeCancelledByClient(array $incident): bool
    {
        if (($incident['tipo_urgencia'] ?? '') !== 'Estándar') {
            return false;
        }

        if (($incident['estado'] ?? '') === 'Cancelada') {
            return false;
        }

        return !$this->isWithin48Hours($incident['fecha_servicio']);
    }

    public function deleteIncident(int $id): bool
    {
        return $this->delete('incidencias', $id);
    }

    public function generateLocalizador(): string
    {
        $year = date('Y');
        do {
            $random = strtoupper(substr(md5(uniqid()), 0, 4));
            $localizador = "RP-{$year}-{$random}";
            $this->db->query("SELECT id FROM incidencias WHERE localizador = :localizador");
            $this->db->bind(':localizador', $localizador);
            $exists = $this->db->result();
        } while ($exists);

        return $localizador;
    }

    public function isWithin48Hours(string $fechaServicio): bool
    {
        $now = new DateTime();
        $servicio = new DateTime($fechaServicio);
        $diff = $now->diff($servicio);
        $hoursLeft = ($diff->days * 24) + $diff->h;

        return $hoursLeft < 48;
    }

    // Obtiene todas las incidencias con información de cliente, técnico y especialidad para el panel admin
    public function getAllIncidentsWithDetails(): array
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

    // Asigna un técnico a una incidencia y actualiza su estado
    public function assignTechnician(int $incidentId, int $technicianId): bool
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

    // Obtiene las incidencias en formato de eventos para el calendario
    public function getCalendarEvents(): array
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

    // Obtiene una incidencia concreta para la edición desde el panel de administración
    public function getIncidentByIdForAdmin(int $id): array | false
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

    public function getIncidentsByTechnicianId(int $technicianId): array
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
                e.nombre_especialidad,
                u.nombre AS cliente_nombre
            FROM incidencias i
            INNER JOIN usuarios u ON i.cliente_id = u.id
            INNER JOIN especialidades e ON i.especialidad_id = e.id
            WHERE i.tecnico_id = :technician_id
            ORDER BY i.fecha_servicio ASC
        ");
        $this->db->bind(':technician_id', $technicianId);
        $this->db->execute();
        return $this->db->results();
    }
}