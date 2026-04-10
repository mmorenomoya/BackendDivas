<?php

require_once __DIR__ . '/../models/Incident.php';
require_once __DIR__ . '/../models/Technician.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/ServiceType.php';

class AdminController
{
    private Incident $incidentModel;
    private Technician $technicianModel;
    private User $userModel;
    private ServiceType $serviceTypeModel;

    public function __construct()
    {
        $this->incidentModel = new Incident();
        $this->technicianModel = new Technician();
        $this->userModel = new User();
        $this->serviceTypeModel = new ServiceType();
    }

    public function index(): void //Muestra el panel principal de administración con el listado de incidencias
    {
        $incidencias = $this->incidentModel->getAllIncidentsWithDetails();
        require_once __DIR__ . '/../views/admin/index.php';
    }

    public function users(): void
    {
        echo "<h1>Gestión de usuarios</h1>";
    }

    public function cancel(): void //Cancela una incidencia cambiando su estado a Cancelada
    {
        $id = $_GET['id'] ?? null;

        if ($id) {
            $this->incidentModel->cancelIncident((int)$id);
        }

        header('Location: ' . BASE_URL . '/admin');
        exit;
    }

    public function assignForm(): void //Muestra el formulario para asignar un técnico a una incidencia
    {
        $incidentId = $_GET['id'] ?? null;

        if (!$incidentId) {
            header('Location: ' . BASE_URL . '/admin');
            exit;
        }

        $technicians = $this->technicianModel->getAllTechnicians();
        require_once __DIR__ . '/../views/admin/assign.php';
    }

    public function assign(): void //Guarda la asignación de un técnico y actualiza el estado de la incidencia
    {
        $incidentId = $_POST['incident_id'] ?? null;
        $technicianId = $_POST['technician_id'] ?? null;

        if ($incidentId && $technicianId) {
            $this->incidentModel->assignTechnician((int)$incidentId, (int)$technicianId);
        }

        header('Location: ' . BASE_URL . '/admin');
        exit;
    }

    public function createForm(): void //Muestra el formulario para crear un nuevo aviso manualmente
    {
        $clientes = $this->userModel->getAllClients();
        $especialidades = $this->serviceTypeModel->getAllServiceTypes();

        require_once __DIR__ . '/../views/admin/create.php';
    }

    public function store(): void //Guarda un nuevo aviso creado por el administrador
    {
        $clienteId = (int)($_POST['cliente_id'] ?? 0);
        $especialidadId = (int)($_POST['especialidad_id'] ?? 0);
        $descripcion = trim($_POST['descripcion'] ?? '');
        $direccion = trim($_POST['direccion'] ?? '');
        $fechaServicio = $_POST['fecha_servicio'] ?? '';
        $tipoUrgencia = $_POST['tipo_urgencia'] ?? 'Estándar';

        $data = [
            'localizador' => $this->incidentModel->generateLocalizador(),
            'cliente_id' => $clienteId,
            'especialidad_id' => $especialidadId,
            'descripcion' => $descripcion,
            'direccion' => $direccion,
            'fecha_servicio' => $fechaServicio,
            'tipo_urgencia' => $tipoUrgencia
        ];

        $this->incidentModel->createIncident($data);

            header('Location: ' . BASE_URL . '/admin');
            exit;
    }

    public function editForm(): void //Muestra el formulario para editar una incidencia existente
    {
        $id = (int)($_GET['id'] ?? 0);

        if (!$id) {
            header('Location: ' . BASE_URL . '/admin');
            exit;
        }

        $incidencia = $this->incidentModel->getIncidentByIdForAdmin($id);
        $clientes = $this->userModel->getAllClients();
        $especialidades = $this->serviceTypeModel->getAllServiceTypes();

        require_once __DIR__ . '/../views/admin/edit.php';
    }

    public function update(): void //Actualiza los datos de una incidencia
    {
        $id = (int)($_POST['id'] ?? 0);
        //$clienteId = (int)($_POST['cliente_id'] ?? 0);
        $especialidadId = (int)($_POST['especialidad_id'] ?? 0);
        $descripcion = trim($_POST['descripcion'] ?? '');
        $direccion = trim($_POST['direccion'] ?? '');
        $fechaServicio = $_POST['fecha_servicio'] ?? '';
        $tipoUrgencia = $_POST['tipo_urgencia'] ?? 'Estándar';

        $data = [
            'especialidad_id' => $especialidadId,
            'descripcion' => $descripcion,
            'direccion' => $direccion,
            'fecha_servicio' => $fechaServicio,
            'tipo_urgencia' => $tipoUrgencia
        ];

        if ($id) {
            $this->incidentModel->updateIncident($id, $data);
        }

        header('Location: ' . BASE_URL . '/admin');
        exit;
    }

    public function calendar(): void //Prepara y muestra los eventos en la vista de calendario
    {
        $eventsFromDb = $this->incidentModel->getCalendarEvents();

        $events = [];

        foreach ($eventsFromDb as $event) {
            $color = $event['tipo_urgencia'] === 'Urgente' ? '#dc3545' : '#0d6efd';

            $events[] = [
                'id' => $event['id'],
                'title' => $event['localizador'] . ' - ' . $event['descripcion'],
                'start' => $event['fecha_servicio'],
                'color' => $color,
                'extendedProps' => [
                    'cliente' => $event['cliente_nombre'],
                    'tecnico' => $event['tecnico_nombre'] ?? 'Sin asignar',
                    'urgencia' => $event['tipo_urgencia'],
                    'estado' => $event['estado'],
                    'descripcion' => $event['descripcion']
                ]
            ];
        }

        require_once __DIR__ . '/../views/admin/calendar.php';
    }
}