<?php

require_once __DIR__ . '/../core/Model.php';

/**
 * @property Database $db
 */
class ServiceType extends Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getAllServiceTypes(): array
    {
        return $this->getAll('especialidades');
    }

    public function getServiceTypeById(int $id): array | false
    {
        return $this->getById('especialidades', $id);
    }

    public function createServiceType(string $name): bool
    {
        $this->db->query("INSERT INTO especialidades (nombre_especialidad) VALUES (:name)");
        $this->db->bind(':name', $name);
        return $this->db->execute();
    }
}