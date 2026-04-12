<?php

require_once __DIR__ . '/../core/Model.php';

class Technician extends Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getAllTechnicians(): array
    {
        $this->db->query("
            SELECT 
                t.id,
                t.usuario_id,
                t.nombre_completo,
                t.especialidad_id,
                t.disponible,
                e.nombre_especialidad,
                u.email
            FROM tecnicos t
            LEFT JOIN especialidades e ON t.especialidad_id = e.id
            LEFT JOIN usuarios u ON t.usuario_id = u.id
            ORDER BY t.nombre_completo ASC
        ");
        $this->db->execute();
        return $this->db->results();
    }

    public function createTechnician(?int $usuarioId, string $nombreCompleto, int $especialidadId): bool
    {
        $this->db->query("
            INSERT INTO tecnicos (usuario_id, nombre_completo, especialidad_id, disponible)
            VALUES (:usuario_id, :nombre_completo, :especialidad_id, 1)
        ");

        $this->db->bind(':usuario_id', $usuarioId);
        $this->db->bind(':nombre_completo', $nombreCompleto);
        $this->db->bind(':especialidad_id', $especialidadId);

        return $this->db->execute();
    }

    public function deactivateTechnician(int $id): bool
    {
        $this->db->query("UPDATE tecnicos SET disponible = 0 WHERE id = :id");
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }

    public function getTechnicianByUserId(int $userId): array|false
    {
        $this->db->query("
            SELECT *
            FROM tecnicos
            WHERE usuario_id = :user_id
            LIMIT 1
        ");
        $this->db->bind(':user_id', $userId);
        $this->db->execute();
        return $this->db->result();
    }
}