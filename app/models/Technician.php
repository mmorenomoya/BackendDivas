<?php

require_once __DIR__ . '/../core/Model.php';

class Technician extends Model
{
    public function getAllTechnicians(): array // Obtiene la lista de técnicos disponibles
    {
        $this->db->query("
            SELECT id, nombre_completo
            FROM tecnicos
            WHERE disponible = 1
            ORDER BY nombre_completo ASC
        ");
        $this->db->execute();
        return $this->db->results();
    }
}