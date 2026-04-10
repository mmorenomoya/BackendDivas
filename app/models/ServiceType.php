<?php

require_once __DIR__ . '/../core/Model.php';

class ServiceType extends Model
{
    public function getAllServiceTypes(): array // Obtiene todos los tipos de servicio o especialidades
    {
        $this->db->query("SELECT id, nombre_especialidad FROM especialidades ORDER BY nombre_especialidad ASC");
        $this->db->execute();
        return $this->db->results();
    }
}