<?php

require_once __DIR__ . '/../models/Technician.php';
require_once __DIR__ . '/../models/ServiceType.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Incident.php';
require_once __DIR__ . '/../core/Auth.php';

class TechnicianController
{
    private Technician $technicianModel;
    private ServiceType $serviceTypeModel;
    private User $userModel;
    private Incident $incidentModel;

    public function __construct()
    {
        $this->technicianModel = new Technician();
        $this->serviceTypeModel = new ServiceType();
        $this->userModel = new User();
        $this->incidentModel = new Incident();
    }

    // Panel admin: gestión de técnicos
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

    // Panel técnico: solo lectura de agenda
    public function dashboard(): void
    {
        Auth::requireLogin();

        if (Auth::getRole() !== 'tecnico') {
            header('Location: ' . BASE_URL);
            exit;
        }

        $user = Auth::getUser();
        $technician = $this->technicianModel->getTechnicianByUserId((int) $user['id']);
        $incidents = [];

        if (!$technician) {
            $_SESSION['error'] = 'No tienes un perfil de técnico vinculado.';
        } else {
            $incidents = $this->incidentModel->getIncidentsByTechnicianId((int) $technician['id']);
        }

        require_once __DIR__ . '/../views/technician/dashboard.php';
    }
}