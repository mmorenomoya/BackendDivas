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
}