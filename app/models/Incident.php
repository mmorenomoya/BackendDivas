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

    public function deleteIncident(int $id): bool
    {
        return $this->delete('incidencias', $id);
    }

    public function generateLocalizador(): string
    {
        $year = date('Y');
        do {
            $random = strtoupper(substr(md5(uniqid()), 0, 4));
            $localizador = "REP-{$year}-{$random}";
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
}