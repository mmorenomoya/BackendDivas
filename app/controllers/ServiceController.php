<?php

require_once __DIR__ . '/../models/ServiceType.php';

class ServiceController
{
    private ServiceType $serviceTypeModel;

    public function __construct()
    {
        $this->serviceTypeModel = new ServiceType();
    }

    public function index(): void
    {
        $services = $this->serviceTypeModel->getAllServiceTypes();
        require_once __DIR__ . '/../views/admin/services.php';
    }

    public function createForm(): void
    {
        require_once __DIR__ . '/../views/admin/services.php';
    }

    public function store(): void
    {
        $name = trim($_POST['nombre_especialidad'] ?? '');

        if ($name === '') {
            $_SESSION['error'] = 'El nombre del servicio es obligatorio.';
            header('Location: ' . BASE_URL . 'admin/services');
            exit;
        }

        $this->serviceTypeModel->createServiceType($name);

        $_SESSION['success'] = 'Servicio creado correctamente.';
        header('Location: ' . BASE_URL . 'admin/services');
        exit;
    }
}