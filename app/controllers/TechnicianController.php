<?php

require_once __DIR__ . '/../models/Technician.php';
require_once __DIR__ . '/../models/ServiceType.php';
require_once __DIR__ . '/../models/User.php';

class TechnicianController
{
    private Technician $technicianModel;
    private ServiceType $serviceTypeModel;
    private User $userModel;

    public function __construct()
    {
        $this->technicianModel = new Technician();
        $this->serviceTypeModel = new ServiceType();
        $this->userModel = new User();
    }

    public function index(): void
    {
        $technicians = $this->technicianModel->getAllTechnicians();
        $services = $this->serviceTypeModel->getAllServiceTypes();
        $technicianUsers = $this->userModel->getAllTechnicianUsers();

        require_once __DIR__ . '/../views/admin/technicians.php';
    }

    public function store(): void
    {
        $nombreCompleto = trim($_POST['nombre_completo'] ?? '');
        $especialidadId = (int) ($_POST['especialidad_id'] ?? 0);
        $usuarioId = !empty($_POST['usuario_id']) ? (int) $_POST['usuario_id'] : null;

        if ($nombreCompleto === '' || $especialidadId <= 0) {
            $_SESSION['error'] = 'El nombre del técnico y la especialidad son obligatorios.';
            header('Location: ' . BASE_URL . 'admin/technicians');
            exit;
        }

        $created = $this->technicianModel->createTechnician($usuarioId, $nombreCompleto, $especialidadId);

        if ($created) {
            $_SESSION['success'] = 'Técnico creado correctamente.';
        } else {
            $_SESSION['error'] = 'No se pudo crear el técnico.';
        }

        header('Location: ' . BASE_URL . 'admin/technicians');
        exit;
    }

    public function delete(): void
    {
        $id = (int) ($_GET['id'] ?? 0);

        if ($id <= 0) {
            $_SESSION['error'] = 'Técnico no válido.';
            header('Location: ' . BASE_URL . 'admin/technicians');
            exit;
        }

        $deleted = $this->technicianModel->deactivateTechnician($id);

        if ($deleted) {
            $_SESSION['success'] = 'Técnico dado de baja correctamente.';
        } else {
            $_SESSION['error'] = 'No se pudo dar de baja el técnico.';
        }

        header('Location: ' . BASE_URL . 'admin/technicians');
        exit;
    }
}